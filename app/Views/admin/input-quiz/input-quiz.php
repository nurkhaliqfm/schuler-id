<?= $this->extend('layout/template'); ?>

<?php $uri = current_url(true)->getSegment(4); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <?php if (session()->getFlashdata('failed')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('failed'); ?>
            </div>
        <?php endif; ?>
        <!-- Input Floating Info -->
        <div class="floating-info">
            <div id="floatingContainer" class="floating-countainer"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <form action="<?= base_url('admin/save_quiz/' . $uri . '?slug=' . $_GET['slug']); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <!-- Nama Quiz -->
                        <h3 class="box-title simulation">Nama Quiz</h3>
                        <div class="mb-3">
                            <input name="QuizName" type="text" class="form-control <?= ($validation->hasError('QuizName')) ? 'is-invalid' : ''; ?>" id="QuizName" value="<?= old('QuizName'); ?>"></input>
                            <div class="invalid-feedback">
                                <?= $validation->getError('QuizName'); ?>
                            </div>
                        </div>

                        <!-- Daftar Soal Quiz -->
                        <div class="container_header_1 daftar__soal">
                            <h3 style="margin-bottom: 4px;" class="box-title simulation">Daftar Soal</h3>
                            <div id="tab_header_button" class="button__container">
                                <?php foreach ($category as $item) : ?>
                                    <div class="tab_button tab_button_style" id="<?= $item['id']; ?>"><?= strtoupper(str_replace('_', ' ', $item['name'])); ?></div>
                                <?php endforeach; ?>
                            </div>

                            <div class="white-box">
                                <div class="container__body__box daftar__soal">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td style="border-bottom: 0px;" class="text-center"></td>
                                                <td style="border-bottom: 0px;" class="text-center">Preview</td>
                                                <td style="border-bottom: 0px;" class="text-center">Kode Soal</td>
                                                <td style="border-bottom: 0px;" class="text-center">Jenis Soal</td>
                                                <td style="border-bottom: 0px;" class="text-center">Pembuatan</td>
                                            </tr>
                                        </thead>
                                        <tbody id="item-table"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="box_item__Btn list_quiz_button selected">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-keyboard="false" id="modalPreview" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <div id="soal_preview"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const tabButton = document.querySelectorAll('div.tab_button_style');

    let category = <?= json_encode($category); ?>;
    let subCategory = <?= json_encode($sub_category); ?>;
    let bankSoals = <?= json_encode($bank_soal); ?>;

    function CreateItem(categoryItem, subCategoryItem, soalItems) {
        var container = document.getElementById("item-table");
        container.innerHTML = '';

        for (let i = 0; i < soalItems.length; i++) {
            let selectedSubCategory = subCategoryItem.find(item => {
                return item.id == soalItems[i]['sub_category_id']
            })

            let selectedCategory = categoryItem.find(item => {
                return item.id == selectedSubCategory['category_id']
            })

            var itemBox = document.createElement("tr");
            var itemCheckbox = document.createElement("td");
            var checkbox = document.createElement('input');
            var itemSoal = document.createElement("td");
            var itemSoalBtn = document.createElement("a");
            var itemKodeSoal = document.createElement("td");
            var itemJenis = document.createElement("td");
            var itemSoalTglCreate = document.createElement("td");

            itemBox.id = 'item-box';
            itemBox.setAttribute('box-name', selectedCategory['id'])
            itemCheckbox.className = "text-center";
            itemKodeSoal.className = "text-center";
            itemJenis.className = "text-center";
            itemSoal.className = "text-center"
            itemSoalTglCreate.className = "text-center"

            checkbox.className = "custom-control-input";
            checkbox.type = "checkbox";
            checkbox.value = soalItems[i]['id_soal'];
            checkbox.setAttribute('checkbox-name', selectedSubCategory['name'])
            checkbox.name = "quiz_list_question[]";
            itemCheckbox.appendChild(checkbox);

            itemSoalBtn.className = "preview_btn box_item__Btn list_quiz_button selected";
            itemSoalBtn.id = soalItems[i]['id_soal'];
            itemSoalBtn.innerHTML = "View"
            itemSoal.appendChild(itemSoalBtn);

            itemKodeSoal.innerHTML = soalItems[i]['kode_soal'];
            itemJenis.innerHTML = selectedSubCategory['name'];
            itemSoalTglCreate.innerHTML = soalItems[i]['created_at']

            itemBox.appendChild(itemCheckbox);
            itemBox.appendChild(itemSoal);
            itemBox.appendChild(itemKodeSoal);
            itemBox.appendChild(itemJenis);
            itemBox.appendChild(itemSoalTglCreate);

            container.appendChild(itemBox);
        }
    }

    function DefaultTabButton(categoryItem, subCategoryItem) {
        document.getElementById(categoryItem[0]['id']).classList.add('active');

        let defaultitem = document.querySelectorAll('tr#item-box');
        let selectedItem = document.querySelectorAll('tr[box-name="' + categoryItem[0]['id'] + '"]');

        let selectSubCategory = subCategoryItem.filter(item => {
            return item.category_id == categoryItem[0]['id']
        })

        defaultitem.forEach(element => {
            element.setAttribute('style', 'display: none;');
        });

        selectedItem.forEach(element => {
            element.setAttribute('style', '');
        });

        let floatingCountainer = document.getElementById('floatingContainer');
        floatingCountainer.innerHTML = '';
        var dataItem = {};

        Object.keys(selectSubCategory).forEach(index => {
            var floatingItem = document.createElement("div");
            floatingItem.className = 'floating-item';
            floatingItem.setAttribute('data-name', selectSubCategory[index]['name']);

            var floatingTitle = document.createElement("div");
            floatingTitle.className = 'floating-title';
            floatingTitle.innerHTML = selectSubCategory[index]['name'];

            var floatingValue = document.createElement("div");
            floatingValue.className = 'floating-value';
            floatingValue.innerHTML = '0';

            floatingItem.appendChild(floatingTitle);
            floatingItem.appendChild(floatingValue);

            floatingCountainer.appendChild(floatingItem);
            dataItem[selectSubCategory[index]['name']] = 0
        })

        selectedItem.forEach(element => {
            element.addEventListener('click', (el) => {
                var build = {};
                for (let k in dataItem) {
                    build[k] = 0
                }
                selectedItem.forEach(element => {
                    let element_item = element.firstChild.firstElementChild;
                    let element_name = element_item.attributes['checkbox-name'].nodeValue;
                    if (element_item.checked == true) {
                        build[element_name] = build[element_name] + 1
                    }
                });

                for (let k in dataItem) {
                    dataItem[k] = build[k];
                    document.querySelector('.floating-item[data-name="' + k + '"] .floating-value').innerHTML = build[k];
                }
            })
        })

        PopUp(bankSoals);
    }

    function TabButtonControl(categoryItem, subCategoryItem, typeItems) {
        for (let i = 0; i < categoryItem.length; i++) {
            let selectedCategory = categoryItem[i]['id'];
            document.getElementById(selectedCategory).addEventListener("click", el => {
                tabButton.forEach(itemBtnTab => {
                    itemBtnTab.classList.remove("active");
                })

                document.getElementById(el.target.id).classList.add("active");

                let defaultitem = document.querySelectorAll('tr#item-box');
                let selectedItem = document.querySelectorAll('tr[box-name="' + selectedCategory + '"]');

                defaultitem.forEach(element => {
                    element.setAttribute('style', 'display: none;');
                });

                selectedItem.forEach(element => {
                    element.setAttribute('style', '');
                });

                let floatingCountainer = document.getElementById('floatingContainer');
                floatingCountainer.innerHTML = '';
                var dataItem = {};

                let selectSubCategory = subCategoryItem.filter(item => {
                    return item.category_id == selectedCategory
                })

                Object.keys(selectSubCategory).forEach(index => {
                    var floatingItem = document.createElement("div");
                    floatingItem.className = 'floating-item';
                    floatingItem.setAttribute('data-name', selectSubCategory[index]['name']);

                    var floatingTitle = document.createElement("div");
                    floatingTitle.className = 'floating-title';
                    floatingTitle.innerHTML = selectSubCategory[index]['name'];

                    var floatingValue = document.createElement("div");
                    floatingValue.className = 'floating-value';
                    floatingValue.innerHTML = '0';

                    floatingItem.appendChild(floatingTitle);
                    floatingItem.appendChild(floatingValue);

                    floatingCountainer.appendChild(floatingItem);
                    dataItem[selectSubCategory[index]['name']] = 0
                })

                selectedItem.forEach(element => {
                    var build = {};
                    for (let k in dataItem) {
                        build[k] = 0
                    }

                    selectedItem.forEach(element => {
                        let element_item = element.firstChild.firstElementChild;
                        let element_name = element_item.attributes['checkbox-name'].nodeValue;
                        if (element_item.checked == true) {
                            build[element_name] = build[element_name] + 1
                        }
                    });

                    for (let k in dataItem) {
                        dataItem[k] = build[k];
                        document.querySelector('.floating-item[data-name="' + k + '"] .floating-value').innerHTML = build[k];
                    }

                    element.addEventListener('click', (el) => {
                        var build = {};
                        for (let k in dataItem) {
                            build[k] = 0
                        }

                        selectedItem.forEach(element => {
                            let element_item = element.firstChild.firstElementChild;
                            let element_name = element_item.attributes['checkbox-name'].nodeValue;
                            if (element_item.checked == true) {
                                build[element_name] = build[element_name] + 1
                            }
                        });

                        for (let k in dataItem) {
                            dataItem[k] = build[k];
                            document.querySelector('.floating-item[data-name="' + k + '"] .floating-value').innerHTML = build[k];
                        }
                    })
                })

                PopUp(bankSoals);
            })

        }
    }

    function PopUp(dataSoal) {
        const previewBtn = document.querySelectorAll('a.preview_btn');
        previewBtn.forEach(element => {
            element.addEventListener('click', el => {
                $('#modalPreview').modal('show');
                let selectedData = dataSoal.filter(filter => {
                    return filter.id_soal == el.target.id
                })
                document.getElementById('soal_preview').innerHTML = selectedData[0].soal
            })
        })
    }

    CreateItem(category, subCategory, bankSoals);
    DefaultTabButton(category, subCategory);
    TabButtonControl(category, subCategory, dataType);
</script>

<?= $this->endSection(); ?>