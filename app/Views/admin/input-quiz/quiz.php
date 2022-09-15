<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container_header_1 daftar__soal">
                        <h3 class="box-title simulation">Daftar Jenis <span>Quiz UTBK</span></h3>
                        <p class="box__subtitle">Pilih jenis quiz UTBK yang diinginkan</p>
                        <div id="tab_header_button" class="button__container">
                            <?php foreach ($quiz_type as $type) : ?>
                                <div class="tab_button tab_button_style" id="<?= $type['slug']; ?>"><?= strtoupper($type['quiz_name']); ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="white-box">
                    <div id="container_body" class="container__body simulation__free">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const tabButton = document.querySelectorAll('div.tab_button_style');

    let dataTypeQuiz = <?= json_encode($quiz_type); ?>;
    let dataCategoryQuiz = <?= json_encode($category_quiz); ?>;
    let dataBankQuiz = <?= json_encode($bank_quiz); ?>;

    function CreateItemOption(categoryItems, items, quiz) {
        var container = document.getElementById("container_body");
        container.innerHTML = '';
        for (let i = 0; i < Object.keys(categoryItems).length; i++) {
            let data_q = quiz.filter(quiz => {
                return quiz.quiz_type == categoryItems[i].slug
            });

            var boxItem = document.createElement("div");
            var boxHeader = document.createElement("div");
            var boxBody = document.createElement("div");
            var boxBodyTitle = document.createElement("div");
            var boxBodyDesc = document.createElement("div");
            var boxFooter = document.createElement("div");
            var boxFooterBtn = document.createElement("a");

            boxItem.className = "box_item__container"
            boxItem.setAttribute('data-box', categoryItems[i].group);
            boxHeader.className = "box_item__header"
            boxHeader.innerHTML = categoryItems[i].category_name.toUpperCase();
            boxBody.className = "box_item__body";
            boxBodyTitle.className = "box_body__number";
            boxBodyTitle.innerHTML = data_q.length;
            boxBodyDesc.className = "box_body__number_desc";
            boxBodyDesc.innerHTML = "Quiz";
            boxFooter.className = "box_item__footer quiz_footer";
            boxFooterBtn.className = "box_item__Btn list_quiz_button selected";
            boxFooterBtn.setAttribute('href', "<?= base_url("admin/daftar_quiz/"); ?>" + "/" + items.slug + "?slug=" + categoryItems[i].slug)
            boxFooterBtn.innerHTML = "Detail"

            boxBody.appendChild(boxBodyTitle);
            boxBody.appendChild(boxBodyDesc);
            boxFooter.appendChild(boxFooterBtn);
            boxItem.appendChild(boxHeader);
            boxItem.appendChild(boxBody);
            boxItem.appendChild(boxFooter);
            container.appendChild(boxItem);
        }
    }

    function DefaultTabButton(typeItems, categoryItems) {
        document.getElementById(typeItems[0].slug).classList.add('active');

        let data = categoryItems.filter(categoryItems => {
            return categoryItems.group == typeItems[0].category_group
        });

        let data_q = dataBankQuiz.filter(dataBankQuiz => {
            return dataBankQuiz.quiz_category == typeItems[0].slug
        });

        CreateItemOption(data, typeItems[0], data_q);
    }

    function TabButtonControl(typeItems, categoryItems) {
        for (let i = 0; i < Object.keys(typeItems).length; i++) {
            let item = typeItems[i];
            let btnId = item.slug;
            document.getElementById(btnId).addEventListener("click", el => {
                tabButton.forEach(itemBtnTab => {
                    itemBtnTab.classList.remove("active");
                })

                document.getElementById(el.target.id).classList.add("active");

                let data = categoryItems.filter(categoryItems => {
                    return categoryItems.group == item.category_group
                });

                let data_q = dataBankQuiz.filter(dataBankQuiz => {
                    return dataBankQuiz.quiz_category == item.slug
                });

                CreateItemOption(data, item, data_q);
            })

        }
    }

    DefaultTabButton(dataTypeQuiz, dataCategoryQuiz);
    TabButtonControl(dataTypeQuiz, dataCategoryQuiz);
</script>
<?= $this->endSection(); ?>