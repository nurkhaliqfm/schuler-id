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
                        <!-- Nama Quiz -->
                        <h3 class="custom-box-title">Nama Quiz</h3>
                        <div class="mb-3">
                            <input name="QuizName" type="text" class="form-control <?= ($validation->hasError('QuizName')) ? 'is-invalid' : ''; ?>" id="QuizName"><?= old('QuizName'); ?></input>
                            <div class="invalid-feedback">
                                <?= $validation->getError('QuizName'); ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>