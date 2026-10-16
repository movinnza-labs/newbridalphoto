<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="robots" content="noindex,nofollow">
  <title><?= esc($title ?? 'Login — The Bridal Admin') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
</head>
<body style="margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#1a1a1a;padding:16px;box-sizing:border-box;">

  <div class="admin-card" style="width:100%;max-width:380px;margin:0;">
    <div style="text-align:center;margin-bottom:1.5rem;">
      <img src="<?= base_url('assets/images/logo.png') ?>" alt="The Bridal Photography" style="height:40px;width:auto;">
      <p style="font-size:.65rem;letter-spacing:.18em;text-transform:uppercase;color:var(--text-muted);margin-top:.6rem;font-family:'Jost',sans-serif;">
        Admin Panel
      </p>
    </div>

    <?php if (! empty($flashError)): ?>
      <div style="background:#FEF2F2;border:1px solid #FCA5A5;color:#B91C1C;padding:.7rem 1rem;border-radius:6px;font-size:.85rem;margin-bottom:1rem;">
        <?= esc($flashError) ?>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('/admin/login/') ?>">
      <label for="username" style="display:block;font-size:.75rem;letter-spacing:.08em;text-transform:uppercase;color:var(--text-muted);margin-bottom:.35rem;">Username / Email</label>
      <input type="text" id="username" name="username" value="<?= esc(old('username') ?? '') ?>" required autofocus autocomplete="username"
             style="width:100%;box-sizing:border-box;padding:.7rem .85rem;border:1px solid #ddd;border-radius:6px;font-size:.95rem;margin-bottom:1rem;">

      <label for="password" style="display:block;font-size:.75rem;letter-spacing:.08em;text-transform:uppercase;color:var(--text-muted);margin-bottom:.35rem;">Password</label>
      <input type="password" id="password" name="password" required autocomplete="current-password"
             style="width:100%;box-sizing:border-box;padding:.7rem .85rem;border:1px solid #ddd;border-radius:6px;font-size:.95rem;margin-bottom:1.4rem;">

      <button type="submit" class="btn btn-gold" style="width:100%;">Login</button>
    </form>
  </div>

</body>
</html>
