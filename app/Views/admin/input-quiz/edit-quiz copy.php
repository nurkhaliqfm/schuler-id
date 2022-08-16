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
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <form action="<?= base_url('admin/update_quiz/'); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <!-- Nama Quiz -->
                        <h3 class="custom-box-title">Nama Quiz</h3>
                        <div class="mb-3">
                            <input name="QuizName" type="text" class="form-control <?= ($validation->hasError('QuizName')) ? 'is-invalid' : ''; ?>" id="QuizName" value="<?= $quiz_name; ?>"></input>
                        </div>

                        <!-- Daftar Soal Quiz -->
                        <h3 class="custom-box-title">Daftar Soal Quiz</h3>
                        <?php $i = 0; ?>
                        <ul class="tabs">
                            <?php foreach ($soal_subject as $ss) : ?>
                                <li class="tab <?= $i == 0 ? "current" : ""; ?>" data-tab="<?= 'tab-' . $i; ?>"><?= strtoupper($ss['type_soal_name']); ?></li>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </ul>
                        <?php $j = 0; ?>
                        <?php foreach ($soal_subject as $ss) : ?>
                            <div id="<?= 'tab-' . $j; ?>" class="tab-content <?= $j == 0 ? "current" : ""; ?>">
                                <table class="table">
                                    <tr>
                                        <td class="text-center"></td>
                                        <td class="text-center">Soal</td>
                                        <td class="text-center">Jenis Soal</td>
                                    </tr>
                                    <?php foreach ($bank_soal as $bs) : ?>
                                        <?php if ($bs['type_soal'] == $ss['type_soal_id']) { ?>
                                            <tr>
                                                <td class="text-center">
                                                    <input class="custom-control-input" type="checkbox" value="<?= $bs['id_soal']; ?>" name="quiz_list_question[]">
                                                </td>
                                                <td class="text-center">
                                                    <a id="<?= $bs['id_soal']; ?>" class="preview_btn box_item__Btn list_quiz_button selected">Preview Soal</a>
                                                </td>
                                                <td class="text-center"><?= $ss[$bs['sub_type_soal']]; ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                    <?php $j++ ?>
                                </table>
                            </div>
                        <?php endforeach; ?>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
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

<script>
    $(document).ready(function() {
        $('ul.tabs li').click(function() {
            var tab_id = $(this).attr('data-tab');
            $('ul.tabs li').removeClass('current');
            $('.tab-content').removeClass('current');
            $(this).addClass('current');
            $("#" + tab_id).addClass('current');
        })
    })
</script>

<?= $this->endSection(); ?>