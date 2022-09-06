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
    <?php $query = !empty($_GET['query']) ? "&query=" . $_GET['query'] : ""; ?>
    <form action="<?php echo base_url('login/kampus_auth?slug=' . $_GET['slug'] . $query); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="white-box login__container">
            <div class="head__login">
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
                <div class="form__menu">
                    <h3 class="custom-box-title">Kampus Impian</h3>
                    <div class="grid-container option__style">
                        <div class="form__icon__box">
                            <div class="form__icon">
                                <i class="fa-solid fa-square-envelope"></i>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <select name="kampus_1" class="form-select <?= ($validation->hasError('kampus_1')) ? 'is-invalid' : ''; ?>" aria-label="Default select example">
                                <option value="" selected>Pilih Universitas</option>
                                <?php foreach ($kampus as $k) : ?>
                                    <option value="<?= $k['id_universitas']; ?>"><?= $k['nama_universitas']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kampus_1'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__login">
                <div class="submit_button">
                    <button type="submit" class="submit__login-btn">SELESAI</button>
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