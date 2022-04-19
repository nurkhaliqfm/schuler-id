<?= $this->extend('layout/template-simulasi'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box fr-view">
                    <div class="simulasi-header-container">
                        <div class="item_timer"><i class="fa-solid fa-clock"></i><span> 75:00</span></div>
                        <div class="title_simulation_test">Test Kemampuan Akademik</div>
                    </div>
                    <div class="question-container">
                        <div class="d-flex bd-highlight mb-3 align-items-center question_header">
                            <div class="bd-highlight quest__number">SOAL NOMOR 1</div>
                            <div class="bd-highlight quest__subject">MATEMATIKA</div>
                            <div class="ms-auto bd-highlight quest__report"><i class="fa-solid fa-circle-info"></i><span> Laporkan Soal</span></div>
                        </div>
                        <div class="question_main">

                        </div>
                    </div>
                    <div class="simulasi-footer-container text-center">
                        <div class="item_prev"><i class="fa-solid fa-arrow-left"></i><span> Sebelumnya</span></div>
                        <div class="item_next"><i class="fa-solid fa-arrow-right"></i><span> Selanjutnya</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>