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
                            <?php foreach ($category as $item) : ?>
                                <div class="tab_button tab_button_style" id="<?= $item['id']; ?>"><?= strtoupper(str_replace('_', ' ', $item['name'])); ?></div>
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

    let category = <?= json_encode($category); ?>;
    let subCategory = <?= json_encode($sub_category); ?>;

    function CreateItem(subCategoryItem, query) {
        var container = document.getElementById("item-table");
        container.innerHTML = '';
        for (let i = 0; i < subCategoryItem.length; i++) {
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
            itemBox.setAttribute('data-box', subCategoryItem[i]['kode'])

            itemNo.innerHTML = i + 1;
            itemJenis.innerHTML = subCategoryItem[i]['name']
            itemJumlah.innerHTML = subCategoryItem[i]['jumlah']

            itemActionBtn.className = "box_item__Btn list_quiz_button selected";
            itemActionBtn.setAttribute('data-button', subCategoryItem[i]['id']);
            itemActionBtn.setAttribute('href', "<?= base_url('admin/daftar_soal/'); ?>" + "/" + query + "/" + subCategoryItem[i]['id'])
            itemActionBtn.innerHTML = "Detail"
            itemAction.appendChild(itemActionBtn);

            itemBox.appendChild(itemNo);
            itemBox.appendChild(itemJenis);
            itemBox.appendChild(itemJumlah);
            itemBox.appendChild(itemAction);

            container.appendChild(itemBox);
        }
    }

    function DefaultTabButton(categoryItem, subCategoryItem) {
        document.getElementById(categoryItem[0].id).classList.add('active');

        let data = subCategoryItem.filter(item => {
            return item.category_id == categoryItem[0].id
        })

        CreateItem(data, categoryItem[0].id);
    }

    function TabButtonControl(categoryItem, subCategoryItem) {
        for (let i = 0; i < categoryItem.length; i++) {
            let category = categoryItem[i];
            let btnId = category.id;
            document.getElementById(btnId).addEventListener("click", el => {
                tabButton.forEach(itemBtnTab => {
                    itemBtnTab.classList.remove("active");
                })

                document.getElementById(el.target.id).classList.add("active");

                let data = subCategoryItem.filter(item => {
                    return item.category_id == category.id
                })

                CreateItem(data, category['id']);
            })

        }
    }

    DefaultTabButton(category, subCategory);
    TabButtonControl(category, subCategory);
</script>

<?= $this->endSection(); ?>