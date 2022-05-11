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
                    <form action="<?= base_url('admin/save_soal'); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <input hidden type="text" name="MenuSoal" value="<?= $menu_soal; ?>">
                        <input hidden type="text" name="SubmenuSoal" value="<?= $submenu_soal; ?>">
                        <!-- Pertanyaan -->
                        <h3 class="custom-box-title">Input Soal</h3>
                        <div class="mb-3">
                            <textarea rows="10" name="editorQuestion" type="text" class="form-control <?= ($validation->hasError('editorQuestion')) ? 'is-invalid' : ''; ?>" id="editorQuestion"><?= old('editorQuestion'); ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('editorQuestion'); ?>
                            </div>
                        </div>

                        <!-- Option -->
                        <h3 class="custom-box-title">Input Option</h3>
                        <div class="grid-container option__style">
                            <div class="checkbox checkbox__form">
                                <input checked type="checkbox" value="option_a" name="checkbox[]" id="checkbox">
                                <div class="box">
                                    A
                                </div>
                            </div>
                            <div class="input-group mb-3" id="optionEditor">
                                <input type="text" class="input__form checked form-control <?= ($validation->hasError('option_a')) ? 'is-invalid' : ''; ?>" name="option_a" id="option_a" value="<?= old('option_a'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('option_a'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="grid-container option__style">
                            <div class="checkbox checkbox__form">
                                <input type="checkbox" value="option_b" name="checkbox[]" id="checkbox">
                                <div class="box">
                                    B
                                </div>
                            </div>
                            <div class="input-group mb-3" id="optionEditor">
                                <input type="text" class="input__form form-control <?= ($validation->hasError('option_b')) ? 'is-invalid' : ''; ?>" name="option_b" id="option_b" value="<?= old('option_b'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('option_b'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="grid-container option__style">
                            <div class="checkbox checkbox__form">
                                <input type="checkbox" value="option_c" name="checkbox[]" id="checkbox">
                                <div class="box">
                                    C
                                </div>
                            </div>
                            <div class="input-group mb-3" id="optionEditor">
                                <input type="text" class="input__form form-control <?= ($validation->hasError('option_c')) ? 'is-invalid' : ''; ?>" name="option_c" id="option_c" value="<?= old('option_c'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('option_c'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="grid-container option__style">
                            <div class="checkbox checkbox__form">
                                <input type="checkbox" value="option_d" name="checkbox[]" id="checkbox">
                                <div class="box">
                                    D
                                </div>
                            </div>
                            <div class="input-group mb-3" id="optionEditor">
                                <input type="text" class="input__form form-control <?= ($validation->hasError('option_d')) ? 'is-invalid' : ''; ?>" name="option_d" id="option_d" value="<?= old('option_d'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('option_d'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="grid-container option__style">
                            <div class="checkbox checkbox__form">
                                <input type="checkbox" value="option_e" name="checkbox[]" id="checkbox">
                                <div class="box">
                                    E
                                </div>
                            </div>
                            <div class="input-group mb-3" id="optionEditor">
                                <input type="text" class="input__form form-control <?= ($validation->hasError('option_e')) ? 'is-invalid' : ''; ?>" name="option_e" id="option_e" value="<?= old('option_e'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('option_e'); ?>
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

<?= $this->endSection(); ?>