<?= $this->extend('layout/template'); ?>

<?php $uri = current_url(true)->getSegment(4); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container__title__box daftar__soal">
                        <h3 class="box-title">Daftar Quiz</h3>
                        <a href="<?= base_url('admin/input_quiz/' . $uri . '?slug=' . $_GET['slug']); ?>" class="box_item__Btn list_quiz_button selected">Tambahkan Quiz</a>
                    </div>

                    <table class="table">
                        <tr>
                            <td class="text-center">No</td>
                            <td class="text-center">Nama Quiz</td>
                            <td class="text-center">Jumlah Soal</td>
                            <td class="text-center">Action</td>
                        </tr>
                        <?php $i = 1; ?>
                        <?php foreach ($bankQuiz as $bQ) : ?>
                            <?php if ($uri == $bQ['quiz_category']) { ?>
                                <?php $index = $i - 1; ?>
                                <tr>
                                    <td class="text-center"><?= $i++; ?></td>
                                    <td class="text-center"><?= $bQ['quiz_name']; ?></td>
                                    <td class="text-center"><?= $quiz_number[$index]; ?></td>
                                    <td class="text-center">
                                        <form action="<?= base_url("admin/deleted_quiz/" . $bQ['quiz_id'] . '?slug=' . $_GET['slug'] . '&u=' . $uri); ?>" method="post" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <button type="submit" type="submit" class="box_item__Btn list_quiz_button delete__btn"><i class="fa-solid fa-trash-alt"></i></button>
                                            <a href="<?= base_url('admin/detail_quiz/' . $bQ['quiz_id'] . '?slug=' . $_GET['slug'] . '&u=' . $uri); ?>" class="box_item__Btn list_quiz_button edit__btn"><i class="fa-solid fa-pen-alt"></i></a>
                                        </form>
                                    </td>
                                </tr>
                            <?php }; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>