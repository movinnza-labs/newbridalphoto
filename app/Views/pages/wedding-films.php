<?php
// Films shown on this page. 'uploadDate' (YYYY-MM-DD, from YouTube) is needed for
// full VideoObject rich results; fill it in when known, it is skipped while null.
$films = [
  ['id' => 'Ssnxgp00FDk', 'title' => 'Goa Pre-Wedding Teaser',
   'alt' => "Still from a Goa pre-wedding teaser film of a couple",
   'desc' => 'A short pre-wedding teaser film shot in Goa by The Bridal Photography.', 'uploadDate' => null],
  ['id' => 'ifhp4rIs9iY', 'title' => 'Prajwal & Chanchal Full Cinematic Wedding Film',
   'alt' => "Still from Prajwal and Chanchal's cinematic wedding film",
   'desc' => 'The full cinematic wedding film of Prajwal and Chanchal, filmed by The Bridal Photography.', 'uploadDate' => null],
  ['id' => 'rQmaQcxtVHI', 'title' => 'Anil & Namrata Pre-Wedding Teaser at Thoseghar Waterfall',
   'alt' => "Still from Anil and Namrata's pre-wedding teaser at Thoseghar waterfall",
   'desc' => 'Pre-wedding teaser of Anil and Namrata, filmed at Thoseghar waterfall near Satara.', 'uploadDate' => null],
  ['id' => 'gWevGNMFv20', 'title' => 'Shruti & Pankaj Cinematic Wedding Teaser, Pune',
   'alt' => "Still from Shruti and Pankaj's cinematic wedding teaser in Pune",
   'desc' => 'Cinematic wedding teaser of Shruti and Pankaj, filmed at their wedding in Pune.', 'uploadDate' => null],
  ['id' => 'fJw2kZLnxms', 'title' => 'Vinay & Ashi Pre-Wedding Film in Lonavala',
   'alt' => "Still from Vinay and Ashi's pre-wedding film in Lonavala",
   'desc' => 'Pre-wedding film of Vinay and Ashi, shot in Lonavala by The Bridal Photography.', 'uploadDate' => null],
  ['id' => 'yt7YFkisqv8', 'title' => 'Marathi Wedding Highlights Teaser',
   'alt' => "Still from a Marathi wedding highlights teaser",
   'desc' => 'A highlights teaser from a traditional Marathi wedding, filmed by The Bridal Photography.', 'uploadDate' => null],
  ['id' => 'MQ9SZfRweoI', 'title' => 'Neha & Deven Pre-Wedding Teaser in Pune',
   'alt' => "Still from Neha and Deven's pre-wedding teaser in Pune",
   'desc' => 'Pre-wedding teaser of Neha and Deven, filmed at a pre-wedding shoot location in Pune.', 'uploadDate' => null],
  ['id' => '4pewQA45p54', 'title' => 'South Indian Wedding Teaser',
   'alt' => "Still from a South Indian wedding teaser film",
   'desc' => 'A wedding teaser from a South Indian wedding, filmed by The Bridal Photography.', 'uploadDate' => null],
];

$faqs = [
  ['What is the difference between a teaser and a full wedding film?',
   'A teaser is a 1 minute cinematic cut of your best moments, made to share on WhatsApp and social media. The cinematic film is 3 to 4 minutes long and tells the story of your whole day. A traditional film covers the events and rituals in full, and its length depends on the events and rituals covered.'],
  ['How long does it take to get our wedding film?',
   'Our delivery timeline for edited videos is 25 days. After delivery you get one round of revisions within 7 days.'],
  ['Do you offer drone shots?',
   'Yes. A drone pilot can be added for ₹6,000 per day. Drones are subject to DGCA and government rules, and the client is responsible for getting permission to fly a drone from the venue and local authorities.'],
  ['Can we choose the songs for our film?',
   'Yes. You are welcome to suggest songs that mean something to you as a couple. Our editors then pick music that suits the pace and feel of your film and is suitable for sharing online.'],
  ['Do you travel outside Pune for weddings?',
   'Yes. We film weddings in Pune, Mumbai, Goa and across Maharashtra. For events outside Pune, travel and accommodation are arranged by the client or charged as per actuals, and for outstation and Mumbai events the crew eats with guests or a per meal charge applies for each crew member.'],
];
?>

<section class="page-hero page-hero-split page-hero-portrait">
  <div class="page-hero-bg"></div>
  <div class="page-hero-img">
    <img src="<?= base_url('assets/images/wedding-photography-pune.webp') ?>"
         alt="Maharashtrian couple in traditional wedding attire posing against a stone wall"
         width="1920" height="700" loading="eager" fetchpriority="high">
  </div>
  <div class="page-hero-content">
    <div class="page-hero-content-inner">
      <p class="eyebrow page-hero-eyebrow">Cinematic Videography &middot; Pune &amp; Mumbai</p>
      <div class="page-hero-rule"></div>
      <h1>Cinematic Wedding Films<br><em>in Pune &amp; Mumbai</em></h1>
      <div class="page-hero-buttons">
        <a href="<?= base_url('/contact/') ?>" class="btn btn-gold">Contact Us</a>
        <a href="tel:+918390367637" class="btn btn-white">+91 83903 67637</a>
      </div>
    </div>
  </div>
