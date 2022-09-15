<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container-head-dashboard">
                        <div class="head-content">
                            <div class="content-img">
                                <img src="<?= base_url("assets/img/folder.png"); ?>" alt="img" width="28" height="28">
                            </div>
                            <div class="content-name">
                                PAKET<br>TERSEDIA
                            </div>
                            <div class="content-value">
                                2
                            </div>
                        </div>
                        <div class="line-separator left"></div>
                        <div class="head-content">
                            <div class="content-img">
                                <img src="<?= base_url("assets/img/folder.png"); ?>" alt="img" width="28" height="28">
                            </div>
                            <div class="content-name">
                                PAKET<br>YANG DIBELI
                            </div>
                            <div class="content-value">
                                1
                            </div>
                        </div>
                        <div class="line-separator right"></div>
                        <div class="head-content">
                            <div class="content-img">
                                <img src="<?= base_url("assets/img/folder.png"); ?>" alt="img" width="28" height="28">
                            </div>
                            <div class="content-name">
                                REFERAL<br>AKTIF
                            </div>
                            <div class="content-value">
                                1
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title">FEED DAN INFORMASI</h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="container-sosmed">
                    <div class="sosmed-facebook"><i class="fa-brands fa-facebook"></i> <span class="sosmed-text">FACEBOOK</span></div>
                    <div class="sosmed-whatsapp"><i class="fa-brands fa-whatsapp"></i> <span class="sosmed-text">WHATSAPP</span></div>
                    <div class="sosmed-instagram"><i class="fa-brands fa-instagram"></i> <span class="sosmed-text">INSTAGRAM</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const facebook = document.querySelector('.sosmed-facebook'),
        whatsapp = document.querySelector('.sosmed-whatsapp'),
        instagram = document.querySelector('.sosmed-instagram');

    facebook.addEventListener('click', () => {
        window.open("https://web.facebook.com/medc.id", '_blank').focus;
    })
    whatsapp.addEventListener('click', () => {
        window.open("https://wa.me/6285396380597", '_blank').focus;
    })
    instagram.addEventListener('click', () => {
        window.open("https://www.instagram.com/medc.id/", '_blank').focus;
    })
</script>
<?= $this->endSection(); ?>