<div class="row" style="font-size: 18px;">
  <div class="col">
    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="h4">UBAH ANGGOTA
          <a href="<?= site_url('Member'); ?>" type="button" class="btn btn-sm btn-circle btn-danger float-right" title="KEMBALI"><i class="fa fa-arrow-left"></i></a>
        </div>
        <hr>
        <form method="POST" id="ubah_anggota" style="font-size: 14px;">
          <div class="row">
            <div class="col-6 offset-3">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="username">Username <span class="text-danger">*</span></label>
                    <input type="hidden" name="id" id="id" class="form-control" value="<?= $anggota->id; ?>">
                    <input type="text" name="username" id="username" class="form-control" value="<?= $anggota->username; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" value="<?= $anggota->nama; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="no_telepon_whatsapp">No. HP <span class="text-danger">*</span></label>
                    <input type="number" name="no_telepon_whatsapp" id="no_telepon_whatsapp" class="form-control" value="<?= $anggota->no_telepon_whatsapp; ?>">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="id_role">Sebagai <span class="text-danger">*</span></label>
                    <select name="id_role" id="id_role" class="form-control">
                      <?php foreach ($sebagai as $r) : ?>
                        <?php if ($anggota->id_role == $r->id_role) {
                          $slc = 'selected';
                        } else {
                          $slc = '';
                        } ?>
                        <option value="<?= $r->id_role ?>" <?= $slc; ?>><?= $r->role; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control"><?= $anggota->alamat; ?></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <button type="button" class="btn btn-sm btn-warning float-right" onclick="aksi()"><i class="fa fa-edit"></i> Ubah</button>
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
    var username = $("#username").val();
    var nama = $("#nama").val();
    var alamat = $("#alamat").val();
    var no_telepon_whatsapp = $("#no_telepon_whatsapp").val();
    if (username == '' || username == null) {
      Swal.fire({
        title: 'USERNAME',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (nama == '' || nama == null) {
      Swal.fire({
        title: 'NAMA',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (no_telepon_whatsapp == '' || no_telepon_whatsapp == null) {
      Swal.fire({
        title: 'NO HP',
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
    if (username != '' || username != null && nama != '' || nama != null && no_telepon_whatsapp != '' || no_telepon_whatsapp != null && alamat != '' || alamat != null) {
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
            url: "<?= site_url('Member/ubahkan') ?>",
            data: $('#ubah_anggota').serialize(),
            dataType: "JSON",
            type: "POST",
            success: function(data) {
              if (data.status == 1) {
                Swal.fire({
                  title: 'DATA NGGOTA',
                  html: 'Berhasil diubah',
                  icon: 'success',
                }).then((value) => {
                  location.href = "<?php echo base_url() ?>Member";
                });
              } else {
                Swal.fire({
                  title: 'DATA ANGGOTA',
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