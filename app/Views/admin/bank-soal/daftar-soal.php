<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container__title__box daftar__soal">
                        <h3 class="box-title">Daftar Soal</h3>
                        <a href="<?= base_url('admin/input_soal/' . $menu_soal . '/' . $submenu_soal); ?>" class="bank__soalBtn">Tambahkan Soal</a>
                    </div>
                    <div class="container__body__box daftar__soal">
                        <table class="table">
                            <tr>
                                <td class="text-center">No</td>
                                <td class="text-center">Id Soal</td>
                                <td class="text-center">Date Created</td>
                                <td class="text-center">Date Updated</td>
                                <td class="text-center">Action</td>
                            </tr>
                            <?php $i = 1; ?>
                            <?php foreach ($bank_soal as $bs) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $bs['id_soal']; ?></td>
                                    <td><?= $bs['created_at']; ?></td>
                                    <td><?= $bs['updated_at']; ?></td>
                                    <td>
                                        <button type="submit" class="bank__soalBtn delete__btn"><i class="fa-solid fa-trash-alt"></i></button>
                                        <a href="<?= base_url('admin/edit_soal/' . $bs['id_soal']); ?>" class="bank__soalBtn"><i class="fa-solid fa-pen-alt"></i></a>
                                        <a href="<?= base_url('admin/duplicat_soal/' . $bs['id_soal']); ?>" class="bank__soalBtn warning__btn"><i class="fa-solid fa-copy"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>