<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCHULER.ID | Registrasi</title>

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
    <form action="<?php echo base_url('login/regist_auth'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="white-box regist__container">
            <div class="head__login regist_head_login">
                <a href="<?= base_url('login/regist'); ?>">
                    <img src="/assets/img/schuler-logo.png" alt="SHCHULER.ID" width="135">
                </a>
            </div>

            <?php if (session()->getFlashdata('failed')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('failed'); ?>
                </div>
            <?php endif; ?>

            <div class="body__login">
                <div class="form__menu flex__2r">
                    <div class="form__submenu">
                        <h3 class="custom-box-title">Nama</h3>
                        <div class="grid-container option__style">
                            <div class="form__icon__box regist_form">
                                <div class="form__icon">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            </div>
                            <div class="input-group regist_input">
                                <input type="text" class="input__form checked form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" placeholder="Masukkan Nama">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('username'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form__submenu">
                        <h3 class="custom-box-title">No Telepon/Whatsapp</h3>
                        <div class="grid-container option__style">
                            <div class="form__icon__box regist_form">
                                <div class="form__icon">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                            </div>
                            <div class="input-group regist_input">
                                <input type="text" class="input__form checked form-control <?= ($validation->hasError('phoneNumber')) ? 'is-invalid' : ''; ?>" name="phoneNumber" placeholder="Masukkan No Telepon">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('phoneNumber'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form__menu flex__2r">
                    <div class="form__submenu">
                        <h3 class="custom-box-title">Alamat Email</h3>
                        <div class="grid-container option__style">
                            <div class="form__icon__box regist_form">
                                <div class="form__icon">
                                    <i class="fa-solid fa-square-envelope"></i>
                                </div>
                            </div>
                            <div class="input-group regist_input">
                                <input type="email" class="input__form checked form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" placeholder="Masukkan Email">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('email'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form__submenu">
                        <h3 class="custom-box-title">Kode Referal (Opsional)</h3>
                        <div class="grid-container option__style">
                            <div class="form__icon__box regist_form">
                                <div class="form__icon">
                                    <i class="fa-solid fa-users-viewfinder"></i>
                                </div>
                            </div>
                            <div class="input-group regist_input">
                                <input type="text" class="input__form checked form-control" name="referalCode" placeholder="Masukkan Kode Referal">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form__menu flex__2r">
                    <div class="form__submenu">
                        <h3 class="custom-box-title">Password</h3>
                        <div class="grid-container option__style">
                            <div class="form__icon__box regist_form">
                                <div class="form__icon">
                                    <i class="fa-solid fa-user-lock"></i>
                                </div>
                            </div>
                            <div class="input-group regist_input">
                                <input type="password" class="input__form checked form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" placeholder="Masukkan Password">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form__submenu">
                        <h3 class="custom-box-title">Ulangi Password</h3>
                        <div class="grid-container option__style">
                            <div class="form__icon__box regist_form">
                                <div class="form__icon">
                                    <i class="fa-solid fa-user-lock"></i>
                                </div>
                            </div>
                            <div class="input-group regist_input">
                                <input type="password" class="input__form checked form-control <?= ($validation->hasError('passwordConfrm')) ? 'is-invalid' : ''; ?>" name="passwordConfrm" placeholder="Masukkan Ulang Password">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('passwordConfrm'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form__menu">
                    <div class="form__submenu">
                        <h3 class="custom-box-title">Sudah Punya AKun ? <a href="<?= base_url('login/'); ?>"> Login Sekarang!</a></h3>
                    </div>
                </div>
            </div>
            <div class="footer__login">
                <div class="submit_button">
                    <button type="submit" class="submit__login-btn">DAFTAR</button>
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