<?= $this->extend('layout/template'); ?>

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
                    <form action="<?= base_url('admin/save_quiz'); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <!-- Nama Quiz -->
                        <h3 class="custom-box-title">Nama Quiz</h3>
                        <div class="mb-3">
                            <input name="QuizName" type="text" class="form-control <?= ($validation->hasError('QuizName')) ? 'is-invalid' : ''; ?>" id="QuizName"><?= old('QuizName'); ?></input>
                            <div class="invalid-feedback">
                                <?= $validation->getError('QuizName'); ?>
                            </div>
                        </div>

                        <!-- Daftar Soal Quiz -->
                        <h3 class="custom-box-title">Daftar Soal Quiz</h3>
                        <?php $i = 0; ?>
                        <ul class="tabs">
                            <?php foreach ($soal_subject as $ss) : ?>
                                <li class="tab <?= $i == 0 ? "current" : ""; ?>" data-tab="<?= 'tab-' . $i; ?>"><?= $ss['type_soal_name']; ?></li>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </ul>
                        <?php $j = 0; ?>
                        <?php foreach ($soal_subject as $ss) : ?>
                            <div id="<?= 'tab-' . $j; ?>" class="tab-content <?= $j == 0 ? "current" : ""; ?>">
                                <table>
                                    <tr>
                                        <td></td>
                                        <td>Id Soal</td>
                                        <td>Jenis Soal</td>
                                    </tr>
                                    <?php foreach ($bank_soal as $bs) : ?>
                                        <?php if ($bs['type_soal'] == $ss['type_soal_id']) { ?>
                                            <tr>
                                                <td>
                                                    <input class="custom-control-input" type="checkbox" value="<?= $bs['id_soal']; ?>" name="quiz_list_question[]">
                                                    <input type="hidden" name="quiz_subject" value="<?= $bs['type_soal']; ?>">
                                                    <input type="hidden" name="quiz_sub_subject" value="<?= $bs['sub_type_soal']; ?>">
                                                </td>
                                                <td><?= $bs['id_soal']; ?></td>
                                                <td><?= $ss[$bs['sub_type_soal']]; ?></td>
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