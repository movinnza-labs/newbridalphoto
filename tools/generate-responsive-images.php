<?php
/**
 * generate-responsive-images.php
 *
 * One-shot CLI tool: scans assets/images/ recursively and creates resized
 * variants for every .webp / .jpg / .jpeg / .png source it finds.
 *
 * Naming convention:
 *   photo.webp          (original — untouched)
 *   photo-400.webp      (generated)
 *   photo-800.webp      (generated)
 *   photo-1200.webp     (generated)
 *   photo-1600.webp     (generated)
 *   photo-1920.webp     (generated)
 *
 * The responsive_img() helper picks these up automatically (silent fallback
 * to the original if a variant doesn't exist — so it's safe to run partial).
 *
 * USAGE — from project root:
 *   php tools\generate-responsive-images.php
 *
 * OPTIONS:
 *   --quality=78    WebP/JPEG quality (default 78)
 *   --force         Overwrite existing variants
 *   --dir=path      Scan a specific subdirectory instead of all of assets/images/
 *   --dry-run       Show what would happen without writing files
 *
 * REQUIREMENTS:
 *   Imagick extension (preferred) OR GD with WebP support.
 *   XAMPP ships both — usually nothing to install.
 */

// ─── Config ──────────────────────────────────────────────────────────────
$projectRoot = dirname(__DIR__);
$sourceDir   = $projectRoot . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images';
$widths      = [400, 800, 1200, 1600, 1920];

// ─── Parse CLI options ───────────────────────────────────────────────────
$opts = [
    'quality' => 78,
    'force'   => false,
    'dryRun'  => false,
    'dir'     => null,
];
foreach (array_slice($argv, 1) as $arg) {
    if ($arg === '--force')       { $opts['force']  = true;  continue; }
    if ($arg === '--dry-run')     { $opts['dryRun'] = true;  continue; }
    if (preg_match('/^--quality=(\d+)/', $arg, $m)) { $opts['quality'] = (int) $m[1]; continue; }
    if (preg_match('/^--dir=(.+)/',     $arg, $m)) { $opts['dir']     = $m[1];         continue; }
}

if ($opts['dir']) {
    $sourceDir = $projectRoot . DIRECTORY_SEPARATOR . trim($opts['dir'], '/\\');
}

if (! is_dir($sourceDir)) {
    fwrite(STDERR, "ERROR: source directory not found: {$sourceDir}\n");
    exit(1);
}

// ─── Detect backend ──────────────────────────────────────────────────────
$useImagick = class_exists('Imagick');
$gdHasWebp  = function_exists('imagewebp');
if (! $useImagick && ! function_exists('imagecreatefromjpeg')) {
    fwrite(STDERR, "ERROR: neither Imagick nor GD is available. Enable one in php.ini.\n");
    exit(1);
}

echo "─────────────────────────────────────────────────────────────────\n";
echo "  Responsive image generator\n";
echo "─────────────────────────────────────────────────────────────────\n";
echo "  Source dir : {$sourceDir}\n";
echo "  Backend    : " . ($useImagick ? 'Imagick' : 'GD') . "\n";
echo "  Quality    : {$opts['quality']}\n";
echo "  Widths     : " . implode(', ', $widths) . "\n";
echo "  Mode       : " . ($opts['dryRun'] ? 'DRY-RUN (no files written)' : 'WRITE') . "\n";
echo "─────────────────────────────────────────────────────────────────\n\n";

// ─── Skip-list (files that previously crashed GD; populated by shutdown handler) ─
$skipListFile  = __DIR__ . DIRECTORY_SEPARATOR . '.image-gen-skip';
$skipList      = is_file($skipListFile)
    ? array_filter(array_map('trim', file($skipListFile)))
    : [];
$skipSet       = array_flip($skipList);

// On fatal error (e.g. GD can't decode an extended-WebP), record the file that
// was being processed so we can re-run the script and skip past it instead of
// infinitely crashing on the same source.
$GLOBALS['currentFile'] = null;
register_shutdown_function(function () use ($skipListFile) {
    $err = error_get_last();
    if (! $err) return;
    if (! in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) return;
    $cur = $GLOBALS['currentFile'] ?? null;
    if (! $cur) return;
    @file_put_contents($skipListFile, $cur . PHP_EOL, FILE_APPEND);
    fwrite(STDERR, "\n  ! Recorded skip: {$cur}\n");
});

// ─── Iterate ─────────────────────────────────────────────────────────────
$iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS));

$stats = ['scanned' => 0, 'generated' => 0, 'skipped' => 0, 'errors' => 0, 'savedBytes' => 0];
$startTime = microtime(true);

