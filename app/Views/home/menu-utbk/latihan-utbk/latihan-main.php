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
                                <div class="form-check" id="option_1"></div>
                                <div class="form-check" id="option_2"></div>
                                <div class="form-check" id="option_3"></div>
                                <div class="form-check" id="option_4"></div>
                                <div class="form-check" id="option_5"></div>
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
    function CreateOption(question_id, id, value, name, label_option) {
        var radiobox = document.createElement('input');
        radiobox.type = 'radio';
        radiobox.id = id;
        radiobox.value = value;
        radiobox.name = name;
        radiobox.className = 'form-check-input';

        var label = document.createElement('label')
        label.htmlFor = id;
        label.className = 'form-check-label';

        var descLabel = document.createTextNode(label_option + '. ');
        var descText = document.createElement('span');
        descText.id = value;

        label.appendChild(descLabel);
        label.appendChild(descText);

        var newline = document.createElement('br');

        var container = document.getElementById(question_id);
        container.appendChild(radiobox);
        container.appendChild(label);
        container.appendChild(newline);
    }

    const list_element = document.getElementById('question__part'),
        pagination_element = document.getElementById('pagination'),
        prev_button = document.getElementById('item_prev'),
        next_button = document.getElementById('item_next'),
        question_num_btn = document.getElementById('question__number_side');

    let dataItems = <?= json_encode($bank_soal); ?>;
    let dataQuiz = <?= json_encode($quiz_data); ?>;
    let typeSoal = <?= json_encode($type_soal); ?>;
    let navbarTitle = <?= json_encode($navbar_title); ?>;
    let current_page = 1;
    let rows = 1;

    function DisplayList(items, rows_per_page, page) {
        page--;
        let start = rows_per_page * page;
        let end = start + rows_per_page;
        let paginatedItems = items.slice(start, end);

        for (let i = 0; i < paginatedItems.length; i++) {
            let item = paginatedItems[i];
            var labelPage = page + 1;

            let dataSoal = dataItems.find(({
                id_soal
            }) => id_soal === item.quiz_question);

            let qSubject = typeSoal.find(({
                id_main_type_soal
            }) => id_main_type_soal === item.quiz_subject);

            let subjectListID = qSubject.list_type_soal_id.split(',');
            let subjectListName = qSubject.list_type_soal.split(',');
            let getId = subjectListID.findIndex(index => index === item.quiz_sub_subject);

            document.getElementById('optionA').setAttribute('name', 'Q_' + labelPage);
            document.getElementById('optionB').setAttribute('name', 'Q_' + labelPage);
            document.getElementById('optionC').setAttribute('name', 'Q_' + labelPage);
            document.getElementById('optionD').setAttribute('name', 'Q_' + labelPage);
            document.getElementById('optionE').setAttribute('name', 'Q_' + labelPage);

            document.getElementById('question__number').innerHTML = labelPage;
            document.getElementById('question__subject').innerHTML = subjectListName[getId];
            document.getElementById('question__part').innerHTML = dataSoal.soal;
            document.getElementById('simulation__title').innerHTML = navbarTitle;
            document.getElementById('simulation__subtitle').innerHTML = qSubject.main_type_soal;
            if (document.querySelector('p[data-f-id="pbf"]')) document.querySelector('p[data-f-id="pbf"]').setAttribute('style', 'display:none');

            document.getElementById('option_a').innerHTML = dataSoal.option_a;
            document.getElementById('option_b').innerHTML = dataSoal.option_b;
            document.getElementById('option_c').innerHTML = dataSoal.option_c;
            document.getElementById('option_d').innerHTML = dataSoal.option_d;
            document.getElementById('option_e').innerHTML = dataSoal.option_e;

            document.querySelectorAll('[name="Q_' + labelPage + '"]').forEach(itemOption => {
                itemOption.checked = false;
            })
        }
    }

    function PaginationListNumber(items, row_per_page) {
        let page_count = Math.ceil(items.length / row_per_page);
        for (let i = 1; i < page_count + 1; i++) {
            let btn = BtnNumberPagination(i, items);
            question_num_btn.appendChild(btn);
        }
    }

    function BtnNumberPagination(page, items) {
        let btn__side = document.createElement("div");
        btn__side.className = "question__number";
        btn__side.setAttribute('id-question', page);
        btn__side.innerHTML = page;

        if (current_page == page) {
            btn__side.classList.add('active');
        }

        return btn__side;
    }

    function ButtonPagination(items, wrapper) {
        next_button.addEventListener('click', () => {
            let pageLabel = current_page;
            var itemOption = document.querySelectorAll('[name="Q_' + pageLabel + '"]');
            var emptyOption = [].filter.call(itemOption, el => {
                return !el.checked;
            });

            if (itemOption.length != emptyOption.length) {
                current_page = current_page + 1;

                DisplayList(items, rows, current_page);
                NavBtnControl(current_page);

                let selectedQuestion = document.querySelector('.question__number[id-question="' + current_page + '"]');
                selectedQuestion.classList.add('active');
            }

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

        if (current_page == dataQuiz.length) {
            next_button.setAttribute('disabled', '')
        } else {
            next_button.removeAttribute('disabled', '')
        }

    }


    CreateOption('option_1', 'optionA', 'option_a', 'flexRadioDefault', 'A');
    CreateOption('option_2', 'optionB', 'option_b', 'flexRadioDefault', 'B');
    CreateOption('option_3', 'optionC', 'option_c', 'flexRadioDefault', 'C');
    CreateOption('option_4', 'optionD', 'option_d', 'flexRadioDefault', 'D');
    CreateOption('option_5', 'optionE', 'option_e', 'flexRadioDefault', 'E');

    DisplayList(dataQuiz, rows, current_page)
    NavBtnControl(current_page)
    PaginationListNumber(dataQuiz, rows)
    ButtonPagination(dataQuiz);
</script>
<?= $this->endSection(); ?>