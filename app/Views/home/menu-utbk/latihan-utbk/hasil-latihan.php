<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container__body result__container">
                        <div class="box_item__container container_result large-box">
                            <div class="box_item__header box_header__container">
                                <div class="header__title-box">
                                    <div class="box_header__title">Hasil Latihan</div>
                                    <div class="box_header__subtitle" id="result_subtitle"></div>
                                </div>
                                <div class="header__button-box container_header_1">
                                    <div class="button__container">
                                        <div class="hasil_btn tab_button_style active">PEMBAHASAN</div>
                                        <div class="hasil_btn tab_button_style">STATISTIK</div>
                                    </div>
                                </div>
                            </div>
                            <div class="box_item__body result_body">
                                <div class="question-container">
                                    <div class="d-flex mb-3 align-items-center question_header">
                                        <div class="quest__number">SOAL NOMOR <span id="question__number"></span></div>
                                        <div class="quest__subject"><span id="question__subject"></span></div>
                                        <div id="box_desc" class="box_desc active">Benar</div>

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
                                    <div class="answare_main">
                                        <div class="answare-text">Jawaban Anda : <span id="your_answare"></span></div>
                                        <div class="answare-text">Kunci Jawaban : <span id="real_answare"></span></div>
                                    </div>
                                    <div class="explanation_main question__part">
                                        <div class="explanation-title">PEMBAHASAN</div>
                                        <div class="answare-text" id="explain__part"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="box_item__footer simulasi-footer-container text-center">
                                <button id="item_prev" class="item_prev"><i class="fa-solid fa-arrow-left"></i><span> Sebelumnya</span></button>
                                <button id="item_next" class="item_next"><span>Selanjutnya </span><i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                        <div class="box_item__container container_result small-box">
                            <div class="box_item__header box_header__container">
                                <div class="header__title-box">Nomor Soal</div>
                            </div>
                            <div class="box_item__body sidebar_body_container">
                                <div class="d-flex mb-3 align-items-center">
                                    <div class="box_desc active"></div>
                                    <div class="box_text">Benar</div>
                                </div>
                                <div class="d-flex mb-3 align-items-center">
                                    <div class="box_desc warning"></div>
                                    <div class="box_text">Salah</div>
                                </div>
                                <div class="d-flex mb-3 align-items-center">
                                    <div class="box_desc normal"></div>
                                    <div class="box_text">Kosong</div>
                                </div>
                            </div>
                            <div class="box_item__footer sidebar_number">
                                <div id="question__number_side" class="sidebar-body"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/latihan-result.js') ?>"></script>
<script>
    let dataItems = <?= json_encode($bank_soal); ?>;
    let dataQuiz = <?= json_encode($quiz_data); ?>;
    let typeSoal = <?= json_encode($type_soal); ?>;
    let navbarTitle = <?= json_encode($navbar_title); ?>;
    let userAnsware = <?= json_encode($user_answare); ?>;
    let current_page = 1;
    let rows = 1;

    DisplayList(dataQuiz, rows, current_page, userAnsware)
    NavBtnControl(current_page)
    PaginationListNumber(dataQuiz, rows, userAnsware)
    ButtonPagination(dataQuiz);
</script>
<?= $this->endSection(); ?>