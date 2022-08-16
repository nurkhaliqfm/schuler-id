<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalDone" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header format-logo">
                <h5 class="modal-logo"><i class="fa-solid fa-circle-info"></i></h5>
            </div>
            <div class="modal-body">
                <span>Submit jawaban sekarang?</span>
                <br>
                <span>Jawaban yang telah disubmit tidak dapat dirubah</span>
            </div>
            <div class="modal-footer">
                <div class="button__container">
                    <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <a id="notif_btn" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalDoneNotif" class="modal-style start__simulation__Btn">
                        <i class="fa-solid fa-play"></i><span>Submit</span>
                    </a>
                    <a class="modal-style close__simulation__Btn" data-bs-dismiss="modal"><i class="fa-solid fa-times-circle"></i><span>Batal</span></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalDoneNotif" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header format-logo">
                <h5 class="modal-logo notif-style"><i class="fa-solid fa-check-circle"></i></h5>
            </div>
            <div class="modal-body notif-style">
                <span class="text-notif">Terimakasih telah melakakuan latihan soal di schuler.id...</span>
            </div>
            <div class="modal-footer">
                <a style="display: none;" class="modal-style close__simulation__Btn" data-bs-dismiss="modal"><i class="fa-solid fa-times-circle"></i><span>Batal</span></a>
            </div>
        </div>
    </div>
</div>