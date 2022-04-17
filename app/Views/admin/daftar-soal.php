<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title">Input Soal</h3>
                    <form>
                        <!-- Pertanyaan -->
                        <div class="mb-3">
                            <textarea rows="10" name="editorQuestion" type="text" class="form-control" id="editorQuestion"></textarea>
                            <script>
                                CKEDITOR.replace('editorQuestion');
                            </script>
                        </div>

                        <!-- Option -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">B</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">C</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">D</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">E</span>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        <!-- Pertanyaan -->
                        <div class="mb-3">
                            <label for="quetion" class="form-label">Point</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"></input>
                        </div>

                        <!-- Pembahasaan -->
                        <div class="mb-3">
                            <label for="quetion" class="form-label">Pembahasan</label>
                            <textarea rows="10" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>