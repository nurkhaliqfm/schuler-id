<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fontawesome/css/all.min.css') ?>">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/theme-style.css') ?>">
    <!-- Fav Icon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/codebreak.png') ?>">

</head>

<body>
    <div id="main-wrapper">
        <?= $this->include('layout/navbar'); ?>
        <?= $this->renderSection('content'); ?>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
    <!-- Bootstrap 5 -->
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Main Js -->
    <script src="<?php echo base_url('assets/js/main.js') ?>"></script>
</body>

</html>