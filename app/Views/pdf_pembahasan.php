<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembahasan Event Simulasi SNBT 2023 | Schuler.Id</title>
    <!-- Fav Icon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/favicon.png') ?>">

    <style>
        * {
            box-sizing: border-box;
        }

        .column_no {
            float: left;
            width: 2%;
            padding: 10px;
        }

        .column {
            float: left;
            width: 98%;
            padding: 10px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        #header {
            position: fixed;
            left: 0px;
            top: -45px;
            right: 0px;
            height: 45px;
            text-align: center;
            border-bottom: 2px solid black;
        }

        #footer {
            position: fixed;
            left: 0px;
            bottom: -140px;
            right: 0px;
            height: 150px;
            border-top: 2px solid black;
        }

        #footer .page:after {
            content: counter(page, upper-roman);
        }
    </style>

</head>

<body>
    <div id="header">
        <img src="https://schuler.id/assets/img/Header.png" alt="Header">
    </div>
    <div id="footer">
        <img src="https://schuler.id/assets/img/Footer.png" alt="Header">
    </div>
    <div id="pembahasan-section" class="container__body result__container">
        <div class="box_item__container container_result large-box">
            <div class="box_item__body result_body">
                <div id="question-container" class="question-container">
                    <div class="question_main">
                        <?php $i = 0; ?>
                        <?php foreach ($data_soal as $ds) : ?>
                            <?php $i++; ?>
                            <div class="item-container row">
                                <div class="column_no" style="vertical-align: top"><?= $i ?>.</div>
                                <div class="column" style="vertical-align: top;">
                                    <div style="margin-bottom: 5px;" id="question__part" class="question__part"><?= str_replace(array('<p style="text-align: justify;">', '/assets/upload_image/'), array('<p style="text-align: justify; margin: 0px;">', 'https://schuler.id/assets/upload_image/'), $ds['soal']) ?></div>
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
                                        <div class="answare-text" id="explain__part"><?= str_replace(array('<p style="text-align: justify;">', '/assets/upload_image/'), array('<p style="text-align: justify; margin: 0px;">', 'https://schuler.id/assets/upload_image/'), $ds['pembahasan']) ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
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