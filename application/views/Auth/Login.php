<div class="container">
  <div class="row mt-5">
    <div class="col text-center">
      <h1 class="text-white"><?= $judul; ?></h1>
      <h3 class="text-white">
          <i class="fa fa-object-group rotate-n-15"></i>
        GROUPING SISTEM
      </h3>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-xl-5 col-lg-12 col-md-9">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">FORM MASUK</h1>
                </div>
                <hr>
                <form class="user" method="POST" id="form_login">
                  <div class="form-group">
                    <input type="text" class="form-control form-control" id="username" name="username" placeholder="Masukan Username...">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control" id="password" name="password" placeholder="Masukan Sandi...">
                  </div>
                  <hr>
                  <button class="btn btn-primary btn-block" type="button" onclick="login()">Masuk</button>
                </form>
                <hr>
                <div class="text-center">
                  <a class="small" href="<?= site_url('Auth/regist') ?>">Buat Akun Baru !</a>
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
  function login() {
    var username = $("#username").val();
    var password = $("#password").val();
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
    if (username != '' && password != '') {
      $.ajax({
        url: "<?= site_url('Auth/cekuser/') ?>" + username,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $.ajax({
              url: "<?= site_url('Auth/cekpassword/') ?>" + username + '/' + password,
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                if (data.status == 1) {
                  Swal.fire({
                    title: 'VALIDASI MASUK',
                    html: 'Sesuai',
                    icon: 'success',
                  }).then((value) => {
                    location.href = "<?php echo base_url() ?>Dashboard";
                  });
                } else {
                  Swal.fire({
                    title: 'PASSWORD',
                    html: 'Salah !',
                    icon: 'error',
                  });
                  return;
                }
              }
            });
          } else {
            Swal.fire({
              title: 'USER',
              html: 'Tidak ada !',
              icon: 'error',
            });
            return;
          }
        }
      });
    }
  }
</script>