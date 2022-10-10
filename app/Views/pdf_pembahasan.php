<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pembahasan Event Simulasi SNBPT 2023 | Siakad Stia Al-Gazali Barru</title>
    <!-- Fav Icon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/favicon.png') ?>">

</head>

<body>
    <div id="pembahasan-section" class="container__body result__container">
        <div class="box_item__container container_result large-box">
            <div class="box_item__body result_body">
                <div id="question-container" class="question-container">
                    <div class="question_main">
                        <table border="1">
                            <?php $i = 0; ?>
                            <?php foreach ($data_soal as $ds) : ?>
                                <?php $i++; ?>
                                <tr>
                                    <td style="vertical-align: top"><?= $i ?>.</td>
                                    <td style="vertical-align: top;">
                                        <div style="margin-bottom: 5px;" id="question__part" class="question__part"><?= $ds['soal'] ?></div>
                                        <div class="question__answer__part">
                                            <div class="form-check"><?= 'A. ' . $ds['option_a'] ?></div>
                                            <div class="form-check"><?= 'B. ' . $ds['option_b'] ?></div>
                                            <div class="form-check"><?= 'C. ' . $ds['option_c'] ?></div>
                                            <div class="form-check"><?= 'D. ' . $ds['option_d'] ?></div>
                                            <div class="form-check"><?= 'E. ' . $ds['option_e'] ?></div>
                                        </div>
                                        <div style="margin-top: 10px;" class="answare_main">
                                            <?php $ans_u = explode('_', $data_jawaban[$ds['id_soal']]) ?>
                                            <?php $ans_r = explode('_', $ds['ans_id']) ?>
                                            <div class="answare-text">Jawaban Anda : <span id="your_answare"><?= sizeof($ans_u) == 2 ? ucwords($ans_u[1]) : '-' ?></span></div>
                                            <div class="answare-text">Kunci Jawaban : <span id="real_answare"><?= ucwords($ans_r[1]) ?></span></div>
                                        </div>
                                        <div style="margin-top: 10px;" class="explanation_main question__part">
                                            <div class="explanation-title">PEMBAHASAN</div>
                                            <div class="answare-text" id="explain__part"><?= str_replace(array('<p style="text-align: justify;">'), array('<p style="text-align: justify; margin: 0px;">'), $ds['pembahasan']) ?></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</body>
<script>
    document.querySelectorAll('p').forEach((el) => {
        el.replaceWith(...parent.childNodes);
    })
</script>

</html>