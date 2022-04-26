<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title">Daftar Soal <?= $type_soal['main_type_soal']; ?></h3>
                    <div class="bank__soal__body">
                        <?php
                        $dataId = explode(',', $type_soal['list_type_soal_id']);
                        $dataName = explode(',', $type_soal['list_type_soal']);
                        $dataNumb = explode(',', $type_soal['list_type_soal_jumlah']);
                        ?>
                        <?php for ($i = 0; $i < count($dataId); $i++) { ?>
                            <div class="soal__type">
                                <div class="soal__type__title"><?= $dataName[$i]; ?></div>
                                <div class="soal__type__number"><?= $dataNumb[$i]; ?></div>
                                <div class="soal__type__button">
                                    <a href="<?= base_url('admin/daftar_soal/' . $type_soal['id_main_type_soal'] . '/' . $dataId[$i]); ?>" class="bank__soalBtn">Pilih</a>
                                </div>
                            </div>
                        <?php }; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>