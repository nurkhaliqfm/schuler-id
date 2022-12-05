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
                        <h3 class="box-title simulation">Mitra Simulasi <span>SNBT OFFLINE</span></h3>
                        <p class="box__subtitle">Berikut Daftar Sekolah Penyelenggara Simulasi SNBT Offline</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="white-box">
                    <div id="container_body" class="container__body simulation__free">
                        <?php foreach ($mitra_list as $ml) : ?>
                            <div class="box_item__container" data-box="snbt_utbk_2023">
                                <div class="box_item__header"><?= $ml['mitra_name'] ?></div>
                                <div class="box_item__body">
                                    <img src="<?= base_url('assets/mitra/' . $ml['mitra_logo']) ?>" alt="mitra_logo" width="100" height="100">
                                </div>
                                <div class="box_item__footer simulasi_box_footer">
                                    <button id="item_login" type="button" class="box_item__Btn list_quiz_button-normal selected" data-button="<?= $ml['mitra_id'] ?>">Masuk</button>
                                    <button id="item_student_daftar" type="button" class="box_item__Btn list_quiz_button-normal selected" data-button="<?= $ml['mitra_id'] ?>" data-bs-toggle="modal" data-bs-target="#modelNISN">Registrasi</button>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modelCekPeserta" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header format-logo">
                <h5 class="modal-title">Verifikasi Akses Simulasi</h5>
            </div>
            <form action="<?= base_url('home/loginSimulasiOffline'); ?>" method="post">
                <input type="hidden" id="txt_csrfname_login" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <input type="hidden" id="id_mitra_login" name="id_mitra" />
                <div class="modal-body">
                    <div class="response-message"></div>
                    <div class="form-floating mb-3">
                        <input name="id_student" type="text" class="form-control" id="floatingInput" required placeholder="Masukkan Kode Akses">
                        <label for="floatingInput">Kode Akses</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="password" type="password" class="form-control" id="floatingInput" required placeholder="Masukkan Password">
                        <label for="floatingInput">Password</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="button__container">
                        <button type="submit" class="modal-style start__simulation__Btn">
                            <i class="fa-solid fa-play"></i><span>Submit</span>
                        </button>
                        <a class="modal-style close__simulation__Btn" data-bs-dismiss="modal"><i class="fa-solid fa-times-circle"></i><span>Batal</span></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modelNISN" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header format-logo">
                <h5 class="modal-title">Masukkan NISN Anda</h5>
            </div>
            <div class="modal-body">
                <span style="color: red;" class="response-message_nisn"></span>
                <div id="nisn_verif" class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Masukkan NISN" required>
                    <label for="floatingInput">NISN</label>
                </div>
            </div>
            <div class="modal-footer">
                <div class="button__container">
                    <a id="submit_nisn_btn" class="modal-style start__simulation__Btn">
                        <i class="fa-solid fa-play"></i><span>Submit</span>
                    </a>
                    <a class="modal-style close__simulation__Btn" data-bs-dismiss="modal"><i class="fa-solid fa-times-circle"></i><span>Batal</span></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modelRegistPeserta" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header format-logo">
                <h5 class="modal-title">Biodata</h5>
            </div>
            <form action="<?= base_url('home/registerSimulasiOffline'); ?>" method="post">
                <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <input type="hidden" id="id_mitra" name="id_mitra" />
                <input type="hidden" id="id_student" name="id_student" />
                <div class="modal-body">
                    <p>Periksa & lengkapi data yang masih kosong</p>
                    <div id="registrasi-form" class="form-floating mb-3">
                        <input name="nama_peserta" type="text" class="form-control" id="floatingInput" placeholder="Nama Peserta" readonly>
                        <label for="floatingInput">Nama</label>
                    </div>
                    <div id="registrasi-form" class="form-floating mb-3">
                        <input name="kelas" type="text" class="form-control" id="floatingInput" placeholder="Kelas" readonly>
                        <label for="floatingInput">Kelas</label>
                    </div>
                    <div id="registrasi-form" class="form-floating mb-3">
                        <input name="asal_sekolah" type="text" class="form-control" id="floatingInput" placeholder="Asal Sekolah" readonly>
                        <label for="floatingInput">Asal Sekolah</label>
                    </div>
                    <div id="registrasi-form" class="form-floating mb-3">
                        <input name="nisn" type="text" class="form-control" id="floatingInput" placeholder="NISN" readonly>
                        <label for="floatingInput">NISN</label>
                    </div>
                    <div id="registrasi-form" class="form-floating mb-3">
                        <input name="tanggal_lahir" type="text" class="form-control" id="floatingInput" required placeholder="Tanggal Lahir" pattern="^(?:(?:1[6-9]|[2-9]\d)?\d{2})(?:(?:(\/|-|\.)(?:0?[13578]|1[02])\1(?:31))|(?:(\/|-|\.)(?:0?[13-9]|1[0-2])\2(?:29|30)))$|^(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(\/|-|\.)0?2\3(?:29)$|^(?:(?:1[6-9]|[2-9]\d)?\d{2})(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:0?[1-9]|1\d|2[0-8])$" maxlength="10" minlength="10" autocomplete="off">
                        <label for="floatingInput">Tanggal Lahir</label>
                        <div id="tanggal_help" class="form-text">Contoh: 1997-01-31 (yyyy-mm-dd)</div>
                    </div>
                    <div id="registrasi-form" class="form-floating mb-3">
                        <input name="pusat_simulasi" type="text" class="form-control" id="floatingInput" placeholder="name@example.com" readonly>
                        <label for="floatingInput">Pusat Simulasi</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="button__container">
                        <button type="submit" class="modal-style start__simulation__Btn">
                            <i class="fa-solid fa-play"></i><span>Submit</span>
                        </button>
                        <a class="modal-style close__simulation__Btn" data-bs-dismiss="modal"><i class="fa-solid fa-times-circle"></i><span>Batal</span></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var item_login = document.querySelectorAll('button#item_login');
    var item_daftar_student = document.querySelectorAll('button#item_student_daftar');
    var base_url = window.location.origin;

    item_login.forEach(item => {
        item.addEventListener('click', button => {
            const id_item = button.target.getAttribute('data-button');
            var csrfName = document.getElementById('txt_csrfname_login').getAttribute('name');
            var csrfHash = document.getElementById('txt_csrfname_login').value;

            const data = {}
            data['request'] = 'session'
            data[csrfName] = csrfHash

            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", base_url + '/home/xhttpOfflineSimulationStatus', true);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    var response = JSON.parse(xhttp.responseText);
                    document.getElementById("txt_csrfname_login").value = response["value"];
                    document.getElementById("txt_csrfname_login").name = response["name"];
                    document.querySelector('#id_mitra_login').value = id_item
                    if (response['data'] === true) {
                        window.location.href = base_url + '/home/offline_simulation_home?query=' + id_item;
                    } else {
                        $('#modelCekPeserta').modal('show');
                    }
                }
            };
            xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send(JSON.stringify(data));
        })
    })

    item_daftar_student.forEach(item => {
        item.addEventListener('click', button => {
            const id_item = button.target.getAttribute('data-button');

            document.getElementById('submit_nisn_btn').addEventListener('click', () => {
                document.querySelector('.response-message_nisn').innerHTML = ''
                var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
                var csrfHash = document.getElementById('txt_csrfname').value;

                const data = {}
                data['request'] = 'verification'
                data[csrfName] = csrfHash
                data['id_mitra'] = id_item
                data['id_peserta'] = document.querySelector('#nisn_verif input').value

                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", base_url + '/home/xhttpOfflineSimulationStatus', true);
                xhttp.onreadystatechange = () => {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        var response = JSON.parse(xhttp.responseText);
                        document.getElementById("txt_csrfname").value = response["value"];
                        document.getElementById("txt_csrfname").name = response["name"];

                        if (response['status'] == 'Success') {
                            $('#modelNISN').modal('hide');
                            $('#modelRegistPeserta').modal('show');
                            document.querySelector('#registrasi-form [name="nama_peserta"]').value = response['data']['peserta_name']
                            document.querySelector('#registrasi-form [name="asal_sekolah"]').value = response['data']['mitra_name']
                            document.querySelector('#registrasi-form [name="nisn"]').value = response['data']['peserta_id']
                            document.querySelector('#registrasi-form [name="kelas"]').value = response['data']['peserta_info']
                            document.querySelector('#registrasi-form [name="pusat_simulasi"]').value = response['data']['mitra_name']
                            document.querySelector('#id_mitra').value = response['data']['mitra_id']
                            document.querySelector('#id_student').value = response['data']['peserta_id']
                        } else if (response['status'] == 'Error') {
                            document.querySelector('.response-message_nisn').innerHTML = '*NISN Tidak Ditemukan'
                        } else if (response['status'] == 'Failed') {
                            document.querySelector('.response-message_nisn').innerHTML = '*NISN Sudah Terdftar, Silahkan Masuk Menggunakan NISN & Password Akun Schuler Anda'
                        }
                    }
                };
                xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                xhttp.setRequestHeader("Content-Type", "application/json");
                xhttp.send(JSON.stringify(data));
            })
        })
    })
</script>
<?= $this->endSection(); ?>