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
    <!-- Froala -->
    <link href="<?= base_url('node_modules/froala-editor/css/froala_editor.pkgd.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('node_modules/froala-editor/css/froala_style.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('node_modules/froala-editor/css/plugins/image.min.css') ?>" rel="stylesheet" type="text/css" />
    <!-- Wiris -->
    <link href="<?= base_url('node_modules/@wiris/mathtype-froala3/icon/css/wirisplugin.css') ?>" />
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/theme-style.css?v=') . time() ?>">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/tempusdominus-bootstrap-4.min.css') ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/select2-bootstrap4.min.css') ?>">

    <!-- jQuery -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <!-- MD5 Script -->
    <script src="<?= base_url('assets/js/md5.js') ?>"></script>
    <!-- Bootstrap 5 -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url('assets/js/select2.full.min.js') ?>"></script>
    <!-- InputMask -->
    <script src="<?php echo base_url('assets/js/moment.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.inputmask.min.js') ?>"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?php echo base_url('assets/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
    <!-- Froala -->
    <script type="text/javascript" src="<?= base_url('node_modules/froala-editor/js/froala_editor.pkgd.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('node_modules/froala-editor/js/plugins/image.min.js') ?>"></script>
    <!-- Wiris -->
    <script type="text/javascript" src="<?= base_url('node_modules/@wiris/mathtype-froala3/wiris.js'); ?>"></script>
</head>

<body>
    <div class="loader-bg">
        <div class="loader"></div>
    </div>
    <div id="main-wrapper">
        <?= $this->include('layout/navbar-pembahasan'); ?>
        <?= $this->renderSection('content'); ?>
    </div>

    <script src="<?= base_url('assets/js/prevent-access.js') ?>"></script>
    <!-- Sidebarmenu Js -->
    <script src="<?= base_url('assets/js/sidebarmenu.js?v=') . time() ?>"></script>
    <!-- Main Js -->
    <script src="<?= base_url('assets/js/main-simulasi.js?v=') . time() ?>"></script>
    <!-- MathJax -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/mml-chtml.js"></script>
</body>

</html>