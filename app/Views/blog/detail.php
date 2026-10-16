<?php
/**
 * Blog detail view. Data is injected by App\Controllers\Blog::detail().
 *
 * @var array      $post     The blog post row.
 * @var array|null $related  Related posts (same category).
 */
$pub = !empty($post['published_at']) ? date('d F Y', strtotime($post['published_at'])) : '';
$catLabels = [
    'pre-wedding' => 'Pre-Wedding',
    'wedding'     => 'Wedding',
    'maternity'   => 'Maternity & Baby',
    'engagement'  => 'Engagement',
    'tips'        => 'Tips & Guides',
    'locations'   => 'Locations',
    'general'     => 'General',
];
$catLabel = $catLabels[$post['category'] ?? 'general'] ?? ucfirst($post['category'] ?? 'Blog');

// ── Inline CTA injection from DB (managed in admin panel) ────────
$content = $post['content'];

// Resolve relative blog image paths (e.g. assets/images/blog/x.webp) through
// base_url() so inline content images work in every environment (local + live).
$content = preg_replace_callback('#src="(assets/[^"]+)"#i', static function ($m) {
    return 'src="' . base_url($m[1]) . '"';
}, $content);
$ctaModel = new \App\Models\BlogCtaModel();
$ctas = $ctaModel->getForBlog((int) $post['id']);
$ctaAppend = '';
foreach ($ctas as $cta) {
    $styleClass = $cta['style'] === 'dark' ? 'blog-inline-cta-contact' : 'blog-inline-cta-book';
    $url = $cta['button_url'];
    if ($url !== '' && strpos($url, 'http') !== 0) {
        $url = base_url($url);
    }
    $box = '<div class="blog-inline-cta ' . esc($styleClass, 'attr') . '">'
         . '<p class="blog-inline-cta-text">' . esc($cta['heading']) . '</p>'
         . '<a href="' . esc($url, 'attr') . '" class="btn btn-white blog-inline-cta-btn">' . esc($cta['button_label']) . '</a>'
         . '</div>';

    $anchor = trim((string) ($cta['anchor_heading'] ?? ''));
    if ($anchor !== '') {
        // Try exact match with common heading tags and HTML-entity-encoded variant
        $variants = [
            '<h2>' . $anchor . '</h2>',
            '<h2>' . htmlspecialchars($anchor, ENT_QUOTES) . '</h2>',
            '<h3>' . $anchor . '</h3>',
        ];
        $replaced = false;
        foreach ($variants as $needle) {
            if (strpos($content, $needle) !== false) {
                $content = str_replace($needle, $box . $needle, $content);
                $replaced = true;
                break;
            }
        }
        // Fallback: append at end if anchor not found
        if (! $replaced) {
            $ctaAppend .= $box;
        }
    } else {
        $ctaAppend .= $box;
    }
}
$content .= $ctaAppend;
?>

<!-- ══ BLOG HERO ══════════════════════════════════════════════════════ -->
<section class="page-hero" style="min-height:60vh;">
  <?php if (!empty($post['featured_image'])): ?>
  <?php $heroImg = str_starts_with($post['featured_image'], 'http') ? $post['featured_image'] : base_url($post['featured_image']); ?>
  <div class="page-hero-img">
    <img src="<?= esc($heroImg) ?>"
         alt="<?= esc($post['featured_image_alt'] ?? $post['title']) ?>"
         width="1920" height="800" loading="eager" fetchpriority="high">
  </div>
  <?php endif; ?>
  <div class="page-hero-bg"></div>
  <div class="page-hero-content">
    <div style="max-width:860px;">
      <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.2rem;flex-wrap:wrap;">
        <span style="background:var(--gold);color:#fff;font-size:.62rem;letter-spacing:.14em;text-transform:uppercase;padding:.3rem .9rem;font-family:var(--font-body);font-weight:600;">
          <?= esc($catLabel) ?>
        </span>
        <?php if ($pub): ?>
        <span style="font-size:.72rem;color:rgba(255,255,255,.5);letter-spacing:.08em;"><?= $pub ?></span>
        <?php endif; ?>
        <?php if (!empty($post['view_count'])): ?>
        <span style="font-size:.72rem;color:rgba(255,255,255,.4);"><?= number_format($post['view_count']) ?> views</span>
        <?php endif; ?>
      </div>
      <h1><?= esc($post['title']) ?></h1>
      <?php if (!empty($post['excerpt'])): ?>
      <p class="page-hero-sub"><?= esc(strip_tags($post['excerpt'])) ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?= view('partials/breadcrumb') ?>

