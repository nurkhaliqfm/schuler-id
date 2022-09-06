<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container_header_1 head_latihan">
                        <h3 class="box-title">PROGRAM BIMBEL OFFLINE SUPERCAMP UTBK 2023</h3>
                        <p class="box__subtitle">&nbsp;</p>
                        <div class="alert__box super_camp_utbk"><i class="fa-solid fa-circle-info"></i>
                            <span> Perhatian : </span>
                            <ul>
                                <li>Fasilitas program supercamp tidak termasuk pada paket premium</li>
                                <li>Setiap pertemuan dilakukan secara offline</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="white-box">
                    <div class="container_header_1 head_latihan">
                        <h3 class="box-title">FEED DAN INFORMASI</h3>
                        <p class="box__subtitle">&nbsp;</p>
                        <div class="box__image">
                            <div class="pamflet-content-img">
                                <img src="<?= base_url("assets/img/pamflet_1.jpg"); ?>" alt="img">
                            </div>
                            <div class="pamflet-content-img">
                                <img src="<?= base_url("assets/img/pamflet_2.jpg"); ?>" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="container-sosmed">
                    <div class="sosmed-whatsapp"><span>JOIN SUPERCAMP</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const whatsapp = document.querySelector('.sosmed-whatsapp');

    whatsapp.addEventListener('click', () => {
        window.open("https://wa.me/6285396380597", '_blank').focus;
    })
</script>

<?= $this->endSection(); ?>