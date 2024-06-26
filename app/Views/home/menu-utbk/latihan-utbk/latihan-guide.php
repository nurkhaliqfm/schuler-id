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
                        <h3 class="box-title simulation">Persiapan <span>Latihan</span></h3>
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
                                <td>Latihan</td>
                                <td>:</td>
                                <td><?= $nama_quiz; ?></td>
                            </tr>
                            <tr>
                                <td>Soal</td>
                                <td>:</td>
                                <td>20 Nomor</td>
                            </tr>
                            <tr>
                                <td>Waktu</td>
                                <td>:</td>
                                <td><?= $timer / 60; ?> Menit</td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer__simulationfree">
                        <div class="button__container">
                            <a class="start__simulation__Btn" data-bs-toggle="modal" data-bs-target="#modalGuide">
                                <i class="fa-solid fa-play"></i><span>Kerjakan</span>
                            </a>
                            <a href="<?= base_url('home/latihan_home'); ?>" class="close__simulation__Btn">
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
                    <a id="start_btn" href="<?= base_url('home/kerjakan_latihan?id=' . $_GET['id'] . '&query=' . $_GET['query']); ?>" class="modal-style start__simulation__Btn">
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

<?= $this->endSection(); ?>