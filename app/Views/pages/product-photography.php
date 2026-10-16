
<section class="page-hero">
  <div class="page-hero-bg"></div>
  <div class="page-hero-img">
    <img src="<?= base_url('assets/images/fashion-hero-1.webp') ?>"
         alt="Fashion &amp; Retail Product Portfolio - The Bridal Photography"
         width="1920" height="700" loading="eager" fetchpriority="high">
  </div>
  <div class="page-hero-content">
    <div class="page-hero-content-inner">
      <p class="eyebrow page-hero-eyebrow">Fashion &amp; Product Photography &middot; Pune</p>
      <div class="page-hero-rule"></div>
      <h1>Fashion &amp; Retail Product<br><em>Portfolio</em></h1>
      <div class="page-hero-buttons">
        <a href="<?= base_url('/contact/') ?>" class="btn btn-gold">Book a Free Consultation</a>
        <a href="tel:+918390367637" class="btn btn-white">+91 83903 67637</a>
      </div>
    </div>
  </div>
</section>

<?= view('partials/breadcrumb') ?>

<!-- Intro -->
<section class="section section-white">
  <div class="container">
    <div class="section-head">
      <div class="rule-center section-head-rule"></div>
      <p class="section-sub">Welcome to our realm of exquisite visual storytelling, where every frame speaks volumes of elegance, allure, and sophistication. At The Bridal Photography, we transcend the boundaries of conventional photography, delving into the realm of fashion and retail product photography with finesse and creativity.</p>
      <p class="section-sub section-sub-gap">In the world of fashion and retail, every detail matters. Whether it's the intricate lace of a bridal gown or the luxurious texture of a high-end accessory, our photographers possess the keen eye and technical prowess to encapsulate the essence of your products. From glamorous fashion shoots to minimalist product showcases, we excel in creating captivating visuals that resonate with your target audience.</p>
    </div>
  </div>
</section>

<!-- Innovation Section -->
<section class="section section-off">
  <div class="container">
    <div class="feature-row feature-row-spaced">
      <div>
        <p class="article-text">Innovation is at the heart of everything we do. Our team of seasoned photographers collaborates closely with clients to understand their vision and brand identity. Through meticulous planning and creative brainstorming sessions, we conceptualize photo shoots that breathe life into your products, leaving a lasting impression on viewers.</p>
      </div>
      <div class="feature-img-wrap">
        <img src="<?= base_url('assets/images/fashion-hero-2.webp') ?>" alt="Fashion &amp; Retail Product Photography" loading="lazy" class="feature-img-full">
      </div>
    </div>
  </div>
</section>

<!-- Capturing Timeless Elegance -->
<section class="section section-white">
  <div class="container">
    <div class="section-head">
      <div class="rule-center section-head-rule"></div>
      <h2 class="section-title">Capturing Timeless Elegance: Fashion &amp; Retail<br><em>Product Photography</em></h2>
    </div>
    <div class="article-img-center">
      <a href="<?= base_url('/contact/') ?>" class="btn btn-gold">Book a Free Consultation</a>
    </div>
  </div>
</section>

<!-- Book a Free Consultation Form -->
<section class="section section-off">
  <div class="container">
    <div class="section-head">
      <div class="rule-center section-head-rule"></div>
      <h2 class="section-title">Book a Free<br><em>Consultation</em></h2>
    </div>
    <div class="contact-layout">
      <div class="enquire-form-card">
        <?= view("partials/form-flash") ?>
        <form method="post" action="<?= base_url('/contact/send/') ?>" novalidate>
          <?= csrf_field() ?>
          <input type="hidden" name="service" value="Fashion &amp; Product Photography">
          <div class="enquire-form-field"><label class="enquire-form-label">Name</label><input type="text" name="name" placeholder="Name" class="enquire-form-input"></div>
          <div class="enquire-form-field"><label class="enquire-form-label">Contact Number</label><input type="tel" name="phone" placeholder="Mobile Number" class="enquire-form-input" required></div>
          <div class="enquire-form-field"><label class="enquire-form-label">Email</label><input type="email" name="email" placeholder="Email" class="enquire-form-input"></div>
          <button type="submit" class="enquire-form-submit">Send</button>
        </form>
      </div>
      <div class="feature-img-wrap">
        <img src="<?= base_url('assets/images/fashion-hero-1.webp') ?>" alt="Fashion Photography" loading="lazy" class="feature-img-full">
      </div>
    </div>
  </div>
</section>

<!-- Related Pages -->
<section class="section-related-pages">
  <div class="container">
    <p class="eyebrow section-related-eyebrow">Related Pages</p>
    <div class="tag-links">
      <a href="<?= base_url('/services/') ?>" class="tag-link">All Services</a>
      <a href="<?= base_url('/wedding-photography-packages/') ?>" class="tag-link">Wedding Packages</a>
      <a href="<?= base_url('/contact/') ?>" class="tag-link">Contact Us</a>
      <a href="<?= base_url('/faq/') ?>" class="tag-link">FAQ</a>
    </div>
  </div>
</section>

<!-- Final CTA -->
<section class="cta-section">
  <div class="container-xs cta-section-inner">
    <h2 class="cta-title">Need a Photographer?<br><em class="cta-title-em">Someone With Experience to Collaborate With?</em></h2>
    <div class="cta-buttons">
      <a href="<?= base_url('/contact/') ?>" class="btn btn-gold">Let's Work</a>
      <a href="https://wa.me/918390367637" class="btn btn-outline-dark" target="_blank" rel="noopener">WhatsApp Us</a>
    </div>
  </div>
</section>
