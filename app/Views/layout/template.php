<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/fontawesome/css/all.min.css') ?>">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- Fav Icon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.png') ?>">
    <!-- Froala -->
    <link href="<?= base_url('node_modules/froala-editor/css/froala_editor.pkgd.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('node_modules/froala-editor/css/froala_style.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('node_modules/froala-editor/css/plugins/image.min.css') ?>" rel="stylesheet" type="text/css" />
    <!-- Wiris -->
    <link href="<?= base_url('node_modules/@wiris/mathtype-froala3/icon/css/wirisplugin.css') ?>" />
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/theme-style.css') ?>">

    <!-- jQuery -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <!-- MD5 Script -->
    <script src="<?= base_url('assets/js/md5.js') ?>"></script>
    <!-- Bootstrap 5 -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Froala -->
    <script type="text/javascript" src="<?= base_url('node_modules/froala-editor/js/froala_editor.pkgd.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('node_modules/froala-editor/js/plugins/image.min.js') ?>"></script>
    <!-- Wiris -->
    <script type="text/javascript" src="<?= base_url('node_modules/@wiris/mathtype-froala3/wiris.js'); ?>"></script>
</head>

<body>
    <div id="main-wrapper">
        <?= $this->include('layout/navbar'); ?>
        <?= $this->renderSection('content'); ?>
    </div>

    <!-- Sidebarmenu Js -->
    <script src="<?= base_url('assets/js/sidebarmenu.js') ?>"></script>
    <!-- Main Js -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    <!-- MathJax -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/mml-chtml.js">
    </script>
</body>

</html>