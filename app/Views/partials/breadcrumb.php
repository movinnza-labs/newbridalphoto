<?php if (!empty($breadcrumb) && count($breadcrumb) > 1): ?>
<div class="breadcrumb-wrap">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <?php foreach ($breadcrumb as $i => [$label, $url]): ?>
        <?php if ($i < count($breadcrumb) - 1): ?>
          <a href="<?= base_url($url) ?>"><?= esc($label) ?></a>
          <span class="breadcrumb-sep">›</span>
        <?php else: ?>
          <span class="breadcrumb-current"><?= esc($label) ?></span>
        <?php endif; ?>
      <?php endforeach; ?>
    </nav>
  </div>
</div>
<?php endif; ?>
