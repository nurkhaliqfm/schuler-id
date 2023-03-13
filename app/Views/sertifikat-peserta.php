<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sertifikat Simulasi SNBT 2023 | Schuler.Id</title>
    <!-- Fav Icon -->
    <link
      rel="icon"
      type="image/x-icon"
      href="https://schuler.id/assets/img/favicon.png"
    />

    <style>
      * {
        box-sizing: border-box;
      }
      
      .kartu__container{
          background-image: url("https://schuler.id/assets/img/garuda.png");
          opacity: 0.05;
          background-repeat: no-repeat;
          background-size:cover;
      }

      .item_kartu {
        margin: 10px;
        padding: 10px;
      }
      
      .item_kartu.header-part{
        border-bottom: 3px solid black;
      }

      .header_box {
        margin-left: auto;
        margin-right: auto;
      }

      .ttd {
        /*color: rgb(1, 166, 243);*/
      }

      .ttd_item .ttd_name {
        margin-bottom: 60px;
      }

      /*table tr td {*/
      /*  color: rgb(1, 166, 243);*/
      /*}*/

      .title-table {
        font-size: 1.1rem;
        /*color: rgb(0, 110, 255);*/
        font-weight: 600;
        padding: 8px 0px 2px 0px;
      }

      .title {
        font-size: 1.5rem;
        color: rgb(0, 110, 255);
        font-weight: 700;
        max-width: 400px;
        text-align: center;
      }

      .subtitle {
        font-size: 1.2rem;
        color: rgb(1, 166, 243);
        text-align: center;
      }
      
      img {
        width: 180px;
      }

      .header_box img {
        width:120px;
        margin-bottom: 10px;
        padding: 0px 40px 5px 40px;
      }
    </style>
  </head>

  <body>
    <div id="kartu-section" class="container__body kartu__container">
      <div class="item_kartu header-part">
        <table class="header_box">
          <tr>
            <td>
              <div style="text-align: center">
                <img
                  class="logo"
                  src="https://schuler.id/assets/img/medc.png"
                  alt="Logo"
                />
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="subtitle">SERTIFIKAT HASIL</div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="title">SIMULASI UJIAN TULIS BERBASIS KOMPUTER TAHUN 2023</div>
            </td>
          </tr>
        </table>
      </div>
      <div class="item_kartu">
        <table>
          <tr>
            <td width="170">NOMOR PESERTA</td>
            <td width="10">:</td>
            <td><?= $nomor_peserta ?></td>
          </tr>
          <tr>
            <td>NAMA PESERTA</td>
            <td>:</td>
            <td><?= strtoupper($peserta_name) ?></td>
          </tr>
          <tr>
            <td>TANGGAL LAHIR</td>
            <td>:</td>
            <td><?= $tgl_lahir ?></td>
          </tr>
          <tr>
            <td>NISN</td>
            <td>:</td>
            <td><?= $nisn ?></td>
          </tr>
          <tr>
            <td>ASAL SEKOLAH</td>
            <td>:</td>
            <td><?= strtoupper($pusat_simulasi) ?></td>
          </tr>
        </table>
      </div>
      <div class="item_kartu">
        <table>
          <tr>
            <td>Telah mengikuti simuasi UTBK-SBNT 2023 pada Tanggal 13 Desember 2022 dengan Nilai Sebagai berikut:</td>
          </tr>
        </table>
      </div>
      <div class="item_kartu">
        <table>
          <tr>
            <td rowspan="8" width="200">
                <img
                  class="qr-code"
                  src="https://schuler.id/assets/img/qr-code.png"
                  alt="Logo"
                />
            </td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td width="180">Penalaran Umum</td>
            <td width="10">:</td>
            <td><?= $poin['Penalaran Umum']['Poin'] ?></td>
          </tr>
          <tr>
            <td>Pemahaman Bacaan & Menulis</td>
            <td>:</td>
            <td><?= $poin['Pemahaman Bacaan & Menulis']['Poin'] ?></td>
          </tr>
          <tr>
            <td>Pengetahuan & Pemahaman Umum</td>
            <td>:</td>
            <td><?= $poin['Pengetahuan & Pemahaman Umum']['Poin'] ?></td>
          </tr>
          <tr>
            <td>Pengetahuan Kuantitatif</td>
            <td>:</td>
            <td><?= $poin['Pengetahuan Kuantitatif']['Poin'] ?></td>
          </tr>
          <tr>
            <td>Literasi Bahasa Indonesia</td>
            <td>:</td>
            <td><?= $poin['Literasi Bahasa Indonesia']['Poin'] ?></td>
          </tr>
          <tr>
            <td>Literasi Bahasa Inggris</td>
            <td>:</td>
            <td><?= $poin['Literasi Bahasa Inggris']['Poin'] ?></td>
          </tr>
          <tr>
            <td>Penalaran Matematika</td>
            <td>:</td>
            <td><?= $poin['Penalaran Matematika']['Poin'] ?></td>
          </tr>
        </table>
      </div>
    </div>
  </body>
</html>
