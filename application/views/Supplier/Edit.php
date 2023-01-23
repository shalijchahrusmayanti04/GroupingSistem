<div class="row" style="font-size: 18px;">
  <div class="col">
    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="h4">UBAH SUPPLIER
          <a href="<?= site_url('Supplier'); ?>" type="button" class="btn btn-sm btn-circle btn-danger float-right" title="KEMBALI"><i class="fa fa-arrow-left"></i></a>
        </div>
        <hr>
        <form method="POST" id="ubah_Supplier" style="font-size: 14px;">
          <div class="row">
            <div class="col-6 offset-3">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="nama">Nama <span class="text-danger">*</span></label>
                    <input type="hidden" name="id" id="id" class="form-control" value="<?= $supplier->id; ?>">
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $supplier->nama; ?>">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="no_telepon_whatsapp">No. Telepon/Whatsapp <span class="text-danger">*</span></label>
                    <input type="number" name="no_telepon_whatsapp" id="no_telepon_whatsapp" class="form-control" value="<?= $supplier->no_telepon_whatsapp; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="npwp">NPWP <span class="text-danger">*</span></label>
                    <input type="text" name="npwp" id="npwp" class="form-control" value="<?= $supplier->npwp; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control"><?= $supplier->alamat; ?></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <button type="button" class="btn btn-sm btn-warning float-right" onclick="aksi()"><i class="fa fa-edit"></i> Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function aksi() {
    var id = $("#id").val();
    var nama = $("#nama").val();
    var alamat = $("#alamat").val();
    var no_telepon_whatsapp = $("#no_telepon_whatsapp").val();
    var npwp = $("#npwp").val();
    if (nama == '' || nama == null) {
      Swal.fire({
        title: 'NAMA',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (npwp == '' || npwp == null) {
      Swal.fire({
        title: 'NPWP',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (no_telepon_whatsapp == '' || no_telepon_whatsapp == null) {
      Swal.fire({
        title: 'No. Telepon/Whatsapp',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (alamat == '' || alamat == null) {
      Swal.fire({
        title: 'ALAMAT',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    var param = '?id=' + id + '&nama=' + nama + '&npwp=' + npwp + '&alamat=' + alamat + '&no_telepon_whatsapp=' + no_telepon_whatsapp;
    if (nama != '' || nama != null && npwp != '' || npwp != null && no_telepon_whatsapp != '' || no_telepon_whatsapp != null && alamat != '' || alamat != null) {
      Swal.fire({
        title: 'UBAH DATA',
        text: "Yakin ingin mengubah data ini ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ubah',
        CancelButtonText: 'Tidak'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= site_url('Supplier/ubahkan') ?>"+param,
            data: $('#ubah_supplier').serialize(),
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              if (data.status == 1) {
                Swal.fire({
                  title: 'DATA SUPPLIER',
                  html: 'Berhasil diubah',
                  icon: 'success',
                }).then((value) => {
                  location.href = "<?php echo base_url() ?>Supplier";
                });
              } else {
                Swal.fire({
                  title: 'DATA SUPPLIER',
                  html: 'Gagal diubah !',
                  icon: 'error'
                });
              }
            }
          });
        }
      })
    }
  }
</script>