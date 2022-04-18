<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-container">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <?= $question; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>