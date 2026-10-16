<?php
$c      = $cta ?? null;
$isEdit = $isEdit ?? false;
$action = $isEdit
    ? base_url('/admin/blogs/' . $post['id'] . '/ctas/update/' . $c['id'] . '/')
    : base_url('/admin/blogs/' . $post['id'] . '/ctas/store/');
$old = function (string $field, $default = '') use ($c) {
    return old($field, $c[$field] ?? $default);
};

// Extract H2 headings from the blog content to help the user pick an anchor
$h2Options = [];
if (!empty($post['content'])) {
    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $post['content'], $m);
    foreach ($m[1] as $h) {
        $clean = trim(html_entity_decode(strip_tags($h)));
        if ($clean !== '') $h2Options[] = $clean;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title><?= esc($title ?? 'CTA Form - Admin') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
</head>
<body style="margin:0;">

<div class="admin-layout">
  <?= view('admin/partials/sidebar', ['activePage' => 'blogs']) ?>

  <div class="admin-main">
    <div class="admin-topbar">
      <span class="admin-topbar-title"><?= $isEdit ? 'Edit CTA' : 'Add New CTA' ?></span>
      <a href="<?= base_url('/admin/blogs/' . $post['id'] . '/ctas/') ?>" class="btn btn-outline-dark btn-sm">← Back to CTAs</a>
    </div>

    <div class="admin-content" style="max-width:780px;">

      <?php if ($flashError = session()->getFlashdata('error')): ?>
      <div class="alert alert-error"><?= $flashError ?></div>
      <?php endif; ?>

      <form action="<?= $action ?>" method="post">
        <?= csrf_field() ?>

        <div class="admin-card">
          <p style="font-size:.82rem;color:var(--text-muted);margin:0 0 1.2rem;">
            Adding CTA for: <strong><?= esc($post['title']) ?></strong>
          </p>

          <div class="form-group">
            <label class="form-label" for="heading">CTA Heading <span style="color:#EF4444;">*</span></label>
            <input type="text" id="heading" name="heading" class="form-control"
                   value="<?= esc($old('heading')) ?>"
                   placeholder="e.g. Contact us today to begin your journey!" required>
            <p class="form-hint">Shown as the main message inside the CTA box.</p>
          </div>

          <div class="form-group">
            <label class="form-label" for="button_label">Button Label <span style="color:#EF4444;">*</span></label>
            <input type="text" id="button_label" name="button_label" class="form-control"
                   value="<?= esc($old('button_label')) ?>"
                   placeholder="e.g. Contact Us" required>
          </div>

          <div class="form-group">
            <label class="form-label" for="button_url">Button URL <span style="color:#EF4444;">*</span></label>
            <input type="text" id="button_url" name="button_url" class="form-control"
                   value="<?= esc($old('button_url', '/contact/')) ?>"
                   placeholder="/contact/" required>
            <p class="form-hint">Relative path like <code>/contact/</code> or a full URL.</p>
          </div>

          <div class="form-group">
            <label class="form-label" for="anchor_heading">Anchor (Insert Before Heading)</label>
            <select id="anchor_heading" name="anchor_heading" class="form-control">
              <option value="">— Append at end of post —</option>
              <?php foreach ($h2Options as $h2): ?>
              <option value="<?= esc($h2) ?>" <?= $old('anchor_heading') === $h2 ? 'selected' : '' ?>>
                Before: <?= esc(mb_strimwidth($h2, 0, 80, '…')) ?>
              </option>
              <?php endforeach; ?>
            </select>
            <p class="form-hint">CTA will be inserted just above this section heading. Leave empty to append at the end.</p>
          </div>

          <div class="form-group">
            <label class="form-label" for="style">Visual Style</label>
            <select id="style" name="style" class="form-control">
              <option value="light" <?= $old('style', 'light') === 'light' ? 'selected' : '' ?>>Light (off-white background, gold border)</option>
              <option value="dark"  <?= $old('style', 'light') === 'dark'  ? 'selected' : '' ?>>Dark (black background, white text)</option>
            </select>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label" for="sort_order">Sort Order</label>
              <input type="number" id="sort_order" name="sort_order" class="form-control"
                     value="<?= esc($old('sort_order', 0)) ?>" min="0">
              <p class="form-hint">Lower numbers render first.</p>
            </div>
            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label">Active</label>
              <label style="display:flex;align-items:center;gap:.6rem;cursor:pointer;font-size:.88rem;margin-top:.6rem;">
                <input type="checkbox" name="is_active" value="1"
                       <?= $old('is_active', 1) ? 'checked' : '' ?>
                       style="width:16px;height:16px;accent-color:var(--gold);">
                Show this CTA on the blog page
              </label>
            </div>
          </div>

          <div style="margin-top:1.6rem;display:flex;gap:.75rem;">
            <button type="submit" class="btn btn-gold">
              <?= $isEdit ? '💾 Update CTA' : '+ Save CTA' ?>
            </button>
            <a href="<?= base_url('/admin/blogs/' . $post['id'] . '/ctas/') ?>" class="btn btn-outline-dark">Cancel</a>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

</body>
</html>
