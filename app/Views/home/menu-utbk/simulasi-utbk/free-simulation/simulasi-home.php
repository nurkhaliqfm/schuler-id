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
                            <div class="saintek-button tab_button_style active" id="btn_1">SAINTEK</div>
                            <div class="soshum-button tab_button_style" id="btn_2">SOSHUM</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="white-box">
                    <div class="container__body simulation__free">
                        <div class="box_item__container jenis__simulasi__container">
                            <div class="box_item__header">SAINTEK 1</div>
                            <div class="box_item__body">
                                <div class="box_body__title">Jumlah Soal: 135 Nomor</div>
                                <div class="box_body__subtitle">Waktu: 150 Menit</div>
                                <div class="box_body__desc">Matematika, Fisika, Kimia, Biologi</div>
                            </div>
                            <div class="box_item__footer">
                                <button type="button" class="box_item__Btn selected" data-toggle="modal" data-target="#modelTargetPTN">
                                    <i class="fa-solid fa-play"></i><span>Kerjakan</span>
                                </button>
                                <a href="#" class="box_item__Btn">
                                    Rangking Universitas
                                </a>
                                <a href="#" class="box_item__Btn">
                                    Rangking Nasional
                                </a>
                            </div>
                        </div>
                        <div class="box_item__container jenis__simulasi__container">
                            <div class="box_item__header jenis__simulasi__head">SOSHUM 1</div>
                            <div class="box_item__body">
                                <div class="box_body__title">Jumlah Soal: 135 Nomor</div>
                                <div class="box_body__subtitle">Waktu: 150 Menit</div>
                                <div class="box_body__desc">Sejarah, Ekonomi, Sosiologi, Geografi</div>
                            </div>
                            <div class="box_item__footer">
                                <a href="<?= base_url('home/simulasi_gratis_guide'); ?>" class="box_item__Btn selected">
                                    <i class="fa-solid fa-play"></i><span>Kerjakan</span>
                                </a>
                                <a href="#" class="box_item__Btn">
                                    Rangking Universitas
                                </a>
                                <a href="#" class="box_item__Btn">
                                    Rangking Nasional
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modelTargetPTN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    const saintekBtn = document.getElementById("btn_1"),
        soshumBtn = document.getElementById("btn_2");

    saintekBtn.addEventListener("click", () => {
        saintekBtn.classList.add("active");
        soshumBtn.classList.remove("active");
    })

    soshumBtn.addEventListener("click", () => {
        soshumBtn.classList.add("active");
        saintekBtn.classList.remove("active");
    })
</script>
<?= $this->endSection(); ?>