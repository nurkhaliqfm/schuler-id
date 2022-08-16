<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
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
                <div class="white-box">
                    <div class="container__title__box daftar__soal">
                        <h3 class="box-title">Daftar Soal</h3>
                        <a href="<?= base_url('admin/input_soal/' . $menu_soal . '/' . $submenu_soal); ?>" class="box_item__Btn list_quiz_button selected"">Tambahkan Soal</a>
                    </div>
                    <div class=" container__body__box daftar__soal">
                            <table class="table">
                                <tr>
                                    <td class="text-center">No</td>
                                    <td class="text-center">Soal</td>
                                    <td class="text-center">Pembuatan</td>
                                    <td class="text-center">Update</td>
                                    <td class="text-center">Action</td>
                                </tr>
                                <?php $i = 1; ?>
                                <?php foreach ($bank_soal as $bs) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i++; ?></td>
                                        <td class="text-center">
                                            <a id="<?= $bs['id_soal']; ?>" class="preview_btn box_item__Btn list_quiz_button selected">Preview Soal</a>
                                        </td>
                                        <td class="text-center"><?= $bs['created_at']; ?></td>
                                        <td class="text-center"><?= $bs['updated_at']; ?></td>
                                        <td class="text-center">
                                            <form action="<?= base_url("admin/deleted_soal/" . $bs['id_soal']); ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <button type="submit" type="submit" class="box_item__Btn list_quiz_button delete__btn"><i class="fa-solid fa-trash-alt"></i></button>
                                                <a href="<?= base_url('admin/edit_soal/' . $bs['id_soal']); ?>" class="box_item__Btn list_quiz_button edit__btn"><i class="fa-solid fa-pen-alt"></i></a>
                                                <a href="<?= base_url('admin/duplicat_soal/' . $bs['id_soal']); ?>" class="box_item__Btn list_quiz_button selected"><i class="fa-solid fa-copy"></i></a>
                                            </form>
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

<div class="modal fade" data-bs-keyboard="false" id="modalPreview" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <div id="soal_preview"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const previewBtn = document.querySelectorAll('a.preview_btn');
    let dataSoal = <?= json_encode($bank_soal); ?>;

    previewBtn.forEach(element => {
        element.addEventListener('click', el => {
            $('#modalPreview').modal('show');
            let selectedData = dataSoal.filter(filter => {
                return filter.id_soal == el.target.id
            })
            document.getElementById('soal_preview').innerHTML = selectedData[0].soal
        })
    })
</script>

<?= $this->endSection(); ?>