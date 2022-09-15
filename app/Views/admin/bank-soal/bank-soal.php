<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="container_header_1 daftar__soal">
                        <h3 class="box-title simulation">Daftar <span>Bank Soal</span></h3>
                        <p class="box__subtitle">Pilih kategori Soal</p>
                        <div id="tab_header_button" class="button__container">
                            <?php foreach ($type_soal as $type) : ?>
                                <div class="tab_button tab_button_style" id="<?= $type['slug']; ?>"><?= strtoupper(str_replace('_', ' ', $type['slug'])); ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="white-box">
                    <div class="container__body__box daftar__soal">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td style="border-bottom: 0px;" class="text-center">No</td>
                                    <td style="border-bottom: 0px;" class="text-center">Jenis Soal</td>
                                    <td style="border-bottom: 0px;" class="text-center">Jumlah Soal</td>
                                    <td style="border-bottom: 0px;" class="text-center">Action</td>
                                </tr>
                            </thead>
                            <tbody id="item-table"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const tabButton = document.querySelectorAll('div.tab_button_style');

    let dataType = <?= json_encode($type_soal); ?>;
    let dataCategory = <?= json_encode($data_category); ?>;

    function CreateItem(categoryItems, query) {
        var container = document.getElementById("item-table");
        container.innerHTML = '';
        for (let i = 0; i < categoryItems.length; i++) {
            var itemBox = document.createElement("tr");
            var itemNo = document.createElement("td");
            var itemJenis = document.createElement("td");
            var itemJumlah = document.createElement("td");
            var itemAction = document.createElement("td");
            var itemActionBtn = document.createElement("a");

            itemNo.className = "text-center"
            itemJenis.className = "text-center"
            itemJumlah.className = "text-center"
            itemAction.className = "text-center"
            itemBox.setAttribute('data-box', categoryItems[i]['slug'])

            itemNo.innerHTML = i + 1;
            itemJenis.innerHTML = categoryItems[i]['dataName']
            itemJumlah.innerHTML = categoryItems[i]['dataNumb']

            itemActionBtn.className = "box_item__Btn list_quiz_button selected";
            itemActionBtn.setAttribute('data-button', categoryItems[i]['dataId']);
            itemActionBtn.setAttribute('href', "<?= base_url('admin/daftar_soal/'); ?>" + "/" + query + "/" + categoryItems[i]['dataId'])
            itemActionBtn.innerHTML = "Detail"
            itemAction.appendChild(itemActionBtn);

            itemBox.appendChild(itemNo);
            itemBox.appendChild(itemJenis);
            itemBox.appendChild(itemJumlah);
            itemBox.appendChild(itemAction);

            container.appendChild(itemBox);
        }
    }

    function DefaultTabButton(typeItems, categoryItems) {
        document.getElementById(typeItems[0].slug).classList.add('active');

        let data = categoryItems.filter(categoryItems => {
            return categoryItems.slug == typeItems[0].slug
        })

        CreateItem(data, typeItems[0].id_main_type_soal);
    }

    function TabButtonControl(typeItems, categoryItems) {
        for (let i = 0; i < typeItems.length; i++) {
            let item = typeItems[i];
            let btnId = item.slug;
            document.getElementById(btnId).addEventListener("click", el => {
                tabButton.forEach(itemBtnTab => {
                    itemBtnTab.classList.remove("active");
                })

                document.getElementById(el.target.id).classList.add("active");

                let data = categoryItems.filter(categoryItems => {
                    return categoryItems.slug == item.slug
                })

                CreateItem(data, item['id_main_type_soal']);
            })

        }
    }

    DefaultTabButton(dataType, dataCategory);
    TabButtonControl(dataType, dataCategory);
</script>

<?= $this->endSection(); ?>