</section>

<?= view('partials/breadcrumb') ?>

<!-- Wedding Films Grid -->
<section class="section section-white">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow section-head-eyebrow">Our Work</p>
      <div class="rule-center section-head-rule"></div>
      <h2 class="section-title">Our Recent<br><em>Wedding Films</em></h2>
      <p class="section-sub">Wedding films, teasers and pre-wedding films shot by our own team in Pune, Lonavala, Satara and Goa.</p>
    </div>

    <div class="film-grid">
      <?php foreach ($films as $film): ?>
      <div>
        <div class="film-grid-item">
          <a class="yt-facade" href="https://www.youtube.com/watch?v=<?= $film['id'] ?>"
             data-id="<?= $film['id'] ?>" data-title="<?= esc($film['title']) ?>"
             rel="noopener" target="_blank"
             aria-label="Play video: <?= esc($film['title']) ?>">
            <picture>
              <source srcset="https://i.ytimg.com/vi_webp/<?= $film['id'] ?>/hqdefault.webp" type="image/webp">
              <img src="https://i.ytimg.com/vi/<?= $film['id'] ?>/hqdefault.jpg" alt="<?= esc($film['alt']) ?>" loading="lazy" decoding="async" width="480" height="360">
            </picture>
            <span class="yt-play" aria-hidden="true"><svg viewBox="0 0 68 48" xmlns="http://www.w3.org/2000/svg"><path d="M66.52 7.74a8.6 8.6 0 0 0-6.05-6.06C55.13.5 34 .5 34 .5S12.87.5 7.53 1.68A8.6 8.6 0 0 0 1.48 7.74C.3 13.07.3 24 .3 24s0 10.93 1.18 16.26a8.6 8.6 0 0 0 6.05 6.06C12.87 47.5 34 47.5 34 47.5s21.13 0 26.47-1.18a8.6 8.6 0 0 0 6.05-6.06C67.7 34.93 67.7 24 67.7 24s0-10.93-1.18-16.26Z" fill="currentColor"/><path d="M27 34V14l18 10-18 10Z" fill="#fff"/></svg></span>
          </a>
        </div>
        <p class="film-grid-title"><?= esc($film['title']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php foreach ($films as $film) {
    $video = [
        '@context'     => 'https://schema.org',
        '@type'        => 'VideoObject',
        'name'         => $film['title'],
        'description'  => $film['desc'],
        'thumbnailUrl' => 'https://i.ytimg.com/vi/' . $film['id'] . '/hqdefault.jpg',
        'embedUrl'     => 'https://www.youtube.com/embed/' . $film['id'],
        'contentUrl'   => 'https://www.youtube.com/watch?v=' . $film['id'],
    ];
    if (! empty($film['uploadDate'])) {
        $video['uploadDate'] = $film['uploadDate'];
    }
    echo \App\Libraries\PageSchema::script($video);
} ?>

<!-- About Our Wedding Films -->
<section class="section section-off">
  <div class="container-sm">
    <div class="section-head">
      <p class="eyebrow section-head-eyebrow">Our Films</p>
      <div class="rule-center section-head-rule"></div>
      <h2 class="section-title">What Is in a<br><em>Wedding Film</em></h2>
    </div>

    <p class="article-text">A wedding film lets you hear the vows, the music and the laughter again, not just see them. Photos keep the moments, but a film keeps the voices, the movement and the mood of the day. Our films are shot by our own team on the Sony A7S3, a camera that handles low light well, which helps in evening receptions and indoor halls.</p>
    <p class="article-text">We have been filming weddings since 2014 in Pune, Mumbai, Goa and across Maharashtra. Most of our couples book a film along with their wedding photography, so one team covers both and the photos and film tell the same story.</p>

    <h3 class="article-heading">Types of wedding films we make</h3>
    <p class="article-text"><strong>Cinematic teaser.</strong> A 1 minute cinematic teaser with the best moments of your wedding. It is short and easy to share with family and friends on WhatsApp and social media, and it is often the first thing couples post after the wedding.</p>
    <p class="article-text"><strong>Cinematic film.</strong> A 3 to 4 minute cinematic film, also called a highlight film, that tells the story of your day from the first preparations to the last dance. It is cut to music, with the vows, speeches and emotional moments placed where they matter most.</p>
    <p class="article-text"><strong>Traditional film.</strong> A full film of the events and rituals for the family to keep. Its length depends on the events and rituals covered, so a long ceremony gives a longer film.</p>
    <p class="article-text">We also offer <a href="<?= base_url('/pre-wedding-photography-packages/') ?>" class="article-link">pre wedding shoot packages in Pune</a> with short pre-wedding films and teasers, like the Goa, Lonavala and Thoseghar films above.</p>

    <h3 class="article-heading">What you get</h3>
    <ul class="pkg-detail-list">
      <li>1 minute cinematic teaser</li>
      <li>3 to 4 minute cinematic film</li>
      <li>Traditional film of the events and rituals</li>
      <li>Edited videos delivered in 25 days</li>
      <li>One round of revisions within 7 days of delivery</li>
      <li>Pendrive of all images and films</li>
    </ul>

    <h3 class="article-heading">How the timeline works</h3>
    <p class="article-text">Before the wedding, we talk through your events, venues and the moments that matter most to you, so the team knows where to be and when. On the wedding day we film the rituals, the people and the small details as they happen, with as little interruption as possible. After the wedding, our editors select the best moments and build the film around them. Our delivery timeline for edited videos is 25 days, and you get one round of revisions within 7 days of delivery.</p>
    <p class="article-text">A few things help the film look its best. Leave about 20 minutes for a couple portrait session after each outfit change, as this is where many of the best cinematic shots come from. Share your event schedule and venue details with us early, so the team can plan for light and sound. Good decor and lighting at the venue also make a big difference on film.</p>

    <h3 class="article-heading">Choosing the music</h3>
    <p class="article-text">Music sets the mood of the whole film, so we ask for your ideas early. You are welcome to suggest songs that mean something to you as a couple. Our editors then pick music that suits the pace and feel of your film and is suitable for sharing online.</p>

    <h3 class="article-heading">Packages and prices</h3>
    <p class="article-text">Every wedding package includes a videographer. Our wedding photography and videography packages start from ₹35,000 per day.</p>
    <ul class="pkg-detail-list">
      <li><strong>Gold, ₹35,000 per day:</strong> traditional photography and traditional videography, with professional editing.</li>
      <li><strong>Platinum, ₹55,000 per day:</strong> candid and traditional photography with traditional videography.</li>
      <li><strong>Diamond, ₹75,000 per day:</strong> cinematic wedding films with candid and traditional photography and traditional videography.</li>
    </ul>
    <p class="article-text">You can add an extra videographer for ₹7,000 per day, a drone pilot for ₹6,000 per day, or same-day editing for ₹7,000. You pay 20% to book your date, with a full refund if you cancel 8 or more days before. See the full details on our <a href="<?= base_url('/wedding-photography-packages/') ?>" class="article-link">wedding photography packages</a> page, or call or WhatsApp <a href="tel:+918390367637" class="article-link">+91 83903 67637</a> to check your date.</p>

    <h3 class="article-heading">Why couples choose us for their film</h3>
    <ul class="pkg-detail-list">
      <li>More than 10 years of filming weddings, since 2014</li>
      <li>Our own team of photographers, videographers and editors</li>
      <li>4.9-star Google rating from 1,179 reviews</li>
      <li>Full-frame cameras, including the Sony A7S3 for low light</li>
      <li>One team for photos and film, so nothing is missed between the two</li>
      <li>Weddings in Pune, Mumbai, Goa and across Maharashtra</li>
    </ul>
  </div>
</section>

<!-- FAQ -->
<section class="section section-white">
  <div class="container-sm">
    <div class="section-head">
      <p class="eyebrow section-head-eyebrow">Common Questions</p>
      <div class="rule-center section-head-rule"></div>
      <h2 class="section-title">Wedding Film<br><em>FAQs</em></h2>
    </div>
    <?php foreach ($faqs as [$q, $a]): ?>
    <div class="faq-item"><button class="faq-trigger" type="button" aria-expanded="false"><span class="faq-q"><?= $q ?></span><span class="faq-icon">+</span></button><div class="faq-body"><p><?= $a ?></p></div></div>
    <?php endforeach; ?>
    <?= \App\Libraries\PageSchema::faqScript($faqs) ?>
  </div>
</section>

<!-- Related Pages -->
<section class="section-related-pages">
  <div class="container">
    <p class="eyebrow section-related-eyebrow">Related Pages</p>
    <div class="tag-links">
      <a href="<?= base_url('/wedding-photography-packages/') ?>" class="tag-link">Wedding Packages</a>
      <a href="<?= base_url('/pre-wedding-photography-packages/') ?>" class="tag-link">All Pre-Wedding Packages</a>
      <a href="<?= base_url('/engagement-photography-packages/') ?>" class="tag-link">Engagement Photography</a>
      <a href="<?= base_url('/contact/') ?>" class="tag-link">Contact Us</a>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="container-xs cta-section-inner">
    <h2 class="cta-title">Want a Film for Your Wedding?<br><em class="cta-title-em">Let's Talk.</em></h2>
    <div class="cta-buttons">
      <a href="<?= base_url('/contact/') ?>" class="btn btn-gold">Contact Us</a>
      <a href="https://wa.me/918390367637" class="btn btn-outline-dark" target="_blank" rel="noopener">WhatsApp Us</a>
    </div>
  </div>
</section>
