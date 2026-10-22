<?= view('partials/breadcrumb') ?>
<section style="padding:7rem 2.5rem 5rem;background:var(--bg-off);">
  <div class="container-sm" style="text-align:center;">
    <p class="eyebrow" style="margin-bottom:.8rem;">Common Questions</p>
    <div class="rule-center" style="margin-bottom:1.5rem;"></div>
    <h1 class="section-title">Frequently Asked<br><em>Questions</em></h1>
    <p class="section-sub">Everything about booking, pricing, packages, locations and process. Can't find your answer? <a href="tel:+918390367637" style="color:var(--gold);">Call us</a> or <a href="https://wa.me/918390367637" style="color:var(--gold);" target="_blank" rel="noopener">WhatsApp</a>.</p>
  </div>
</section>
<section class="section section-white">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;">
      <div>
        <h2 style="font-family:var(--font-serif);font-size:1.5rem;color:var(--gold);margin:0 0 1.5rem;font-weight:400;">Pricing &amp; Packages</h2>
        <?php foreach([
          ['How much does a pre-wedding shoot cost?','Our pre-wedding packages are ₹14,999 (Gold), ₹29,999 (Platinum - most popular, with cinematic video and a 1 min reel) and ₹55,555 (Diamond - 2 days destination shoot). See our <a href="'.base_url('/pre-wedding-photography-packages/').'" style="color:var(--gold);">full packages page</a>. For a smaller budget, we also have a <a href="'.base_url('/pre-wedding-shoot-pune-under-10000/').'" style="color:var(--gold);">₹9,999 budget package</a>.'],
          ['How much does wedding photography cost?','Wedding packages: ₹35,000/day (Gold), ₹55,000/day (Platinum), ₹75,000/day (Diamond with cinematic film). All include a videographer.'],
          ['How much does maternity photography cost?','₹6,000 (Gold studio), ₹9,000 (Platinum studio + outdoor), ₹18,000 (Diamond full day + film). Designer gowns provided free.'],
          ['How much does engagement photography cost?','₹7,000 (Gold), ₹22,000 (Platinum), ₹35,000 (Diamond). Also covers Roka and ring ceremonies.'],
          ['Is there a budget option under ₹10,000?','Yes - our <a href="'.base_url('/pre-wedding-shoot-pune-under-10000/').'" style="color:var(--gold);">₹9,999 package</a> includes 1 candid photographer, a 3-hour session, 35 edited photos and all raw photos the next day through a drive link.'],
        ] as [$q,$a]): ?>
        <div class="faq-item"><button class="faq-trigger"><span class="faq-q"><?= $q ?></span><span class="faq-icon">+</span></button><div class="faq-body"><p><?= $a ?></p></div></div>
        <?php endforeach; ?>
      </div>
      <div>
        <h2 style="font-family:var(--font-serif);font-size:1.5rem;color:var(--gold);margin:0 0 1.5rem;font-weight:400;">Process &amp; Delivery</h2>
        <?php foreach([
          ['How many photos will I receive?','Wedding: 250 edited photos in 15 days. Pre-wedding: 60 to 70 edited photos with every package (Gold, Platinum and Diamond). Maternity: 30 to 100+ edited photos in 7 to 25 days, depending on the package.'],
          ['What is the cancellation policy?','20% advance confirms your date. 100% refund if cancelled 8 or more days before. Cancellations within 7 days are non-refundable.'],
          ['What if it rains on shoot day?','We monitor forecasts 48 hrs before. Outdoor shoots can be rescheduled at no charge. Equipment is fully weather-protected.'],
          ['How are photos delivered?','Via a private password-protected online gallery. Download all photos in full resolution. Albums (₹400/page) and raw data (₹6,500) are available add-ons.'],
          ['When should I do my maternity shoot?','28–32 weeks is ideal. We can shoot up to 36 weeks. Book at 20 weeks to secure your preferred date and outdoor location.'],
        ] as [$q,$a]): ?>
        <div class="faq-item"><button class="faq-trigger"><span class="faq-q"><?= $q ?></span><span class="faq-icon">+</span></button><div class="faq-body"><p><?= $a ?></p></div></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<section style="padding:2.5rem 2.5rem;background:var(--bg-warm);border-top:1px solid var(--border-light);">
  <div class="container"><p class="eyebrow" style="margin-bottom:.9rem;">Related Pages</p><div class="tag-links">
    <a href="<?= base_url('/pre-wedding-photography-packages/') ?>" class="tag-link">Pre-Wedding Packages</a>
    <a href="<?= base_url('/wedding-photography-packages/') ?>" class="tag-link">Wedding Packages</a>
    <a href="<?= base_url('/maternity-photographer-pune/') ?>" class="tag-link">Maternity Photography</a>
    <a href="<?= base_url('/engagement-photography-packages/') ?>" class="tag-link">Engagement</a>
    <a href="<?= base_url('/mumbai/') ?>" class="tag-link">Mumbai Hub</a>
    <a href="<?= base_url('/ahilyanagar/') ?>" class="tag-link">Ahilyanagar Hub</a>
  </div></div>
</section>
<section class="cta-section"><div class="container-xs" style="position:relative;z-index:1;text-align:center;">
  <h2 class="cta-title">Still Have Questions?<br><em style="color:var(--gold);font-style:italic;">We're Here to Help</em></h2>
  <p class="cta-sub">Call or WhatsApp us - we reply within 2 hours</p>
  <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
    <a href="tel:+918390367637" class="btn btn-gold">Call +91 83903 67637</a>
    <a href="https://wa.me/918390367637" class="btn btn-outline-dark" target="_blank" rel="noopener">WhatsApp Us</a>
  </div>
</div></section>
