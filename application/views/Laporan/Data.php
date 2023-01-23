<div class="row" style="font-size: 15px;">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="h4"><?= $judul; ?> Perbarang</div>
        <hr>
        <div class="row">
          <div class="col-6 offset-3">
            <form method="POST" id="form-laporan">
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Barang</label>
                <div class="col-sm-10">
                  <select name="kode_barang" id="kode_barang" class="form-control select2_barang"></select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Dari</label>
                <div class="col-sm-10">
                  <input type="date" name="dari" id="dari" class="form-control" value="<?= date('Y-m-d'); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Sampai</label>
                <div class="col-sm-10">
                  <input type="date" name="sampai" id="sampai" class="form-control" value="<?= date('Y-m-d'); ?>">
                </div>
              </div>
              <button class="btn btn-primary btn-sm float-right" type="button" onclick="_cetak()"><i class="fa fa-print"></i> Cetak</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function _cetak() {
    var kode_barang = $("#kode_barang").val();
    var dari = $("#dari").val();
    var sampai = $("#sampai").val();
    if (kode_barang == '' || kode_barang == null) {
      Swal.fire({
        title: 'BARANG',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
    } else {
      param = "?kode_barang=" + kode_barang + "&dari=" + dari + "&sampai=" + sampai
      window.open('<?= site_url("Laporan/kartu_stok") ?>' + param, 'blank');
    }
  }
</script>