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
                    <!-- Nama Quiz -->
                    <h3 class="box-title simulation">Nama Quiz</h3>
                    <div class="mb-3">
                        <input disabled name="QuizName" type="text" class="form-control <?= ($validation->hasError('QuizName')) ? 'is-invalid' : ''; ?>" id="QuizName" value="<?= $quiz_name; ?>"></input>
                    </div>

                    <!-- Daftar Soal Quiz -->
                    <div class="container_header_1 daftar__soal">
                        <div class="header_edit">
                            <h3 class="box-title simulation">Daftar Soal</h3>
                            <a id="addSoal_popUp" class="addSoal_popUp box_item__Btn list_quiz_button delete__btn">Tambahkan Soal</a>
                        </div>
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
                                            <td style="border-bottom: 0px;" class="text-center">No</td>
                                            <td style="border-bottom: 0px;" class="text-center">Soal</td>
                                            <td style="border-bottom: 0px;" class="text-center">Id</td>
                                            <td style="border-bottom: 0px;" class="text-center">Jenis Soal</td>
                                            <td style="border-bottom: 0px;" class="text-center">Pembuatan</td>
                                            <td style="border-bottom: 0px;" class="text-center">Action</td>
                                        </tr>
                                    </thead>
                                    <tbody id="item-table"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <a href="<?= base_url('admin/daftar_quiz/' . $_GET['u'] . '?slug=' . $_GET['slug']); ?>" class="box_item__Btn list_quiz_button delete__btn">Kembali</a>
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

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalPreviewAdd" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <a id="btn_preview_modal-close" type="button" class="btn-close custom_modal_closs" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <div id="soal_preview_modal"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalAddSoalQuiz" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close custom_modal_closs" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form-modal_add-question">
                    <?= csrf_field(); ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <td style="border-bottom: 0px;" class="text-center"></td>
                                <td style="border-bottom: 0px;" class="text-center">Soal</td>
                                <td style="border-bottom: 0px;" class="text-center">Jenis Soal</td>
                                <td style="border-bottom: 0px;" class="text-center">Pembuatan</td>
                            </tr>
                        </thead>
                        <tbody id="item-table-modal"></tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer side-position">
                <button id="submit_modalBtn" type="submit" class="box_item__Btn list_quiz_button selected">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    const tabButton = document.querySelectorAll('div.tab_button_style');

    let dataType = <?= json_encode($soal_subject); ?>;
    let dataCategory = <?= json_encode($bank_soal); ?>;
    let dataCategoryOption = <?= json_encode($bank_soal_option); ?>;

    function CreateItem(categoryItems, query) {
        var container = document.getElementById("item-table");
        container.innerHTML = '';
        for (let i = 0; i < categoryItems.length; i++) {
            var itemBox = document.createElement("tr");
            var itemNo = document.createElement("td");
            var itemSoal = document.createElement("td");
            var itemSoalBtn = document.createElement("a");
            var itemIdSoal = document.createElement("td");
            var itemJenis = document.createElement("td");
            var itemAction = document.createElement("td");
            var itemActionBtn = document.createElement("a");
            var itemSoalTgl = document.createElement("td");

            itemNo.className = "text-center"
            itemJenis.className = "text-center"
            itemSoal.className = "text-center"
            itemIdSoal.className = "text-center"
            itemSoalTgl.className = "text-center"
            itemAction.className = "text-center"

            itemNo.innerHTML = i + 1;
            itemJenis.innerHTML = query[categoryItems[i]['sub_type_soal']];
            itemIdSoal.innerHTML = categoryItems[i]['id_soal'];

            itemSoalBtn.className = "preview_btn box_item__Btn list_quiz_button selected";
            itemSoalBtn.id = categoryItems[i]['id_soal'];
            itemSoalBtn.innerHTML = "View"
            itemSoal.appendChild(itemSoalBtn);

            itemActionBtn.className = "box_item__Btn list_quiz_button delete__btn";
            itemActionBtn.setAttribute('href', "<?= base_url('admin/delete_soal_quiz') . '?quiz_id=' . $uri . "&slug=" . $_GET['slug'] . "&u=" . $_GET['u'] . "&id_soal="; ?>" + categoryItems[i]['id_soal'])
            itemActionBtn.innerHTML = "Hapus Soal"
            itemAction.appendChild(itemActionBtn);

            itemSoalTgl.innerHTML = categoryItems[i]['created_at']

            itemBox.appendChild(itemNo);
            itemBox.appendChild(itemSoal);
            itemBox.appendChild(itemIdSoal);
            itemBox.appendChild(itemJenis);
            itemBox.appendChild(itemSoalTgl);
            itemBox.appendChild(itemAction);

            container.appendChild(itemBox);
        }
    }

    function DefaultTabButton(typeItems, categoryItems, categoryItemsOption) {
        document.getElementById(typeItems[0].type_soal_name).classList.add('active');

        let data = categoryItems.filter(categoryItems => {
            return categoryItems.type_soal == typeItems[0].type_soal_id
        })

        let data_2 = categoryItemsOption.filter(categoryItemsOption => {
            return categoryItemsOption.type_soal == typeItems[0].type_soal_id
        })

        CreateItem(data, typeItems[0]);
        PopUp(dataCategory);
        PopUpAddSoal(data_2, typeItems[0])
    }

    function TabButtonControl(typeItems, categoryItems, categoryItemsOption) {
        for (let i = 0; i < typeItems.length; i++) {
            let item = typeItems[i];
            let btnId = item.type_soal_name;
            document.getElementById(btnId).addEventListener("click", el => {
                tabButton.forEach(itemBtnTab => {
                    itemBtnTab.classList.remove("active");
                })

                document.getElementById(el.target.id).classList.add("active");

                let data = categoryItems.filter(categoryItems => {
                    return categoryItems.type_soal == item.type_soal_id
                })

                let data_2 = categoryItemsOption.filter(categoryItemsOption => {
                    return categoryItemsOption.type_soal == item.type_soal_id
                })

                CreateItem(data, item);
                PopUp(dataCategory);
                PopUpAddSoal(data_2, item)
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

    function PopUpAddSoal(categoryItems, query) {
        const modalAddSoalBtn = document.querySelector('a.addSoal_popUp');
        modalAddSoalBtn.addEventListener('click', () => {
            $('#modalAddSoalQuiz').modal('show');
            var container = document.getElementById("item-table-modal");

            container.innerHTML = '';
            for (let i = 0; i < categoryItems.length; i++) {
                document.getElementById('form-modal_add-question').setAttribute('action', "<?= base_url('admin/save_soal_quiz') . '?quiz_id=' . $uri . "&slug=" . $_GET['slug'] . "&u=" . $_GET['u'] . "&id_soal="; ?>" + categoryItems[i]['id_soal'])

                var itemBox = document.createElement("tr");
                var itemCheckbox = document.createElement("td");
                var checkbox = document.createElement('input');
                var itemSoal = document.createElement("td");
                var itemSoalBtn = document.createElement("a");
                var itemJenis = document.createElement("td");
                var itemSoalTgl = document.createElement("td");

                itemCheckbox.className = "text-center"
                itemJenis.className = "text-center"
                itemSoal.className = "text-center"
                itemSoalTgl.className = "text-center"

                checkbox.className = "custom-control-input";
                checkbox.type = "checkbox";
                checkbox.value = categoryItems[i]['id_soal'];
                checkbox.name = "quiz_list_question[]";
                itemCheckbox.appendChild(checkbox);
                itemJenis.innerHTML = query[categoryItems[i]['sub_type_soal']];

                itemSoalBtn.className = "preview_modal_btn box_item__Btn list_quiz_button selected";
                itemSoalBtn.id = categoryItems[i]['id_soal'];
                itemSoalBtn.innerHTML = "Preview Soal"
                itemSoal.appendChild(itemSoalBtn);

                itemSoalTgl.innerHTML = categoryItems[i]['created_at']

                itemBox.appendChild(itemCheckbox);
                itemBox.appendChild(itemSoal);
                itemBox.appendChild(itemJenis);
                itemBox.appendChild(itemSoalTgl);

                container.appendChild(itemBox);
            }

            const previewModalBtn = document.querySelectorAll('a.preview_modal_btn');
            previewModalBtn.forEach(element => {
                element.addEventListener('click', el => {
                    $('#modalPreviewAdd').modal('show');
                    $('#modalAddSoalQuiz').modal('hide');
                    let selectedData = dataCategoryOption.filter(filter => {
                        return filter.id_soal == el.target.id
                    })
                    document.getElementById('soal_preview_modal').innerHTML = selectedData[0].soal
                })
            })

            document.getElementById('btn_preview_modal-close').addEventListener('click', () => {
                $('#modalAddSoalQuiz').modal('show');
            })

            var myModalForm = document.getElementById('form-modal_add-question');
            document.getElementById('submit_modalBtn').addEventListener('click', () => {
                myModalForm.submit();
            });

        })

    }

    DefaultTabButton(dataType, dataCategory, dataCategoryOption);
    TabButtonControl(dataType, dataCategory, dataCategoryOption);
</script>

<?= $this->endSection(); ?>