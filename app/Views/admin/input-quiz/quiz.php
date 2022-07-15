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

    function CreateItemOption(categoryItems) {
        for (let i = 0; i < Object.keys(categoryItems).length; i++) {
            var container = document.getElementById("container_body");
            var boxItem = document.createElement("div");
            var boxHeader = document.createElement("div");
            var boxBody = document.createElement("div");
            var boxBodyTitle = document.createElement("div");
            var boxFooter = document.createElement("div");
            var boxFooterBtn = document.createElement("a");

            boxItem.className = "box_item__container"
            boxItem.setAttribute('data-box', categoryItems[i].group);
            boxHeader.className = "box_item__header"
            boxHeader.innerHTML = categoryItems[i].category_name.toUpperCase();
            boxBody.className = "box_item__body";
            boxBodyTitle.className = "box_body__title";
            boxBodyTitle.innerHTML = "Jumlah Soal = 12 Nomor";
            boxFooter.className = "box_item__footer quiz_footer";
            boxFooterBtn.className = "box_item__Btn list_quiz_button selected";
            boxFooterBtn.setAttribute('data-button', categoryItems[i].slug);
            boxFooterBtn.innerHTML = "Detail"

            boxBody.appendChild(boxBodyTitle);
            boxFooter.appendChild(boxFooterBtn);
            boxItem.appendChild(boxHeader);
            boxItem.appendChild(boxBody);
            boxItem.appendChild(boxFooter);
            container.appendChild(boxItem);
        }
    }

    function FilterCategoryOptions(categoryItems, items) {
        for (let i = 0; i < Object.keys(categoryItems).length; i++) {
            if (categoryItems[i].group == items.category_group) {
                document.querySelectorAll('.box_item__container[data-box="' + categoryItems[i].group + '"]').forEach(item => {
                    item.setAttribute('style', "");
                })
            } else {
                document.querySelectorAll('.box_item__container[data-box="' + categoryItems[i].group + '"]').forEach(item => {
                    item.setAttribute('style', "display:none");
                })
            }
        }
    }

    function DefaultTabButton(typeItems, categoryItems) {
        document.getElementById(typeItems[0].slug).classList.add('active');
        document.querySelectorAll('a.list_quiz_button').forEach(item => {
            item.setAttribute('href', "<?= base_url('admin/daftar_quiz/'); ?>" + "/" + typeItems[0].slug + "/?slug=" + item.getAttribute('data-button'))
        })

        FilterCategoryOptions(categoryItems, typeItems[0]);
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
                document.querySelectorAll('a.list_quiz_button').forEach(item => {
                    item.setAttribute('href', "<?= base_url('admin/daftar_quiz/'); ?>" + "/" + el.target.id + "/?slug=" + item.getAttribute('data-button'))
                })

                FilterCategoryOptions(categoryItems, item);
            })

        }
    }

    CreateItemOption(dataCategoryQuiz);
    DefaultTabButton(dataTypeQuiz, dataCategoryQuiz);
    TabButtonControl(dataTypeQuiz, dataCategoryQuiz);
</script>
<?= $this->endSection(); ?>