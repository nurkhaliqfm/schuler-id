<!DOCTYPE html>
<html lang="en" translate="no">

<head>
    <meta charset="utf-8">
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/fontawesome/css/all.min.css') ?>">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- Fav Icon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.png?v=') . time() ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/theme-style-simulation.css?v=') . time() ?>">

    <!-- jQuery -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <!-- MD5 Script -->
    <script src="<?= base_url('assets/js/md5.js') ?>"></script>
    <!-- Bootstrap 5 -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</head>

<body>
    <div class="loader-bg">
        <div class="loader"></div>
    </div>
    <div id="main-wrapper">
        <?= $this->include('layout/navbar-simulasi'); ?>
        <?= $this->renderSection('content'); ?>
    </div>


    <script src="<?= base_url('assets/js/prevent-access.js') ?>"></script>
    <!-- Sidebar Js -->
    <script src="<?= base_url('assets/js/sidebarmenu.js?v=') . time() ?>"></script>
    <!-- Main Js -->
    <script src="<?= base_url('assets/js/main-simulasi.js?v=') . time() ?>"></script>
    <!-- MathJax -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/mml-chtml.js">
    </script>
</body>

</html>