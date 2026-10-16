<footer class="site-footer">
  <div class="footer-grid">

    <!-- Brand -->
    <div>
      <a href="<?= base_url('/') ?>">
        <picture>
          <source srcset="<?= base_url('assets/images/logo-dark.webp') ?>" type="image/webp">
          <img src="<?= base_url('assets/images/logo-dark.png') ?>"
               alt="The Bridal Photography" width="140" height="40" loading="lazy"
               style="height:40px;width:auto;opacity:.85;filter:brightness(0) invert(1);">
        </picture>
      </a>
      <p class="footer-brand-text">
        Award-winning wedding, pre-wedding & maternity photography studio.
        Pune · Mumbai · Ahilyanagar · Maharashtra.
      </p>
      <div class="footer-socials">
        <a href="https://www.instagram.com/thebridal.photography/" target="_blank" rel="noopener noreferrer"
           class="footer-social" aria-label="The Bridal Photography on Instagram">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <rect x="2.5" y="2.5" width="19" height="19" rx="5"/>
            <circle cx="12" cy="12" r="4.2"/>
            <circle cx="17.4" cy="6.6" r="1.1" fill="currentColor" stroke="none"/>
          </svg>
          <span class="visually-hidden">Follow The Bridal Photography on Instagram</span>
        </a>
        <a href="https://www.facebook.com/thebridalphotography" target="_blank" rel="noopener noreferrer"
           class="footer-social" aria-label="The Bridal Photography on Facebook">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
            <path d="M13.5 21.95v-8.2h2.76l.41-3.2h-3.17V8.5c0-.93.26-1.56 1.59-1.56h1.7V4.08a22.7 22.7 0 0 0-2.48-.13c-2.45 0-4.13 1.5-4.13 4.24v2.36H7.4v3.2h2.78v8.2h3.32Z"/>
          </svg>
          <span class="visually-hidden">Follow The Bridal Photography on Facebook</span>
        </a>
        <a href="https://www.youtube.com/channel/UCIR4wPINJDXZNhskW12faMA" target="_blank" rel="noopener noreferrer"
           class="footer-social" aria-label="The Bridal Photography on YouTube">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
            <path d="M21.6 7.2a2.5 2.5 0 0 0-1.76-1.77C18.3 5 12 5 12 5s-6.3 0-7.84.43A2.5 2.5 0 0 0 2.4 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.76 1.77C5.7 19 12 19 12 19s6.3 0 7.84-.43A2.5 2.5 0 0 0 21.6 16.8 26 26 0 0 0 22 12a26 26 0 0 0-.4-4.8ZM10 15V9l5.2 3L10 15Z"/>
          </svg>
          <span class="visually-hidden">Subscribe to The Bridal Photography on YouTube</span>
        </a>
      </div>
    </div>

    <!-- Services -->
    <div>
      <p class="footer-col-title">Services</p>
      <nav class="footer-links">
        <a href="<?= base_url('/about-us/') ?>">About Us</a>
        <a href="<?= base_url('/pre-wedding-shoot-locations-in-pune/') ?>">Pre-Wedding Shoot</a>
        <a href="<?= base_url('/wedding-photography-packages/') ?>">Wedding Photography</a>
        <a href="<?= base_url('/engagement-photography-packages/') ?>">Engagement</a>
        <a href="<?= base_url('/roka-ring-ceremony-photography-pune/') ?>">Roka Ceremony</a>
        <a href="<?= base_url('/maternity-photographer-pune/') ?>">Maternity</a>
        <a href="<?= base_url('/baby-shower-photography-packages/') ?>">Baby Shower</a>
        <a href="<?= base_url('/wedding-films/') ?>">Wedding Films</a>
        <a href="<?= base_url('/fashion-and-product-photography/') ?>">Product Photography</a>
      </nav>
    </div>

    <!-- Locations -->
    <div>
      <p class="footer-col-title">Locations</p>
      <nav class="footer-links">
        <a href="<?= base_url('/mumbai/') ?>">Mumbai</a>
        <a href="<?= base_url('/ahilyanagar/') ?>">Ahilyanagar</a>
        <a href="<?= base_url('/pre-wedding-shoot-satara/') ?>">Satara</a>
        <a href="<?= base_url('/pre-wedding-shoot-locations-in-goa/') ?>">Goa</a>
        <a href="<?= base_url('/pre-wedding-shoot-locations-mumbai/') ?>">Mumbai Pre-Wedding</a>
        <a href="<?= base_url('/maternity-photoshoot-locations-pune/') ?>">Maternity Locations</a>
      </nav>
    </div>

    <!-- Contact -->
    <div>
      <p class="footer-col-title">Contact Us</p>
      <div class="footer-links">
        <a href="tel:+918390367637"
           style="color:var(--gold);font-size:.95rem;font-weight:500;letter-spacing:.02em;">
          +91 83903 67637
        </a>
        <a href="mailto:thebridal11@gmail.com">thebridal11@gmail.com</a>
        <span style="color:rgba(248,244,239,.3);font-size:.78rem;margin-top:.4rem;">
          Katraj, Pune 411046
        </span>
        <span style="color:rgba(248,244,239,.3);font-size:.78rem;">Swargate, Pune</span>
        <span style="color:rgba(248,244,239,.3);font-size:.78rem;">Mumbai Branch</span>
      </div>
    </div>

  </div><!-- /footer-grid -->

  <div class="footer-bottom" style="padding:1.5rem 0;">
    <span class="footer-copy">
      © <?= date('Y') ?> The Bridal Photography · Wedding Photographers Pune, Mumbai &amp; Ahilyanagar · Search Engine Optimization by <a href="https://www.movinnza.in/" target="_blank" rel="noopener noreferrer" style="color:var(--gold);text-decoration:none;">Movinnza</a>
    </span>
    <nav style="display:flex;gap:1.5rem;">
      <a href="<?= base_url('/faq/') ?>" style="color:rgba(248,244,239,.25);font-size:.72rem;">FAQ</a>
      <a href="<?= base_url('/blog/') ?>" style="color:rgba(248,244,239,.25);font-size:.72rem;">Blog</a>
      <a href="<?= base_url('/services/') ?>" style="color:rgba(248,244,239,.25);font-size:.72rem;">Services</a>
    </nav>
  </div>
</footer>
