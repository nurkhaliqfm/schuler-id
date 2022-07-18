<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container_header_1 head__simulationfree">
                        <h3 class="box-title simulation">Simulasi UTBK <span>GRATIS</span></h3>
                        <p class="box__subtitle">Berikut Daftar Simulasi UTBK Gratis</p>
                        <div class="alert__box"><i class="fa-solid fa-circle-info"></i><span> Perhatian : </span>Gunakan browser google chrome versi terbaru agar website dapat diakses dengan lancar tanpa masalah</div>
                        <div class="button__container">
                            <?php foreach ($type_soal as $ts) : ?>
                                <div class="tab_button tab_button_style" id="<?= $ts['slug']; ?>"><?= strtoupper($ts['slug']); ?></div>
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

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalGuide" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header format-title">
                <h5 class="modal-title">Pilih Target PTN Impian Anda</h5>
            </div>
            <div class="modal-body">
                <select class="form-select" aria-label="Default select example">
                    <option selected>Pilih Universitas</option>
                    <option value="unhas">Universitas Hasanuddin</option>
                    <option value="ui">Universitas Indonesia</option>
                    <option value="itb">Institute Teknologi Bandung</option>
                </select>
            </div>
            <div class="modal-footer">
                <div class="button__container">
                    <a id="start_btn" class="modal-style start__simulation__Btn">
                        <i class="fa-solid fa-play"></i><span>Simpan</span>
                    </a>
                    <a class="modal-style close__simulation__Btn" data-bs-dismiss="modal"><i class="fa-solid fa-times-circle"></i><span>Batal</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/simulasi-home-category.js') ?>"></script>

<script>
    let dataTypeSoal = <?= json_encode($type_soal); ?>;
    let dataCategorySoal = <?= json_encode($bank_quiz); ?>;
    let filterGroup = <?= json_encode($filter_category); ?>;
    let base_url = "<?= base_url('home/simulasi_gratis_guide/'); ?>";

    CreateItemOption(dataTypeSoal, dataCategorySoal, filterGroup);
    DefaultTabButton(dataTypeSoal, dataCategorySoal, base_url);
    TabButtonControl(dataTypeSoal, dataCategorySoal, base_url);
</script>
<?= $this->endSection(); ?>