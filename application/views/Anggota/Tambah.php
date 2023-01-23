<div class="row" style="font-size: 18px;">
  <div class="col">
    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="h4">TAMBAH ANGGOTA
          <a href="<?= site_url('Member'); ?>" type="button" class="btn btn-sm btn-circle btn-danger float-right" title="KEMBALI"><i class="fa fa-arrow-left"></i></a>
        </div>
        <hr>
        <form method="POST" id="tambah_anggota" style="font-size: 14px;">
          <div class="row">
            <div class="col-6 offset-3">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="username">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" id="username" class="form-control">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="Password" name="password" id="password" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="no_telepon_whatsapp">No. Telepon/Whatsapp <span class="text-danger">*</span></label>
                    <input type="number" name="no_telepon_whatsapp" id="no_telepon_whatsapp" class="form-control">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="id_role">Sebagai <span class="text-danger">*</span></label>
                    <select name="id_role" id="id_role" class="form-control">
                      <?php foreach ($sebagai as $r) : ?>
                        <option value="<?= $r->id_role ?>"><?= $r->role; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control"></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <button type="button" class="btn btn-sm btn-primary float-right" onclick="aksi()"><i class="fa fa-user-plus"></i> Tambah</button>
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
    var password = $("#password").val();
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
    if (password == '' || password == null) {
      Swal.fire({
        title: 'PASSWORD',
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
        title: 'NO TELEPON/WHATSAPP',
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
    if (username != '' || username != null && password != '' || password != null && nama != '' || nama != null && no_telepon_whatsapp != '' || no_telepon_whatsapp != null && alamat != '' || alamat != null) {
      $.ajax({
        url: "<?= site_url('Member/tambahkan') ?>",
        data: $('#tambah_anggota').serialize(),
        dataType: "JSON",
        type: "POST",
        success: function(data) {
          if (data.status == 1) {
            Swal.fire({
              title: 'DATA NGGOTA',
              html: 'Berhasil ditambahkan',
              icon: 'success',
            }).then((value) => {
              location.href = "<?php echo base_url() ?>Member";
            });
          } else {
            Swal.fire({
              title: 'DATA ANGGOTA',
              html: 'Gagal ditambahkan !',
              icon: 'error'
            });
          }
        }
      });
    }
  }
</script>