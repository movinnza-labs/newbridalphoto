<?php
$catLabels = $categories ?? [];
?>

<?= view('partials/breadcrumb') ?>

<!-- ══ PAGE HERO ══════════════════════════════════════════════════════ -->
<section class="page-hero">
  <div class="page-hero-bg"></div>
  <div class="page-hero-content">
    <div style="max-width:1320px;margin:0 auto;display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:2rem;">
      <div>
        <p class="eyebrow" style="margin-bottom:.75rem;">Photography Journal</p>
        <div style="width:52px;height:1px;background:linear-gradient(90deg,var(--gold),transparent);margin-bottom:1.4rem;"></div>
        <h1>Guides, Stories and<br><em>Inspiration</em></h1>
        <p class="page-hero-sub">
          Pre-wedding location guides, photography tips and behind-the-scenes stories
          from our shoots across Maharashtra and beyond.
        </p>
      </div>
      <div style="text-align:right;">
        <div style="font-family:var(--font-serif);font-size:3rem;color:var(--gold);line-height:1;"><?= $total ?? 0 ?></div>
        <div style="font-size:.62rem;letter-spacing:.18em;text-transform:uppercase;color:rgba(248,244,239,.35);">Articles</div>
      </div>
    </div>
  </div>
</section>

<!-- ══ FEATURED POST ══════════════════════════════════════════════════ -->
<?php if (!empty($featured)): $f = $featured; ?>
<section class="section section-white" style="padding-bottom:0;">
  <div class="container">
    <p class="eyebrow" style="margin-bottom:1.2rem;">Featured Article</p>
    <a href="<?= base_url('/blog/' . esc($f['slug']) . '/') ?>" class="featured-post">
      <div class="featured-post-img">
        <?php if ($f['featured_image']): ?>
        <?php $fImg = str_starts_with($f['featured_image'], 'http') ? $f['featured_image'] : base_url($f['featured_image']); ?>
        <img src="<?= esc($fImg) ?>"
             alt="<?= esc($f['featured_image_alt'] ?? $f['title']) ?>"
             loading="eager" fetchpriority="high" width="800" height="500">
        <?php endif; ?>
      </div>
      <div class="featured-post-body">
        <p class="eyebrow" style="margin-bottom:.75rem;">
          <?= esc($catLabels[$f['category']] ?? ucfirst($f['category'] ?? 'Blog')) ?>
          &nbsp;·&nbsp;
          <?= $f['published_at'] ? date('M Y', strtotime($f['published_at'])) : '' ?>
        </p>
        <h2 class="featured-post-title"><?= esc($f['title']) ?></h2>
        <p class="featured-post-excerpt">
          <?= esc(substr(strip_tags($f['excerpt'] ?? $f['content'] ?? ''), 0, 200)) ?>…
        </p>
        <span class="featured-post-link">Read Full Article →</span>
      </div>
    </a>
  </div>
</section>
<?php endif; ?>

