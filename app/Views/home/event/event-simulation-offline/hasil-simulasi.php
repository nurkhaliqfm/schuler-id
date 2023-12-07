<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box result_white-box">
                    <div class="box_item__header result_container__header">
                        <div class="header__title-box">
                            <div class="box_header__title">Hasil Simulasi</div>
                            <div class="box_header__subtitle" id="result_subtitle"></div>
                            <div class="header__button-box container_header_1">
                                <div class="button__container">
                                    <a href="<?= base_url('/PdfController/cetak_pembahasan?query=' . $_GET['query']) ?>" class="hasil_btn tab_button_style statistik "><i class="fa-solid fa-download"></i> <span>Download</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="header__button-box container_header_1">
                            <div class="button__container">
                                <div data-button="pembahasan" id="pembahasanBtn" class="hasil_btn tab_button_style pembahasan  active"><i class="fa-solid fa-file-lines"></i> <span class="pembahasan-tab">PEMBAHASAN</span></div>
                                <div data-button="statistik" id="statistikBtn" class="hasil_btn tab_button_style statistik "><i class="fa-solid fa-chart-simple"></i> <span class="statistik-tab">STATISTIK</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="header__button-box container_header_1 simulation-result__tab">
                        <div class="button__container">
                            <?php empty($_GET['id']) ? $uri = '' : $uri = $_GET['id']; ?>
                            <?php empty($_GET['slug']) ? $slug = '' : $slug = $_GET['slug']; ?>
                            <?php $i = 0; ?>
                            <?php foreach ($type_soal_tab as $rts) : ?>
                                <?php if ($i == 0) {; ?>
                                    <a href="" data-id="<?= $rts['id']; ?>" data-status="" class="tab_button tab_button_style <?= $uri == '' || $uri == $rts['id'] ? 'active' : ''; ?>"><?= strtoupper($rts['name']); ?></a>
                                <?php } else {; ?>
                                    <a href="" data-id="<?= $rts['id']; ?>" data-status="" class="tab_button tab_button_style <?= $uri == $rts['id'] ? 'active' : ''; ?>"><?= strtoupper($rts['name']); ?></a>
                                <?php }; ?>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div id="pembahasan-section" class="container__body result__container">
                        <div class="box_item__container container_result large-box">
                            <div class="box_item__body result_body">
                                <div id="question-container" class="question-container">
                                    <div class="d-flex mb-3 align-items-center question_header">
                                        <div class="quest__number">SOAL NOMOR <span id="question__number"></span></div>
                                        <div class="quest__subject"><span id="question__subject"></span></div>
                                        <div id="box_desc" class="box_desc box_desc-box  active"><span class="box_desc-text" id="box_desc-text">Benar</span></div>

                                        <div class="ms-auto quest__report alert__box custom-alert"><i class="fa-solid fa-circle-info"></i><span class="alert-text_danger"> Laporkan Soal</span></div>
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
                                <button id="item_prev" class="item_prev"><i class="fa-solid fa-arrow-left"></i><span class="item_prev-text"> Sebelumnya</span></button>
                                <button id="item_next" class="item_next"><span class="item_next-text">Selanjutnya </span><i class="fa-solid fa-arrow-right"></i></button>
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
                    <div id="statistik-section" style="display: none;" class="container__body statistik__container">
                        <div class="box_item__container container_statistik small-box">
                            <div class="box_item__header">SKOR SIMULASI UTBK</div>
                            <div class="box_item__body statistik-skor">
                                <div id="result_simulasi" class="box_body__title"></div>
                            </div>
                            <div class=" box_item__footer quiz_footer"></div>
                        </div>
                        <div class="box_item__container container_statistik small-box">
                            <div class="box_item__header" id="result_category__title"></div>
                            <div id="result_base_category" class="box_item__body statistik-skor result_base_category">

                            </div>
                            <div class=" box_item__footer quiz_footer"></div>
                        </div>
                        <div class="box_item__container container_statistik small-box">
                            <div class="box_item__header" id="grafik_category__title"></div>
                            <div class="box_item__body statistik-skor">
                                <div class="pie-charts">
                                    <div class="pieID--micro-skills pie-chart-wrapper">
                                        <div class="pie-chart">
                                            <div class="pie-chart__pie"></div>
                                            <ul class="pie-chart__legend"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" box_item__footer quiz_footer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/simulasi-event-result.js?v=') . time() ?>"></script>
