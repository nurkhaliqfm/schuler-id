<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title">Input Soal</h3>
                    <form action="<?= base_url('admin/question'); ?>" method="POST">
                        <!-- Pertanyaan -->
                        <div class="mb-3">
                            <textarea rows="10" name="editorQuestion" type="text" class="form-control" id="editorQuestion"></textarea>
                        </div>

                        <!-- Option -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" class="form-control" id="option_a" placeholder="Option A">
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
                        <div class="mb-3">
                            <label for="quetion" class="form-label">Point</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"></input>
                        </div>

                        <!-- Pembahasaan -->
                        <div class="mb-3">
                            <label for="quetion" class="form-label">Pembahasan</label>
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