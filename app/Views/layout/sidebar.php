<?php $uri = current_url(true)->getSegment(2); ?>

<nav class="sidebar-nav full <?= $uri != 'admin' ? '' : 'admin-style'; ?>">
    <div class="sidebar-body">
        <?php if ($uri != 'admin') { ?>
            <ul id="sidebarnav" class="sidebarnav-list">
                <li class="sidebar-item last-btn">
                    <a class="sidebar-link <?= $uri == 'index' || $uri == '' ? 'active' : ''; ?>" href=" <?= base_url('/'); ?>" aria-expanded="false">
                        <i class="fa-solid fa-house"></i>
                        <span class="hide-menu">Beranda</span>
                    </a>
                </li>
                <li class="sidebar-item-title">
                    <span class="title-sidebar-item">PROGRAM KHUSUS</span>
                </li>
                <li class="sidebar-item last-btn">
                    <a class="sidebar-link" href="<?= base_url('home/super_camp_utbk'); ?>" aria-expanded="false">
                        <i class="fa-solid fa-laptop-code"></i>
                        <span class="hide-menu">Super Camp UTBK</span>
                    </a>
                </li>
                <li class="sidebar-item-title">
                    <span class="title-sidebar-item">PEMBELIAN</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <i class="fa-solid fa-store"></i>
                        <span class="hide-menu">Beli Paket UTBK</span>
                    </a>
                </li>
                <li class="sidebar-item last-btn">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <i class="fa-solid fa-credit-card"></i>
                        <span class="hide-menu">Invoice & Pembayaran</span>
                    </a>
                </li>
                <li class="sidebar-item-title">
                    <span class="title-sidebar-item">MENU UTBK</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <i class="fa-solid fa-laptop-file"></i>
                        <span class="hide-menu">
                            Latihan UTBK
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                    <ul class="nav-treeview collapse">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?= base_url('home/kerjakan_latihan'); ?>" aria-expanded="false">
                                <i class="fa-solid fa-file-pen"></i>
                                <span class="hide-menu">
                                    Kerjakan Latihan
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?= base_url('home/hasil_latihan'); ?>" aria-expanded="false">
                                <i class="fa-solid fa-file-circle-check"></i>
                                <span class="hide-menu">
                                    Hasil Latihan
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item last-btn">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <i class="fa-solid fa-laptop-file"></i>
                        <span class="hide-menu">
                            Simulasi UTBK
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                    <ul class="nav-treeview collapse">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?= base_url('home/simulasi_gratis'); ?>" aria-expanded="false">
                                <i class="fa-solid fa-file-pen"></i>
                                <span class="hide-menu">
                                    Simulasi Gratis
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?= base_url('home/simulasi_premium'); ?>" aria-expanded="false">
                                <i class="fa-solid fa-file-pen"></i>
                                <span class="hide-menu">
                                    Simulasi Premium
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?= base_url('home/hasil_simulasi'); ?>" aria-expanded="false">
                                <i class="fa-solid fa-file-circle-check"></i>
                                <span class="hide-menu">
                                    Hasil Simulasi
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item-title">
                    <span class="title-sidebar-item">EVENT</span>
                </li>
                <li class="sidebar-item last-btn">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <i class="fa-solid fa-magnifying-glass-chart"></i>
                        <span class="hide-menu">Event Simulasi</span>
                    </a>
                </li>
                <li class="sidebar-item-title">
                    <span class="title-sidebar-item">AKUN</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <i class="fa-solid fa-users-viewfinder"></i>
                        <span class="hide-menu">Referal</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <i class="fa-solid fa-user"></i>
                        <span class="hide-menu">Akun Saya</span>
                    </a>
                </li>
            </ul>
        <?php } else {; ?>
            <ul id="sidebarnav" class="sidebarnav-list">
                <li class="sidebar-item admin-style">
                    <a class="sidebar-link admin-style <?= $uri == 'index' || $uri == '' ? 'active' : ''; ?>" href=" <?= base_url('admin/'); ?>" aria-expanded="false">
                        <i class="fa-solid fa-house"></i>
                        <span class="hide-menu">Beranda</span>
                    </a>
                </li>
                <li class="sidebar-item admin-style">
                    <a class="sidebar-link admin-style" href="#" aria-expanded="false">
                        <i class="fa-solid fa-laptop-file"></i>
                        <span class="hide-menu">
                            Input Soal
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                    <ul class="nav-treeview collapse">
                        <li class="sidebar-item">
                            <a class="sidebar-link admin-style" href="<?= base_url('admin/daftar_soal'); ?>" aria-expanded="false">
                                <i class="fa-solid fa-file-pen"></i>
                                <span class="hide-menu">
                                    Bank Soal
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link admin-style" href="#" aria-expanded="false">
                                <i class="fa-solid fa-file-pen"></i>
                                <span class="hide-menu">
                                    Kuis
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        <?php }; ?>
    </div>
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
</nav>