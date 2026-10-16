<?php $active = $activePage ?? ''; ?>
<div class="admin-sidebar">
  <div class="admin-sidebar-logo">
    <a href="<?= base_url('/admin/') ?>">
      <img src="<?= base_url('assets/images/logo.png') ?>"
           alt="The Bridal Photography" style="height:32px;width:auto;filter:brightness(0) invert(1);opacity:.8;">
    </a>
    <p style="font-size:.62rem;letter-spacing:.15em;text-transform:uppercase;color:rgba(201,169,110,.5);margin-top:.5rem;font-family:'Jost',sans-serif;">
      Admin Panel
    </p>
  </div>

  <nav class="admin-nav">
    <a href="<?= base_url('/admin/') ?>" class="<?= $active === 'dashboard' ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>

    <div style="font-size:.58rem;letter-spacing:.2em;text-transform:uppercase;color:rgba(201,169,110,.35);padding:.75rem 1rem .35rem;font-family:'Jost',sans-serif;">
      Content
    </div>

    <a href="<?= base_url('/admin/blogs/') ?>" class="<?= $active === 'blogs' ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 6h16M4 10h16M4 14h8M4 18h6"/></svg>
      Blog Posts
    </a>

    <a href="<?= base_url('/admin/blogs/create/') ?>" class="<?= $active === 'blogs-create' ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 5v14M5 12h14"/></svg>
      New Post
    </a>

    <div style="font-size:.58rem;letter-spacing:.2em;text-transform:uppercase;color:rgba(201,169,110,.35);padding:.75rem 1rem .35rem;font-family:'Jost',sans-serif;">
      Website
    </div>

    <a href="<?= base_url('/') ?>" target="_blank">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
      View Website ↗
    </a>

    <a href="<?= base_url('/blog/') ?>" target="_blank">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
      View Blog ↗
    </a>

    <a href="<?= base_url('/admin/logout/') ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
      Logout<?= session()->get('admin_email') ? ' (' . esc(session()->get('admin_email')) . ')' : '' ?>
    </a>
  </nav>
</div>
