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
                    <form action="<?= base_url('admin/update_soal_truefalse'); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <input hidden type="text" name="id" value="<?= $bank_soal['id']; ?>">
                        <input hidden type="text" name="MenuSoal" value="<?= $menu_soal; ?>">
                        <input hidden type="text" name="SubmenuSoal" value="<?= $submenu_soal; ?>">
                        <input hidden type="text" name="SoalStyle" value="<?= $soal_style; ?>">

                        <!-- Pertanyaan -->
                        <h3 class="custom-box-title">Edit Soal True False</h3>
                        <div class="mb-3">
                            <textarea rows="10" name="editorQuestion" type="text" class="form-control <?= ($validation->hasError('editorQuestion')) ? 'is-invalid' : ''; ?>" id="editorQuestion"><?= old('editorQuestion') ? old('editorQuestion') : $bank_soal['soal']; ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('editorQuestion'); ?>
                            </div>
                        </div>

                        <!-- Soal Tag -->
                        <h3 class="custom-box-title">Jenis Pilihan</h3>
                        <div class="mb-3">
                            <select name="jenisPilihan" class="form-select <?= ($validation->hasError('jenisPilihan')) ? 'is-invalid' : ''; ?>" aria-label="Default select example">
                                <option disabled selected> Pilih Tag Soal</option>
                                <option <?= old('jenisPilihan') ? (old('jenisPilihan') == "true_false" ? "selected" : "") : ($jenis_pilihan['soal_tag'] == "true_false" ? "selected" : ""); ?> value="true_false">Ture/False</option>
                                <option <?= old('jenisPilihan') ? (old('jenisPilihan') == "memperlemah_nonmemperlemah" ? "selected" : "") : ($jenis_pilihan['soal_tag'] == "memperlemah_nonmemperlemah" ? "selected" : ""); ?> value="memperlemah_nonmemperlemah">Memperlemah/Tidak Memperlemah</option>
                                <option <?= old('jenisPilihan') ? (old('jenisPilihan') == "mendukung_nonmendukung" ? "selected" : "") : ($jenis_pilihan['soal_tag'] == "mendukung_nonmendukung" ? "selected" : ""); ?> value="mendukung_nonmendukung">Mendukung/Tidak Mendukung </option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('jenisPilihan'); ?>
                            </div>
                        </div>

                        <!-- Option -->
                        <h3 class="custom-box-title">Input Option</h3>
                        <?php $i = 1; ?>
                        <?php foreach ($answer_quest as $ans) : ?>
                            <div class="grid-container option__style">
                                <div>
                                    <div class="checkbox checkbox__form">
                                        <input <?= $ans['ans_id'] == "option_" . $i . "_true" ?  "checked" : ""; ?> type="checkbox" value="<?= 'option_' . $i . '_true' ?>" name="<?= 'checkbox_' . $i . '[]' ?>" id="<?= 'checkbox_' . $i ?>">
                                        <div class="box">
                                            T
                                        </div>
                                    </div>
                                    <div class="checkbox checkbox__form">
                                        <input <?= $ans['ans_id'] == "option_" . $i . "_false" ?  "checked" : ""; ?> type="checkbox" value="<?= 'option_' . $i . '_false' ?>" name="<?= 'checkbox_' . $i . '[]' ?>" id="<?= 'checkbox_' . $i ?>">
                                        <div class="box">
                                            F
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3" id="optionEditor">
                                    <textarea rows="10" type="text" class="input__form form-control <?= ($validation->hasError('option_' . $i)) ? 'is-invalid' : ''; ?>" name="<?= 'option_' . $i ?>" id="<?= 'option_' . $i ?>" ; ?><?= old('option_' . $i) ? old('option_' . $i) : $ans['sub_soal_slug']; ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('option_' . $i); ?>
                                    </div>
                                </div>
                            </div>
                            <?php $i++ ?>
                        <?php endforeach; ?>

                        <!-- Pertanyaan -->
                        <h3 class="custom-box-title">Input Nilai</h3>
                        <div class="mb-3">
                            <select name="questionValue" class="form-select <?= ($validation->hasError('questionValue')) ? 'is-invalid' : ''; ?>" aria-label="Default select example">
                                <option disabled selected>Pilih Nilai</option>
                                <option <?= old('questionValue') ? (old('questionValue') == "1" ? "selected" : "") : ($bank_soal['value'] == "1" ? "selected" : ""); ?> value="1">1</option>
                                <option <?= old('questionValue') ? (old('questionValue') == "2" ? "selected" : "") : ($bank_soal['value'] == "2" ? "selected" : ""); ?> value="2">2</option>
                                <option <?= old('questionValue') ? (old('questionValue') == "3" ? "selected" : "") : ($bank_soal['value'] == "3" ? "selected" : ""); ?> value="3">3</option>
                                <option <?= old('questionValue') ? (old('questionValue') == "4" ? "selected" : "") : ($bank_soal['value'] == "4" ? "selected" : ""); ?> value="4">4</option>
                                <option <?= old('questionValue') ? (old('questionValue') == "5" ? "selected" : "") : ($bank_soal['value'] == "5" ? "selected" : ""); ?> value="5">5</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('questionValue'); ?>
                            </div>
                        </div>


                        <!-- Pembahasaan -->
                        <h3 class="custom-box-title">Input Pembahasan</h3>
                        <div class="mb-3">
                            <textarea rows="10" type="text" class="form-control <?= ($validation->hasError('editorExplanation')) ? 'is-invalid' : ''; ?>" name="editorExplanation" id="editorExplanation"><?= old('editorExplanation') ? old('editorExplanation') : $bank_soal['pembahasan']; ?></textarea>
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
    const inputForm = document.querySelectorAll('.input__form');

    function resetOption() {
        inputForm.forEach(inputForm => {
            inputForm.classList.remove('checked');
        })
    }
    $('input[type="checkbox"]').on('change', function() {
        $('input[name="' + this.name + '"]').not(this).prop('checked', false);

        resetOption();
        var inputValue = $(this).attr("value");
        $('#optionEditor #' + inputValue).addClass("checked");
    });
</script>

<script>
    var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
    var csrfHash = document.getElementById('txt_csrfname').value;
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
            csrf_token_name: document.getElementById('txt_csrfname').value,
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
            csrf_token_name: document.getElementById('txt_csrfname').value,
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
            csrf_token_name: document.getElementById('txt_csrfname').value,
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
            csrf_token_name: document.getElementById('txt_csrfname').value,
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
            csrf_token_name: document.getElementById('txt_csrfname').value,
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