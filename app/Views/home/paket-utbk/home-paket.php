<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box belipaket_white-box">
                    <div class="box_item__header belipaket_container__header">
                        <div class="header__title-box">
                            <div class="box_header__title">Beli Paket UTBK</div>
                            <div class="box_header__subtitle" id="result_subtitle">&nbsp;</div>
                        </div>
                    </div>
                    <div class="container__body paket__container">
                        <?php foreach ($shop_item as $si) : ?>
                            <div class="box_item__container container_paket small-box">
                                <div class="box_item__header">
                                    <div class="box_body__title"><?= $si['nama_item']; ?></div>
                                    <?php if ($si['discount'] != 0) { ?>
                                        <div class="box_body__subtitle discount_paket">
                                            <span class="alert__box alert-belipaket">
                                                Diskon <?= $si['discount']; ?>%
                                            </span>
                                            <span class="price"><?= 'Rp. ' . number_format($si['price'], 2, ',', '.'); ?></span>
                                        </div>
                                    <?php }; ?>
                                    <?php $disount = $si['price'] - (($si['price'] * $si['discount']) / 100); ?>
                                    <?php $price = $si['price'] == 0 ? 0 : number_format($disount, 2, ',', '.'); ?>
                                    <div class="box_body__subtitle"><i class="fas fa-tags"></i><span><?= ' Rp. ' . $price; ?></span></div>
                                </div>
                                <div class="box_item__body paket_body">
                                    <?php $desc = explode(',', $si['item_description']); ?>
                                    <ul>
                                        <?php foreach ($desc as $d) : ?>
                                            <li><?= $d; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php if ($si['discount'] != 0) { ?>
                                    <div class="box_item__footer paket_footer">
                                        <div class="button__container">
                                            <a button-data="<?= $si['id']; ?>" class="tab_button tab_button_style active"><i class="fa-solid fa-cart-shopping"></i> <span>BELI PAKET</span></a>
                                        </div>
                                    </div>
                                <?php }; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalChart" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Keranjang</h5>
                <button type="button" class="btn-close custom_modal_closs" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modalChart">
                <table class="table">
                    <thead>
                        <tr>
                            <td id="title_item" colspan="2" class="font-weight-bolder"></td>
                        </tr>
                        <tr>
                            <td id="discount_title" style="font-weight: 600;" width="50%"></td>
                            <td class="text-end">
                                <span id="price"></span>
                                <br>
                                <span id="real_price" class="text-decoration-line-through" style="font-size: 0.8rem"></span>
                            </td>
                        </tr>
                    </thead>
                </table>
                <table class="table">
                    <thead>
                        <tr>
                            <td style="font-weight: 600;" width="50%">TOTAL</td>
                            <td id="total_price" class="text-end"></td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer side-position">
                <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <button id="pay-button" class="box_item__Btn list_quiz_button selected"><i class="fa-solid fa-cart-shopping"></i> <span>Pembayaran</span> </button>
            </div>
        </div>
    </div>
</div>

