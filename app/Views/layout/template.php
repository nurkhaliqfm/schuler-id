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
    <!-- Froala -->
    <link href="<?= base_url('node_modules/froala-editor/css/plugins/image.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('node_modules/froala-editor/css/froala_editor.pkgd.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('node_modules/froala-editor/css/froala_style.min.css') ?>" rel="stylesheet" type="text/css" />
    <!-- Wiris -->
    <link href="<?= base_url('node_modules/@wiris/mathtype-froala3/icon/css/wirisplugin.css') ?>" rel="stylesheet" type="text/css" />

</head>

<body>
    <div id="main-wrapper">
        <?= $this->include('layout/navbar'); ?>
        <?= $this->renderSection('content'); ?>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <!-- Bootstrap 5 -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Main Js -->
    <script src="<?= base_url('assets/js/sidebarmenu.js') ?>"></script>
    <!-- Main Js -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    <!-- Froala -->
    <script type="text/javascript" src="<?= base_url('node_modules/froala-editor/js/plugins/image.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('node_modules/froala-editor/js/froala_editor.pkgd.min.js') ?>"></script>
    <!-- Wiris -->
    <script type="text/javascript" src="<?= base_url('node_modules/@wiris/mathtype-froala3/wiris.js'); ?>"></script>
    <script>
        FroalaEditor.DefineIcon('imageInfo', {
            NAME: 'info',
            SVG_KEY: 'help'
        });
        FroalaEditor.RegisterCommand('imageInfo', {
            title: 'Info',
            focus: false,
            undo: false,
            refreshAfterCallback: false,
            callback: function() {
                var $img = this.image.get();
                alert($img.attr('src'));
            }
        });

        new FroalaEditor('#editorQuestion', {
            toolbarButtons: {
                moreText: {
                    buttons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting'],
                    align: 'left',
                    buttonsVisible: 3
                },
                moreParagraph: {
                    buttons: ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent'],
                    align: 'left',
                    buttonsVisible: 3
                },

                moreRich: {
                    buttons: ['insertImage', 'insertTable', 'specialCharacters'],
                    align: 'left',
                    buttonsVisible: 3
                },

                more: {
                    buttons: ['wirisEditor', 'wirisChemistry', 'html'],
                    align: 'left',
                    buttonVisible: 3
                },

                moreMisc: {
                    buttons: ['undo', 'redo'],
                    align: 'right',
                    buttonsVisible: 2
                }
            },



            // imageUploadParam: 'image_param',
            // imageUploadURL: '<?= base_url('admin/upload_image') ?>',
            // imageUploadParams: {
            //     id: 'my_editor',
            //     class: 'my_editor'
            // },
            // imageUploadMethod: 'POST',
            // imageMaxSize: 5 * 1024 * 1024,
            // imageAllowedTypes: ['jpeg', 'jpg', 'png'],

            // imageEditButtons: ['wirisEditor', 'wirisChemistry'],
            imageEditButtons: ['imageDisplay', 'imageAlign', 'imageInfo', 'imageRemove'],
            htmlAllowedTags: ['.*'],
            htmlAllowedAttrs: ['.*'],
            htmlAllowedEmptyTags: ['mprescripts', 'none'],
        })

        new FroalaEditor('#editorExplanation', {
            toolbarButtons: {
                moreText: {
                    buttons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting'],
                    align: 'left',
                    buttonsVisible: 3
                },
                moreParagraph: {
                    buttons: ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent'],
                    align: 'left',
                    buttonsVisible: 3
                },

                moreRich: {
                    buttons: ['insertImage', 'insertTable', 'specialCharacters'],
                    align: 'left',
                    buttonsVisible: 3
                },

                more: {
                    buttons: ['wirisEditor', 'wirisChemistry', 'html'],
                    align: 'left',
                    buttonVisible: 3
                },

                moreMisc: {
                    buttons: ['undo', 'redo'],
                    align: 'right',
                    buttonsVisible: 2
                }
            },

            imageEditButtons: ['wirisEditor', 'wirisChemistry'],
            htmlAllowedTags: ['.*'],
            htmlAllowedAttrs: ['.*'],
            htmlAllowedEmptyTags: ['mprescripts', 'none'],
        })
    </script>
</body>

</html>