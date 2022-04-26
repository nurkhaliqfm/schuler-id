<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title">Bank Soal</h3>
                    <div class="bank__soal__body">
                        <?php foreach ($type_soal as $ts) : ?>
                            <form action="<?= base_url('admin/jenis_bank_soal'); ?>" method="POST">
                                <input hidden type="text" name="MenuSoal" value="<?= $ts['id_main_type_soal']; ?>">
                                <div class="soal__type">
                                    <div class="soal__type__title"><?= $ts['main_type_soal']; ?></div>
                                    <div class="soal__type__number"><?= count(explode(',', $ts['list_type_soal_id'])); ?></div>
                                    <div class="soal__type__button">
                                        <button type="submit" class="bank__soalBtn">Pilih</button>
                                    </div>
                                </div>
                            </form>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>