<?php $uri = current_url(true)->getSegment(2); ?>

<nav class="sidebar-nav full <?= $uri != 'admin' ? '' : 'admin-style'; ?>">
    <div class="sidebar-body">
        <div class="question__number active">1</div>
        <?php for ($i = 2; $i <= 20; $i++) {; ?>
            <div class="question__number"><?= $i; ?></div>
        <?php }; ?>
    </div>
</nav>