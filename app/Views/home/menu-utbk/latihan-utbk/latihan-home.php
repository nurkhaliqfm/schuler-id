<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container_header_1 head_latihan">
                        <h3 class="box-title simulation">Latihan UTBK <span><?= strtoupper($quiz_group); ?></span></h3>
                        <p class="box__subtitle">Belajar menejeman waktu sesuai kategori yang diinginkan</p>
                        <div class="alert__box"><i class="fa-solid fa-circle-info"></i><span> Perhatian : </span>Gunakan browser google chrome versi terbaru agar website dapat diakses dengan lancar tanpa masalah</div>
                        <div class="button__container">
                            <?php foreach ($type_soal as $ts) : ?>
                                <div class="tab_button tab_button_style" id="<?= $ts['id']; ?>"><?= strtoupper($ts['name']); ?></div>
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

    let dataTypeSoal = <?= json_encode($type_soal); ?>;
    let dataCategorySoal = <?= json_encode($bank_quiz); ?>;
    let filterGroup = <?= json_encode($filter_category); ?>;

    function CreateItemOption(categoryItems, filter) {
        let filterArray = filter.split(',');
        for (let i = 0; i < Object.keys(categoryItems).length; i++) {
            if (filterArray.includes(categoryItems[i].quiz_subject)) {
                var container = document.getElementById("container_body");
                var boxItem = document.createElement("div");
                var boxHeader = document.createElement("div");
                var boxBody = document.createElement("div");
                var boxBodyTitle = document.createElement("div");
                var boxBodySubtitle = document.createElement("div");
                var boxFooter = document.createElement("div");
                var boxFooterBtn = document.createElement("a");

                boxItem.className = "box_item__container"
                boxItem.setAttribute('data-box', categoryItems[i].quiz_subject);
                boxHeader.className = "box_item__header"
                boxHeader.innerHTML = categoryItems[i].quiz_name.toUpperCase();
                boxBody.className = "box_item__body";
                boxBodyTitle.className = "box_body__title";
                boxBodyTitle.innerHTML = "Jumlah Soal = 12 Nomor";
                boxBodySubtitle.className = "box_body__subtitle";
                boxBodySubtitle.innerHTML = "Waktu: 15 Menit";
                boxFooter.className = "box_item__footer quiz_footer";
                boxFooterBtn.className = "box_item__Btn list_quiz_button selected";
                boxFooterBtn.setAttribute('data-button', categoryItems[i].quiz_id);
                boxFooterBtn.innerHTML = "Kerjakan"

                boxBody.appendChild(boxBodyTitle);
                boxBody.appendChild(boxBodySubtitle);
                boxFooter.appendChild(boxFooterBtn);
                boxItem.appendChild(boxHeader);
                boxItem.appendChild(boxBody);
                boxItem.appendChild(boxFooter);
                container.appendChild(boxItem);
            }
        }
    }

    function FilterCategoryOptions(categoryItems, items) {
        for (let i = 0; i < Object.keys(categoryItems).length; i++) {
            if (categoryItems[i].quiz_subject == items.id) {
                document.querySelectorAll('.box_item__container[data-box="' + categoryItems[i].quiz_subject + '"]').forEach(item => {
                    item.setAttribute('style', "");
                })
            } else {
                document.querySelectorAll('.box_item__container[data-box="' + categoryItems[i].quiz_subject + '"]').forEach(item => {
                    item.setAttribute('style', "display:none");
                })
            }
        }
    }

    function DefaultTabButton(typeItems, categoryItems) {
        document.getElementById(typeItems[0].id).classList.add('active');
        document.querySelectorAll('a.list_quiz_button').forEach(item => {
            item.setAttribute('href', "<?= base_url('home/latihan_guide/'); ?>" + "/?id=" + typeItems[0].id + "&query=" + item.getAttribute('data-button'))
        })

        FilterCategoryOptions(categoryItems, typeItems[0]);
    }

    function TabButtonControl(typeItems, categoryItems) {
        for (let i = 0; i < Object.keys(typeItems).length; i++) {
            let item = typeItems[i];
            let btnId = item.id;
            document.getElementById(btnId).addEventListener("click", el => {
                tabButton.forEach(itemBtnTab => {
                    itemBtnTab.classList.remove("active");
                })

                document.getElementById(el.target.id).classList.add("active");
                document.querySelectorAll('a.list_quiz_button').forEach(item => {
                    item.setAttribute('href', "<?= base_url('home/latihan_guide/'); ?>" + "/?id=" + el.target.id + "&query=" + item.getAttribute('data-button'))
                })

                FilterCategoryOptions(categoryItems, item);
            })

        }
    }

    CreateItemOption(dataCategorySoal, filterGroup);
    DefaultTabButton(dataTypeSoal, dataCategorySoal);
    TabButtonControl(dataTypeSoal, dataCategorySoal);
</script>

<?= $this->endSection(); ?>