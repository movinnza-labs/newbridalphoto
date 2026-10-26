<?php
/**
 * Font Downloader — fetches Google Fonts .woff2 files locally.
 *
 * Run from project root:
 *   php scripts/download-fonts.php
 *
 * Downloads 11 unique .woff2 files into assets/fonts/ matching the subsets
 * served by Google Fonts CSS for:
 *   - Jost (weights 400/500/600, normal)
 *   - Playfair Display (weights 400/500/600, normal + italic 400/500)
 */

$targetDir = __DIR__ . '/../assets/fonts';

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

$files = [
    // Jost — variable font, one file per subset serves all weights
    'jost-cyrillic.woff2'   => 'https://fonts.gstatic.com/s/jost/v20/92zatBhPNqw73oDd4iYl.woff2',
    'jost-latin-ext.woff2'  => 'https://fonts.gstatic.com/s/jost/v20/92zatBhPNqw73ord4iYl.woff2',
    'jost-latin.woff2'      => 'https://fonts.gstatic.com/s/jost/v20/92zatBhPNqw73oTd4g.woff2',

    // Playfair Display — italic
    'playfair-italic-cyrillic.woff2'   => 'https://fonts.gstatic.com/s/playfairdisplay/v40/nuFkD-vYSZviVYUb_rj3ij__anPXDTnohkk72xU.woff2',
    'playfair-italic-vietnamese.woff2' => 'https://fonts.gstatic.com/s/playfairdisplay/v40/nuFkD-vYSZviVYUb_rj3ij__anPXDTnojUk72xU.woff2',
    'playfair-italic-latin-ext.woff2'  => 'https://fonts.gstatic.com/s/playfairdisplay/v40/nuFkD-vYSZviVYUb_rj3ij__anPXDTnojEk72xU.woff2',
    'playfair-italic-latin.woff2'      => 'https://fonts.gstatic.com/s/playfairdisplay/v40/nuFkD-vYSZviVYUb_rj3ij__anPXDTnogkk7.woff2',

    // Playfair Display — normal
    'playfair-cyrillic.woff2'   => 'https://fonts.gstatic.com/s/playfairdisplay/v40/nuFiD-vYSZviVYUb_rj3ij__anPXDTjYgFE_.woff2',
    'playfair-vietnamese.woff2' => 'https://fonts.gstatic.com/s/playfairdisplay/v40/nuFiD-vYSZviVYUb_rj3ij__anPXDTPYgFE_.woff2',
    'playfair-latin-ext.woff2'  => 'https://fonts.gstatic.com/s/playfairdisplay/v40/nuFiD-vYSZviVYUb_rj3ij__anPXDTLYgFE_.woff2',
    'playfair-latin.woff2'      => 'https://fonts.gstatic.com/s/playfairdisplay/v40/nuFiD-vYSZviVYUb_rj3ij__anPXDTzYgA.woff2',
];

echo "Downloading " . count($files) . " font files to {$targetDir}/\n";
echo str_repeat('-', 60) . "\n";

$success = 0;
$failed  = 0;

foreach ($files as $filename => $url) {
    $destination = $targetDir . '/' . $filename;
    echo str_pad($filename, 40);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0 Safari/537.36',
        CURLOPT_SSL_VERIFYPEER => false,
    ]);
    $data     = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error    = curl_error($ch);
    curl_close($ch);

    if ($data !== false && $httpCode === 200 && strlen($data) > 1000) {
        file_put_contents($destination, $data);
        $size = number_format(strlen($data) / 1024, 1);
        echo " OK    ({$size} KB)\n";
        $success++;
    } else {
        echo " FAIL  (HTTP {$httpCode}" . ($error ? " — {$error}" : '') . ")\n";
        $failed++;
    }
}

echo str_repeat('-', 60) . "\n";
echo "Done: {$success} succeeded, {$failed} failed\n";

if ($failed === 0) {
    echo "\nAll fonts downloaded. Local fonts.css will now activate automatically\n";
    echo "(main.php detects assets/fonts/jost-latin.woff2 and switches to local).\n";
}
