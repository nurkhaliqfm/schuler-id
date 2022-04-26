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
                            <div class="quest__subject">SKOLASTIK</div>
                            <div class="ms-auto quest__report alert__box"><i class="fa-solid fa-circle-info"></i><span> Laporkan Soal</span></div>
                        </div>
                        <div class="question_main">
                            <div id="question__part" class="question__part"></div>
                            <div class="question__answer__part">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="optionA">
                                    <label class="form-check-label" for="optionA">
                                        A. <span id="option_a"></span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="optionB">
                                    <label class="form-check-label" for="optionB">
                                        B. <span id="option_b"></span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="optionC">
                                    <label class="form-check-label" for="optionC">
                                        C. <span id="option_c"></span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="optionD">
                                    <label class="form-check-label" for="optionD">
                                        D. <span id="option_d"></span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="optionE">
                                    <label class="form-check-label" for="optionE">
                                        E. <span id="option_e"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simulasi-footer-container text-center">
                        <button id="item_prev" class="item_prev"><i class="fa-solid fa-arrow-left"></i><span> Sebelumnya</span></button>
                        <button id="item_next" class="item_next"><span>Selanjutnya </span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const list_element = document.getElementById('question__part'),
        pagination_element = document.getElementById('pagination'),
        prev_button = document.getElementById('item_prev'),
        next_button = document.getElementById('item_next');

    let dataItems = <?= json_encode($bank_soal); ?>;
    let current_page = 1;
    let rows = 1;

    function DisplayList(items, rows_per_page, page) {
        page--;
        let start = rows_per_page * page;
        let end = start + rows_per_page;
        let paginatedItems = items.slice(start, end);

        for (let i = 0; i < paginatedItems.length; i++) {
            let item = paginatedItems[i];
            document.getElementById('question__number').innerHTML = page + 1;
            document.getElementById('question__part').innerHTML = item.soal;
            document.getElementById('option_a').innerHTML = item.option_a;
            document.getElementById('option_b').innerHTML = item.option_b;
            document.getElementById('option_c').innerHTML = item.option_c;
            document.getElementById('option_d').innerHTML = item.option_d;
            document.getElementById('option_e').innerHTML = item.option_e;
        }
    }

    // function paginationList(items, row_per_page){
    //     let page
    // }

    function buttonPagination(page, items) {
        next_button.addEventListener('click', () => {
            current_page = current_page + 1;
            DisplayList(items, rows, current_page)
            NavBtnControl(current_page);
        })

        prev_button.addEventListener('click', () => {
            current_page = current_page - 1;
            DisplayList(items, rows, current_page)
            NavBtnControl(current_page);
        })
    }

    function NavBtnControl(current_page) {
        if (current_page == 1) {
            prev_button.setAttribute('disabled', '')
        } else {
            prev_button.removeAttribute('disabled', '')
        }

        if (current_page == dataItems.length) {
            next_button.setAttribute('disabled', '')
        } else {
            next_button.removeAttribute('disabled', '')
        }

    }

    DisplayList(dataItems, rows, current_page)
    NavBtnControl(current_page)
    buttonPagination(current_page, dataItems)
</script>
<?= $this->endSection(); ?>