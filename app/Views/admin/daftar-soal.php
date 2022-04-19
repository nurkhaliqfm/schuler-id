<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <form action="<?= base_url('admin/question'); ?>" method="POST">
                        <!-- Pertanyaan -->
                        <h3 class="custom-box-title">Input Soal</h3>
                        <div class="mb-3">
                            <textarea rows="10" name="editorQuestion" type="text" class="form-control" id="editorQuestion"></textarea>
                        </div>

                        <!-- Option -->
                        <h3 class="custom-box-title">Input Option</h3>
                        <div class="input-group mb-3" id="optionEditor">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <textarea rows="1" type="text" class="form-control" id="option_a" placeholder="Option A"></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">B</span>
                            <input type="text" class="form-control" id="option_b" placeholder="Option B">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">C</span>
                            <input type="text" class="form-control" id="option_c" placeholder="Option C">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">D</span>
                            <input type="text" class="form-control" id="option_d" placeholder="Option D">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">E</span>
                            <input type="text" class="form-control" id="option_e" placeholder="Option E">
                        </div>

                        <!-- Pertanyaan -->
                        <h3 class="custom-box-title">Input Nilai</h3>
                        <div class="mb-3">
                            <select class="form-select" aria-label="Default select example">
                                <option disabled selected>Pilih Nilai</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>


                        <!-- Pembahasaan -->
                        <h3 class="custom-box-title">Input Pembahasan</h3>
                        <div class="mb-3">
                            <textarea rows="10" type="text" class="form-control" id="editorExplanation"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>