<?php
/**
 * Rebuilds the static sitemap.xml (with image entries) from the live routes.
 *
 * Run on localhost with XAMPP running:
 *   D:\xampp\php\php.exe tools/build_sitemap.php [BASE_URL]
 *   default BASE_URL = http://localhost:8080/thebridal
 *
 * What it does:
 *  - reads page routes (Controller::method) from app/Config/Routes.php;
 *    closures (old-URL 301s) and admin routes are skipped
 *  - adds published blog posts from the database
 *  - fetches every URL; only 200 pages whose canonical equals their own URL go in
 *  - lastmod = date of the page's view file (blog: updated_at)
 *  - adds <image:image> entries (max 20 per page) for location and service pages
 *
 * Output: sitemap.xml in the project root (the file robots.txt points to).
 */

$root = dirname(__DIR__);
$base = rtrim($argv[1] ?? 'http://localhost:8080/thebridal', '/');
$live = 'https://thebridal.photography';

// URLs kept out on purpose (see SEO_FIX_NOTES.md)
$exclude = [
    '/blog/odio-non-quo-rerum-a/', // lorem ipsum test post, waiting for a decision
];

// Pages that get image entries: location and service pages
$noImages = ['/', '/contact/', '/faq/', '/about-us/', '/blog/'];

// ── 1. Routes -> controller method ───────────────────────────────────────
$routesSrc = file_get_contents("$root/app/Config/Routes.php");
preg_match_all("#\\\$routes->get\\('(/[^']*)',\\s*'([A-Za-z]+)::([A-Za-z]+)'\\)#", $routesSrc, $m, PREG_SET_ORDER);
$pages = [];
foreach ($m as [, $path, $ctrl, $method]) {
    if (str_contains($path, '(:')) {
        continue;
    }
    $pages[$path] = ['ctrl' => $ctrl, 'method' => $method];
}

// ── 2. Controller method -> view file ────────────────────────────────────
$viewOf = function (string $ctrl, string $method) use ($root): ?string {
    static $src = [];
    $src[$ctrl] ??= (string) @file_get_contents("$root/app/Controllers/$ctrl.php");
    if (! preg_match('/function\s+' . $method . '\s*\(.*?(?=\n\s*(public|private|protected)\s+function|\z)/s', $src[$ctrl], $body)) {
        return null;
    }
    if (preg_match("/render\\('([^']+)'/", $body[0], $v) || preg_match("/'view'\\s*=>\\s*'([^']+)'/", $body[0], $v)) {
        return $v[1];
    }
    return null;
};

$entries = [];
foreach ($pages as $path => $p) {
    $view = $viewOf($p['ctrl'], $p['method']) ?? ($path === '/' ? 'pages/home' : null);
    $file = $view ? "$root/app/Views/$view.php" : null;
    $entries[$path] = ['lastmod' => ($file && is_file($file)) ? filemtime($file) : time()];
}

// ── 3. Blog posts from the database (.env settings) ──────────────────────
$env = [];
foreach (@file("$root/.env") ?: [] as $line) {
    if (preg_match('/^\s*([\w.]+)\s*=\s*\'?([^\'\r\n]*)\'?/', $line, $e)) {
        $env[$e[1]] = trim($e[2]);
    }
}
$db = @new mysqli(
    $env['database.default.hostname'] ?? 'localhost',
    $env['database.default.username'] ?? 'root',
    $env['database.default.password'] ?? '',
    $env['database.default.database'] ?? 'thebridal',
    (int) ($env['database.default.port'] ?? 3306)
);
if ($db->connect_errno) {
    fwrite(STDERR, "DB connect failed: {$db->connect_error}\n");
    exit(1);
}
$prefix = $env['database.default.DBPrefix'] ?? 'tb_';
$res    = $db->query("SELECT slug, COALESCE(updated_at, published_at, created_at) AS d FROM {$prefix}blogs WHERE status = 'published'");
while ($row = $res->fetch_assoc()) {
    $entries['/blog/' . $row['slug'] . '/'] = ['lastmod' => strtotime($row['d'])];
}

// ── 4. Fetch, check and collect images ───────────────────────────────────
$ok      = [];
$skipped = [];
foreach ($entries as $path => $e) {
    if (in_array($path, $exclude, true)) {
        $skipped[] = "$path (excluded)";
        continue;
    }
    $ch = curl_init($base . $path);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => false, CURLOPT_TIMEOUT => 30]);
    $html = (string) curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($code !== 200) {
        $skipped[] = "$path (HTTP $code)";
        continue;
    }
    preg_match('/<link rel="canonical" href="([^"]+)"/', $html, $c);
    if (($c[1] ?? '') !== $live . $path) {
        $skipped[] = "$path (canonical is " . ($c[1] ?? 'missing') . ')';
        continue;
    }

    $images = [];
    if (! in_array($path, $noImages, true) && ! str_starts_with($path, '/blog/')) {
        $main = explode('</main>', explode('<main', $html, 2)[1] ?? '', 2)[0];
        preg_match_all('/<img\b[^>]*\bsrc="([^"]+)"/', $main, $imgs);
        foreach ($imgs[1] as $src) {
            if (! preg_match('#/(assets/images/[^"?\s]+)#', $src, $im)) {
                continue; // skip YouTube thumbnails and other hosts
            }
            $images[$live . '/' . $im[1]] = true;
            if (count($images) >= 20) {
                break;
            }
        }
    }
    $ok[$path] = $e + ['images' => array_keys($images)];
}

// ── 5. Write sitemap.xml ─────────────────────────────────────────────────
uksort($ok, static fn ($a, $b) => [$a !== '/', substr_count($a, '/'), $a] <=> [$b !== '/', substr_count($b, '/'), $b]);

$x = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
   . "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n"
   . "        xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\">\n";
foreach ($ok as $path => $e) {
    $x .= "  <url>\n    <loc>" . htmlspecialchars($live . $path, ENT_XML1) . "</loc>\n"
        . '    <lastmod>' . date('Y-m-d', $e['lastmod']) . "</lastmod>\n";
    foreach ($e['images'] as $img) {
        $x .= "    <image:image><image:loc>" . htmlspecialchars($img, ENT_XML1) . "</image:loc></image:image>\n";
    }
    $x .= "  </url>\n";
}
$x .= "</urlset>\n";
file_put_contents("$root/sitemap.xml", $x);

$imgCount = array_sum(array_map(static fn ($e) => count($e['images']), $ok));
echo 'Wrote sitemap.xml: ' . count($ok) . " URLs, $imgCount image entries\n";
if ($skipped) {
    echo "Left out:\n  " . implode("\n  ", $skipped) . "\n";
}
