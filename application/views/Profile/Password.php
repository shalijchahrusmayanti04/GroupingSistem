<form method="POST" id="fom_pass">
  <div class="row" style="font-size: 14px;">
    <div class="col">
      <div class="card shadow mb-3">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="pass1">Password Baru</label>
                <input type="text" name="password1" id="password1" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="pass2">Ulangi Password Baru</label>
                <input type="text" name="password2" id="password2" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <button class="btn btn-primary btn-sm" type="button" id="btnsimpan" onclick="simpan()"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  function simpan() {
    var password1 = $("#password1").val();
    var password2 = $("#password2").val();
    if (password1 == '') {
      Swal.fire({
        title: 'PASSWORD BARU',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (password2 == '') {
      Swal.fire({
        title: 'ULANGI PASSWORD BARU',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (password1 != password2) {
      Swal.fire({
        title: 'PASSWORD',
        html: 'Harus Sama !',
        icon: 'error',
      });
    } else {
      Swal.fire({
        title: 'UBAH PASSWORD',
        text: "Yakin ingin mengubah password ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ubah',
        CancelButtonText: 'Tidak'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= site_url('Profile/simpan_password') ?>",
            data: $('#fom_pass').serialize(),
            dataType: "JSON",
            type: "POST",
            success: function(data) {
              if (data.status == 1) {
                Swal.fire({
                  title: 'PASSWORD',
                  html: 'Berhasil diubah',
                  icon: 'success',
                }).then((value) => {
                  location.href = "<?php echo base_url() ?>Profile/ubah_password";
                });
              } else {
                Swal.fire({
                  title: 'PASSWORD',
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