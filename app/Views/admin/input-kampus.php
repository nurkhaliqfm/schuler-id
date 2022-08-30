<?= $this->extend('layout/template'); ?>

<?php $uri = current_url(true)->getSegment(4); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <?php if (session()->getFlashdata('failed')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('failed'); ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <form action="<?= base_url('admin/save_kampus'); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <!-- Nama Quiz -->
                        <h3 class="box-title simulation">Nama Kampus</h3>
                        <div class="mb-3">
                            <input name="nama_kampus" type="text" class="form-control <?= ($validation->hasError('nama_kampus')) ? 'is-invalid' : ''; ?>" id="nama_kampus" value="<?= old('nama_kampus'); ?>"></input>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_kampus'); ?>
                            </div>
                        </div>

                        <button type="submit" class="box_item__Btn list_quiz_button selected">Simpan</button>
                    </form>
                </div>
            </div>

            <div class="col-md-12">
                <div class="white-box">
                    <div class="container__body__box daftar__soal">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td style="border-bottom: 0px;" class="text-center">No</td>
                                    <td style="border-bottom: 0px;" class="text-center">Nama Kampus</td>
                                    <td style="border-bottom: 0px;" class="text-center">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($daftar_Kampus as $dk) : ?>
                                    <tr>
                                        <td style="border-bottom: 0px;" class="text-center"><?= $i++; ?></td>
                                        <td style="border-bottom: 0px;" class="text-center"><?= $dk['nama_universitas']; ?></td>
                                        <td style="border-bottom: 0px;" class="text-center">
                                            <form action="<?= base_url("admin/deleted_kampus/" . $dk['id_universitas']); ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <button type="submit" type="submit" class="box_item__Btn list_quiz_button delete__btn"><i class="fa-solid fa-trash-alt"></i></button>
                                            </form>
                                        </td>
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

<?= $this->endSection(); ?>