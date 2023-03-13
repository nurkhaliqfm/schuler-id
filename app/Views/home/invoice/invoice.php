<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box invoice_white-box">
                    <div class="head__simulationfree">
                        <h3 class="box-title">Invoice <span>Pembelian</span></h3>
                        <div class="alert__box invoice_alert"><i class="fa-solid fa-circle-info"></i>
                            <span> Perhatian : </span>
                            <ul>
                                <li>Screenshoot bukti pembayaran anda untuk verifikasi apabila ada kendala pembayaran</li>
                                <li>Apabila dalam waktu 30 menit setelah melakukan pembayaran namun pembayaran belum terkonfirmasi, silahkan hubungi admin melalaui email halo@schuler.id atau ke whatsapp +62 812-4533-5890 dengan mengirim bukti transfer</li>
                            </ul>
                        </div>
                    </div>
                    <div class="header__button-box container_header_1 simulation-result__tab">
                        <div class="button__container">
                            <a id="tab_button" data-button="pending" class="tab_button tab_button_style">
                                <span class="text-start">Panding</span>
                                <span class="text-end">(<?= $pending ?>)</span></a>
                            <a id="tab_button" data-button="settlement" class="tab_button tab_button_style">
                                <span class="text-start">Sukses</span>
                                <span class="text-end">(<?= $settlement ?>)</span></a>
                            </a>
                            <a id="tab_button" data-button="cancel" class="tab_button tab_button_style">
                                <span class="text-start">Batal</span>
                                <span class="text-end">(<?= $cancel ?>)</span></a>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="white-box invoice_white-box">
                    <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <div id="invoice-body" class="container__body invoice__container"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/invoice.js?v=') . time() ?>"></script>
<script>
    let dataInvoice = <?= json_encode($data_transaksi); ?>;
    let listStatus = <?= json_encode($list_status) ?>;
    let base_url = "<?= base_url('home/transactionHandle/') ?>";
    let htmlRoot = document.getElementById('invoice-body');

    var csrfName = document.getElementById('txt_csrfname').getAttribute('name');
    var csrfHash = document.getElementById('txt_csrfname').value;

    DefaultTabButton(htmlRoot, dataInvoice);
    TabButtonControl(htmlRoot, dataInvoice);
    ButtonControl(base_url);

    if (document.querySelector('.rek_data') != null) {
        let copyRek = document.querySelector('.rek_data').getAttribute('value');
        let copyNominal = document.querySelector('.nominal_value').getAttribute('value');

        document.getElementById('copy_rek').addEventListener('click', () => {
            navigator.clipboard.writeText(copyRek);
        })

        document.getElementById('copy_nominal').addEventListener('click', () => {
            navigator.clipboard.writeText(copyNominal);
        })
    }
</script>
<?= $this->endSection(); ?>