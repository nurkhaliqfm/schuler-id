<header>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('/'); ?>">
                <img src="<?= base_url('assets/img/schuler-logo.png'); ?>" alt="SCHULER.ID" width="135">
            </a>

            <div class="d-flex">
                <div class="navbar-shop">
                    <i class="fa-solid fa-cart-shopping"></i> <span> 0 </span> item
                </div>
                <div class="navbar-username">
                    Hai, <?= $user_name; ?>
                </div>
                <div class="navbar-profil">
                    <a href="#" class="d-block link-dark text-decoration-none">
                        <img src="<?= base_url('assets/img/codebreak.png'); ?>" alt="img" width="35" height="35" class="rounded-circle border-profil">
                    </a>
                </div>
                <div class="menu-btn">
                    <div class="menu-btn__burger">
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<aside class="left-sidebar">
    <?= $this->include('layout/sidebar'); ?>
</aside>