<script>
    let dataItems = <?= json_encode($bank_soal); ?>;
    let dataQuiz = <?= json_encode($quiz_data); ?>;
    let dataQuizRemake = <?= json_encode($bank_soal_remake); ?>;
    let typeSoal = <?= json_encode($type_soal); ?>;
    let typeSoalTab = <?= json_encode($type_soal_tab); ?>;
    let navbarTitle = <?= json_encode($navbar_title); ?>;
    let userAnsware = <?= json_encode($user_answare); ?>;
    let urltab = "<?= base_url('home/hasil_event?query=' . $_GET['query']); ?>"
    let current_page = 1;
    let rows = 1;
    let tab_section;

    if (<?= json_encode($uri); ?> == "") {
        tab_section = typeSoalTab[0]
    } else {
        tab_section = typeSoalTab.find(
            ({
                id
            }) => id === <?= json_encode($uri); ?>
        );
    }

    DisplayList(dataQuizRemake, rows, current_page, userAnsware);
    NavBtnControl(current_page, dataQuizRemake);
    PaginationListNumber(dataQuizRemake, rows, userAnsware, tab_section);
    ButtonPagination(dataQuizRemake);

    const pembahasan_btn = document.getElementById('pembahasanBtn'),
        statistik_btn = document.getElementById('statistikBtn');


    if ("<?= $slug; ?>" == "" || "<?= $slug ?>" == "pembahasan") {
        document.getElementById('statistik-section').setAttribute('style', 'display: none;')
        document.getElementById('pembahasan-section').setAttribute('style', '')
        statistik_btn.classList.remove('active')
        pembahasan_btn.classList.add('active')

        document.querySelectorAll(".tab_button.tab_button_style").forEach(element => {
            let defaultURL = urltab + '&id=' + element.getAttribute('data-id');
            element.setAttribute('href', defaultURL);
        });
    } else {
        document.getElementById('pembahasan-section').setAttribute('style', 'display: none;')
        document.getElementById('statistik-section').setAttribute('style', '')
        statistik_btn.classList.add('active')
        pembahasan_btn.classList.remove('active')

        document.querySelectorAll(".tab_button.tab_button_style").forEach(element => {
            let defaultURL = urltab + '&id=' + element.getAttribute('data-id') + '&slug=' + "<?= $slug; ?>";
            element.setAttribute('href', defaultURL)
        });
    }

    statistik_btn.addEventListener('click', () => {
        document.getElementById('pembahasan-section').setAttribute('style', 'display: none;')
        document.getElementById('statistik-section').setAttribute('style', '')
        statistik_btn.classList.add('active')
        pembahasan_btn.classList.remove('active')

        let getslug = statistik_btn.getAttribute('data-button');
        document.querySelectorAll(".tab_button.tab_button_style").forEach(element => {
            let fixURL = urltab + '&id=' + element.getAttribute('data-id') + '&slug=' + getslug
            element.setAttribute('href', fixURL)
        });
    })

    pembahasan_btn.addEventListener('click', () => {
        document.getElementById('statistik-section').setAttribute('style', 'display: none;')
        document.getElementById('pembahasan-section').setAttribute('style', '')
        statistik_btn.classList.remove('active')
        pembahasan_btn.classList.add('active')

        let getslug = pembahasan_btn.getAttribute('data-button');
        document.querySelectorAll(".tab_button.tab_button_style").forEach(element => {
            let fixURL = urltab + '&id=' + element.getAttribute('data-id') + '&slug=' + getslug
            element.setAttribute('href', fixURL)
        });
    })
</script>
<script src="<?= base_url('assets/js/chart.js') ?>"></script>
<?= $this->endSection(); ?>