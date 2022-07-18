<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container_header_1 head_latihan">
                        <h3 class="box-title simulation">Latihan UTBK <span><?= strtoupper($quiz_group); ?></span></h3>
                        <p class="box__subtitle">Belajar menejeman waktu sesuai kategori yang diinginkan</p>
                        <div class="alert__box"><i class="fa-solid fa-circle-info"></i><span> Perhatian : </span>Gunakan browser google chrome versi terbaru agar website dapat diakses dengan lancar tanpa masalah</div>
                        <div class="button__container">
                            <?php foreach ($type_soal as $ts) : ?>
                                <div class="tab_button tab_button_style" id="<?= $ts['id']; ?>"><?= strtoupper($ts['name']); ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="white-box">
                    <div id="container_body" class="container__body simulation__free">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/latihan-home-category.js') ?>"></script>
<script>
    let dataTypeSoal = <?= json_encode($type_soal); ?>;
    let dataCategorySoal = <?= json_encode($bank_quiz); ?>;
    let filterGroup = <?= json_encode($filter_category); ?>;
    let base_url = "<?= base_url('home/latihan_guide/'); ?>";

    CreateItemOption(dataCategorySoal, filterGroup);
    DefaultTabButton(dataTypeSoal, dataCategorySoal, base_url);
    TabButtonControl(dataTypeSoal, dataCategorySoal, base_url);
</script>

<?= $this->endSection(); ?>