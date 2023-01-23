<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?= $judul; ?></title>
  <link href="<?= site_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?= site_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/tables/DataTables-1.11.5/css/jquery.dataTables.min.css" type="text/css">
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/tables/DataTables-1.11.5/css/dataTables.bootstrap4.min.css" type="text/css">
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/tables/Buttons-2.2.2/css/buttons.bootstrap4.min.css" type="text/css">
  <script src="<?= base_url('assets'); ?>/sweetalert/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/sweetalert/dist/sweetalert2.min.css">
  <script src="<?= base_url('assets'); ?>/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets'); ?>/js/Chart.js"></script>
  <script src="<?= base_url('assets'); ?>/js/jquery-3.5.1.js"></script>
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/select2/dist/css/select2.min.css">
  <script src="<?= base_url('assets'); ?>/select2/dist/js/select2.min.js" type="text/javascript"></script>
</head>

<body id="page-top" style="font-size: 15px;">
  <div class="container-fluid">
    <div class="h3 text-center font-weight-bold"><?= $judul; ?></div>
    <div class="h6 text-center"><?= date("d-m-Y", strtotime($dari)); ?> s/d <?= date("d-m-Y", strtotime($sampai)); ?></div>
    <hr>
    <table border="0">
      <tr>
        <td>KODE BARANG</td>
        <td>:</td>
        <td><?= $kode_barang; ?></td>
      </tr>
      <tr>
        <td>NAMA BARANG</td>
        <td>:</td>
        <td><?= $barang; ?></td>
      </tr>
      <tr>
        <td>JENIS BARANG</td>
        <td>:</td>
        <td><?= $jenis; ?></td>
      </tr>
    </table>
    <br>
    <div class="row">
      <div class="col">
        <div class="table-responsive">
          <table class="table table-striped table-hover table-bordered">
            <thead>
              <tr class="text-center">
                <th class="table-dark">NO</th>
                <th class="table-dark">KETERANGAN</th>
                <th class="table-dark">TANGGAL</th>
                <th class="table-dark">JAM</th>
                <th class="table-dark">REKANAN</th>
                <th class="table-dark">MASUK</th>
                <th class="table-dark">KELUAR</th>
                <th class="table-dark">SALDO</th>
              </tr>
              <tr>
                <th>#</th>
                <th colspan="6">SALDO AWAL</th>
                <td><span class="float-right"><?= number_format($sa); ?></span></td>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              $saldox = 0;
              foreach ($data_x as $d) :
                $saldox += $d->masuk - $d->keluar;
                $saldo = $sa + $saldox;
              ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td>TRANSAKSI <?= $d->keterangan; ?></td>
                  <td><?= date("d-m-Y", strtotime($d->tanggal)); ?></td>
                  <td><?= date("H:i:s", strtotime($d->jam)); ?></td>
                  <td><?= $d->rekanan; ?></td>
                  <td><span class="float-right"><?= number_format($d->masuk); ?></span></td>
                  <td><span class="float-right"><?= number_format($d->keluar); ?></span></td>
                  <td><span class="float-right"><?= number_format($saldo); ?></span></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= site_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= site_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?= site_url('assets/'); ?>js/sb-admin-2.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/DataTables-1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/DataTables-1.11.5/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/Buttons-2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/Buttons-2.2.2/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/JSZip-2.5.0/jszip.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/Buttons-2.2.2/js/buttons.html5.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/Buttons-2.2.2/js/buttons.print.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/Buttons-2.2.2/js/buttons.colVis.min.js"></script>
  <script src="<?= base_url('assets'); ?>/sweetalert/dist/sweetalert2.all.min.js"></script>
</body>

</html>