<script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-KzP6dvkpW5QvBuX1"></script>
<script>
    let shopItem = <?= json_encode($shop_item); ?>;
    let urlPayMidtrans = "<?= base_url('home/payMidtrans') ?>";
    let urlMakeTransaksi = "<?= base_url('home/save_transaksi') ?>";
    let urlConfirmation = "<?= base_url('home/transactionHandle') ?>";
    let urlRedirect = "<?= base_url('home/pembayaran') ?>";

    function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
    }

    document.querySelectorAll('.tab_button.tab_button_style').forEach(el => {
        el.addEventListener('click', (element) => {
            var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
            var csrfHash = document.getElementById('txt_csrfname').value;
            let itemId = element.target.parentElement.getAttribute('button-data');
            let itemClicked = shopItem.find(obj => obj.id === itemId);
            if (itemClicked) {
                let slug = itemClicked['slug'][0].toUpperCase() + itemClicked['slug'].substring(1);
                let price = itemClicked['price'] - ((itemClicked['price'] * itemClicked['discount']) / 100);

                document.getElementById('title_item').innerHTML = "Kumpulan Soal-Soal " + slug.replaceAll("_", " ").toUpperCase();
                document.getElementById('discount_title').innerHTML = "Discount " + itemClicked['discount'] + '% ' + slug.replaceAll("_", " ").toUpperCase();
                document.getElementById('price').innerHTML = convertToRupiah(price) + ',00';
                document.getElementById('real_price').innerHTML = convertToRupiah(itemClicked['price']) + ',00';
                document.getElementById('total_price').innerHTML = convertToRupiah(price) + ',00';

                $('#modalChart').modal('show');

                document.getElementById('pay-button').onclick = function() {
                    $('#modalChart').modal('hide');

                    const data = {};
                    data[csrfName] = csrfHash;
                    data['id_item'] = itemClicked['id_item'];

                    var xhttp = new XMLHttpRequest();
                    xhttp.open("POST", urlPayMidtrans, true);
                    xhttp.onreadystatechange = () => {
                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            var response = JSON.parse(xhttp.responseText);
                            document.getElementById('txt_csrfname').value = response['value'];
                            document.getElementById('txt_csrfname').name = response['name'];

                            snap.pay(response.snapToken, {
                                onSuccess: function(result) {
                                    let dataResult = JSON.stringify(result, null, 2);
                                    let objResult = JSON.parse(dataResult);

                                    const data = {};
                                    data['status'] = 'success';
                                    data[response['name']] = response['value'];
                                    data['id_item'] = itemClicked['id_item'];
                                    data['transaction_id'] = objResult.transaction_id;
                                    data['order_id'] = objResult.order_id;
                                    data['payment_type'] = objResult.payment_type;
                                    data['transaction_time'] = objResult.transaction_time;
                                    data['transaction_status'] = objResult.transaction_status;
                                    data['bank'] = objResult.va_numbers[0].bank;
                                    data['va_number'] = objResult.va_numbers[0].va_number;

                                    var xhttp = new XMLHttpRequest();
                                    xhttp.open("POST", urlMakeTransaksi, true);
                                    xhttp.onreadystatechange = () => {
                                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                                            var response = JSON.parse(xhttp.responseText);
                                            document.getElementById('txt_csrfname').value = response['value'];
                                            document.getElementById('txt_csrfname').name = response['name'];
                                            
                                            var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
                                            var csrfHash = document.getElementById('txt_csrfname').value;

                                            const dataConf = {};
                                            dataConf["user_order"] = "cek_transaction";
                                            dataConf['order_id'] = objResult.order_id;
                                            dataConf[csrfName] = csrfHash;

                                            var xhttpNew = new XMLHttpRequest();
                                            xhttpNew.open("POST", urlConfirmation, true);
                                            xhttpNew.onreadystatechange = () => {
                                                if (xhttpNew.readyState == 4 && xhttpNew.status == 200) {
                                                    var response = JSON.parse(xhttpNew.responseText);
                                                    document.getElementById('txt_csrfname').value = response['value'];
                                                    document.getElementById('txt_csrfname').name = response['name'];
                                                    window.location.href = urlRedirect;
                                                }
                                            };
                                            xhttpNew.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                                            xhttpNew.setRequestHeader("Content-Type", "application/json");
                                            xhttpNew.send(JSON.stringify(dataConf));
                                        }
                                    };
                                    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                                    xhttp.setRequestHeader("Content-Type", "application/json");
                                    xhttp.send(JSON.stringify(data));
                                },
                                onPending: function(result) {
                                    let dataResult = JSON.stringify(result, null, 2);
                                    let objResult = JSON.parse(dataResult);

                                    const data = {};
                                    data[response['name']] = response['value'];
                                    data['id_item'] = itemClicked['id_item'];
                                    data['transaction_id'] = objResult.transaction_id;
                                    data['order_id'] = objResult.order_id;
                                    data['payment_type'] = objResult.payment_type;
                                    data['transaction_time'] = objResult.transaction_time;
                                    data['transaction_status'] = objResult.transaction_status;
                                    data['bank'] = objResult.va_numbers[0].bank;
                                    data['va_number'] = objResult.va_numbers[0].va_number;

                                    var xhttp = new XMLHttpRequest();
                                    xhttp.open("POST", urlMakeTransaksi, true);
                                    xhttp.onreadystatechange = () => {
                                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                                            var response = JSON.parse(xhttp.responseText);
                                            document.getElementById('txt_csrfname').value = response['value'];
                                            document.getElementById('txt_csrfname').name = response['name'];
                                            window.location.href = urlRedirect;
                                        }
                                    };
                                    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                                    xhttp.setRequestHeader("Content-Type", "application/json");
                                    xhttp.send(JSON.stringify(data));
                                },
                                onError: function(result) {
                                    console.log(JSON.stringify(result, null, 2));
                                }
                            });

                        }
                    };
                    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                    xhttp.setRequestHeader("Content-Type", "application/json");
                    xhttp.send(JSON.stringify(data));
                };
            }
        })
    })
</script>

<?= $this->endSection(); ?>