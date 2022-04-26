<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="head__simulationfree">
                        <h3 class="box-title simulation">Simulasi UTBK <span>GRATIS</span></h3>
                        <p class="box__subtitle">Berikut Daftar Simulasi UTBK Gratis</p>
                        <div class="alert__box"><i class="fa-solid fa-circle-info"></i><span> Perhatian : </span>Gunakan browser google chrome versi terbaru agar website dapat diakses dengan lancar tanpa masalah</div>
                        <div class="button__container">
                            <div class="saintek-button simftype__Btn active" id="simf__sainBtn">SAINTEK</div>
                            <div class="soshum-button simftype__Btn" id="simf__soshBtn">SOSHUM</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="white-box">
                    <div class="container__body simulation__free">
                        <div class="jenis__simulasi__container">
                            <div class="jenis__simulasi__head">SAINTEK 1</div>
                            <div class="jenis__simulasi__body">
                                <div class="jenis__simulasi__questnumb">Jumlah Soal: 135 Nomor</div>
                                <div class="jenis__simulasi__time">Waktu: 150 Menit</div>
                                <div class="jenis__simulasi__desk">Matematika, Fisika, Kimia, Biologi</div>
                            </div>
                            <div class="jenis__simulasi__foot">
                                <button type="button" class="jenis__simulasi_Btn selected" data-toggle="modal" data-target="#modelTargetPTN">
                                    <i class="fa-solid fa-play"></i><span>Kerjakan</span>
                                </button>
                                <a href="#" class="jenis__simulasi_Btn">
                                    Rangking Universitas
                                </a>
                                <a href="#" class="jenis__simulasi_Btn">
                                    Rangking Nasional
                                </a>
                            </div>
                        </div>
                        <div class="jenis__simulasi__container">
                            <div class="jenis__simulasi__head">SOSHUM 1</div>
                            <div class="jenis__simulasi__body">
                                <div class="jenis__simulasi__questnumb">Jumlah Soal: 135 Nomor</div>
                                <div class="jenis__simulasi__time">Waktu: 150 Menit</div>
                                <div class="jenis__simulasi__desk">Sejarah, Ekonomi, Sosiologi, Geografi</div>
                            </div>
                            <div class="jenis__simulasi__foot">
                                <a href="<?= base_url('home/simulasi_gratis_guide'); ?>" class="jenis__simulasi_Btn selected">
                                    <i class="fa-solid fa-play"></i><span>Kerjakan</span>
                                </a>
                                <a href="#" class="jenis__simulasi_Btn">
                                    Rangking Universitas
                                </a>
                                <a href="#" class="jenis__simulasi_Btn">
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
    const simfsainBtn = document.getElementById("simf__sainBtn"),
        simfsoshBtn = document.getElementById("simf__soshBtn");

    simfsainBtn.addEventListener("click", () => {
        simfsainBtn.classList.add("active");
        simfsoshBtn.classList.remove("active");
    })

    simfsoshBtn.addEventListener("click", () => {
        simfsoshBtn.classList.add("active");
        simfsainBtn.classList.remove("active");
    })
</script>
<?= $this->endSection(); ?>