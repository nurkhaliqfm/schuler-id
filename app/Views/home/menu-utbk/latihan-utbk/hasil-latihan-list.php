<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container_header_1 head_latihan">
                        <h3 class="box-title simulation">Daftar Hasil <span>Latihan UTBK</span></h3>
                        <div class="alert__box"><i class="fa-solid fa-circle-info"></i><span> Perhatian : </span>Data hasil latihan akan terhapus jika latihan dikerjakan kembali</div>
                        <div class="result-container">
                            <div class="result-table">
                                <div class="headings">
                                    <span class="heading">Nama</span>
                                    <span class="heading">Jenis Latihan</span>
                                    <span class="heading">Kategori</span>
                                    <span class="heading">Actions</span>
                                </div>
                                <?php foreach ($data_user as $du) : ?>
                                    <div class="result">
                                        <span><?= $du['quiz_name']; ?></span>
                                        <span><?= ucwords($du['type']); ?></span>
                                        <span><?= $du['category']; ?></span>
                                        <span>
                                            <a class="table_button" href="<?= base_url('home/hasil_latihan/?query=') . $du['quiz_id']; ?>">Detail</a>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>