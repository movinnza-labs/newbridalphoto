<?php
$currentUrl = current_url();
$isHome = rtrim($currentUrl, '/') === rtrim(base_url(), '/');
?>
<header>
  <nav id="site-nav" class="site-nav <?= $isHome ? '' : 'scrolled' ?>">
    <div class="nav-inner">

      <!-- Logo -->
      <a href="<?= base_url('/') ?>" class="nav-logo" aria-label="The Bridal Photography - Home">
        <!-- Dark logo for white nav -->
        <picture>
          <source srcset="<?= base_url('assets/images/logo.webp') ?>" type="image/webp">
          <img class="nav-logo-light"
               src="<?= base_url('assets/images/logo.png') ?>"
               alt="The Bridal Photography" width="160" height="44" loading="eager">
        </picture>
        <!-- Light logo for transparent dark hero -->
        <picture>
          <source srcset="<?= base_url('assets/images/logo.webp') ?>" type="image/webp">
          <img class="nav-logo-dark"
               src="<?= base_url('assets/images/logo.png') ?>"
               alt="The Bridal Photography" width="160" height="44" loading="eager">
        </picture>
      </a>

      <!-- Desktop Links -->
      <ul class="nav-links">
        <li>
          <a href="<?= base_url('/') ?>" class="<?= $currentUrl === base_url('/') ? 'active' : '' ?>">Home</a>
        </li>

        <li class="nav-dropdown">
          <a href="<?= base_url('/pre-wedding-shoot-locations-in-pune/') ?>"
             class="<?= str_contains($currentUrl, 'pre-wedding') ? 'active' : '' ?>">
            Pre-Wedding ▾
          </a>
          <ul class="nav-dropdown-menu">
            <li><a href="<?= base_url('/pre-wedding-shoot-locations-in-pune/') ?>">Locations in Pune</a></li>
            <li><a href="<?= base_url('/pre-wedding-photography-packages/') ?>">Packages</a></li>
            <li><a href="<?= base_url('/pre-wedding-shoot-pune-under-10000/') ?>">Under ₹10,000</a></li>
            <li><a href="<?= base_url('/pre-wedding-shoot-satara/') ?>">Satara</a></li>
            <li><a href="<?= base_url('/pre-wedding-shoot-locations-mumbai/') ?>">Mumbai Locations</a></li>
            <li><a href="<?= base_url('/pre-wedding-shoot-locations-in-goa/') ?>">Goa</a></li>
            <li><a href="<?= base_url('/when-to-take-pre-wedding-shoot/') ?>">Timing Guide</a></li>
          </ul>
        </li>

        <li class="nav-dropdown">
          <a href="<?= base_url('/wedding-photography-packages/') ?>"
             class="<?= str_contains($currentUrl, 'wedding') ? 'active' : '' ?>">
            Wedding ▾
          </a>
          <ul class="nav-dropdown-menu">
            <li><a href="<?= base_url('/wedding-photography-packages/') ?>">Wedding Packages</a></li>
            <li><a href="<?= base_url('/wedding-films/') ?>">Wedding Films</a></li>
            <li><a href="<?= base_url('/best-destination-wedding-venues-pune/') ?>">Wedding Venue in Pune</a></li>
            <li><a href="<?= base_url('/engagement-photography-packages/') ?>">Engagement</a></li>
            <li><a href="<?= base_url('/roka-ring-ceremony-photography-pune/') ?>">Roka / Ring Ceremony</a></li>
          </ul>
        </li>

        <li class="nav-dropdown">
          <a href="<?= base_url('/maternity-photographer-pune/') ?>"
             class="<?= str_contains($currentUrl, 'maternity') || str_contains($currentUrl, 'baby-shower') ? 'active' : '' ?>">
            Maternity ▾
          </a>
          <ul class="nav-dropdown-menu">
            <li><a href="<?= base_url('/maternity-photographer-pune/') ?>">Maternity Photographer</a></li>
            <li><a href="<?= base_url('/maternity-photoshoot-locations-pune/') ?>">Maternity Locations</a></li>
            <li><a href="<?= base_url('/baby-shower-photography-packages/') ?>">Baby Shower</a></li>
          </ul>
        </li>

        <li class="nav-dropdown">
          <a href="<?= base_url('/services/') ?>"
             class="<?= str_contains($currentUrl, '/services') || str_contains($currentUrl, 'baby-photoshoot') || str_contains($currentUrl, 'newborn-photography') || str_contains($currentUrl, 'birthday-photography') || str_contains($currentUrl, 'housewarming-photography') || str_contains($currentUrl, 'product-photography') ? 'active' : '' ?>">
            Services ▾
          </a>
          <ul class="nav-dropdown-menu">
            <li><a href="<?= base_url('/baby-photoshoot-pune/') ?>">Baby Photoshoot</a></li>
            <li><a href="<?= base_url('/newborn-photography-pune/') ?>">Newborn Photography</a></li>
            <li><a href="<?= base_url('/birthday-photography-pune/') ?>">Birthday Photography</a></li>
            <li><a href="<?= base_url('/housewarming-photography-pune/') ?>">Housewarming Photography</a></li>
            <li><a href="<?= base_url('/fashion-and-product-photography/') ?>">Fashion &amp; Product Photography</a></li>
            <li><a href="<?= base_url('/services/') ?>">All Services</a></li>
          </ul>
        </li>

        <li class="nav-dropdown">
          <a href="<?= base_url('/mumbai/') ?>"
             class="<?= str_contains($currentUrl, 'mumbai') || str_contains($currentUrl, 'ahilyanagar') || str_contains($currentUrl, 'mahabaleshwar') || str_contains($currentUrl, 'lonavala') || str_contains($currentUrl, 'nashik') || str_contains($currentUrl, 'sambhajinagar') ? 'active' : '' ?>">
            Cities ▾
          </a>
          <ul class="nav-dropdown-menu">
            <li><a href="<?= base_url('/mumbai/') ?>">Mumbai Hub</a></li>
            <li><a href="<?= base_url('/ahilyanagar/') ?>">Ahilyanagar Hub</a></li>
            <li><a href="<?= base_url('/mahabaleshwar/') ?>">Mahabaleshwar</a></li>
            <li><a href="<?= base_url('/lonavala/') ?>">Lonavala</a></li>
            <li><a href="<?= base_url('/nashik/') ?>">Nashik</a></li>
            <li><a href="<?= base_url('/chhatrapati-sambhajinagar/') ?>">Chhatrapati Sambhajinagar</a></li>
          </ul>
        </li>

        <li><a href="<?= base_url('/blog/') ?>"
               class="<?= str_contains($currentUrl, '/blog') ? 'active' : '' ?>">Blog</a></li>

        <li><a href="<?= base_url('/faq/') ?>"
               class="<?= str_contains($currentUrl, '/faq') ? 'active' : '' ?>">FAQ</a></li>

        <li><a href="<?= base_url('/contact/') ?>"
               class="<?= str_contains($currentUrl, '/contact') ? 'active' : '' ?>">Contact</a></li>

        <li>
          <a href="tel:+918390367637" class="nav-cta">+91 83903 67637</a>
        </li>
      </ul>

      <!-- Hamburger -->
      <button id="nav-ham" class="nav-ham" aria-label="Open menu" aria-expanded="false" aria-controls="nav-mobile">
        <!-- Hamburger icon -->
        <svg class="ham-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <!-- Close icon -->
        <svg class="ham-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M18 6L6 18M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="nav-mobile">
      <a href="<?= base_url('/') ?>">Home</a>

      <div class="mob-group">
        <button class="mob-group-toggle" aria-expanded="false">
          Pre-Wedding <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="mob-group-links">
          <a href="<?= base_url('/pre-wedding-shoot-locations-in-pune/') ?>">Locations in Pune</a>
          <a href="<?= base_url('/pre-wedding-photography-packages/') ?>">Packages</a>
          <a href="<?= base_url('/pre-wedding-shoot-pune-under-10000/') ?>">Under ₹10,000</a>
          <a href="<?= base_url('/pre-wedding-shoot-satara/') ?>">Satara</a>
          <a href="<?= base_url('/pre-wedding-shoot-locations-mumbai/') ?>">Mumbai Locations</a>
          <a href="<?= base_url('/pre-wedding-shoot-locations-in-goa/') ?>">Goa</a>
          <a href="<?= base_url('/when-to-take-pre-wedding-shoot/') ?>">Timing Guide</a>
        </div>
      </div>

      <div class="mob-group">
        <button class="mob-group-toggle" aria-expanded="false">
          Wedding <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="mob-group-links">
          <a href="<?= base_url('/wedding-photography-packages/') ?>">Wedding Packages</a>
          <a href="<?= base_url('/wedding-films/') ?>">Wedding Films</a>
          <a href="<?= base_url('/best-destination-wedding-venues-pune/') ?>">Wedding Venue in Pune</a>
          <a href="<?= base_url('/engagement-photography-packages/') ?>">Engagement</a>
          <a href="<?= base_url('/roka-ring-ceremony-photography-pune/') ?>">Roka / Ring Ceremony</a>
        </div>
      </div>

      <div class="mob-group">
        <button class="mob-group-toggle" aria-expanded="false">
          Maternity <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="mob-group-links">
          <a href="<?= base_url('/maternity-photographer-pune/') ?>">Maternity Photographer</a>
          <a href="<?= base_url('/maternity-photoshoot-locations-pune/') ?>">Maternity Locations</a>
          <a href="<?= base_url('/baby-shower-photography-packages/') ?>">Baby Shower</a>
        </div>
      </div>

      <div class="mob-group">
        <button class="mob-group-toggle" aria-expanded="false">
          Services <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="mob-group-links">
          <a href="<?= base_url('/baby-photoshoot-pune/') ?>">Baby Photoshoot</a>
          <a href="<?= base_url('/newborn-photography-pune/') ?>">Newborn Photography</a>
          <a href="<?= base_url('/birthday-photography-pune/') ?>">Birthday Photography</a>
          <a href="<?= base_url('/housewarming-photography-pune/') ?>">Housewarming Photography</a>
          <a href="<?= base_url('/fashion-and-product-photography/') ?>">Fashion &amp; Product Photography</a>
          <a href="<?= base_url('/services/') ?>">All Services</a>
        </div>
      </div>

      <div class="mob-group">
        <button class="mob-group-toggle" aria-expanded="false">
          Cities <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="mob-group-links">
          <a href="<?= base_url('/mumbai/') ?>">Mumbai Hub</a>
          <a href="<?= base_url('/ahilyanagar/') ?>">Ahilyanagar Hub</a>
          <a href="<?= base_url('/mahabaleshwar/') ?>">Mahabaleshwar</a>
          <a href="<?= base_url('/lonavala/') ?>">Lonavala</a>
          <a href="<?= base_url('/nashik/') ?>">Nashik</a>
          <a href="<?= base_url('/chhatrapati-sambhajinagar/') ?>">Chhatrapati Sambhajinagar</a>
        </div>
      </div>

      <a href="<?= base_url('/blog/') ?>">Blog</a>
      <a href="<?= base_url('/faq/') ?>">FAQ</a>
      <a href="<?= base_url('/contact/') ?>">Contact</a>
      <a href="tel:+918390367637" class="mob-cta">📞 +91 83903 67637</a>
    </div>
  </nav>
</header>
