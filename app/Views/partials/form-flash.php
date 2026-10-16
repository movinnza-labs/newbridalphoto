<?php
// Reusable flash-message block — drop this in right above any form on the site.
$flashSuccess = session()->getFlashdata('success');
$flashWarning = session()->getFlashdata('warning');
$flashErrors  = session()->getFlashdata('errors') ?: [];
if ($flashSuccess || $flashWarning || !empty($flashErrors)):
?>
<?php if ($flashSuccess): ?>
  <div class="alert alert-success" role="status"><?= esc($flashSuccess) ?></div>
<?php endif; ?>
<?php if ($flashWarning): ?>
  <div class="alert alert-warning" role="status"><?= esc($flashWarning) ?></div>
<?php endif; ?>
<?php if (!empty($flashErrors)): ?>
  <div class="alert alert-error" role="alert">
    <strong>Please fix the following errors:</strong>
    <ul class="alert-list">
      <?php foreach ($flashErrors as $err): ?>
        <li><?= esc($err) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>
<?php endif; ?>
