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
                        <a href="<?= base_url('admin/input_quiz/' . $uri . '/?slug=' . $_GET['slug']); ?>" class="bank__soalBtn">Tambahkan Quiz</a>
                    </div>

                    <table class="table">
                        <tr>
                            <td>No</td>
                            <td>Nama Quiz</td>
                            <td>Jumlah Soal</td>
                            <td>Action</td>
                        </tr>
                        <?php $i = 1; ?>
                        <?php foreach ($bankQuiz as $bQ) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $bQ['quiz_name']; ?></td>
                                <td>20</td>
                                <td>Action</td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>