<?= $this->extend('layout/template-simulasi'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container__body simulasi__container">
                        <div class="box_item__container container_simulasi large-box">
                            <div class="box_item__body simulasi_body">
                                <div class="question-container">
                                    <div class="d-flex mb-3 align-items-center question_header">
                                        <div class="quest__number">SOAL NOMOR <span id="question__number"></span></div>
                                        <div class="quest__subject"><span id="question__subject"></span></div>
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
                                </div>
                            </div>
                            <div class="simulasi-footer-container text-center">
                                <button id="item_prev" class="item_prev"><i class="fa-solid fa-arrow-left"></i><span class="item_prev-text"> Sebelumnya</span></button>
                                <button id="item_next" class="item_next"><span class="item_next-text">Selanjutnya </span><i class="fa-solid fa-arrow-right"></i></button>
                                <button style="display: none;" data-bs-toggle="modal" data-bs-target="#modalDone" id="item_selesai" class="item_next"><span>Selesai </span></button>
                                <button style="display: none;" data-bs-toggle="modal" data-bs-target="#modalSessionNotif" id="item_session_notif" class="item_next"><span>Selesai </span></button>
                                <a href="<?= base_url("home/kerjakan_simulasi_geratis?id=" . $_GET['id'] . '&query=' . $_GET['query'] . '&utbk_session=' . $utbk_session + 1); ?>" style="display: none;" id="item_selesai_cekpoint" class="item_next"><span>Selesai</span></a>
                            </div>
                        </div>
                        <div class="box_item__container container_simulasi small-box">
                            <div id="question__number_side" class="sidebar-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('home/menu-utbk/simulasi-utbk/free-simulation/simulasi-popup'); ?>

<!-- <script src="<?= base_url('assets/js/prevent-access.js') ?>"></script> -->
<script src="<?= base_url('assets/js/simulasi-control.js') ?>"></script>
<script type="text/javascript">
    function preventBack() {
        window.history.forward();
    }
    setTimeout("preventBack()", 0);
    window.onunload = function() {
        null
    };
</script>
<script>
    let dataItems = <?= json_encode($bank_soal); ?>;
    let dataQuiz = <?= json_encode($quiz_data); ?>;
    let typeSoal = <?= json_encode($type_soal); ?>;
    let utbk_session = parseInt(<?= json_encode($utbk_session); ?>) + 1;
    let utbk_session_limit = <?= json_encode($utbk_session_limit); ?>;
    let navbarTitle = <?= json_encode($navbar_title); ?>;
    let sessionID = <?= json_encode($session_id); ?>;
    let id = <?= json_encode($_GET['id']); ?>;
    let query = <?= json_encode($_GET['query']); ?>;
    let urlRedirect = "<?= base_url('home/hasil_latihan'); ?>";
    let urlDone = "<?= base_url('home/save_simulasi_geratis') ?>";
    let current_page = 1;
    let rows = 1;
    let timerUtbk = <?= $timer ?>;

    var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
    var csrfHash = document.getElementById('txt_csrfname').value;

    var UserQuizStorage = localStorage.getItem(sessionID);
    UserQuizStorage = UserQuizStorage ? JSON.parse(UserQuizStorage) : {};

    if (UserQuizStorage["status_timer"] == "stop") {
        let timerStatus = "start";
        UserQuizStorage["status_timer"] = "start";
        localStorage.setItem(sessionID, JSON.stringify(UserQuizStorage));
    } else {
        let timerStatus = UserQuizStorage["status_timer"];
    }

    DisplayList(dataQuiz, rows, current_page, csrfName, csrfHash)
    NavBtnControl(current_page, dataQuiz)
    PaginationListNumber(dataQuiz, rows)
    ButtonPagination(dataQuiz, urlDone, urlRedirect);

    new Timer(
        document.querySelector(".timer__countdown"), timerUtbk
    );

    new Timer(
        document.querySelector(".timer__countdown-half"), timerUtbk
    );
</script>
<?= $this->endSection(); ?>