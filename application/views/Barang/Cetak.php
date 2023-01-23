<div class="h3 text-center font-weight-bold"><?= $judul; ?></div>
<div class="h6 text-center"><?= $tanggal; ?></div>
<hr>
<div class="row">
  <div class="col">
    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered">
        <thead>
          <tr class="text-center">
            <th class="table-dark" width="5%">NO</th>
            <th class="table-dark">KODE BARANG</th>
            <th class="table-dark">NAMA BARANG</th>
            <th class="table-dark">JENIS</th>
            <th class="table-dark">HARGA</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($sql as $s) :
          ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $s->kode_barang; ?></td>
              <td><?= $s->nama; ?></td>
              <td><?= $s->jenis_barang; ?></td>
              <td>Rp. <span class="float-right"><?= number_format($s->harga); ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>