<div class="h3 text-center font-weight-bold"><?= $judul; ?></div>
<div class="h6 text-center"><?= $tanggal; ?></div>
<hr>
<div class="row">
  <div class="col">
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
          foreach ($sql as $d) : ?>
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