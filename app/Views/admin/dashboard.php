<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title><?= esc($title ?? 'Admin — The Bridal Photography') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
</head>
<body style="margin:0;">

<div class="admin-layout">
  <!-- Sidebar -->
  <?= view('admin/partials/sidebar', ['activePage' => 'dashboard']) ?>

  <!-- Main -->
  <div class="admin-main">
    <div class="admin-topbar">
      <span class="admin-topbar-title">Dashboard</span>
      <div style="display:flex;align-items:center;gap:1rem;">
        <a href="<?= base_url('/') ?>" target="_blank"
           style="font-size:.75rem;color:var(--text-muted);text-decoration:none;">
          ↗ View Website
        </a>
      </div>
    </div>

    <div class="admin-content">

      <!-- Stats -->
      <div class="grid-4" style="gap:1rem;margin-bottom:2rem;">
        <?php foreach ([
          ['Total Posts',  $totalBlogs ?? 0,   '#6366F1', '📝'],
          ['Published',    $published ?? 0,    '#22C55E', '✅'],
          ['Drafts',       $drafts ?? 0,       '#F59E0B', '📋'],
          ['Categories',   7,                  '#8B5CF6', '🏷'],
        ] as [$label, $value, $color, $icon]): ?>
        <div class="admin-card" style="margin-bottom:0;border-top:3px solid <?= $color ?>;">
          <div style="font-size:1.8rem;margin-bottom:.25rem;"><?= $icon ?></div>
          <div style="font-family:var(--font-serif);font-size:2.2rem;color:var(--text-primary);line-height:1;"><?= $value ?></div>
          <div style="font-size:.72rem;letter-spacing:.12em;text-transform:uppercase;color:var(--text-muted);margin-top:.25rem;"><?= $label ?></div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Recent posts -->
      <div class="admin-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.2rem;">
          <h2 style="font-size:1rem;font-weight:600;color:var(--text-primary);margin:0;">Recent Blog Posts</h2>
          <a href="<?= base_url('/admin/blogs/create/') ?>" class="btn btn-gold btn-sm">+ New Post</a>
        </div>

        <?php if (!empty($recentBlogs)): ?>
        <table class="admin-table">
          <thead>
            <tr>
              <th>Title</th>
              <th>Category</th>
              <th>Status</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recentBlogs as $p): ?>
            <tr>
              <td>
                <a href="<?= base_url('/blog/' . esc($p['slug']) . '/') ?>" target="_blank"
                   style="color:var(--text-primary);font-weight:500;text-decoration:none;font-size:.86rem;">
                  <?= esc(mb_strimwidth($p['title'], 0, 60, '…')) ?>
                </a>
              </td>
              <td style="font-size:.8rem;color:var(--text-muted);"><?= esc(ucfirst($p['category'] ?? '—')) ?></td>
              <td>
                <span class="admin-badge <?= $p['status'] === 'published' ? 'admin-badge-green' : 'admin-badge-yellow' ?>">
                  <?= esc(ucfirst($p['status'])) ?>
                </span>
              </td>
              <td style="font-size:.8rem;color:var(--text-muted);">
                <?= $p['published_at'] ? date('d M Y', strtotime($p['published_at'])) : '—' ?>
              </td>
              <td>
                <div style="display:flex;gap:.5rem;">
                  <a href="<?= base_url('/admin/blogs/edit/' . $p['id'] . '/') ?>" class="btn btn-sm btn-outline-dark">Edit</a>
                  <a href="<?= base_url('/blog/' . esc($p['slug']) . '/') ?>" target="_blank" class="btn btn-sm btn-outline-gold">View</a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php else: ?>
        <div style="text-align:center;padding:3rem;color:var(--text-muted);">
          <p>No blog posts yet.</p>
          <a href="<?= base_url('/admin/blogs/create/') ?>" class="btn btn-gold" style="margin-top:1rem;">Create Your First Post</a>
        </div>
        <?php endif; ?>

        <div style="margin-top:1.2rem;text-align:right;">
          <a href="<?= base_url('/admin/blogs/') ?>" style="font-size:.78rem;color:var(--gold);">View all posts →</a>
        </div>
      </div>

      <!-- Quick actions -->
      <div class="admin-card">
        <h2 style="font-size:1rem;font-weight:600;color:var(--text-primary);margin:0 0 1.2rem;">Quick Actions</h2>
        <div style="display:flex;gap:1rem;flex-wrap:wrap;">
          <a href="<?= base_url('/admin/blogs/create/') ?>" class="btn btn-gold btn-sm">✏️ New Blog Post</a>
          <a href="<?= base_url('/admin/blogs/') ?>" class="btn btn-outline-dark btn-sm">📋 Manage All Posts</a>
          <a href="<?= base_url('/blog/') ?>" target="_blank" class="btn btn-outline-gold btn-sm">↗ View Blog</a>
          <a href="<?= base_url('/') ?>" target="_blank" class="btn btn-outline-dark btn-sm">↗ View Website</a>
        </div>
      </div>

    </div><!-- /admin-content -->
  </div><!-- /admin-main -->
</div><!-- /admin-layout -->

</body>
</html>
