<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container_header_1 head_latihan">
                        <h3 class="box-title simulation">Daftar Jenis <span>Latihan UTBK</span></h3>
                        <p class="box__subtitle">Pilih jenis latihan UTBK yang diinginkan</p>
                        <div class="alert__box"><i class="fa-solid fa-circle-info"></i><span> Perhatian : </span>Gunakan browser google chrome versi terbaru agar website dapat diakses dengan lancar tanpa masalah</div>
                        <div class="button__container">
                            <?php foreach ($data_type as $dt) : ?>
                                <a class="tab_button_style" href="<?= base_url('home/latihan_home/' . $dt['slug']); ?>"><?= strtoupper($dt['category_name']); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>