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
                        <h3 class="box-title simulation">Event Simulasi <span>SNBT 2023</span></h3>
                        <p class="box__subtitle">Berikut Daftar Event UTBK 2023</p>
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

<script src="<?= base_url('assets/js/simulasi-event-home-category.js?v=') . time() ?>"></script>

<script>
    let pembahasan = <?= json_encode($history); ?>;
    let dataTypeSoal = <?= json_encode($type_soal); ?>;
    let dataCategorySoal = <?= json_encode($bank_quiz); ?>;
    let filterGroup = <?= json_encode($filter_category); ?>;

    CreateItemOption(dataTypeSoal, dataCategorySoal, filterGroup, pembahasan);
    DefaultTabButton(dataTypeSoal, dataCategorySoal);
    TabButtonControl(dataTypeSoal, dataCategorySoal);
</script>
<?= $this->endSection(); ?>