<!-- ══ ARTICLE ═══════════════════════════════════════════════════════ -->
<section class="section section-white">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 320px;gap:4rem;align-items:start;">

      <!-- Main content -->
      <article>
        <!-- Article body -->
        <div style="font-size:.95rem;color:var(--text-body);line-height:1.9;
                    font-family:var(--font-body);"
             class="blog-content">
          <?= $content ?>
        </div>

        <!-- Tags -->
        <?php if (!empty($post['tags'])): ?>
        <div style="margin-top:3rem;padding-top:1.5rem;border-top:1px solid var(--border-light);">
          <p class="eyebrow" style="margin-bottom:.75rem;">Tags</p>
          <div class="tag-links">
            <?php foreach (explode(',', $post['tags']) as $tag): ?>
            <?php if (trim($tag)): ?>
            <span class="tag-link" style="cursor:default;"><?= esc(trim($tag)) ?></span>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- Social share -->
        <div style="margin-top:2.5rem;padding-top:1.5rem;border-top:1px solid var(--border-light);">
          <p class="eyebrow" style="margin-bottom:.75rem;">Share This Article</p>
          <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
            <?php
            $shareUrl = urlencode('https://thebridal.photography/blog/' . $post['slug'] . '/');
            $shareTitle = urlencode($post['title']);
            ?>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>"
               target="_blank" rel="noopener noreferrer" class="tag-link">
              Share on Facebook
            </a>
            <a href="https://api.whatsapp.com/send?text=<?= $shareTitle . ' ' . $shareUrl ?>"
               target="_blank" rel="noopener noreferrer" class="tag-link">
              Share on WhatsApp
            </a>
            <a href="https://twitter.com/intent/tweet?url=<?= $shareUrl ?>&text=<?= $shareTitle ?>"
               target="_blank" rel="noopener noreferrer" class="tag-link">
              Share on Twitter
            </a>
          </div>
        </div>

        <!-- Author strip -->
        <div style="margin-top:3rem;padding:1.8rem;background:var(--bg-off);border:1px solid var(--border-light);display:flex;gap:1.5rem;align-items:center;">
          <div style="width:56px;height:56px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <span style="font-family:var(--font-serif);font-size:1.4rem;color:#fff;font-weight:400;">TB</span>
          </div>
          <div>
            <p style="font-weight:600;color:var(--text-primary);margin:0 0 .25rem;font-size:.9rem;">The Bridal Photography Team</p>
            <p style="font-size:.82rem;color:var(--text-muted);margin:0;line-height:1.6;">
              Award-winning photography studio in Pune & Mumbai with 10+ years of experience
              and 1,179+ happy couples. 4.9★ Google rated.
            </p>
          </div>
        </div>
      </article>

      <!-- Sidebar -->
      <aside style="position:sticky;top:6rem;">

        <!-- CTA box -->
        <div style="background:var(--bg-dark);padding:2rem;margin-bottom:2rem;border-top:3px solid var(--gold);">
          <p class="eyebrow" style="margin-bottom:.75rem;">Book a Session</p>
          <h3 style="font-family:var(--font-serif);font-size:1.4rem;color:var(--text-inverse);font-weight:400;margin:0 0 .75rem;line-height:1.3;">
            Ready to Capture Your Story?
          </h3>
          <p style="font-size:.8rem;color:rgba(248,244,239,.5);line-height:1.7;margin:0 0 1.4rem;">
            Packages from ₹6,000. 4.9★ rated. 1,179+ happy couples.
          </p>
          <a href="tel:+918390367637" class="btn btn-gold" style="display:block;text-align:center;width:100%;">
            +91 83903 67637
          </a>
          <a href="https://wa.me/918390367637" class="btn btn-outline-gold" style="display:block;text-align:center;width:100%;margin-top:.75rem;"
             target="_blank" rel="noopener noreferrer">
            WhatsApp Us
          </a>
        </div>

        <!-- Popular packages -->
        <div style="background:var(--bg-off);padding:1.5rem;border:1px solid var(--border-light);margin-bottom:2rem;">
          <p class="eyebrow" style="margin-bottom:1rem;">Popular Pages</p>
          <nav style="display:flex;flex-direction:column;gap:.5rem;">
            <?php foreach ([
              ['Pre-Wedding Locations', '/pre-wedding-shoot-locations-in-pune/'],
              ['Wedding Packages', '/wedding-photography-packages/'],
              ['Maternity Photography', '/maternity-photographer-pune/'],
              ['Budget Under ₹10K', '/pre-wedding-shoot-pune-under-10000/'],
              ['Satara Shoots', '/pre-wedding-shoot-satara/'],
              ['FAQ', '/faq/'],
            ] as [$label, $url]): ?>
            <a href="<?= base_url($url) ?>"
               style="font-size:.82rem;color:var(--text-muted);padding:.4rem 0;border-bottom:1px solid var(--border-light);display:flex;justify-content:space-between;align-items:center;text-decoration:none;transition:color .2s;"
               onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-muted)'">
              <?= $label ?> <span style="color:var(--gold);">→</span>
            </a>
            <?php endforeach; ?>
          </nav>
        </div>
      </aside>

    </div>
  </div>
