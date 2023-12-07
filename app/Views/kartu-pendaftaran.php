<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kartu Pendaftaran Simulasi SNBT 2023 | Schuler.Id</title>
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

      .item_kartu {
        border: 1px solid rgb(0, 0, 0);
        margin: 10px;
        padding: 10px;
      }

      .header_box {
        margin-left: auto;
        margin-right: auto;
      }

      .ttd {
        color: rgb(1, 166, 243);
      }

      .ttd_item .ttd_name {
        margin-bottom: 60px;
      }

      table tr td {
        color: rgb(1, 166, 243);
      }

      .title-table {
        font-size: 1.1rem;
        color: rgb(0, 110, 255);
        font-weight: 600;
        padding: 8px 0px 2px 0px;
      }

      .title {
        font-size: 2rem;
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
        width: 200px;
        margin-bottom: 10px;
        border-bottom: 2px solid rgb(206, 206, 206);
        padding: 0px 40px 5px 40px;
      }
    </style>
  </head>

  <body>
    <div id="kartu-section" class="container__body kartu__container">
      <div class="item_kartu">
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
              <div class="subtitle">KARTU TANDA PESERTA</div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="title">SIMULASI UTBK-SNBT TAHUN 2023</div>
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
            <td><?= $peserta_name ?></td>
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
        </table>
      </div>
      <div class="item_kartu">
        <table>
          <tr>
            <td colspan="3" class="title-table">JADWAL SIMULASI</td>
          </tr>
          <tr>
            <td width="170">HARI</td>
            <td width="10">:</td>
            <td><?= $hari ?></td>
          </tr>
          <tr>
            <td>TANGGAL</td>
            <td>:</td>
            <td><?= $tanggal ?></td>
          </tr>
          <tr>
            <td>JAM/SESI</td>
            <td>:</td>
            <td><?= $jam ?></td>
          </tr>
          <tr>
            <td colspan="3" class="title-table">LOKASI SIMULASI</td>
          </tr>
          <tr>
            <td>PUSAT SIMULASI</td>
            <td>:</td>
            <td><?= $pusat_simulasi ?></td>
          </tr>
          <tr>
            <td>RUANGAN</td>
            <td>:</td>
            <td><?= $ruangan ?></td>
          </tr>
          <tr>
            <td colspan="3" class="title-table">PILIHAN KAMPUS IMPIAN</td>
          </tr>
          <tr>
            <td>PERGURUAN TINGGI</td>
            <td>:</td>
            <td><?= $universitas_pilihan ?></td>
          </tr>
        </table>
      </div>
      <div class="item_kartu ttd">
        <table style="margin-left: auto; margin-right: auto">
          <tr>
            <td>
              <div class="ttd_name" style="text-align: center">Peserta</div>
            </td>
            <td width="40%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>
              <div class="ttd_name" style="text-align: center">Verifikator</div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="ttd_place">
                .......................................
              </div>
            </td>
            <td></td>
            <td>
              <div class="ttd_place">
                .......................................
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </body>
</html>
