<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title><?= esc($title ?? 'Manage Blogs — Admin') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
</head>
<body style="margin:0;">

<div class="admin-layout">
  <?= view('admin/partials/sidebar', ['activePage' => 'blogs']) ?>

  <div class="admin-main">
    <div class="admin-topbar">
      <span class="admin-topbar-title">Blog Posts (<?= $total ?? 0 ?>)</span>
      <a href="<?= base_url('/admin/blogs/create/') ?>" class="btn btn-gold btn-sm">+ New Post</a>
    </div>

    <div class="admin-content">

      <?php if ($flashSuccess = session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= esc($flashSuccess) ?></div>
      <?php endif; ?>

      <?php if ($flashError = session()->getFlashdata('error')): ?>
      <div class="alert alert-error"><?= $flashError ?></div>
      <?php endif; ?>

      <div class="admin-card">
        <?php if (!empty($posts)): ?>
        <table class="admin-table">
          <thead>
            <tr>
              <th style="width:36px;">#</th>
              <th>Title</th>
              <th>Category</th>
              <th>Status</th>
              <th>Featured</th>
              <th>Views</th>
              <th>Published</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($posts as $p): ?>
            <tr>
              <td style="font-size:.8rem;color:var(--text-light);"><?= $p['id'] ?></td>
              <td>
                <div style="font-weight:500;font-size:.88rem;color:var(--text-primary);margin-bottom:.2rem;">
                  <?= esc(mb_strimwidth($p['title'], 0, 65, '…')) ?>
                </div>
                <div style="font-size:.72rem;color:var(--text-light);">/blog/<?= esc($p['slug']) ?>/</div>
              </td>
              <td>
                <span style="font-size:.72rem;background:var(--bg-off);padding:.2rem .6rem;color:var(--text-muted);">
                  <?= esc($categories[$p['category']] ?? ucfirst($p['category'] ?? '—')) ?>
                </span>
              </td>
              <td>
                <span class="admin-badge <?= $p['status'] === 'published' ? 'admin-badge-green' : 'admin-badge-yellow' ?>">
                  <?= ucfirst(esc($p['status'])) ?>
                </span>
              </td>
              <td style="text-align:center;">
                <?= $p['is_featured'] ? '<span style="color:var(--gold);">★</span>' : '<span style="color:var(--border-light);">☆</span>' ?>
              </td>
              <td style="font-size:.8rem;color:var(--text-muted);"><?= number_format($p['view_count'] ?? 0) ?></td>
              <td style="font-size:.8rem;color:var(--text-muted);">
                <?= $p['published_at'] ? date('d M Y', strtotime($p['published_at'])) : '—' ?>
              </td>
              <td>
                <div style="display:flex;gap:.4rem;flex-wrap:wrap;">
                  <a href="<?= base_url('/admin/blogs/edit/' . $p['id'] . '/') ?>"
                     class="btn btn-sm btn-outline-dark">Edit</a>

                  <a href="<?= base_url('/admin/blogs/' . $p['id'] . '/ctas/') ?>"
                     class="btn btn-sm btn-outline-gold">CTAs</a>

                  <a href="<?= base_url('/blog/' . esc($p['slug']) . '/') ?>" target="_blank"
                     class="btn btn-sm btn-outline-gold">↗</a>

                  <form action="<?= base_url('/admin/blogs/delete/' . $p['id'] . '/') ?>"
                        method="post" style="display:inline;"
                        onsubmit="return confirm('Delete \'<?= esc(addslashes($p['title'])) ?>\'? This cannot be undone.')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <!-- Pagination -->
        <?php if (($totalPages ?? 1) > 1): ?>
        <div style="display:flex;gap:.5rem;margin-top:1.5rem;justify-content:center;">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <a href="<?= base_url('/admin/blogs/?page=' . $i) ?>"
             style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;border:1px solid <?= $i === ($currentPage ?? 1) ? 'var(--gold)' : 'var(--border-light)' ?>;font-size:.82rem;color:<?= $i === ($currentPage ?? 1) ? 'var(--gold)' : 'var(--text-muted)' ?>;text-decoration:none;">
            <?= $i ?>
          </a>
          <?php endfor; ?>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div style="text-align:center;padding:4rem;">
          <p style="color:var(--text-muted);margin-bottom:1.5rem;">No blog posts yet.</p>
          <a href="<?= base_url('/admin/blogs/create/') ?>" class="btn btn-gold">Create Your First Post</a>
        </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>

</body>
</html>
