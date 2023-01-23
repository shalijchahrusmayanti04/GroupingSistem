<div class="row" style="font-size: 16px;">
  <div class="col">
    <div class="card shadow mb-3">
      <div class="card-body">
        Selamat Datang <b class="text-primary"><?= strtoupper($sebagai->role); ?></b>
        <a href="<?= site_url('Member/tambah'); ?>" class="btn btn-primary btn-circle btn-sm float-right" style="margin-left: 10px;" title="TAMBAH ANGGOTA" type="button"><i class="fa fa-plus"></i></a>
        <a href="<?= site_url('Member/cetak'); ?>" class="btn btn-warning btn-circle btn-sm float-right" target="_blank" title="CETAK" type="button"><i class="fa fa-print"></i></a>
      </div>
    </div>
  </div>
</div>
<div class="row" style="font-size: 14px;">
  <div class="col">
    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table id="master_datatable" class="table table-striped table-hover table-bordered">
            <thead>
              <tr class="text-center bg-dark text-white">
                <th width="5%">NO</th>
                <th width="10%">PROFILE</th>
                <th>USERNAME</th>
                <th>NAMA</th>
                <th>NO. TELEPONWHATSAPP</th>
                <th>SEBAGAI</th>
                <th>ALAMAT</th>
                <th>AKSI</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($anggota as $a) : ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td class="text-center">
                    <?php if ($a->on_off == 1) {
                      $on = 'green';
                    } else {
                      $on = 'black';
                    } ?>
                    <img src="<?= base_url('assets/img/user/') . $a->image; ?>" width="50px" height="50px" style="border-radius: 50%; border: 2px solid; border-color: <?= $on; ?>;">
                  </td>
                  <td><?= $a->username; ?></td>
                  <td><?= $a->nama; ?></td>
                  <td><?= $a->no_telepon_whatsapp; ?></td>
                  <td class="text-center">
                    <?php if ($a->id_role == 1) {
                      $color = 'btn-primary';
                    } else {
                      $color = 'btn-success';
                    } ?>
                    <button disabled type="button" class="btn <?= $color; ?> btn-sm" style="width: 100%;"><?= strtoupper($a->role); ?></button>
                  </td>
                  <td><?= $a->alamat; ?></td>
                  <td class="text-center">
                    <?php if ($a->on_off == 0) : ?>
                      <a href="<?= site_url('Member/ubah/') . $a->id; ?>" type="button" class="btn btn-sm btn-circle btn-warning" title="UBAH"><i class="fa fa-edit"></i></a>
                      <button type="button" class="btn btn-sm btn-circle btn-danger" title="HAPUS" onclick="hapus('<?= $a->id; ?>')"><i class="fa fa-trash"></i></button>
                    <?php else : ?>
                      <button disabled type="button" class="btn btn-sm btn-circle btn-warning" title="UBAH"><i class="fa fa-edit"></i></button>
                      <button type="button" class="btn btn-sm btn-circle btn-danger" title="HAPUS" disabled><i class="fa fa-trash"></i></button>
                    <?php endif; ?>
                  </td>
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
  function hapus(id) {
    Swal.fire({
      title: 'HAPUS DATA',
      text: "Yakin ingin menghapus data ini ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus',
      CancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Member/hapus/') ?>" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                title: 'HAPUS DATA',
                html: 'Berhasil dilakukan',
                icon: 'success',
              }).then((value) => {
                location.href = "<?php echo base_url() ?>Member";
              });
            } else {
              Swal.fire(
                'HAPUS DATA',
                'Gagal dilakukan !',
                'danger'
              );
            }
          }
        });
      }
    })
  }
</script>