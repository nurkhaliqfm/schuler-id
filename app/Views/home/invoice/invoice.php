<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box invoice_white-box">
                    <div class="head__simulationfree">
                        <h3 class="box-title">Persiapan <span>Latihan</span></h3>
                        <div class="alert__box invoice_alert"><i class="fa-solid fa-circle-info"></i>
                            <span> Perhatian : </span>
                            <ul>
                                <li>Screenshoot bukti pembayaran anda untuk verifikasi apabila ada kendala pembayaran</li>
                                <li>Apabila dalam waktu 30 menit setelah melakukan pembayaran namun pembayaran belum terkonfirmasi, silahkan hubungi admin melalaui email halo@schuler.id atau ke whatsapp +62 812-4533-5890 dengan mengirim bukti transfer</li>
                            </ul>
                        </div>
                    </div>
                    <div class="header__button-box container_header_1 simulation-result__tab">
                        <div class="button__container">
                            <?php empty($_GET['slug']) ? $uri = '' : $uri = $_GET['slug']; ?>
                            <a class="tab_button tab_button_style <?= $uri == '' || $uri == 'panding' ? 'active' : ''; ?>">
                                <span class="text-start">Panding</span>
                                <span class="text-end">(1)</span></a>
                            <a class="tab_button tab_button_style <?= $uri == 'sukses' ? 'active' : ''; ?>">
                                <span class="text-start">Sukses</span>
                                <span class="text-end">(1)</span></a>
                            </a>
                            <a class="tab_button tab_button_style <?= $uri == 'batal' ? 'active' : ''; ?>">
                                <span class="text-start">Batal</span>
                                <span class="text-end">(1)</span></a>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="white-box invoice_white-box">
                    <div class="box_item__header belipaket_container__header">
                        <div class="header__title-box">
                            <div class="box_header__title">Beli Paket UTBK</div>
                            <div class="box_header__subtitle" id="result_subtitle">&nbsp;</div>
                        </div>
                    </div>
                    <div class="container__body paket__container">
                        <div class="box_item__container container_paket small-box">
                            <div class="box_item__header">
                                <div class="box_body__title">Premium</div>
                                <div class="box_body__subtitle discount_paket">
                                    <span class="alert__box alert-belipaket">
                                        Diskon 90%
                                    </span>
                                    <span class="price">Rp 250.000,00</span>
                                </div>
                                <div class="box_body__subtitle"><i class="fas fa-tags"></i><span> Rp 25.000,00</span></div>
                            </div>
                            <div class="box_item__body paket_body">
                                <ul>
                                    <li>Materi UTBK Terupdate</li>
                                    <li>Simulasi Premium Sistem CAT</li>
                                    <li>Pembahasan Simulasi Lengkap</li>
                                    <li>Analsis Statistik dan Hasil Simulasi</li>
                                    <li>Latihan Soal SAINTEK/SOSHUM/CAMPURAN</li>
                                    <li>Rangking Simulasi Nasional dan Daerah</li>
                                </ul>
                            </div>
                            <div class="box_item__footer paket_footer">
                                <div class="button__container">
                                    <a class="tab_button tab_button_style active" data-bs-toggle="modal" data-bs-target="#modalChart"><i class="fa-solid fa-cart-shopping"></i> <span>BELI</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalChart" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Keranjang</h5>
                <button type="button" class="btn-close custom_modal_closs" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modalChart">
                <form method="POST" id="form-modal_add-question">
                    <?= csrf_field(); ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <td colspan="2" class="font-weight-bolder">Paket Soal-Soal Premium</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600;" width="50%">Diskon 90% Premium</td>
                                <td class="text-end">Rp 25.000,00<br><span class="text-decoration-line-through" style="font-size: 0.8rem">Rp 250.00,00</span></td>
                            </tr>
                        </thead>
                    </table>
                    <table class="table">
                        <thead>
                            <tr>
                                <td style="font-weight: 600;" width="50%">TOTAL</td>
                                <td class="text-end">Rp 25.000,00</td>
                            </tr>
                        </thead>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="box_item__Btn list_quiz_button selected"><i class="fa-solid fa-cart-shopping"></i> <span>Pembayaran</span> </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>