</section>

<!-- ══ RELATED POSTS ══════════════════════════════════════════════════ -->
<?php if (!empty($related)): ?>
<section class="section section-off">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow" style="margin-bottom:.7rem;">Continue Reading</p>
      <div class="rule-center" style="margin-bottom:1.4rem;"></div>
      <h2 class="section-title" style="font-size:1.8rem;">Related Articles</h2>
    </div>

    <div class="blog-grid">
      <?php foreach ($related as $r): ?>
      <a href="<?= base_url('/blog/' . esc($r['slug']) . '/') ?>" class="blog-card" style="text-decoration:none;">
        <div class="blog-card-img">
          <?php if ($r['featured_image']): ?>
          <?php $rImg = str_starts_with($r['featured_image'], 'http') ? $r['featured_image'] : base_url($r['featured_image']); ?>
          <img src="<?= esc($rImg) ?>" alt="<?= esc($r['featured_image_alt'] ?? $r['title']) ?>"
               loading="lazy" width="600" height="375">
          <?php endif; ?>
        </div>
        <div class="blog-card-body">
          <p class="blog-card-cat"><?= esc(ucfirst(str_replace('-', ' ', $r['category'] ?? 'Blog'))) ?></p>
          <h3 class="blog-card-title"><?= esc($r['title']) ?></h3>
          <span class="blog-card-link">Read Article</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ══ CTA ══════════════════════════════════════════════════════════ -->
<section class="cta-section">
  <div class="container-xs" style="position:relative;z-index:1;text-align:center;">
    <h2 class="cta-title" style="margin-bottom:1rem;">
      Let's Create <em style="color:var(--gold);font-style:italic;">Beautiful Photos</em><br>Together
    </h2>
    <p class="cta-sub">20% advance to confirm · 100% refund if cancelled 8+ days before</p>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
      <a href="tel:+918390367637" class="btn btn-gold">Call +91 83903 67637</a>
      <a href="<?= base_url('/pre-wedding-photography-packages/') ?>" class="btn btn-outline-dark">View Packages</a>
    </div>
  </div>
</section>
