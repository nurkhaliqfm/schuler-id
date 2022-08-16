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
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <form action="<?= base_url('admin/save_quiz/' . $uri . '/?slug=' . $_GET['slug']); ?>" method="POST">
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
                                <?php foreach ($soal_subject as $ss) : ?>
                                    <div class="tab_button tab_button_style" id="<?= $ss['type_soal_name']; ?>"><?= strtoupper(str_replace('_', ' ', $ss['type_soal_name'])); ?></div>
                                <?php endforeach; ?>
                            </div>

                            <div class="white-box">
                                <div class="container__body__box daftar__soal">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td style="border-bottom: 0px;" class="text-center"></td>
                                                <td style="border-bottom: 0px;" class="text-center">Soal</td>
                                                <td style="border-bottom: 0px;" class="text-center">Jenis Soal</td>
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

    let dataType = <?= json_encode($soal_subject); ?>;
    let dataCategory = <?= json_encode($bank_soal); ?>;

    function CreateItem(categoryItems, typeItems) {
        var container = document.getElementById("item-table");
        container.innerHTML = '';
        for (let i = 0; i < categoryItems.length; i++) {

            let query = typeItems.filter(typeItems => {
                return typeItems.type_soal_id == categoryItems[i]['type_soal']
            })

            var itemBox = document.createElement("tr");
            var itemCheckbox = document.createElement("td");
            var checkbox = document.createElement('input');
            var itemSoal = document.createElement("td");
            var itemSoalBtn = document.createElement("a");
            var itemJenis = document.createElement("td");

            itemBox.id = 'item-box';
            itemBox.setAttribute('box-name', query[0]['type_soal_name'])
            itemCheckbox.className = "text-center";
            itemJenis.className = "text-center";
            itemSoal.className = "text-center";

            checkbox.className = "custom-control-input";
            checkbox.type = "checkbox";
            checkbox.value = categoryItems[i]['id_soal'];
            checkbox.name = "quiz_list_question[]";
            itemCheckbox.appendChild(checkbox);
            itemJenis.innerHTML = query[0][categoryItems[i]['sub_type_soal']];

            itemSoalBtn.className = "preview_btn box_item__Btn list_quiz_button selected";
            itemSoalBtn.id = categoryItems[i]['id_soal'];
            itemSoalBtn.innerHTML = "Preview Soal"
            itemSoal.appendChild(itemSoalBtn);

            itemBox.appendChild(itemCheckbox);
            itemBox.appendChild(itemSoal);
            itemBox.appendChild(itemJenis);

            container.appendChild(itemBox);
        }
    }

    function DefaultTabButton(typeItems, categoryItems) {
        document.getElementById(typeItems[0].type_soal_name).classList.add('active');

        let defaultitem = document.querySelectorAll('tr#item-box');
        let selectedItem = document.querySelectorAll('tr[box-name="' + typeItems[0][
            ['type_soal_name']
        ] + '"]');

        defaultitem.forEach(element => {
            element.setAttribute('style', 'display: none;');
        });

        selectedItem.forEach(element => {
            element.setAttribute('style', '');
        });

        PopUp(dataCategory);
    }

    function TabButtonControl(typeItems, categoryItems) {
        for (let i = 0; i < typeItems.length; i++) {
            let item = typeItems[i];
            let btnId = item.type_soal_name;
            document.getElementById(btnId).addEventListener("click", el => {
                tabButton.forEach(itemBtnTab => {
                    itemBtnTab.classList.remove("active");
                })

                document.getElementById(el.target.id).classList.add("active");

                let defaultitem = document.querySelectorAll('tr#item-box');
                let selectedItem = document.querySelectorAll('tr[box-name="' + item[
                    ['type_soal_name']
                ] + '"]');

                defaultitem.forEach(element => {
                    element.setAttribute('style', 'display: none;');
                });

                selectedItem.forEach(element => {
                    element.setAttribute('style', '');
                });

                PopUp(dataCategory);
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

    CreateItem(dataCategory, dataType);
    DefaultTabButton(dataType, dataCategory);
    TabButtonControl(dataType, dataCategory);
</script>

<?= $this->endSection(); ?>