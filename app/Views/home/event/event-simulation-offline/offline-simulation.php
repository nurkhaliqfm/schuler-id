<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <?php if (session()->getFlashdata('failed')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashdata('failed'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="container_header_1 head__simulationfree">
                        <h3 class="box-title simulation">Simulasi SNBT <span>SMA YPS Sorowako</span></h3>
                        <p class="box__subtitle">Berikut Daftar Sekolah Penyelenggara Simulasi SNBT Offline</p>
                        <div class="alert__box"><i class="fa-solid fa-circle-info"></i><span> Perhatian : </span>Gunakan browser google chrome versi terbaru agar website dapat diakses dengan lancar tanpa masalah</div>
                        <div style="display: none;" class="button__container">
                            <?php foreach ($type_soal as $ts) : ?>
                                <div class="tab_button tab_button_style" id="<?= $ts['slug']; ?>"><?= strtoupper(str_replace('_', ' ', $ts['slug'])); ?></div>
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
<script src="<?= base_url('assets/js/simulasi-offline-home-category.js?v=') . time() ?>"></script>

<script>
    let dataTypeSoal = <?= json_encode($type_soal); ?>;
    let dataCategorySoal = <?= json_encode($bank_quiz); ?>;
    let filterGroup = <?= json_encode($filter_category); ?>;
    let mitra = <?= json_encode($_GET['query']); ?>;

    CreateItemOption(dataTypeSoal, dataCategorySoal, filterGroup);
    DefaultTabButton(dataTypeSoal, dataCategorySoal);
</script>
<?= $this->endSection(); ?>