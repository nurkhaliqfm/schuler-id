<header>
    <nav class="navbar  mb-3 navbar-expand-lg navbar-light fixed-top">
        <a unlink id="navbar-brand" class="navbar-brand">
            <img id="navbar-brand-img" src="<?= base_url('assets/img/schuler-logo.png'); ?>" alt="SCHULER.ID" width="135">
        </a>
        <div class="navbar-title-container">
            <div class="navbar-title">
                <div id="simulation__title" class="navbar__title"></div>
                <div id="simulation__subtitle" class="title_simulation_test">Test Kemampuan Akademik</div>
            </div>
            <div class="navbar-subtitle alert__box"><i class="fa-solid fa-circle-info"></i><span> Panduan</span></div>
        </div>
        <div class="ms-auto simulasi-header-container">
            <div class="timer__countdown"></div>
        </div>
    </nav>
</header>

<aside class="right-sidebar">
    <?= $this->include('layout/sidebar-simulasi'); ?>
</aside>