<?php $uri = current_url(true)->getSegment(2); ?>

<nav class="sidebar-nav full <?= $uri != 'admin' ? '' : 'admin-style'; ?>">
    <div id="question__number_side" class="sidebar-body">
    </div>
</nav>