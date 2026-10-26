<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title><?= esc($title ?? 'Manage CTAs - Admin') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
</head>
<body style="margin:0;">

<div class="admin-layout">
  <?= view('admin/partials/sidebar', ['activePage' => 'blogs']) ?>

  <div class="admin-main">
    <div class="admin-topbar">
      <span class="admin-topbar-title">CTAs for: <?= esc(mb_strimwidth($post['title'], 0, 50, '…')) ?></span>
      <div style="display:flex;gap:.5rem;">
        <a href="<?= base_url('/admin/blogs/' . $post['id'] . '/ctas/create/') ?>" class="btn btn-gold btn-sm">+ Add CTA</a>
        <a href="<?= base_url('/admin/blogs/edit/' . $post['id'] . '/') ?>" class="btn btn-outline-dark btn-sm">Edit Post</a>
        <a href="<?= base_url('/admin/blogs/') ?>" class="btn btn-outline-dark btn-sm">← All Posts</a>
      </div>
    </div>

    <div class="admin-content">

      <?php if ($flashSuccess = session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= esc($flashSuccess) ?></div>
      <?php endif; ?>
      <?php if ($flashError = session()->getFlashdata('error')): ?>
      <div class="alert alert-error"><?= $flashError ?></div>
      <?php endif; ?>

      <div class="admin-card">
        <p style="font-size:.86rem;color:var(--text-muted);margin:0 0 1.2rem;">
          CTAs below are injected into the blog content at the anchor heading specified. Leave anchor empty to append at the end.
          <a href="<?= base_url('/blog/' . esc($post['slug']) . '/') ?>" target="_blank" style="color:var(--gold);">↗ Preview post</a>
        </p>

        <?php if (!empty($ctas)): ?>
        <table class="admin-table">
          <thead>
            <tr>
              <th>Order</th>
              <th>Heading</th>
              <th>Button</th>
              <th>Anchor (before H2)</th>
              <th>Style</th>
              <th>Active</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($ctas as $c): ?>
            <tr>
              <td style="width:60px;font-size:.85rem;color:var(--text-muted);"><?= (int) $c['sort_order'] ?></td>
              <td style="font-size:.88rem;font-weight:500;color:var(--text-primary);">
                <?= esc(mb_strimwidth($c['heading'], 0, 60, '…')) ?>
              </td>
              <td style="font-size:.82rem;">
                <span style="font-weight:500;color:var(--text-primary);"><?= esc($c['button_label']) ?></span><br>
                <span style="font-size:.72rem;color:var(--text-muted);"><?= esc($c['button_url']) ?></span>
              </td>
              <td style="font-size:.8rem;color:var(--text-muted);">
                <?= $c['anchor_heading'] ? esc(mb_strimwidth($c['anchor_heading'], 0, 40, '…')) : '<em>append at end</em>' ?>
              </td>
              <td>
                <span class="admin-badge <?= $c['style'] === 'dark' ? 'admin-badge-yellow' : 'admin-badge-green' ?>">
                  <?= ucfirst(esc($c['style'])) ?>
                </span>
              </td>
              <td style="text-align:center;">
                <?= $c['is_active'] ? '<span style="color:var(--gold);">●</span>' : '<span style="color:var(--border-light);">○</span>' ?>
              </td>
              <td>
                <div style="display:flex;gap:.4rem;flex-wrap:wrap;">
                  <a href="<?= base_url('/admin/blogs/' . $post['id'] . '/ctas/edit/' . $c['id'] . '/') ?>"
                     class="btn btn-sm btn-outline-dark">Edit</a>
                  <form action="<?= base_url('/admin/blogs/' . $post['id'] . '/ctas/delete/' . $c['id'] . '/') ?>"
                        method="post" style="display:inline;"
                        onsubmit="return confirm('Delete this CTA? This cannot be undone.')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <?php else: ?>
        <div style="text-align:center;padding:3rem;">
          <p style="color:var(--text-muted);margin-bottom:1.2rem;">No CTAs added to this post yet.</p>
          <a href="<?= base_url('/admin/blogs/' . $post['id'] . '/ctas/create/') ?>" class="btn btn-gold">+ Add First CTA</a>
        </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>

</body>
</html>
