<?php if (session()->get('user_level') != 'admin super') { ?>
    <div class="sidebar-bottom">
        <div class="sidebar-profil-container">
            <div class="profil-container">
                <img class="profil-sidebar" alt="img" src="<?= base_url('assets/img/codebreak.png'); ?>">
            </div>
            <div class="user-name-container">
                <p class="user-name">
                    <?= $user_name; ?>
                </p>
                <div class="sidebar-shop">
                    <i class="fa-solid fa-cart-shopping"></i> <span> 0 </span> item
                </div>
            </div>
        </div>
    </div>
<?php }; ?>