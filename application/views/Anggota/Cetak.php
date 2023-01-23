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
            <th class="table-dark">USERNAME</th>
            <th class="table-dark">NAMA</th>
            <th class="table-dark">ALAMAT</th>
            <th class="table-dark">NO TELEPON/WHASTAPP</th>
            <th class="table-dark">SEBAGAI</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($sql as $s) :
          ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $s->username; ?></td>
              <td><?= $s->nama; ?></td>
              <td><?= $s->alamat; ?></td>
              <td><?= $s->no_telepon_whatsapp; ?></td>
              <td><?= $s->role; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>