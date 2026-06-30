<?php

declare(strict_types=1);

require_once __DIR__ . '/../auth.php';

/**
 * Fixed left sidebar for logged-in CMS screens.
 *
 * @param 'content' $activeId Currently only "content" (edit wizard); extend when more admin routes exist.
 * @param list<array{title?: string, section_name?: string, hint?: string, groups?: mixed}>|null $wizardSteps
 * @param int|null $sidebarActivePanel 1-based index matching open section (for highlight).
 */
function cms_admin_render_nav(
    string $activeId = 'content',
    ?int $wizardStepCount = null,
    ?array $wizardSteps = null,
    ?int $sidebarActivePanel = null
): void {
    $h = static function (string $s): string {
        return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    };

    $displayUser = cms_current_username();

    $isContent = $activeId === 'content';
    $showWizard = $isContent
        && $wizardStepCount !== null
        && $wizardStepCount > 0
        && $wizardSteps !== null;
    $highlight = max(1, min($wizardStepCount ?? 1, $sidebarActivePanel ?? 1));
    ?>
<aside class="cms-admin-sidebar" aria-label="My Portfolio">
  <div class="cms-admin-sidebar-brand">
    <a class="cms-admin-brand text-decoration-none" href="edit.php"><?= $h('My Portfolio') ?></a>
    <span class="cms-admin-sidebar-tagline"><?= $h('Editor') ?></span>
    <p class="cms-admin-sidebar-user mb-0"><?= $h($displayUser) ?></p>
  </div>
  <div class="cms-admin-sidebar-divider" aria-hidden="true"></div>
  <div class="cms-admin-sidebar-actions" role="group" aria-label="<?= $h('CMS actions') ?>">
    <a class="cms-admin-sidebar-btn cms-admin-sidebar-btn--compact btn cms-admin-sidebar-btn--view-red" href="../index.php" target="_blank" rel="noopener noreferrer" title="<?= $h('Opens in new tab') ?>">
      <span class="cms-admin-sidebar-btn-label"><?= $h('View site') ?></span>
    </a>
    <?php if (!$isContent) { ?>
    <a class="cms-admin-sidebar-btn cms-admin-sidebar-btn--compact btn btn-primary" href="edit.php">
      <span class="cms-admin-sidebar-btn-label"><?= $h('Edit content') ?></span>
    </a>
    <?php } ?>
    <?php if ($isContent) { ?>
    <button type="submit" form="cms-wizard-form" class="cms-admin-sidebar-btn cms-admin-sidebar-btn--compact btn btn-success" id="cms-sidebar-save">
      <span class="cms-admin-sidebar-btn-label"><?= $h('Save') ?></span>
    </button>
    <?php } ?>
    <a class="cms-admin-sidebar-btn cms-admin-sidebar-btn--compact btn btn-outline-danger" href="logout.php">
      <span class="cms-admin-sidebar-btn-label"><?= $h('Log out') ?></span>
    </a>
  </div>
  <?php if ($showWizard) { ?>
  <div class="cms-admin-sidebar-steps">
    <p class="cms-admin-sidebar-section-label mb-0"><?= $h('Sections') ?></p>
    <nav class="cms-admin-page-list" aria-label="<?= $h('Jump to section') ?>">
      <?php
      for ($d = 1; $d <= $wizardStepCount; ++$d) {
          $stepDef = $wizardSteps[$d - 1];
          $ptitle = (string) ($stepDef['title'] ?? ('Section ' . $d));
          $sname = trim((string) ($stepDef['section_name'] ?? ''));
          $tip = $sname !== '' ? $ptitle . ' — ' . $sname : $ptitle;
          $isCur = $d === $highlight;
          ?>
      <a href="#cms-panel-<?= $d ?>" class="cms-admin-page-link js-cms-section-jump<?= $isCur ? ' is-current' : '' ?>" data-panel="<?= (int) $d ?>" title="<?= $h($tip) ?>">
        <span class="cms-admin-page-num"><?= (int) $d ?></span>
        <span class="cms-admin-page-title"><?= $h($ptitle) ?></span>
      </a>
      <?php } ?>
    </nav>
  </div>
  <?php } ?>
</aside>
    <?php
}
