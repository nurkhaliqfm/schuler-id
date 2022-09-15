<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCHULER.ID | Login</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/fontawesome/css/all.min.css') ?>">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/login-regist-themestyle.css?v=') . time() ?>">
    <!-- Fav Icon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.png') ?>">
</head>

<body>
    <form action="<?php echo base_url('login/auth'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="white-box login__container">
            <div class="head__login">
                <a href="<?= base_url('login/'); ?>">
                    <img src="/assets/img/schuler-logo.png" alt="SHCHULER.ID" width="135">
                </a>
            </div>
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('user_or_pass')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('user_or_pass'); ?>
                </div>
            <?php endif; ?>
            <div class="body__login">
                <div class="form__menu">
                    <h3 class="custom-box-title">Alamat Email</h3>
                    <div class="grid-container option__style">
                        <div class="form__icon__box">
                            <div class="form__icon">
                                <i class="fa-solid fa-square-envelope"></i>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" class="input__form checked form-control" name="email" placeholder="Masukkan Email">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form__menu">
                    <h3 class="custom-box-title">Password</h3>
                    <div class="grid-container option__style">
                        <div class="form__icon__box">
                            <div class="form__icon">
                                <i class="fa-solid fa-user-lock"></i>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="input__form checked form-control" name="password" placeholder="Masukkan Password">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form__menu">
                    <h3 class="custom-box-title">Lupa Password ? <a href="<?= base_url('login/forget_password'); ?>"> Reset Sekarang!</a></h3>
                    <h3 class="custom-box-title">Belum Punya Akun ? <a href="<?= base_url('login/regist'); ?>"> Daftar Sekarang!</a></h3>

                </div>
            </div>
            <div class="footer__login">
                <div class="submit_button">
                    <button type="submit" class="submit__login-btn">LOGIN</button>
                </div>
            </div>
        </div>
    </form>

    <!-- jQuery -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <!-- Bootstrap 5 -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>