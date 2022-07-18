<?= $this->extend('layout/template-simulasi'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box fr-view">
                    <div class="question-container">
                        <div class="d-flex mb-3 align-items-center question_header">
                            <div class="quest__number">SOAL NOMOR <span id="question__number"></span></div>
                            <div class="quest__subject"><span id="question__subject"></span></div>
                            <div class="ms-auto quest__report alert__box"><i class="fa-solid fa-circle-info"></i><span> Laporkan Soal</span></div>
                        </div>
                        <div class="question_main">
                            <div id="question__part" class="question__part"></div>
                            <div class="question__answer__part">
                                <div class="form-check" id="option_1" option-name='A'></div>
                                <div class="form-check" id="option_2" option-name='B'></div>
                                <div class="form-check" id="option_3" option-name='C'></div>
                                <div class="form-check" id="option_4" option-name='D'></div>
                                <div class="form-check" id="option_5" option-name='E'></div>
                            </div>
                        </div>
                    </div>
                    <div class="simulasi-footer-container text-center">
                        <button id="item_prev" class="item_prev"><i class="fa-solid fa-arrow-left"></i><span> Sebelumnya</span></button>
                        <button id="item_next" class="item_next"><span>Selanjutnya </span><i class="fa-solid fa-arrow-right"></i></button>
                        <button style="display: none;" id="item_selesai" class="item_next"><span>Selesai </span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/prevent-access.js') ?>"></script>
<script src="<?= base_url('assets/js/simulasi-control.js') ?>"></script>
<script>
    let dataItems = <?= json_encode($bank_soal); ?>;
    let dataQuiz = <?= json_encode($quiz_data); ?>;
    let typeSoal = <?= json_encode($type_soal); ?>;
    let navbarTitle = <?= json_encode($navbar_title); ?>;
    let sessionID = <?= json_encode($session_id); ?>;
    let query = <?= json_encode($_GET['query']); ?>;
    let current_page = 1;
    let rows = 1;

    DisplayList(dataQuiz, rows, current_page)
    NavBtnControl(current_page)
    PaginationListNumber(dataQuiz, rows)
    ButtonPagination(dataQuiz, query);

    new Timer(
        document.querySelector(".timer__countdown"), <?= $timer ?>
    );
</script>
<?= $this->endSection(); ?>