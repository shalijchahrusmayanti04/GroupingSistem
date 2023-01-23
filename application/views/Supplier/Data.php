<div class="row" style="font-size: 16px;">
  <div class="col">
    <div class="card shadow mb-3">
      <div class="card-body">
        <?= strtoupper($judul); ?>
        <a href="<?= site_url('Supplier/tambah'); ?>" class="btn btn-primary btn-circle btn-sm float-right" style="margin-left: 10px;" title="TAMBAH VENDOR" type="button"><i class="fa fa-plus"></i></a>
        <a href="<?= site_url('Supplier/cetak'); ?>" class="btn btn-warning btn-circle btn-sm float-right" target="_blank" title="CETAK" type="button"><i class="fa fa-print"></i></a>
      </div>
    </div>
  </div>
</div>
<div class="row" style="font-size: 14px;">
  <div class="col">
    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table id="master_datatable" class="table table-triped table-hover table-bordered">
            <thead>
              <tr class="text-center bg-dark text-white">
                <th width="5%">NO</th>
                <th>NAMA</th>
                <th>NPWP</th>
                <th>NO. TELEPON/WHATSAPP</th>
                <th>ALAMAT</th>
                <th>AKSI</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($vendor as $v) : ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td><?= $v->nama; ?></td>
                  <td><?= $v->npwp; ?></td>
                  <td><?= $v->no_telepon_whatsapp; ?></td>
                  <td><?= $v->alamat; ?></td>
                  <td class="text-center">
                    <?php $sql = $this->db->query("SELECT * FROM in_header WHERE id_supplier = '$v->id'")->num_rows(); ?>
                    <a href="<?= site_url('Supplier/ubah/') . $v->id; ?>" type="button" class="btn btn-sm btn-circle btn-warning" title="UBAH"><i class="fa fa-edit"></i></a>
                    <?php if ($sql < 1) : ?>
                      <button type="button" class="btn btn-sm btn-circle btn-danger" title="HAPUS" onclick="hapus('<?= $v->id; ?>')"><i class="fa fa-trash"></i></button>
                    <?php else : ?>
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
          url: "<?= site_url('Supplier/hapus/') ?>" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                title: 'HAPUS DATA',
                html: 'Berhasil dilakukan',
                icon: 'success',
              }).then((value) => {
                location.href = "<?php echo base_url() ?>Supplier";
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