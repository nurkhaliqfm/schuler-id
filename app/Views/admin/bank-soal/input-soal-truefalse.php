<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <?php if (session()->getFlashdata('failed')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('failed'); ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <form action="<?= base_url('admin/save_soal_truefalse'); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <input hidden type="text" name="MenuSoal" value="<?= $menu_soal; ?>">
                        <input hidden type="text" name="SubmenuSoal" value="<?= $submenu_soal; ?>">
                        <input hidden type="text" name="SoalStyle" value="<?= $soal_style; ?>">

                        <!-- Pertanyaan -->
                        <h3 class="custom-box-title">Soal True False</h3>
                        <div class="mb-3">
                            <textarea rows="10" name="editorQuestion" type="text" class="form-control <?= ($validation->hasError('editorQuestion')) ? 'is-invalid' : ''; ?>" id="editorQuestion"><?= old('editorQuestion'); ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('editorQuestion'); ?>
                            </div>
                        </div>

                        <!-- Soal Tag -->
                        <h3 class="custom-box-title">Jenis Pilihan</h3>
                        <div class="mb-3">
                            <select name="jenisPilihan" class="form-select <?= ($validation->hasError('jenisPilihan')) ? 'is-invalid' : ''; ?>" aria-label="Default select example">
                                <option disabled selected> Pilih Tag Soal</option>
                                <option <?= old('jenisPilihan') == "true_false" ? "selected" : ""; ?> value="true_false">Ture/False</option>
                                <option <?= old('jenisPilihan') == "memperlemah_nonmemperlemah" ? "selected" : ""; ?> value="memperlemah_nonmemperlemah">Memperlemah/Tidak Memperlemah</option>
                                <option <?= old('jenisPilihan') == "mendukung_nonmendukung" ? "selected" : ""; ?> value="mendukung_nonmendukung">Mendukung/Tidak Mendukung </option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('jenisPilihan'); ?>
                            </div>
                        </div>

                        <!-- Option -->
                        <h3 class="custom-box-title">Input Option</h3>
                        <div class="grid-container option__style">
                            <div>
                                <div class="checkbox checkbox__form">
                                    <input checked type="checkbox" value="option_1_true" name="checkbox_1[]" id="checkbox_1">
                                    <div class="box">
                                        T
                                    </div>
                                </div>
                                <div class="checkbox checkbox__form">
                                    <input type="checkbox" value="option_1_false" name="checkbox_1[]" id="checkbox_1">
                                    <div class="box">
                                        F
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3" id="optionEditor">
                                <textarea rows="10" type="text" class="input__form checked form-control <?= ($validation->hasError('option_1')) ? 'is-invalid' : ''; ?>" name="option_1" id="option_1" ; ?><?= old('option_1'); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('option_1'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="grid-container option__style">
                            <div>
                                <div class="checkbox checkbox__form">
                                    <input checked type="checkbox" value="option_2_true" name="checkbox_2[]" id="checkbox_2">
                                    <div class="box">
                                        T
                                    </div>
                                </div>
                                <div class="checkbox checkbox__form">
                                    <input type="checkbox" value="option_2_false" name="checkbox_2[]" id="checkbox_2">
                                    <div class="box">
                                        F
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3" id="optionEditor">
                                <textarea rows="10" type="text" class="input__form checked form-control <?= ($validation->hasError('option_2')) ? 'is-invalid' : ''; ?>" name="option_2" id="option_2" ; ?><?= old('option_2'); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('option_2'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="grid-container option__style">
                            <div>
                                <div class="checkbox checkbox__form">
                                    <input checked type="checkbox" value="option_3_true" name="checkbox_3[]" id="checkbox_3">
                                    <div class="box">
                                        T
                                    </div>
                                </div>
                                <div class="checkbox checkbox__form">
                                    <input type="checkbox" value="option_3_false" name="checkbox_3[]" id="checkbox_3">
                                    <div class="box">
                                        F
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3" id="optionEditor">
                                <textarea rows="10" type="text" class="input__form checked form-control <?= ($validation->hasError('option_3')) ? 'is-invalid' : ''; ?>" name="option_3" id="option_3" ; ?><?= old('option_3'); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('option_3'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="grid-container option__style">
                            <div>
                                <div class="checkbox checkbox__form">
                                    <input type="checkbox" value="option_4_true" name="checkbox_4[]" id="checkbox_4">
                                    <div class="box">
                                        T
                                    </div>
                                </div>
                                <div class="checkbox checkbox__form">
                                    <input checked type="checkbox" value="option_4_false" name="checkbox_4[]" id="checkbox_4">
                                    <div class="box">
                                        F
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3" id="optionEditor">
                                <textarea rows="10" type="text" class="input__form checked form-control <?= ($validation->hasError('option_4')) ? 'is-invalid' : ''; ?>" name="option_4" id="option_4" ; ?><?= old('option_4'); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('option_4'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="grid-container option__style">
                            <div>
                                <div class="checkbox checkbox__form">
                                    <input checked type="checkbox" value="option_5_true" name="checkbox_5[]" id="checkbox_5">
                                    <div class="box">
                                        T
                                    </div>
                                </div>
                                <div class="checkbox checkbox__form">
                                    <input type="checkbox" value="option_5_false" name="checkbox_5[]" id="checkbox_5">
                                    <div class="box">
                                        F
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3" id="optionEditor">
                                <textarea rows="10" type="text" class="input__form checked form-control <?= ($validation->hasError('option_5')) ? 'is-invalid' : ''; ?>" name="option_5" id="option_5" ; ?><?= old('option_5'); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('option_5'); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Pertanyaan -->
                        <h3 class="custom-box-title">Input Nilai</h3>
                        <div class="mb-3">
                            <select name="questionValue" class="form-select <?= ($validation->hasError('questionValue')) ? 'is-invalid' : ''; ?>" aria-label="Default select example">
                                <option disabled selected>Pilih Nilai</option>
                                <option <?= old('questionValue') == "1" ? "selected" : ""; ?> value="1">1</option>
                                <option <?= old('questionValue') == "2" ? "selected" : ""; ?> value="2">2</option>
                                <option <?= old('questionValue') == "3" ? "selected" : ""; ?> value="3">3</option>
                                <option <?= old('questionValue') == "4" ? "selected" : ""; ?> value="4">4</option>
                                <option <?= old('questionValue') == "5" ? "selected" : ""; ?> value="5">5</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('questionValue'); ?>
                            </div>
                        </div>


                        <!-- Pembahasaan -->
                        <h3 class="custom-box-title">Input Pembahasan</h3>
                        <div class="mb-3">
                            <textarea rows="10" type="text" class="form-control <?= ($validation->hasError('editorExplanation')) ? 'is-invalid' : ''; ?>" name="editorExplanation" id="editorExplanation"><?= old('editorExplanation'); ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('editorExplanation'); ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const inputForm1 = document.querySelectorAll('input[type="checkbox"]#checkbox_1');
    const inputForm2 = document.querySelectorAll('input[type="checkbox"]#checkbox_2');
    const inputForm3 = document.querySelectorAll('input[type="checkbox"]#checkbox_3');
    const inputForm4 = document.querySelectorAll('input[type="checkbox"]#checkbox_4');
    const inputForm5 = document.querySelectorAll('input[type="checkbox"]#checkbox_5');

    $('input[type="checkbox"]#checkbox_1').on('change', function() {
        $('input[name="' + this.name + '"]').not(this).prop('checked', false);

        inputForm1.forEach(obj => {
            obj.classList.remove('checked');
        })

        var inputValue = $(this).attr("value");
        $('#optionEditor #' + inputValue).addClass("checked");
    });

    $('input[type="checkbox"]#checkbox_2').on('change', function() {
        $('input[name="' + this.name + '"]').not(this).prop('checked', false);

        inputForm2.forEach(obj => {
            obj.classList.remove('checked');
        })
        var inputValue = $(this).attr("value");
        $('#optionEditor #' + inputValue).addClass("checked");
    });

    $('input[type="checkbox"]#checkbox_3').on('change', function() {
        $('input[name="' + this.name + '"]').not(this).prop('checked', false);

        inputForm3.forEach(obj => {
            obj.classList.remove('checked');
        })
        var inputValue = $(this).attr("value");
        $('#optionEditor #' + inputValue).addClass("checked");
    });

    $('input[type="checkbox"]#checkbox_4').on('change', function() {
        $('input[name="' + this.name + '"]').not(this).prop('checked', false);

        inputForm4.forEach(obj => {
            obj.classList.remove('checked');
        })
        var inputValue = $(this).attr("value");
        $('#optionEditor #' + inputValue).addClass("checked");
    });

    $('input[type="checkbox"]#checkbox_5').on('change', function() {
        $('input[name="' + this.name + '"]').not(this).prop('checked', false);

        inputForm5.forEach(obj => {
            obj.classList.remove('checked');
        })
        var inputValue = $(this).attr("value");
        $('#optionEditor #' + inputValue).addClass("checked");
    });
</script>

<script>
    let urlPostImage = "<?= base_url('admin/upload_image') ?>"
    var csrfName = document.getElementById("txt_csrfname").getAttribute("name");
    var csrfHash = document.getElementById("txt_csrfname").value;

    new FroalaEditor('#editorQuestion', {
        toolbarButtons: {
            moreText: {
                buttons: ['bold', 'italic', 'underline', 'clearFormatting', 'fontSize', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle'],
                align: 'left',
                buttonsVisible: 5
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
                buttons: ['wirisEditor', 'wirisChemistry'],
                align: 'left',
                buttonVisible: 3
            },

            moreMisc: {
                buttons: ['undo', 'redo'],
                align: 'right',
                buttonsVisible: 2
            }
        },

        useClasses: false,
        enter: FroalaEditor.ENTER_BR,
        pastePlain: true,
        fontSize: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '30', '36', '48', '60', '72', '96'],
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageRemove'],
        imageUploadURL: '<?= base_url('admin/upload_image') ?>',
        imageUploadParams: {
            csrf_token_name: csrfHash,
            id: 'my_editor',
        },
        imageUploadMethod: 'POST',
        imageMaxSize: 5 * 1024 * 1024,
        imageAllowedTypes: ['jpeg', 'jpg', 'png'],

        events: {
            'image.beforeUpload': function(images) {
                // Return false if you want to stop the image upload.
            },
            'image.uploaded': function(response) {
                console.log('uploaded server =' + response);
                // Image was uploaded to the server.
            },
            'image.inserted': function($img, response) {
                console.log('inserted editor =' + response);
                var responseText = JSON.parse(response);
                document.getElementById('txt_csrfname').setAttribute('name', responseText.tokenName);
                document.getElementById('txt_csrfname').setAttribute('value', responseText.tokenValue);
                // Image was inserted in the editor.
            },
            'image.replaced': function($img, response) {
                // Image was replaced in the editor.
            },
            'image.error': function(error, response) {
                console.log(response);
                if (error.code == 1) {
                    console.log(error);
                } else if (error.code == 2) {
                    console.log(error);
                } else if (error.code == 3) {
                    console.log(error);
                } else if (error.code == 4) {
                    console.log(error);
                } else if (error.code == 5) {
                    console.log(error);
                } else if (error.code == 6) {
                    console.log(error);
                } else if (error.code == 7) {
                    console.log(error);
                }
            },

            'image.removed': function($img) {
                var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
                var csrfHash = document.getElementById('txt_csrfname').value;

                var data = {};
                data[csrfName] = csrfHash;
                data["src"] = $img.attr('src');

                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "<?= base_url('admin/deleted_image') ?>", true);
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(xhttp.responseText);
                        console.log('Image Was Deleted');
                        document.getElementById('txt_csrfname').setAttribute('name', response.tokenName);
                        document.getElementById('txt_csrfname').setAttribute('value', response.tokenValue);
                    }
                };

                xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                xhttp.setRequestHeader("Content-Type", "application/json");
                xhttp.send(JSON.stringify(data));
            }
        },

        htmlAllowedTags: ['.*'],
        htmlAllowedAttrs: ['.*'],
        htmlAllowedEmptyTags: ['mprescripts', 'none'],
    })

    new FroalaEditor('#editorExplanation', {
        toolbarButtons: {
            moreText: {
                buttons: ['bold', 'italic', 'underline', 'clearFormatting', 'fontSize', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle'],
                align: 'left',
                buttonsVisible: 5
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
                buttons: ['wirisEditor', 'wirisChemistry'],
                align: 'left',
                buttonVisible: 3
            },

            moreMisc: {
                buttons: ['undo', 'redo'],
                align: 'right',
                buttonsVisible: 2
            }
        },

        useClasses: false,
        enter: FroalaEditor.ENTER_BR,
        pastePlain: true,
        fontSize: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '30', '36', '48', '60', '72', '96'],
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageRemove'],
        imageUploadURL: '<?= base_url('admin/upload_image') ?>',
        imageUploadParams: {
            csrf_token_name: csrfHash,
            id: 'my_editor',
        },
        imageUploadMethod: 'POST',
        imageMaxSize: 5 * 1024 * 1024,
        imageAllowedTypes: ['jpeg', 'jpg', 'png'],

        events: {
            'image.beforeUpload': function(images) {
                // Return false if you want to stop the image upload.
            },
            'image.uploaded': function(response) {
                // Image was uploaded to the server.
            },
            'image.inserted': function($img, response) {
                var responseText = JSON.parse(response);
                document.getElementById('txt_csrfname').setAttribute('name', responseText.tokenName);
                document.getElementById('txt_csrfname').setAttribute('value', responseText.tokenValue);
                // Image was inserted in the editor.
            },
            'image.replaced': function($img, response) {
                // Image was replaced in the editor.
            },
            'image.error': function(error, response) {
                if (error.code == 1) {
                    console.log(error);
                } else if (error.code == 2) {
                    console.log(error);
                } else if (error.code == 3) {
                    console.log(error);
                } else if (error.code == 4) {
                    console.log(error);
                } else if (error.code == 5) {
                    console.log(error);
                } else if (error.code == 6) {
                    console.log(error);
                } else if (error.code == 7) {
                    console.log(error);
                }
            },

            'image.removed': function($img) {
                var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
                var csrfHash = document.getElementById('txt_csrfname').value;

                var data = {};
                data[csrfName] = csrfHash;
                data["src"] = $img.attr('src');

                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "<?= base_url('admin/deleted_image') ?>", true);
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(xhttp.responseText);
                        console.log('Image Was Deleted');
                        document.getElementById('txt_csrfname').setAttribute('name', response.tokenName);
                        document.getElementById('txt_csrfname').setAttribute('value', response.tokenValue);
                    }
                };

                xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                xhttp.setRequestHeader("Content-Type", "application/json");
                xhttp.send(JSON.stringify(data));
            }
        },

        htmlAllowedTags: ['.*'],
        htmlAllowedAttrs: ['.*'],
        htmlAllowedEmptyTags: ['mprescripts', 'none'],
    })

    new FroalaEditor('#option_1', {
        toolbarButtons: {
            moreText: {
                buttons: ['bold', 'italic', 'underline', 'clearFormatting', 'fontSize', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle'],
                align: 'left',
                buttonsVisible: 5
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
                buttons: ['wirisEditor', 'wirisChemistry'],
                align: 'left',
                buttonVisible: 3
            },

            moreMisc: {
                buttons: ['undo', 'redo'],
                align: 'right',
                buttonsVisible: 2
            }
        },

        useClasses: false,
        enter: FroalaEditor.ENTER_BR,
        pastePlain: true,
        fontSize: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '30', '36', '48', '60', '72', '96'],
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageRemove'],
        imageUploadURL: '<?= base_url('admin/upload_image') ?>',
        imageUploadParams: {
            csrf_token_name: csrfHash,
            id: 'my_editor',
        },
        imageUploadMethod: 'POST',
        imageMaxSize: 5 * 1024 * 1024,
        imageAllowedTypes: ['jpeg', 'jpg', 'png'],

        events: {
            'image.beforeUpload': function(images) {
                // Return false if you want to stop the image upload.
            },
            'image.uploaded': function(response) {
                // Image was uploaded to the server.
            },
            'image.inserted': function($img, response) {
                var responseText = JSON.parse(response);
                document.getElementById('txt_csrfname').setAttribute('name', responseText.tokenName);
                document.getElementById('txt_csrfname').setAttribute('value', responseText.tokenValue);
                // Image was inserted in the editor.
            },
            'image.replaced': function($img, response) {
                // Image was replaced in the editor.
            },
            'image.error': function(error, response) {
                if (error.code == 1) {
                    console.log(error);
                } else if (error.code == 2) {
                    console.log(error);
                } else if (error.code == 3) {
                    console.log(error);
                } else if (error.code == 4) {
                    console.log(error);
                } else if (error.code == 5) {
                    console.log(error);
                } else if (error.code == 6) {
                    console.log(error);
                } else if (error.code == 7) {
                    console.log(error);
                }
            },

            'image.removed': function($img) {
                var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
                var csrfHash = document.getElementById('txt_csrfname').value;

                var data = {};
                data[csrfName] = csrfHash;
                data["src"] = $img.attr('src');

                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "<?= base_url('admin/deleted_image') ?>", true);
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(xhttp.responseText);
                        console.log('Image Was Deleted');
                        document.getElementById('txt_csrfname').setAttribute('name', response.tokenName);
                        document.getElementById('txt_csrfname').setAttribute('value', response.tokenValue);
                    }
                };

                xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                xhttp.setRequestHeader("Content-Type", "application/json");
                xhttp.send(JSON.stringify(data));
            }
        },

        useClasses: false,
        enter: FroalaEditor.ENTER_BR,
        pastePlain: true,
        htmlAllowedTags: ['.*'],
        htmlAllowedAttrs: ['.*'],
        htmlAllowedEmptyTags: ['mprescripts', 'none'],
    })

    new FroalaEditor('#option_2', {
        toolbarButtons: {
            moreText: {
                buttons: ['bold', 'italic', 'underline', 'clearFormatting', 'fontSize', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle'],
                align: 'left',
                buttonsVisible: 5
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
                buttons: ['wirisEditor', 'wirisChemistry'],
                align: 'left',
                buttonVisible: 3
            },

            moreMisc: {
                buttons: ['undo', 'redo'],
                align: 'right',
                buttonsVisible: 2
            }
        },

        useClasses: false,
        enter: FroalaEditor.ENTER_BR,
        pastePlain: true,
        fontSize: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '30', '36', '48', '60', '72', '96'],
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageRemove'],
        imageUploadURL: '<?= base_url('admin/upload_image') ?>',
        imageUploadParams: {
            csrf_token_name: csrfHash,
            id: 'my_editor',
        },
        imageUploadMethod: 'POST',
        imageMaxSize: 5 * 1024 * 1024,
        imageAllowedTypes: ['jpeg', 'jpg', 'png'],

        events: {
            'image.beforeUpload': function(images) {
                // Return false if you want to stop the image upload.
            },
            'image.uploaded': function(response) {
                // Image was uploaded to the server.
            },
            'image.inserted': function($img, response) {
                var responseText = JSON.parse(response);
                document.getElementById('txt_csrfname').setAttribute('name', responseText.tokenName);
                document.getElementById('txt_csrfname').setAttribute('value', responseText.tokenValue);
                // Image was inserted in the editor.
            },
            'image.replaced': function($img, response) {
                // Image was replaced in the editor.
            },
            'image.error': function(error, response) {
                if (error.code == 1) {
                    console.log(error);
                } else if (error.code == 2) {
                    console.log(error);
                } else if (error.code == 3) {
                    console.log(error);
                } else if (error.code == 4) {
                    console.log(error);
                } else if (error.code == 5) {
                    console.log(error);
                } else if (error.code == 6) {
                    console.log(error);
                } else if (error.code == 7) {
                    console.log(error);
                }
            },

            'image.removed': function($img) {
                var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
                var csrfHash = document.getElementById('txt_csrfname').value;

                var data = {};
                data[csrfName] = csrfHash;
                data["src"] = $img.attr('src');

                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "<?= base_url('admin/deleted_image') ?>", true);
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(xhttp.responseText);
                        console.log('Image Was Deleted');
                        document.getElementById('txt_csrfname').setAttribute('name', response.tokenName);
                        document.getElementById('txt_csrfname').setAttribute('value', response.tokenValue);
                    }
                };

                xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                xhttp.setRequestHeader("Content-Type", "application/json");
                xhttp.send(JSON.stringify(data));
            }
        },

        htmlAllowedTags: ['.*'],
        htmlAllowedAttrs: ['.*'],
        htmlAllowedEmptyTags: ['mprescripts', 'none'],
    })

    new FroalaEditor('#option_3', {
        toolbarButtons: {
            moreText: {
                buttons: ['bold', 'italic', 'underline', 'clearFormatting', 'fontSize', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle'],
                align: 'left',
                buttonsVisible: 5
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
                buttons: ['wirisEditor', 'wirisChemistry'],
                align: 'left',
                buttonVisible: 3
            },

            moreMisc: {
                buttons: ['undo', 'redo'],
                align: 'right',
                buttonsVisible: 2
            }
        },

        useClasses: false,
        enter: FroalaEditor.ENTER_BR,
        pastePlain: true,
        fontSize: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '30', '36', '48', '60', '72', '96'],
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageRemove'],
        imageUploadURL: '<?= base_url('admin/upload_image') ?>',
        imageUploadParams: {
            csrf_token_name: csrfHash,
            id: 'my_editor',
        },
        imageUploadMethod: 'POST',
        imageMaxSize: 5 * 1024 * 1024,
        imageAllowedTypes: ['jpeg', 'jpg', 'png'],

        events: {
            'image.beforeUpload': function(images) {
                // Return false if you want to stop the image upload.
            },
            'image.uploaded': function(response) {
                // Image was uploaded to the server.
            },
            'image.inserted': function($img, response) {
                var responseText = JSON.parse(response);
                document.getElementById('txt_csrfname').setAttribute('name', responseText.tokenName);
                document.getElementById('txt_csrfname').setAttribute('value', responseText.tokenValue);
                // Image was inserted in the editor.
            },
            'image.replaced': function($img, response) {
                // Image was replaced in the editor.
            },
            'image.error': function(error, response) {
                if (error.code == 1) {
                    console.log(error);
                } else if (error.code == 2) {
                    console.log(error);
                } else if (error.code == 3) {
                    console.log(error);
                } else if (error.code == 4) {
                    console.log(error);
                } else if (error.code == 5) {
                    console.log(error);
                } else if (error.code == 6) {
                    console.log(error);
                } else if (error.code == 7) {
                    console.log(error);
                }
            },

            'image.removed': function($img) {
                var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
                var csrfHash = document.getElementById('txt_csrfname').value;

                var data = {};
                data[csrfName] = csrfHash;
                data["src"] = $img.attr('src');

                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "<?= base_url('admin/deleted_image') ?>", true);
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(xhttp.responseText);
                        console.log('Image Was Deleted');
                        document.getElementById('txt_csrfname').setAttribute('name', response.tokenName);
                        document.getElementById('txt_csrfname').setAttribute('value', response.tokenValue);
                    }
                };

                xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                xhttp.setRequestHeader("Content-Type", "application/json");
                xhttp.send(JSON.stringify(data));
            }
        },

        htmlAllowedTags: ['.*'],
        htmlAllowedAttrs: ['.*'],
        htmlAllowedEmptyTags: ['mprescripts', 'none'],
    })

    new FroalaEditor('#option_4', {
        toolbarButtons: {
            moreText: {
                buttons: ['bold', 'italic', 'underline', 'clearFormatting', 'fontSize', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle'],
                align: 'left',
                buttonsVisible: 5
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
                buttons: ['wirisEditor', 'wirisChemistry'],
                align: 'left',
                buttonVisible: 3
            },

            moreMisc: {
                buttons: ['undo', 'redo'],
                align: 'right',
                buttonsVisible: 2
            }
        },

        useClasses: false,
        enter: FroalaEditor.ENTER_BR,
        pastePlain: true,
        fontSize: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '30', '36', '48', '60', '72', '96'],
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageRemove'],
        imageUploadURL: '<?= base_url('admin/upload_image') ?>',
        imageUploadParams: {
            csrf_token_name: csrfHash,
            id: 'my_editor',
        },
        imageUploadMethod: 'POST',
        imageMaxSize: 5 * 1024 * 1024,
        imageAllowedTypes: ['jpeg', 'jpg', 'png'],

        events: {
            'image.beforeUpload': function(images) {
                // Return false if you want to stop the image upload.
            },
            'image.uploaded': function(response) {
                // Image was uploaded to the server.
            },
            'image.inserted': function($img, response) {
                var responseText = JSON.parse(response);
                document.getElementById('txt_csrfname').setAttribute('name', responseText.tokenName);
                document.getElementById('txt_csrfname').setAttribute('value', responseText.tokenValue);
                // Image was inserted in the editor.
            },
            'image.replaced': function($img, response) {
                // Image was replaced in the editor.
            },
            'image.error': function(error, response) {
                if (error.code == 1) {
                    console.log(error);
                } else if (error.code == 2) {
                    console.log(error);
                } else if (error.code == 3) {
                    console.log(error);
                } else if (error.code == 4) {
                    console.log(error);
                } else if (error.code == 5) {
                    console.log(error);
                } else if (error.code == 6) {
                    console.log(error);
                } else if (error.code == 7) {
                    console.log(error);
                }
            },

            'image.removed': function($img) {
                var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
                var csrfHash = document.getElementById('txt_csrfname').value;

                var data = {};
                data[csrfName] = csrfHash;
                data["src"] = $img.attr('src');

                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "<?= base_url('admin/deleted_image') ?>", true);
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(xhttp.responseText);
                        console.log('Image Was Deleted');
                        document.getElementById('txt_csrfname').setAttribute('name', response.tokenName);
                        document.getElementById('txt_csrfname').setAttribute('value', response.tokenValue);
                    }
                };

                xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                xhttp.setRequestHeader("Content-Type", "application/json");
                xhttp.send(JSON.stringify(data));
            }
        },

        htmlAllowedTags: ['.*'],
        htmlAllowedAttrs: ['.*'],
        htmlAllowedEmptyTags: ['mprescripts', 'none'],
    })

    new FroalaEditor('#option_5', {
        toolbarButtons: {
            moreText: {
                buttons: ['bold', 'italic', 'underline', 'clearFormatting', 'fontSize', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle'],
                align: 'left',
                buttonsVisible: 5
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
                buttons: ['wirisEditor', 'wirisChemistry'],
                align: 'left',
                buttonVisible: 3
            },

            moreMisc: {
                buttons: ['undo', 'redo'],
                align: 'right',
                buttonsVisible: 2
            }
        },

        useClasses: false,
        enter: FroalaEditor.ENTER_BR,
        pastePlain: true,
        fontSize: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '30', '36', '48', '60', '72', '96'],
        imageEditButtons: ['imageDisplay', 'imageAlign', 'imageRemove'],
        imageUploadURL: '<?= base_url('admin/upload_image') ?>',
        imageUploadParams: {
            csrf_token_name: csrfHash,
            id: 'my_editor',
        },
        imageUploadMethod: 'POST',
        imageMaxSize: 5 * 1024 * 1024,
        imageAllowedTypes: ['jpeg', 'jpg', 'png'],

        events: {
            'image.beforeUpload': function(images) {
                // Return false if you want to stop the image upload.
            },
            'image.uploaded': function(response) {
                // Image was uploaded to the server.
            },
            'image.inserted': function($img, response) {
                var responseText = JSON.parse(response);
                document.getElementById('txt_csrfname').setAttribute('name', responseText.tokenName);
                document.getElementById('txt_csrfname').setAttribute('value', responseText.tokenValue);
                // Image was inserted in the editor.
            },
            'image.replaced': function($img, response) {
                // Image was replaced in the editor.
            },
            'image.error': function(error, response) {
                if (error.code == 1) {
                    console.log(error);
                } else if (error.code == 2) {
                    console.log(error);
                } else if (error.code == 3) {
                    console.log(error);
                } else if (error.code == 4) {
                    console.log(error);
                } else if (error.code == 5) {
                    console.log(error);
                } else if (error.code == 6) {
                    console.log(error);
                } else if (error.code == 7) {
                    console.log(error);
                }
            },

            'image.removed': function($img) {
                var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
                var csrfHash = document.getElementById('txt_csrfname').value;

                var data = {};
                data[csrfName] = csrfHash;
                data["src"] = $img.attr('src');

                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "<?= base_url('admin/deleted_image') ?>", true);
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(xhttp.responseText);
                        console.log('Image Was Deleted');
                        document.getElementById('txt_csrfname').setAttribute('name', response.tokenName);
                        document.getElementById('txt_csrfname').setAttribute('value', response.tokenValue);
                    }
                };

                xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                xhttp.setRequestHeader("Content-Type", "application/json");
                xhttp.send(JSON.stringify(data));
            }
        },

        htmlAllowedTags: ['.*'],
        htmlAllowedAttrs: ['.*'],
        htmlAllowedEmptyTags: ['mprescripts', 'none'],
    })
</script>

<?= $this->endSection(); ?>