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
                            <div class="result-table list__result">
                                <table class="table">
                                    <thead>
                                        <tr class="headings">
                                            <td class="text-center heading">Nama</td>
                                            <td class="text-center heading">Kategori</td>
                                            <td class="text-center heading">Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data_user as $du) : ?>
                                            <tr class="result">
                                                <td><?= $du['quiz_name']; ?></td>
                                                <td><?= ucwords($du['category']); ?></td>
                                                <td>
                                                    <a class="table_button" href="<?= base_url('home/hasil_simulasi?query=') . $du['quiz_id']; ?>">Detail</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>