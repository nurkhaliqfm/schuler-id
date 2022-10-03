<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class="container-fluid">

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('failed')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('failed'); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box invoice_white-box">
                    <div class="head__simulationfree">
                        <h3 class="box-title">Pengaturan <span>Akun</span></h3>
                        <br>
                        <div class="form-group mb-2">
                            <p class="fw-bold">Nama</p>
                            <p><?= $data['username'] ?></p>
                        </div>
                        <div class="form-group mb-2">
                            <p class="fw-bold">Asal Sekolah</p>
                            <p><?= $data['asal_sekolah'] ?></p>
                            <div id="change_sekolah-box" class="button__container">
                                <a id="change_sekolah" class="start__simulation__Btn">
                                    <i class="fa-solid fa-pen"></i><span>Ubah Asal Sekolah</span>
                                </a>
                            </div>
                            <div id="sekolah-box" style="display: none;" class="alert__box account_setting-alert">
                                <form action="<?= base_url('home/update-sekolah'); ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <div class="col-md mb-2">
                                        <div class="form-floating">
                                            <input name="asal_sekolah" type="text" class="form-control" id="floatingInputGrid">
                                            <label for="floatingInputGrid">Input Asal Sekolah</label>
                                        </div>
                                    </div>

                                    <div class="button__container">
                                        <button type="submit" class="save-btn text-center">Simpan</button>
                                        <a id="batal-edit-sekolah" class="batal-btn text-center">Batal</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <p class="fw-bold">Alamat Email</p>
                            <p><?= $data['email'] ?></p>
                        </div>
                        <div class=" form-group mb-2">
                            <p class="fw-bold">No. Hp</p>
                            <p><?= $data['phone'] ?></p>
                        </div>
                        <div class=" form-group mb-2">
                            <p class="fw-bold">Kampus Pilihan</p>
                            <p><?= $kampus['nama_universitas'] ?></p>
                            <div id="change_univ-box" class="button__container">
                                <a id="change_univ" class="start__simulation__Btn">
                                    <i class="fa-solid fa-pen"></i><span>Ubah Kampus</span>
                                </a>
                            </div>
                            <div id="univ-box" style="display: none;" class="alert__box account_setting-alert">
                                <form action="<?= base_url('home/update-universitas'); ?>" method="POST">
                                    <?= csrf_field(); ?>
                                    <div class="input-group mb-3">
                                        <select id="selectKampus" name="kampus_1" class="form-select" aria-label="Default select example">
                                            <option value="" selected>Pilih Universitas</option>
                                            <?php foreach ($university_list as $uL) : ?>
                                                <option <?= $kampus['id_universitas'] == $uL['id_universitas'] ? 'selected' : '' ?> value="<?= $uL['id_universitas']; ?>"><?= $uL['nama_universitas']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="button__container">
                                        <button type="submit" class="save-btn text-center">Simpan</button>
                                        <a id="batal-edit-univ" class="batal-btn text-center">Batal</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div id="change_pass_box" class="button__container">
                                <a id="change_pass" class="start__simulation__Btn">
                                    <i class="fa-solid fa-lock"></i><span>Ubah Password</span>
                                </a>
                            </div>
                            <div id="pass-box" style="display: none;" class="alert__box account_setting-alert">
                                <form action="<?= base_url('home/update-password'); ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <div class="col-md mb-2">
                                        <div class="form-floating">
                                            <input name="password" type="text" class="form-control" id="floatingInputGrid">
                                            <label for="floatingInputGrid">Input Password Baru</label>
                                            <div class="form-text">Password minimal 8 Karakter</div>
                                        </div>
                                    </div>

                                    <div class="button__container">
                                        <button type="submit" class="save-btn text-center">Simpan</button>
                                        <a id="batal-edit-pass" class="batal-btn text-center">Batal</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#selectKampus").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Nama Kampus",
            minimumInputLength: 4
        });
    })

    let univ_change_btn = document.getElementById('change_univ'),
        univ_change = document.getElementById('univ-box'),
        univ_change_box = document.getElementById('change_univ-box'),
        batal_univ_btn = document.getElementById('batal-edit-univ'),
        sekolah_change_btn = document.getElementById('change_sekolah'),
        sekolah_change = document.getElementById('sekolah-box'),
        sekolah_change_box = document.getElementById('change_sekolah-box'),
        batal_sekolah_btn = document.getElementById('batal-edit-sekolah'),
        pass_change_btn = document.getElementById('change_pass'),
        pass_change = document.getElementById('pass-box'),
        pass_change_box = document.getElementById('change_univ-box'),
        batal_pass_btn = document.getElementById('batal-edit-pass');

    sekolah_change_btn.addEventListener('click', () => {
        sekolah_change_btn.setAttribute('style', 'display: none;');
        sekolah_change.setAttribute('style', '');
        pass_change_box.setAttribute('style', '');
        pass_change.setAttribute('style', 'display: none;');
        univ_change_box.setAttribute('style', '');
        univ_change.setAttribute('style', 'display: none;');
    })

    batal_sekolah_btn.addEventListener('click', () => {
        sekolah_change_btn.setAttribute('style', '');
        sekolah_change.setAttribute('style', 'display: none;');
    })

    univ_change_btn.addEventListener('click', () => {
        pass_change_box.setAttribute('style', '');
        pass_change.setAttribute('style', 'display: none;');
        univ_change_box.setAttribute('style', 'display: none;');
        univ_change.setAttribute('style', '');
        sekolah_change_btn.setAttribute('style', '');
        sekolah_change.setAttribute('style', 'display: none;');
    })

    batal_univ_btn.addEventListener('click', () => {
        univ_change_box.setAttribute('style', '');
        univ_change.setAttribute('style', 'display: none;');
    })

    pass_change_btn.addEventListener('click', () => {
        pass_change_box.setAttribute('style', 'display: none;');
        pass_change.setAttribute('style', '');
        univ_change_box.setAttribute('style', '');
        univ_change.setAttribute('style', 'display: none;');
        sekolah_change_btn.setAttribute('style', '');
        sekolah_change.setAttribute('style', 'display: none;');
    })

    batal_pass_btn.addEventListener('click', () => {
        pass_change_box.setAttribute('style', '');
        pass_change.setAttribute('style', 'display: none;');
    })
</script>
<?= $this->endSection(); ?>