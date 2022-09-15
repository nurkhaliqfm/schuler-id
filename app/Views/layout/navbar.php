<header>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <div class="d-flex">
                <a id="navbar-brand" class="navbar-brand" href="<?= base_url('/'); ?>">
                    <img id="navbar-brand-img" src="<?= base_url('assets/img/schuler-logo.png'); ?>" alt="SCHULER.ID" width="135">
                </a>
                <div class="menu-btn">
                    <div class="menu-btn__burger">
                    </div>
                </div>
            </div>

            <div class="d-flex">
                <?php if (session()->get('user_level') != 'admin super') { ?>
                    <div class="navbar-shop">
                        <i class="fa-solid fa-cart-shopping"></i> <span> 0 </span> item
                    </div>
                <?php }; ?>
                <div class="navbar-username">
                    Hai, <?= $user_name; ?>
                </div>
                <div class="navbar-profil">
                    <a href="#" class="d-block link-dark text-decoration-none">
                        <img src="<?= base_url('assets/img/codebreak.png'); ?>" alt="img" width="30" height="30" class="rounded-circle border-profil">
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>

<aside class="left-sidebar">
    <?= $this->include('layout/sidebar'); ?>
</aside>