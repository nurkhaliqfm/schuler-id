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
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/theme-style.css') ?>">
    <!-- Fav Icon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.png') ?>">

</head>

<body>
    <div id="main-wrapper">
        <?= $this->include('layout/navbar'); ?>
        <?= $this->renderSection('content'); ?>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <!-- CKEditor -->
    <script src="<?= base_url('ckeditor/ckeditor.js') ?>"></script>
    <!-- Bootstrap 5 -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Main Js -->
    <script src="<?= base_url('assets/js/sidebarmenu.js') ?>"></script>
    <!-- Main Js -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>

    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>
    <script>
        ClassicEditor
            .create(document.querySelector('#editorQuestion'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>