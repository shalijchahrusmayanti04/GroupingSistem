<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-6">
        <div class="h3">
          <?= $judul; ?>
          <button type="button" class="btn btn-primary btn-sm mb-3 btn-circle float-right" title="Tambah" onclick="tambah_data()"><i class="fa fa-plus-circle"></i></button>
        </div>
        <hr>
        <div class="table-responsive">
          <button class="btn btn-warning btn-sm" onclick="cetak()"><i class="fa fa-print"></i> Cetak</button>
          <table id="master_datatable" class="table table-striped table-hover table-bordered" style="font-size: 15px;">
            <thead>
              <tr class="text-center">
                <th class="table-dark" width="5%">No</th>
                <th class="table-dark">Jenis Barang</th>
                <th class="table-dark" width="20%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($data as $d) : ?>
                <tr>
                  <td class="text-right"><?= $no++; ?></td>
                  <td><?= $d->jenis_barang; ?></td>
                  <td class="text-center">
                    <button type="button" class="btn btn-warning btn-sm btn-circle" title="Ubah" onclick="ubah_data('<?= $d->id; ?>')"><i class="fa fa-edit"></i></button>
                    <?php $cek = $this->db->get_where("barang", ["id_jenis" => $d->id])->num_rows(); ?>
                    <?php if ($cek > 0) : ?>
                      <button type="button" class="btn btn-danger btn-sm btn-circle" title="Hapus" disabled><i class="fa fa-trash"></i></button>
                    <?php else : ?>
                      <button type="button" class="btn btn-danger btn-sm btn-circle" title="Hapus" onclick="hapus_data('<?= $d->id; ?>')"><i class="fa fa-trash"></i></button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-6" id="form">
        <div class="card">
          <div class="card-body">
            <span id="title"></span>
            <button type="button" class="btn btn-danger float-right btn-sm btn-circle" title="Tutup" onclick="hide_form()"><i class="fa fa-times"></i></button>
            <hr>
            <form id="form-data" method="POST" style="font-size: 15px;">
              <div class="form-group">
                <label>Jenis Barang</label>
                <input type="hidden" class="form-control" id="id" name="id">
                <input type="text" class="form-control" id="jenis_barang" name="jenis_barang">
              </div>
              <button type="button" id="btn-aksi" onclick="aksi()"><i id="i-icon"></i> <span id="btn-form"></span></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $("#form").hide();

  function hide_form() {
    $("#form").hide(200);
  }

  function tambah_data() {
    $("#form").show(200);
    $("#title").text("Tambah Data");
    $("#btn-form").text("Simpan");
    $("#btn-aksi").removeClass("btn btn-sm btn-warning");
    $("#btn-aksi").addClass("btn btn-sm btn-primary");
    $("#i-icon").addClass("fa fa-save");
    $("#id").val('');
    $("#jenis_barang").val('');
  }

  function ubah_data(id) {
    $.ajax({
      url: "<?= site_url('jenis_barang/get_data/') ?>" + id,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $("#id").val(data.id);
        $("#jenis_barang").val(data.jenis_barang);

        $("#form").show(200);
        $("#title").text("Ubah Data");
        $("#btn-form").text("Ubah");
        $("#btn-aksi").removeClass("btn btn-sm btn-primary");
        $("#btn-aksi").addClass("btn btn-sm btn-warning");
        $("#i-icon").addClass("fa fa-edit");
      }
    })
  }

  function aksi() {
    var id = $("#id").val();
    var jenis_barang = $("#jenis_barang").val();
    var text = $("#btn-form").text();
    if (text == 'Simpan') {
      var url = '<?= site_url("jenis_barang/olahdata/1"); ?>';
      var cek_text = "TAMBAH";
    } else {
      var url = '<?= site_url("jenis_barang/olahdata/2"); ?>';
      var cek_text = "UBAH";
    }
    if (jenis_barang == '' || jenis_barang == null) {
      Swal.fire({
        title: 'NAMA jenis_barang',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    } else {
      $.ajax({
        url: url + "?jenis_barang=" + jenis_barang + "&id=" + id,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            Swal.fire({
              title: cek_text + ' DATA',
              html: 'Berhasil dilakukan',
              icon: 'success',
            }).then((value) => {
              location.href = "<?php echo base_url() ?>jenis_barang";
            });
          } else {
            Swal.fire({
              title: cek_text + ' DATA',
              html: 'Gagal dilakukan !',
              icon: 'error'
            });
          }
        }
      });
    }
  }

  function hapus_data(id) {
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
          url: "<?= site_url('jenis_barang/hapus/') ?>" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                title: 'HAPUS DATA',
                html: 'Berhasil dilakukan',
                icon: 'success',
              }).then((value) => {
                location.href = "<?php echo base_url() ?>jenis_barang";
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
      text: "Master jenis_barang ?",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Cetak',
      CancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        window.open('<?= site_url("jenis_barang/cetak") ?>', 'blank');
      }
    })
  }
</script>