<!-- ══ FILTER + GRID ══════════════════════════════════════════════════ -->
<section class="section section-white">
  <div class="container">

    <!-- Filter tabs -->
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border-light);">
      <p style="font-size:.65rem;letter-spacing:.2em;text-transform:uppercase;color:var(--text-muted);margin:0;">
        <?= $total ?? 0 ?> Articles
      </p>
      <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
        <button class="tag-link" data-filter="all" style="cursor:pointer;background:var(--gold);color:#fff;border-color:var(--gold);" onclick="this.closest('section').querySelectorAll('[data-filter]').forEach(b=>b.style='');this.style='background:var(--gold);color:#fff;border-color:var(--gold)';">All</button>
        <?php foreach ($catLabels as $key => $label): ?>
        <button class="tag-link" data-filter="<?= esc($key) ?>" style="cursor:pointer;"
                onclick="filterBlog('<?= esc($key) ?>', this)">
          <?= esc($label) ?>
        </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Blog grid -->
    <?php if (!empty($posts)): ?>
    <div class="blog-grid" id="blog-grid">
      <?php foreach ($posts as $p): ?>
      <article class="blog-card" data-post-cat="<?= esc($p['category'] ?? 'general') ?>">
        <div class="blog-card-img">
          <?php if ($p['featured_image']): ?>
          <?php $pImg = str_starts_with($p['featured_image'], 'http') ? $p['featured_image'] : base_url($p['featured_image']); ?>
          <img src="<?= esc($pImg) ?>"
               alt="<?= esc($p['featured_image_alt'] ?? $p['title']) ?>"
               loading="lazy" width="600" height="375">
          <?php else: ?>
          <div style="width:100%;height:200px;background:var(--bg-cream);display:flex;align-items:center;justify-content:center;">
            <span style="color:var(--gold);font-family:var(--font-serif);font-size:1.5rem;">TB</span>
          </div>
          <?php endif; ?>
        </div>
        <div class="blog-card-body">
          <span class="blog-card-cat"><?= esc($catLabels[$p['category']] ?? ucfirst($p['category'] ?? 'Blog')) ?></span> <h3 class="blog-card-title"><a href="<?= base_url('/blog/' . esc($p['slug']) . '/') ?>"><?= esc($p['title']) ?></a></h3>
          <p class="blog-card-excerpt">
            <?= esc(substr(strip_tags($p['excerpt'] ?? $p['content'] ?? ''), 0, 120)) ?>…
          </p>
          <div class="blog-card-meta">
            <?= $p['published_at'] ? date('d M Y', strtotime($p['published_at'])) : '' ?>
            <?php if (!empty($p['view_count'])): ?> · <?= number_format($p['view_count']) ?> views<?php endif; ?>
          </div>
          <span class="blog-card-link">Read Article</span>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if (($totalPages ?? 1) > 1): ?>
    <div style="display:flex;justify-content:center;gap:.5rem;margin-top:3rem;flex-wrap:wrap;">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <a href="<?= base_url('/blog/?page=' . $i) ?>"
         style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border:1px solid <?= $i === ($currentPage ?? 1) ? 'var(--gold)' : 'var(--border-light)' ?>;font-size:.82rem;color:<?= $i === ($currentPage ?? 1) ? 'var(--gold)' : 'var(--text-muted)' ?>;background:<?= $i === ($currentPage ?? 1) ? 'var(--gold-pale)' : 'transparent' ?>;transition:all .2s;text-decoration:none;">
        <?= $i ?>
      </a>
      <?php endfor; ?>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div style="text-align:center;padding:5rem 0;">
      <p style="color:var(--text-muted);font-size:1rem;">No blog posts found.</p>
      <a href="<?= base_url('/blog/') ?>" class="btn btn-gold" style="margin-top:1.5rem;">View All Articles</a>
    </div>
    <?php endif; ?>

  </div>
</section>

<!-- Topic hub -->
<section style="padding:3rem 2.5rem;background:var(--bg-off);border-top:1px solid var(--border-light);">
  <div class="container">
    <p class="eyebrow" style="margin-bottom:1rem;">Explore by Topic</p>
    <div class="tag-links">
      <?php foreach ([
        ['Pre-Wedding Locations Pune',  '/pre-wedding-shoot-locations-in-pune/'],
        ['Satara & Kaas Plateau',       '/pre-wedding-shoot-satara/'],
        ['Goa Pre-Wedding',             '/pre-wedding-shoot-locations-in-goa/'],
        ['Mumbai Shoots',               '/pre-wedding-shoot-locations-mumbai/'],
        ['When to Shoot',               '/when-to-take-pre-wedding-shoot/'],
        ['Budget Under ₹10K',           '/pre-wedding-shoot-pune-under-10000/'],
        ['Maternity Photography',       '/maternity-photographer-pune/'],
        ['Engagement Photography',      '/engagement-photography-packages/'],
        ['FAQ',                         '/faq/'],
      ] as [$label, $url]): ?>
      <a href="<?= base_url($url) ?>" class="tag-link"><?= $label ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
function filterBlog(cat, btn) {
  document.querySelectorAll('[data-filter]').forEach(b => {
    b.style.background = ''; b.style.color = ''; b.style.borderColor = '';
  });
  btn.style.background = 'var(--gold)'; btn.style.color = '#fff'; btn.style.borderColor = 'var(--gold)';
  document.querySelectorAll('[data-post-cat]').forEach(card => {
    card.style.display = (cat === 'all' || card.dataset.postCat === cat) ? '' : 'none';
  });
}
</script>
