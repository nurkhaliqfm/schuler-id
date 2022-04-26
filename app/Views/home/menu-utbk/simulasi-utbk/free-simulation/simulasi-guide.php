<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="head__simulationfree">
                        <h3 class="box-title simulation">Persiapan <span>Simulasi</span></h3>
                        <div class="alert__box"><i class="fa-solid fa-circle-info"></i><span> Perhatian : </span>Gunakan browser google chrome versi terbaru agar website dapat diakses dengan lancar tanpa masalah</div>
                    </div>
                    <div class="body__simulationfree">
                        <table class="table">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Jenis Latihan</td>
                                <td>:</td>
                                <td>Saintek 1</td>
                            </tr>
                            <tr>
                                <td>Jumlah Soal</td>
                                <td>:</td>
                                <td>135 Nomor</td>
                            </tr>
                            <tr>
                                <td>Waktu Mengerjakan</td>
                                <td>:</td>
                                <td>170 Menit</td>
                            </tr>
                            <tr>
                                <td>PTN Pilihan</td>
                                <td>:</td>
                                <td>UNIVERSITAS HASANUDDIN</td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer__simulationfree">
                        <div class="button__container">
                            <a href="<?= base_url('home/simulasi_gratis_main'); ?>" class="start__simulation__Btn">
                                <i class="fa-solid fa-play"></i><span>Kerjakan</span>
                            </a>
                            <a href="<?= base_url('home/simulasi_gratis'); ?>" class="close__simulation__Btn">
                                <i class="fa-solid fa-times-circle"></i><span>Batal</span>
                            </a>
                        </div>
                    </div>
                </div>
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