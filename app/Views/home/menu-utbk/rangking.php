<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container_header_1 head_latihan">
                        <h3 class="box-title simulation">Daftar Rangking <span>Nasional UTBK</span></h3>
                        <div class="alert__box"><i class="fa-solid fa-circle-info"></i><span> Perhatian : </span>Data hasil latihan akan terhapus jika latihan dikerjakan kembali</div>
                        <div class="result-container">
                            <div class="result-table list__result">
                                <table class="table">
                                    <thead>
                                        <tr class="headings">
                                            <td class="text-center heading">Rank</td>
                                            <td class="text-center heading">Nama</td>
                                            <td class="text-center heading">Universitas Pilihan</td>
                                            <td class="text-center heading">Asal Sekolah</td>
                                            <td class="text-center heading">Skor</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($data_rangking as $dr) : ?>
                                            <tr class="result">
                                                <td><?= $i++; ?></td>
                                                <td><?= ucwords($dr['user_name']); ?></td>
                                                <td><?= ucwords($dr['universitas_pilihan']); ?></td>
                                                <td><?= ucwords($dr['asal_sekolah']); ?></td>
                                                <td><?= ucwords($dr['skor']); ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <?php if ($data_user != null) { ?>
                                            <tr class="result">
                                                <td><?= $user_rank; ?></td>
                                                <td><?= ucwords($data_user['user_name']); ?></td>
                                                <td><?= ucwords($data_user['universitas_pilihan']); ?></td>
                                                <td><?= ucwords($data_user['asal_sekolah']); ?></td>
                                                <td><?= ucwords($data_user['skor']); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tfoot>
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