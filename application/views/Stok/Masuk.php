<div class="row" id="depan">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="h4">
          History <?= $judul; ?>
          <a href="<?= site_url('Stok/in_entri'); ?>" type="button" class="btn btn-primary btn-sm btn-circle float-right" title="Tambah"><i class="fa fa-plus"></i></a>
        </div>
        <hr>
        <button class="btn btn-warning btn-sm" onclick="cetak()"><i class="fa fa-print"></i> Cetak</button>
        <table id="master_datatable" class="table table-striped table-hover table-bordered" style="font-size: 15px;">
          <thead>
            <tr class="text-center">
              <th width="5%" class="table-dark">No</th>
              <th class="table-dark">Invoice</th>
              <th class="table-dark">Supplier</th>
              <th class="table-dark">Tanggal Masuk</th>
              <th class="table-dark">Jam Masuk</th>
              <th class="table-dark">Total</th>
              <th class="table-dark">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($data_header as $dh) : ?>
              <tr>
                <td class="text-right"><?= $no++; ?></td>
                <td><?= $dh->invoice_masuk; ?></td>
                <td>
                  <?php $sql = $this->db->get_where('supplier', ['id' => $dh->id_supplier])->row(); ?>
                  <?= $sql->nama; ?>
                </td>
                <td class="text-center"><?= date("D, d-m-Y", strtotime($dh->tgl)); ?></td>
                <td class="text-center"><?= date("H:i:s", strtotime($dh->jam)); ?></td>
                <td>Rp. <span class="float-right"><?= number_format($dh->total); ?></span></td>
                <td class="text-center">
                  <?php if ($this->session->userdata('id_role') == 1) : ?>
                    <a href="<?= site_url('Stok/in_edit/') . $dh->invoice_masuk ?>" class="btn btn-warning btn-sm btn-circle" type="button"><i class="fa fa-edit"></i></a>
                    <button class="btn btn-info btn-sm btn-circle" title="Cetak" type="button" onclick="cetak_x('<?= $dh->invoice_masuk; ?>')"><i class="fa fa-print"></i></button>
                    <button class="btn btn-danger btn-sm btn-circle" type="button" onclick="hapus('<?= $dh->invoice_masuk; ?>')"><i class="fa fa-trash"></i></button>
                  <?php else : ?>
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

<script>
  function hapus(invoice) {
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
          url: "<?= site_url('Stok/in_hapus/') ?>" + invoice,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                title: 'HAPUS DATA',
                html: 'Berhasil dilakukan',
                icon: 'success',
              }).then((value) => {
                location.href = "<?= base_url() ?>Stok/in";
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

  function cetak() {
    Swal.fire({
      title: 'CETAK DATA',
      text: "Stok Masuk ?",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Cetak',
      CancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        window.open('<?= site_url("Stok/cetak_in") ?>', 'blank');
      }
    })
  }

  function cetak_x(param) {
    window.open('<?= site_url("Stok/cetak_in_x/") ?>' + param, 'blank');
  }
</script>