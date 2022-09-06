<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalDone" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header format-logo">
                <h5 class="modal-logo"><i class="fa-solid fa-circle-info"></i></h5>
            </div>
            <div class="modal-body">
                <span>Yakin Ingin Melanjutkan?</span>
                <br>
                <span>Jawaban yang telah disubmit tidak dapat dirubah</span>
            </div>
            <div class="modal-footer">
                <div class="button__container">
                    <input type="hidden" id="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <a id="notif_btn" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="<?= $utbk_session + 1 < $utbk_session_limit ? '#modalSessionNotif' : "#modalDoneNotif"; ?>" class="modal-style start__simulation__Btn">
                        <i class="fa-solid fa-play"></i><span>Submit</span>
                    </a>
                    <a class="modal-style close__simulation__Btn" data-bs-dismiss="modal"><i class="fa-solid fa-times-circle"></i><span>Batal</span></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalDoneNotif" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header format-logo">
                <h5 class="modal-logo notif-style"><i class="fa-solid fa-check-circle"></i></h5>
            </div>
            <div class="modal-body notif-style">
                <span class="text-notif">Terimakasih telah melakakuan simulasi UTBK Premium di schuler.id...</span>
            </div>
            <div class="modal-footer">
                <a style="display: none;" class="modal-style close__simulation__Btn" data-bs-dismiss="modal"><i class="fa-solid fa-times-circle"></i><span>Batal</span></a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalSessionNotif" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body notif-style">
                <span id="next_session" class="text-notif title-style"></span>
                <div class="timer-style">
                    <i class="fa-solid fa-clock"></i>
                    <br>
                    <div class="session-timer">
                        <span class="timer__countdown__minute">00</span>
                        <span>:</span>
                        <span id="timer_session_count" class="timer__countdown__second">30</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalBackButton" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header format-logo">
                <h5 class="modal-logo"><i class="fa-solid fa-circle-info"></i></h5>
            </div>
            <div class="modal-body">
                <span>Yakin Ingin Meninggal Simulasi?</span>
                <br>
                <span>Data pada simulasi ini akan dihapus</span>
            </div>
            <div class="modal-footer">
                <div class="button__container">
                    <a class="modal-style start__simulation__Btn" href="<?= base_url('home/simulasi_premium'); ?>">
                        <i class="fa-solid fa-play"></i><span>Submit</span>
                    </a>
                    <a class="modal-style close__simulation__Btn" data-bs-dismiss="modal"><i class="fa-solid fa-times-circle"></i><span>Batal</span></a>
                </div>
            </div>
        </div>
    </div>
</div>