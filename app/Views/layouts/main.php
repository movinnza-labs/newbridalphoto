<?php
  // Self-referencing canonical: use the controller value, else the current
  // path with a trailing slash (never fall back to the homepage).
  if (empty($canonical)) {
      $canonical = '/' . trim(uri_string(), '/');
      if ($canonical !== '/') {
          $canonical .= '/';
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? 'The Bridal Photography | Pune & Mumbai') ?></title>
  <meta name="description" content="<?= esc($description ?? 'Award-winning wedding & pre-wedding photography in Pune & Mumbai.') ?>">
    <meta name="google-site-verification" content="0AijdY0IhZTBFYpeevIgDR_9a7RHWNvqH8rJES1VUMs" />
  <link rel="canonical" href="https://thebridal.photography<?= esc($canonical ?? '/') ?>">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/icons/favicon.ico') ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/images/icons/favicon.png') ?>">
  <link rel="apple-touch-icon" href="<?= base_url('assets/images/icons/favicon.png') ?>">

  <!-- LCP hero image preload (set $preloadImage from controller to enable) -->
  <?php if (!empty($preloadImage)): ?>
  <link rel="preload" as="image" href="<?= base_url($preloadImage) ?>" fetchpriority="high" type="image/webp">
  <?php endif; ?>

  <!-- Open Graph -->
  <meta property="og:title"       content="<?= esc($title ?? 'The Bridal Photography') ?>">
  <meta property="og:description" content="<?= esc($description ?? '') ?>">
  <meta property="og:url"         content="https://thebridal.photography<?= esc($canonical ?? '/') ?>">
  <meta property="og:type"        content="<?= isset($post) ? 'article' : 'website' ?>">
  <meta property="og:image"       content="<?= esc($og_image ?? base_url('assets/images/logo.png')) ?>">
  <meta name="twitter:card"       content="summary_large_image">
  <meta name="robots"             content="index, follow">

  <!-- Fonts: auto-detect self-hosted; fall back to Google Fonts until woff2 files are uploaded -->
  <?php $localFontsReady = is_file(FCPATH . 'assets/fonts/jost-latin.woff2'); ?>
  <?php if ($localFontsReady): ?>
    <!-- Local self-hosted fonts (faster: no external DNS/TLS, same-origin cache) -->
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="<?= base_url('assets/fonts/jost-latin.woff2') ?>">
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="<?= base_url('assets/fonts/playfair-latin.woff2') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/fonts.css?v=150526.1') ?>">
  <?php else: ?>
    <!-- Google Fonts fallback (until self-hosted woff2 files are uploaded to assets/fonts/) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style"
          href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap"
          media="print" onload="this.media='all'">
    <noscript>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap">
    </noscript>
  <?php endif; ?>

  <!-- CSS (minified in place; cache-buster bumped) -->
  <link rel="stylesheet" href="<?= base_url('assets/css/main.css?v=161026.0') ?>">

  <!-- Visually-hidden utility (for accessible icon-only links) -->
  <style>.visually-hidden{position:absolute!important;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}</style>

  <?php if (isset($extraHead)) echo $extraHead; ?>

  <!-- JSON-LD Base -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "@id": "https://thebridal.photography/#business",
    "name": "The Bridal Photography",
    "url": "https://thebridal.photography/",
    "telephone": "+918390367637",
    "email": "thebridal11@gmail.com",
    "priceRange": "₹₹",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Katraj",
      "addressLocality": "Pune",
      "addressRegion": "Maharashtra",
      "postalCode": "411046",
      "addressCountry": "IN"
    },
    "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": "4.9",
      "reviewCount": "1179",
      "bestRating": "5"
    },
    "image": "<?= base_url('assets/images/logo.png') ?>",
    "sameAs": [
      "https://www.instagram.com/thebridal.photography/",
      "https://www.facebook.com/thebridalphotography",
      "https://www.youtube.com/channel/UCIR4wPINJDXZNhskW12faMA"
    ]
  }
  </script>
  <?php if (isset($schemaExtra)) echo $schemaExtra; ?>
<!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-46LBNQBYLV"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-46LBNQBYLV');
  </script>
</head>
<body>

  <?= view('partials/header') ?>

  <main id="main-content">
    <?= view($view ?? 'pages/home', get_defined_vars()) ?>
  </main>

  <?= view('partials/footer') ?>

 
  <!-- WhatsApp Float -->
  <?php
    // Build a per-page WhatsApp message: page name + canonical URL.
    // JS in main.js will refresh the same href client-side as a safety net.
    $waSiteName = 'The Bridal Photography';
    $waPageName = trim(preg_replace('/\s*[|·].*$/u', '', $title ?? $waSiteName)) ?: $waSiteName;
    $waPageUrl  = 'https://thebridal.photography' . ($canonical ?? '/');
    $waMessage  = "Hi *{$waSiteName}*! I need more info about {$waPageName} {$waPageUrl}";
  ?>
  <a href="https://wa.me/918390367637?text=<?= rawurlencode($waMessage) ?>"
     class="wa-float" target="_blank" rel="noopener noreferrer nofollow"
     aria-label="Chat with The Bridal Photography on WhatsApp">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" aria-hidden="true" focusable="false">
      <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.15-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
    </svg>
    <span class="visually-hidden">Chat with us on WhatsApp</span>
  </a>
  <script src="<?= base_url('assets/js/main.js?v=190526.0') ?>" defer></script>
</body>
</html>
