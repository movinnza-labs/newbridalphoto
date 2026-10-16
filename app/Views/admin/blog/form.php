<?php
$p     = $post ?? null;
$isEdit= $isEdit ?? false;
$cats  = $categories ?? [];
$action= $isEdit ? base_url('/admin/blogs/update/' . ($p['id'] ?? '') . '/') : base_url('/admin/blogs/store/');
$old   = function(string $field, $default = '') use ($p) {
    return old($field, $p[$field] ?? $default);
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title><?= esc($title ?? 'Blog Form — Admin') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">

  <!-- TinyMCE CDN — free no-API-key self-hosted version -->
  <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body style="margin:0;">

<div class="admin-layout">
  <?= view('admin/partials/sidebar', ['activePage' => $isEdit ? 'blogs' : 'blogs-create']) ?>

  <div class="admin-main">
    <div class="admin-topbar">
      <span class="admin-topbar-title"><?= $isEdit ? 'Edit Blog Post' : 'Create New Blog Post' ?></span>
      <div style="display:flex;gap:1rem;">
        <?php if ($isEdit && $p): ?>
        <a href="<?= base_url('/blog/' . esc($p['slug']) . '/') ?>" target="_blank"
           class="btn btn-outline-gold btn-sm">↗ Preview</a>
        <?php endif; ?>
        <a href="<?= base_url('/admin/blogs/') ?>" class="btn btn-outline-dark btn-sm">← Back to List</a>
      </div>
    </div>

    <div class="admin-content" style="max-width:1100px;">

      <?php if ($flashError = session()->getFlashdata('error')): ?>
      <div class="alert alert-error"><?= $flashError ?></div>
      <?php endif; ?>

      <form action="<?= $action ?>" method="post" enctype="multipart/form-data" id="blog-form">
        <?= csrf_field() ?>

        <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

          <!-- Left: Main content -->
          <div>

            <!-- Title -->
            <div class="admin-card">
              <div class="form-group" style="margin-bottom:0;">
                <label class="form-label" for="title">Post Title <span style="color:#EF4444;">*</span></label>
                <input type="text" id="title" name="title" class="form-control"
                       value="<?= esc($old('title')) ?>"
                       placeholder="Enter an engaging blog title…"
                       oninput="autoSlug(this.value)"
                       style="font-size:1.05rem;font-weight:500;" required>
              </div>
            </div>

            <!-- Slug -->
            <div class="admin-card">
              <div class="form-group">
                <label class="form-label" for="slug">URL Slug</label>
                <div style="display:flex;align-items:center;gap:.5rem;">
                  <span style="font-size:.82rem;color:var(--text-muted);white-space:nowrap;">/blog/</span>
                  <input type="text" id="slug" name="slug" class="form-control"
                         value="<?= esc($old('slug')) ?>"
                         placeholder="post-url-slug">
                  <span style="font-size:.82rem;color:var(--text-muted);white-space:nowrap;">/</span>
                </div>
                <p class="form-hint">Auto-generated from title. Only lowercase letters, numbers and hyphens.</p>
              </div>

              <div class="form-group" style="margin-bottom:0;">
                <label class="form-label" for="excerpt">Short Excerpt</label>
                <textarea id="excerpt" name="excerpt" class="form-control" rows="3"
                          placeholder="Brief summary shown on blog listing page (160 chars recommended)…"><?= esc($old('excerpt')) ?></textarea>
                <p class="form-hint">Shown on blog listing and used as meta description fallback.</p>
              </div>
            </div>

            <!-- Content Editor -->
            <div class="admin-card">
              <label class="form-label" for="content">Content <span style="color:#EF4444;">*</span></label>
              <textarea id="content" name="content" class="form-control"
                        rows="20" placeholder="Write your blog content here…"><?= $old('content') ?></textarea>
            </div>

          </div><!-- /left -->

          <!-- Right: Meta & settings -->
          <div>

            <!-- Publish box -->
            <div class="admin-card">
              <h3 style="font-size:.85rem;font-weight:600;color:var(--text-primary);margin:0 0 1rem;padding-bottom:.75rem;border-bottom:1px solid var(--border-light);">
                Publish Settings
              </h3>

              <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select id="status" name="status" class="form-control">
                  <option value="draft"     <?= $old('status', 'draft') === 'draft'     ? 'selected' : '' ?>>Draft</option>
                  <option value="published" <?= $old('status', 'draft') === 'published' ? 'selected' : '' ?>>Published</option>
                  <option value="archived"  <?= $old('status', 'draft') === 'archived'  ? 'selected' : '' ?>>Archived</option>
                </select>
              </div>

              <div class="form-group">
                <label class="form-label" for="published_at">Publish Date</label>
                <input type="datetime-local" id="published_at" name="published_at" class="form-control"
                       value="<?= $p ? date('Y-m-d\TH:i', strtotime($p['published_at'] ?? 'now')) : date('Y-m-d\TH:i') ?>">
              </div>

              <div class="form-group">
                <label style="display:flex;align-items:center;gap:.6rem;cursor:pointer;font-size:.84rem;font-weight:500;color:var(--text-primary);">
                  <input type="checkbox" name="is_featured" value="1"
                         <?= ($old('is_featured', 0)) ? 'checked' : '' ?>
                         style="width:16px;height:16px;accent-color:var(--gold);">
                  Mark as Featured Post ★
                </label>
                <p class="form-hint">Featured posts are shown in the hero slot on the blog listing.</p>
              </div>

              <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
                <button type="submit" name="action" value="publish" class="btn btn-gold btn-sm">
                  <?= $isEdit ? '💾 Update Post' : '🚀 Publish Post' ?>
                </button>
                <button type="submit" name="action" value="draft" class="btn btn-outline-dark btn-sm"
                        onclick="document.getElementById('status').value='draft'">
                  Save as Draft
                </button>
              </div>
            </div>

            <!-- Category -->
            <div class="admin-card">
              <h3 style="font-size:.85rem;font-weight:600;color:var(--text-primary);margin:0 0 1rem;padding-bottom:.75rem;border-bottom:1px solid var(--border-light);">
                Category
              </h3>
              <div class="form-group" style="margin-bottom:0;">
                <select id="category" name="category" class="form-control">
                  <?php foreach ($cats as $key => $label): ?>
                  <option value="<?= esc($key) ?>" <?= $old('category', 'general') === $key ? 'selected' : '' ?>>
                    <?= esc($label) ?>
                  </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <!-- Featured Image -->
            <div class="admin-card">
              <h3 style="font-size:.85rem;font-weight:600;color:var(--text-primary);margin:0 0 1rem;padding-bottom:.75rem;border-bottom:1px solid var(--border-light);">
                Featured Image
              </h3>

              <?php if ($isEdit && !empty($p['featured_image'])): ?>
              <div style="margin-bottom:1rem;border:1px solid var(--border-light);padding:.5rem;">
                <img src="<?= base_url(esc($p['featured_image'])) ?>" alt="Current featured image"
                     style="width:100%;height:140px;object-fit:cover;display:block;">
                <p style="font-size:.7rem;color:var(--text-muted);margin:.4rem 0 0;text-align:center;">Current image</p>
              </div>
              <?php endif; ?>

              <div class="form-group">
                <label class="form-label" for="featured_image">
                  <?= $isEdit ? 'Replace Image' : 'Upload Image' ?>
                </label>
                <input type="file" id="featured_image" name="featured_image" class="form-control"
                       accept="image/jpeg,image/png,image/webp,image/gif">
                <p class="form-hint">Recommended: 1200×630px. Max 5MB. JPG/PNG/WebP.</p>
              </div>

              <div class="form-group" style="margin-bottom:0;">
                <label class="form-label" for="featured_image_alt">Image Alt Text</label>
                <input type="text" id="featured_image_alt" name="featured_image_alt" class="form-control"
                       value="<?= esc($old('featured_image_alt')) ?>"
                       placeholder="Describe the image for SEO & accessibility">
              </div>
            </div>

            <!-- SEO -->
            <div class="admin-card">
              <h3 style="font-size:.85rem;font-weight:600;color:var(--text-primary);margin:0 0 1rem;padding-bottom:.75rem;border-bottom:1px solid var(--border-light);">
                SEO Settings
              </h3>

              <div class="form-group">
                <label class="form-label" for="meta_title">
                  Meta Title
                  <span id="mt-count" style="font-weight:400;color:var(--text-light);float:right;"></span>
                </label>
                <input type="text" id="meta_title" name="meta_title" class="form-control"
                       value="<?= esc($old('meta_title')) ?>"
                       placeholder="Post title — The Bridal Photography"
                       oninput="countChars(this,'mt-count',60)">
                <p class="form-hint">Ideal: 50–60 characters. Auto-filled from title if empty.</p>
              </div>

              <div class="form-group" style="margin-bottom:0;">
                <label class="form-label" for="meta_description">
                  Meta Description
                  <span id="md-count" style="font-weight:400;color:var(--text-light);float:right;"></span>
                </label>
                <textarea id="meta_description" name="meta_description" class="form-control" rows="3"
                          placeholder="Concise description for search results (150–160 characters)…"
                          oninput="countChars(this,'md-count',160)"><?= esc($old('meta_description')) ?></textarea>
              </div>
            </div>

            <!-- Tags -->
            <div class="admin-card">
              <div class="form-group" style="margin-bottom:0;">
                <label class="form-label" for="tags">Tags</label>
                <input type="text" id="tags" name="tags" class="form-control"
                       value="<?= esc($old('tags')) ?>"
                       placeholder="pre-wedding, pune, locations">
                <p class="form-hint">Comma-separated tags.</p>
              </div>
            </div>

          </div><!-- /right -->
        </div><!-- /grid -->
      </form>

    </div>
  </div>
</div>

<script>
// Auto-generate slug from title
function autoSlug(title) {
  const slugField = document.getElementById('slug');
  // Only auto-fill if field is empty or matches a previously auto-filled value
  const currentSlug = slugField.value;
  const prevAutoSlug = slugField.dataset.auto || '';
  if (!currentSlug || currentSlug === prevAutoSlug) {
    const newSlug = title.toLowerCase()
      .replace(/[^\w\s-]/g, '')
      .replace(/[\s_-]+/g, '-')
      .replace(/^-+|-+$/g, '');
    slugField.value = newSlug;
    slugField.dataset.auto = newSlug;
  }
}

// Character counter
function countChars(el, counterId, ideal) {
  const len = el.value.length;
  const span = document.getElementById(counterId);
  if (span) {
    span.textContent = len + ' / ' + ideal;
    span.style.color = len > ideal ? '#EF4444' : len >= ideal * .85 ? '#22C55E' : 'var(--text-light)';
  }
}

// Init TinyMCE
tinymce.init({
  selector: '#content',
  height: 500,
  menubar: true,
  plugins: [
    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
    'insertdatetime', 'media', 'table', 'help', 'wordcount'
  ],
  toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
           'bullist numlist outdent indent | link image media | removeformat | code fullscreen help',
  image_title: true,
  automatic_uploads: true,
  images_upload_url: '<?= base_url('/admin/blogs/upload-image/') ?>',
  images_upload_credentials: true,
  file_picker_types: 'image',
  content_style: `
    body { font-family: 'Jost', sans-serif; font-size: 15px; color: #3D3028; line-height: 1.8; max-width: 800px; margin: 1rem auto; padding: 0 1rem; }
    h2 { font-family: 'Playfair Display', serif; color: #1C1612; }
    h3 { font-family: 'Playfair Display', serif; color: #1C1612; }
    a  { color: #C9A96E; }
    blockquote { border-left: 3px solid #C9A96E; padding: .75rem 1.25rem; background: #FAF8F4; }
  `,
  setup: function(editor) {
    editor.on('init', function() {
      // Trigger char count on init
      const metaTitle = document.getElementById('meta_title');
      const metaDesc  = document.getElementById('meta_description');
      if (metaTitle?.value) countChars(metaTitle, 'mt-count', 60);
      if (metaDesc?.value)  countChars(metaDesc, 'md-count', 160);
    });
  }
});
</script>

</body>
</html>
