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
                    <div class="head__simulationfree">
                        <h3 class="box-title simulation">Persiapan <span>Simulasi</span></h3>
                        <div class="alert__box"><i class="fa-solid fa-circle-info"></i><span> Perhatian : </span>Gunakan browser google chrome versi terbaru agar website dapat diakses dengan lancar tanpa masalah</div>
                    </div>
                    <div class="body__simulationfree" style="overflow-x: scroll;">
                        <table class="table">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="align-middle">Simulasi</td>
                                <td class="align-middle">:</td>
                                <td class="align-middle"><?= strtoupper($nama_quiz); ?></td>
                            </tr>
                            <tr>
                                <td class="align-middle">Soal</td>
                                <td class="align-middle">:</td>
                                <td class="align-middle"><?= $jumlah_soal; ?> Nomor</td>
                            </tr>
                            <tr>
                                <td class="align-middle">Waktu</td>
                                <td class="align-middle">:</td>
                                <td class="align-middle"><?= ($timer / 60) * $quiz_part; ?> Menit</td>
                            </tr>
                            <tr>
                                <td class="align-middle">PTN Pilihan</td>
                                <td class="align-middle">:</td>
                                <td class="align-middle"><?= $universitas_pilihan; ?></td>
                            </tr>
                            <tr>
                                <td class="align-middle" rowspan="2">Jadwal Pengerjaan</td>
                                <td class="align-middle" rowspan="2">:</td>
                                <td class="align-middle" style="border-bottom: 0px;"><?= $jadwal_tgl ?></td>
                            </tr>
                            <tr>
                                <td class="align-middle"><?= $jadwal_waktu ?> WITA</td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer__simulationfree">
                        <div class="button__container">
                            <a disable class="start__simulation__Btn" data-bs-toggle="modal" data-bs-target="#modalGuide">
                                <i class="fa-solid fa-play"></i><span>Mulai</span>
                            </a>
                            <a  href="<?= base_url('/PdfController/cetak_kartu_peserta?id=' . $_GET['id'] . '&query=' . $_GET['query'] . '&m=' . $_GET['m']) ?>" class="start__simulation__Btn" style="margin-left: 5px;">
                                 <i class="fa-solid fa-download"></i> <span>Kartu Peserta</span>
                            </a>
                            <!--<a href="" class="start__simulation__Btn" style="margin-left: 5px;">-->
                            <!--    <i class="fa-solid fa-download"></i><span>Sertifikat SNBT</span>-->
                            <!--</a>-->
                            <a href="<?= base_url('/home/offline_simulation_home?query=' . $_GET['m']); ?>" class="close__simulation__Btn">
                                <i class="fa-solid fa-times-circle"></i><span>Batal</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalGuide" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header format-logo">
                <h5 class="modal-logo"><i class="fa-solid fa-circle-info"></i></h5>
            </div>
            <div class="modal-body">
                <ol>
                    <li>Pastikan koneksi internet anda stabil</li>
                    <li>Gunakan browser google chrome versi terbaru</li>
                    <li>Pastikan tidak ada aktivitas login anda pada perangkat lain saat sedang mengerjakan soal</li>
                </ol>
            </div>
            <div class="modal-footer">
                <div class="button__container">
                    <a id="start_btn" href="<?= base_url('home/kerjakan_offline_simulasi?id=' . $_GET['id'] . '&query=' . $_GET['query'] . '&m=' . $_GET['m']); ?>" class="modal-style start__simulation__Btn">
                        <i class="fa-solid fa-play"></i><span>Mulai</span>
                    </a>
                    <a class="modal-style close__simulation__Btn" data-bs-dismiss="modal"><i class="fa-solid fa-times-circle"></i><span>Batal</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const mulaiBtn = document.getElementById('start_btn');
    let sessionID = <?= json_encode($session_id); ?>;

    mulaiBtn.addEventListener('click', () => {
        localStorage.removeItem(sessionID);
    })
</script>

<script type="text/javascript">
    function preventBack() {
        window.history.forward();
    }
    setTimeout("preventBack()", 0);
    window.onunload = function() {
        null
    };
</script>

<?= $this->endSection(); ?>