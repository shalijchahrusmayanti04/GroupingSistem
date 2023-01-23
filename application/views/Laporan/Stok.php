<div class="row" style="font-size: 15px;">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="h4">
          <?= $judul; ?>
          <button class="btn btn-warning btn-sm float-right" onclick="cetak()"><i class="fa fa-print"></i> Cetak</button>
        </div>
        <hr>
        <div class="table-responsive">
          <table id="master_datatable" class="table table-striped table-hover table-bordered">
            <thead>
              <tr class="text-center">
                <th class="table-dark">NO</th>
                <th class="table-dark">NAMA BARANG</th>
                <th class="table-dark">JENIS BARANG</th>
                <th class="table-dark">HARGA SATUAN</th>
                <th class="table-dark">TERIMA</th>
                <th class="table-dark">KELUAR</th>
                <th class="table-dark">STOK AKHIR</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($data as $d) : ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $d->nama; ?></td>
                  <td><?= $d->jenis_barang; ?></td>
                  <td>Rp. <span class="float-right"><?= number_format($d->harga); ?></span></td>
                  <td><span class="float-right"><?= number_format($d->stok_in); ?></span></td>
                  <td><span class="float-right"><?= number_format($d->stok_out); ?></span></td>
                  <td><span class="float-right"><?= number_format($d->stok_hasil); ?></span></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function cetak() {
    Swal.fire({
      title: 'CETAK DATA',
      text: "Daftar Stok ?",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Cetak',
      CancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        window.open('<?= site_url("Laporan/cetak_ds") ?>', 'blank');
      }
    })
  }
</script>