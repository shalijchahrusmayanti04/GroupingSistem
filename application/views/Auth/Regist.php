<div class="container">
  <div class="row mt-5">
    <div class="col text-center">
      <h1 class="text-white"><?= $judul; ?></h1>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-xl-6 col-lg-12 col-md-9">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">FORM DAFTAR</h1>
                </div>
                <hr>
                <form class="user" method="POST" id="form_regist">
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <input type="text" class="form-control form-control" id="username" name="username" placeholder="Masukan Username...">
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <input type="password" class="form-control form-control" id="password" name="password" placeholder="Masukan Sandi...">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <input type="text" class="form-control form-control" id="nama" name="nama" placeholder="Masukan Nama...">
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <input type="number" maxlength="15" minlength="3" class="form-control form-control" id="No.Telepon/Whatsapp" name="No.Telepon/Whatsapp" placeholder="Masukan No HP...">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan Alamat..."></textarea>
                    </div>
                  </div>
                  <br>
                  <button class="btn btn-primary btn-block" type="button" onclick="daftar()">Daftar</button>
                </form>
                <hr>
                <div class="text-center">
                  <a class="small" href="<?= site_url('Auth') ?>">Sudah Punya Akun !</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function daftar() {
    var username = $("#username").val();
    var password = $("#password").val();
    var nama = $("#nama").val();
    var No_Telepon_Whatsapp = $("#No.Telepon/Whatsapp").val();
    var alamat = $("#alamat").val();
    if (username == '') {
      Swal.fire({
        title: 'USERNAME',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (password == '') {
      Swal.fire({
        title: 'PASSWORD',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (nama == '') {
      Swal.fire({
        title: 'NAMA',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (No.Telepon/Whatsapp == '') {
      Swal.fire({
        title: 'No.Telepon/Whatsapp',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (alamat == '') {
      Swal.fire({
        title: 'ALAMAT',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (username != '' && password != '' && nama != '' && No.Telepon/Whatsapp != '' && alamat != '') {
      $.ajax({
        url: "<?= site_url('Auth/cekuser_regist/') ?>" + username,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $.ajax({
              url: "<?= site_url('Auth/daftarkan/') ?>" + username,
              data: $('#form_regist').serialize(),
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                if (data.status == 1) {
                  Swal.fire({
                    title: 'DAFTAR',
                    html: 'Berhasil dilakukan',
                    icon: 'success',
                  }).then((value) => {
                    location.href = "<?php echo base_url() ?>Auth";
                  });
                } else {
                  Swal.fire({
                    title: 'DAFATR',
                    html: 'Gagal Dilakukan !',
                    icon: 'error',
                  });
                }
              }
            });
          } else {
            Swal.fire({
              title: 'USERNAME',
              html: 'Sudah digunakan !',
              icon: 'error',
            });
          }
        }
      });
    }
  }
</script>