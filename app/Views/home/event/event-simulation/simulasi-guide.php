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
                                <td class="align-middle"><?= $jumlah_soal ?> Nomor</td>
                            </tr>
                            <tr>
                                <td class="align-middle">Waktu</td>
                                <td class="align-middle">:</td>
                                <td class="align-middle"><?= $timer ?> Menit</td>
                            </tr>
                            <tr>
                                <td class="align-middle">PTN Pilihan</td>
                                <td class="align-middle">:</td>
                                <td class="align-middle"><?= $universitas_pilihan; ?></td>
                            </tr>
                            <tr>
                                <td class="align-middle" rowspan="2">Jadwal Pengerjaan</td>
                                <td class="align-middle" rowspan="2">:</td>
                                <td class="align-middle" style="border-bottom: 0px;"><?= $jadwal_tgl[1] ?></td>
                            </tr>
                            <tr>
                                <td class="align-middle"><?= $jadwal_waktu[1] ?><?= $jadwal_waktu[0] == '0' ? '' : ' WITA' ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer__simulationfree">
                        <div class="button__container">
                            <a class="start__simulation__Btn" data-bs-toggle="modal" data-bs-target="#modalGuide">
                                <i class="fa-solid fa-play"></i><span>Mulai</span>
                            </a>
                            <!--<a class="middle__simulation__Btn" data-bs-toggle="modal" data-bs-target="#modalSchedule">-->
                            <!--    <i class="fa-solid fa-clock"></i><span>Jadwal</span>-->
                            <!--</a>-->
                            <a href="<?= base_url('home/event_simulasi'); ?>" class="close__simulation__Btn">
                                <i class="fa-solid fa-times-circle"></i><span>Batal</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalSchedule" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= base_url('home/event_simulasi_schedule') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value=<?= $_GET['id'] ?>>
            <input type="hidden" name="query" value=<?= $_GET['query'] ?>>
            <div class="modal-content">
                <div class="modal-header format-logo">
                </div>
                <div class="modal-body">
                    <p class="mb-2">Silahkan Memilih Jadwal Yang Masih Tersedia</p>
                    <select name="tgl_value" id="tgl_option" class="form-select mb-1" aria-label="Default select example" required>
                        <option disabled selected>Pilih Jadwal Simulasi</option>
                        <?php foreach ($list_tanggal as $lt) : ?>
                            <?php $data_tgl = explode(',', $lt) ?>
                            <option value=<?= $data_tgl[0] ?>><?= $data_tgl[1] ?></option>
                        <?php endforeach ?>
                    </select>
                    <select name="sesi_value" id="sesi_option" class="form-select" aria-label="Default select example" required>
                        <option disabled selected>Pilih Sesi</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <div class="button__container">
                        <button type="submit" class="modal-style start__simulation__Btn">
                            <i class="fa-solid fa-save"></i><span>Simpan</span>
                        </button>
                        <a class="modal-style close__simulation__Btn" data-bs-dismiss="modal"><i class="fa-solid fa-times-circle"></i><span>Batal</span></a>
                    </div>
                </div>
            </div>
        </form>
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
                    <a id="start_btn" href="<?= base_url('home/kerjakan_event_simulasi?id=' . $_GET['id'] . '&query=' . $_GET['query']); ?>" class="modal-style start__simulation__Btn">
                        <i class="fa-solid fa-play"></i><span>Mulai</span>
                    </a>
                    <a class="modal-style close__simulation__Btn" data-bs-dismiss="modal"><i class="fa-solid fa-times-circle"></i><span>Batal</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var list_sesi = <?= json_encode($list_sesi) ?>;
    document.getElementById('tgl_option').addEventListener('change', (el) => {
        document.getElementById('sesi_option').innerHTML = '';
        let value = document.getElementById('tgl_option').value;
        let getSession = list_sesi.filter(
            (el) => {
                return el[0] == value
            });

        getSession.forEach(element => {
            const str = element[1].replace('_', ' ');
            const session_name = str.charAt(0).toUpperCase() + str.slice(1);
            var option = document.createElement('option');
            option.setAttribute('value', element[1]);
            option.innerHTML = session_name + ' (' + element[2] + ')'
            document.getElementById('sesi_option').appendChild(option);
        });

    })
</script>
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