foreach ($iter as $file) {
    if (! $file->isFile()) {
        continue;
    }

    $path = $file->getPathname();
    $ext  = strtolower($file->getExtension());

    if (! in_array($ext, ['webp', 'jpg', 'jpeg', 'png'], true)) {
        continue;
    }

    // Skip files that already look like variants (-NNN.ext)
    if (preg_match('/-(?:\d{2,4})\.(?:webp|jpg|jpeg|png)$/i', $path)) {
        continue;
    }

    // Skip files known to crash GD (recorded by shutdown handler on prior runs)
    if (isset($skipSet[$path])) {
        echo "  ~ skip (in .image-gen-skip): " . shortPath($path, $projectRoot) . "\n";
        continue;
    }

    // Track current file so the shutdown handler knows what to record on fatal
    $GLOBALS['currentFile'] = $path;

    $stats['scanned']++;
    $info = pathinfo($path);
    $base = $info['filename'];
    $dir  = $info['dirname'];

    // Read source dimensions
    $size = @getimagesize($path);
    if (! $size) {
        echo "  ! Skip (unreadable): " . shortPath($path, $projectRoot) . "\n";
        $stats['errors']++;
        continue;
    }
    [$srcW, $srcH] = $size;
    $srcType = $size[2] ?? 0;   // IMAGETYPE_* — actual content, not extension

    echo "  • " . shortPath($path, $projectRoot) . " ({$srcW}×{$srcH})\n";

    foreach ($widths as $w) {
        if ($w >= $srcW) {
            continue;   // Don't upscale
        }
        $newH      = (int) round($srcH * ($w / $srcW));
        $variant   = "{$dir}/{$base}-{$w}.{$ext}";

        if (file_exists($variant) && ! $opts['force']) {
            echo "    └ exists  -{$w}.{$ext}\n";
            $stats['skipped']++;
            continue;
        }

        if ($opts['dryRun']) {
            echo "    └ would create -{$w}.{$ext} ({$w}×{$newH})\n";
            $stats['generated']++;
            continue;
        }

        try {
            if ($useImagick) {
                resizeImagick($path, $variant, $w, $newH, $ext, $opts['quality']);
            } else {
                resizeGD($path, $variant, $w, $newH, $ext, $opts['quality'], $srcType);
            }
            $savedBytes = max(0, filesize($path) - filesize($variant));
            $stats['savedBytes'] += $savedBytes;
            $stats['generated']++;
            echo "    └ wrote   -{$w}.{$ext} ({$w}×{$newH}, " . formatBytes(filesize($variant)) . ")\n";
        } catch (Throwable $e) {
            echo "    └ ERROR   -{$w}.{$ext}: " . $e->getMessage() . "\n";
            $stats['errors']++;
        }
    }
}

// All iterations completed without fatal — clear so shutdown handler doesn't
// flag the final processed file as bad if a stray warning occurs during teardown.
$GLOBALS['currentFile'] = null;

$elapsed = number_format(microtime(true) - $startTime, 1);

echo "\n─────────────────────────────────────────────────────────────────\n";
echo "  Done in {$elapsed}s\n";
echo "  Scanned   : {$stats['scanned']} sources\n";
echo "  Generated : {$stats['generated']} variants\n";
echo "  Skipped   : {$stats['skipped']} (already existed — pass --force to overwrite)\n";
echo "  Errors    : {$stats['errors']}\n";
echo "─────────────────────────────────────────────────────────────────\n";


// ─── Helpers ─────────────────────────────────────────────────────────────

function shortPath(string $abs, string $root): string {
    return str_replace($root . DIRECTORY_SEPARATOR, '', $abs);
}

function formatBytes(int $bytes): string {
    if ($bytes < 1024)      return "{$bytes} B";
    if ($bytes < 1048576)   return number_format($bytes / 1024, 1) . " KB";
    return number_format($bytes / 1048576, 2) . " MB";
}

function resizeImagick(string $src, string $dst, int $w, int $h, string $ext, int $quality): void {
    $img = new Imagick($src);
    $img->setImageFormat($ext === 'jpg' ? 'jpeg' : $ext);
    $img->resizeImage($w, $h, Imagick::FILTER_LANCZOS, 1);
    $img->setImageCompressionQuality($quality);
    if ($ext === 'webp') {
        $img->setOption('webp:method', '6');
        $img->setOption('webp:lossless', 'false');
    }
    $img->stripImage();
    $img->writeImage($dst);
    $img->destroy();
}

function resizeGD(string $src, string $dst, int $w, int $h, string $ext, int $quality, int $srcType = 0): void {
    // Read using the ACTUAL detected image type (from getimagesize), not the file
    // extension. Some files on disk have a .webp extension but contain JPEG/PNG
    // bytes — using the wrong loader causes a GD fatal that kills the whole batch.
    $readerType = $srcType ?: 0;
    switch ($readerType) {
        case IMAGETYPE_WEBP: $srcImg = imagecreatefromwebp($src); break;
        case IMAGETYPE_JPEG: $srcImg = imagecreatefromjpeg($src); break;
        case IMAGETYPE_PNG:  $srcImg = imagecreatefrompng($src);  break;
        case IMAGETYPE_GIF:  $srcImg = imagecreatefromgif($src);  break;
        default:
            // Fall back to extension-based loader for callers that don't pass $srcType
            switch ($ext) {
                case 'webp': $srcImg = imagecreatefromwebp($src); break;
                case 'jpg':
                case 'jpeg': $srcImg = imagecreatefromjpeg($src); break;
                case 'png':  $srcImg = imagecreatefrompng($src);  break;
                default: throw new RuntimeException("Unsupported ext: {$ext}");
            }
    }
    if (! $srcImg) {
        throw new RuntimeException("Failed to read source");
    }

    $dstImg = imagecreatetruecolor($w, $h);

    // Preserve transparency for png/webp
    if ($ext === 'png' || $ext === 'webp') {
        imagealphablending($dstImg, false);
        imagesavealpha($dstImg, true);
        $transparent = imagecolorallocatealpha($dstImg, 0, 0, 0, 127);
        imagefilledrectangle($dstImg, 0, 0, $w, $h, $transparent);
    }

    imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $w, $h, imagesx($srcImg), imagesy($srcImg));

    switch ($ext) {
        case 'webp': imagewebp($dstImg, $dst, $quality);   break;
        case 'jpg':
        case 'jpeg': imagejpeg($dstImg, $dst, $quality);   break;
        case 'png':  imagepng($dstImg, $dst, 6);           break;
    }

    imagedestroy($srcImg);
    imagedestroy($dstImg);
}
