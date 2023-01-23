<div class="card">
  <div class="card-body">
    <div class="h3">
      <?= $judul; ?>
      <button type="button" id="btn_tambah_barang" class="btn btn-primary btn-sm mb-3 btn-circle float-right" title="Tambah" onclick="tambah_data_barang()"><i class="fa fa-plus-circle"></i></button>
      <button type="button" id="btn_tutup_barang" class="btn btn-danger btn-sm mb-3 btn-circle float-right" title="Tutup" onclick="tutup_data_barang()"><i class="fa fa-times"></i></button>
    </div>
    <hr>
    <div class="row">
      <div class="col-12" id="data-table">
        <div class="table-responsive">
          <div class="row" style="font-size: 15px;">
            <div class="col-4">
              <select name="jenis" id="jenis" class="form-control select2_jenis" onchange="grouping(this.value)">
                <?php
                if (isset($jenis)) {
                  $datajenis = $this->db->get_where("jenis_barang", ["id" => $jenis])->row();
                  echo "<option value='$jenis' selected>$datajenis->jenis</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-8">
              <button class="btn btn-warning btn-sm float-right" onclick="cetak()"><i class="fa fa-print"></i> Cetak</button>
            </div>
          </div>
          <br>
          <table id="master_datatable" class="table table-striped table-hover table-bordered" style="font-size: 15px;">
            <thead>
              <tr class="text-center">
                <th class="table-dark" width="5%">No</th>
                <th class="table-dark">Kode</th>
                <th class="table-dark">Nama</th>
                <th class="table-dark">Harga</th>
                <th class="table-dark">Jenis Barang</th>
                <th class="table-dark" width="20%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($data as $d) : ?>
                <tr>
                  <td class="text-right"><?= $no++; ?></td>
                  <td><?= $d->kode_barang; ?></td>
                  <td><?= $d->nama; ?></td>
                  <td>Rp. <span class="float-right"><?= number_format($d->harga); ?></span></td>
                  <td>
                    <?php $sql = $this->db->get_where("jenis_barang", ["id" => $d->id_jenis])->row(); ?>
                    <?= $sql->jenis_barang; ?>
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-warning btn-sm btn-circle" title="Ubah" onclick="ubah_data_barang('<?= $d->kode_barang; ?>')"><i class="fa fa-edit"></i></button>
                    <?php
                    $sql2 = $this->db->get_where("transaksi", ['kode_barang' => $d->kode_barang])->num_rows();
                    if ($sql2 > 0) :
                    ?>
                      <button type="button" class="btn btn-danger btn-sm btn-circle" title="Hapus" disabled><i class="fa fa-trash"></i></button>
                    <?php else : ?>
                      <button type="button" class="btn btn-danger btn-sm btn-circle" title="Hapus" onclick="hapus_data_barang('<?= $d->id; ?>')"><i class="fa fa-trash"></i></button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-12" id="form_data">
        <div class="h3">
          <span id="title-form" style="font-size: 18px;"></span>
        </div>
        <div class="row">
          <div class="col-6">
            <hr>
            <form id="form_datax" method="POST" style="font-size: 15px;">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Nama</label>
                    <input type="hidden" class="form-control" id="id" name="id">
                    <input type="text" class="form-control" id="nama" name="nama">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Harga</label>
                    <input type="text" class="form-control" id="harga" name="harga" onchange="forhar()">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Jenis</label>
                    <br>
                    <select name="id_jenis" id="id_jenis" class="form-control select2_jenis" style="width: 100%;"></select>
                  </div>
                </div>
                <div class="col">
                </div>
              </div>
              <button type="button" id="btn-aksi" class="float-right" onclick="aksi()"><i id="i-icon"></i> <span id="btn-form"></span></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $("#btn_tutup_barang").hide();
  $("#form_data").hide();

  function tambah_data_barang() {
    $("#data-table").hide(200);
    $("#btn_tutup_barang").show(200);
    $("#btn_tambah_barang").hide(200);
    $("#form_data").show(200);
    $("#title-form").text("TAMBAH DATA");
    $("#btn-form").text("Simpan");
    $("#btn-aksi").removeClass("btn btn-sm btn-warning");
    $("#btn-aksi").addClass("btn btn-sm btn-primary");
    $("#i-icon").removeClass("fa fa-edit");
    $("#i-icon").addClass("fa fa-save");
  }

  // function ceknama(param) {
  //   $.ajax({
  //     url: "<?= site_url('Barang/ceknama/') ?>" + param,
  //     type: "POST",
  //     dataType: "JSON",
  //     success: function(data) {
  //       if (data.status == 1) {
  //         Swal.fire({
  //           title: 'NAMA BARANG',
  //           html: 'Sudah digunakan',
  //           icon: 'info',
  //         }).then((value) => {
  //           $("#nama").val('');
  //         });
  //       }
  //     }
  //   })
  // }

  function ubah_data_barang(id) {
    $.ajax({
      url: "<?= site_url('Barang/get_data/') ?>" + id,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $("#id").val(data.id);
        $("#nama").val(data.nama);
        $("#harga").val(separateComma(data.harga));
        $("#id_jenis").val(data.id_jenis).change();
        $("#kadaluarsa").val(data.kadaluarsa).change();

        $("#data-table").hide(200);
        $("#btn_tutup_barang").show(200);
        $("#btn_tambah_barang").hide(200);
        $("#form_data").show(200);
        $("#title-form").text("UBAH DATA");
        $("#btn-form").text("Ubah");
        $("#btn-aksi").removeClass("btn btn-sm btn-primary");
        $("#btn-aksi").addClass("btn btn-sm btn-warning");
        $("#i-icon").removeClass("fa fa-save");
        $("#i-icon").addClass("fa fa-edit");
      }
    })
  }

  function tutup_data_barang() {
    $("#data-table").show(200);
    $("#btn_tutup_barang").hide(200);
    $("#btn_tambah_barang").show(200);
    $("#form_data").hide(200);
  }

  function forhar() {
    var hargax = $("#harga").val();
    var harga = Number(parseInt(hargax.replaceAll(',', '')));
    $("#harga").val(separateComma(harga));
  }

  function aksi() {
    var id = $("#id").val();
    var nama = $("#nama").val();
    var hargax = $("#harga").val();
    var harga = Number(parseInt(hargax.replaceAll(',', '')));
    var jenis = $("#id_jenis").val();
    var text = $("#btn-form").text();
    if (text == 'Simpan') {
      var url = '<?= site_url("Barang/olahdata/1?harga="); ?>' + harga;
      var cek_text = "TAMBAH";
    } else {
      var url = '<?= site_url("Barang/olahdata/2?harga="); ?>' + harga;
      var cek_text = "UBAH";
    }
    if (nama == '' || nama == null) {
      Swal.fire({
        title: 'NAMA',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (hargax == '' || hargax == null) {
      Swal.fire({
        title: 'HARGA',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (jenis == '' || jenis == null) {
      Swal.fire({
        title: 'JENIS',
        html: 'Tidak Boleh Kosong !',
        icon: 'error',
      });
      return;
    }
    if (nama != '' && harga != '' && jenis != '') {
      $.ajax({
        url: url,
        data: $('#form_datax').serialize(),
        dataType: "JSON",
        type: "POST",
        success: function(data) {
          if (data.status == 1) {
            Swal.fire({
              title: cek_text + ' DATA',
              html: 'Berhasil dilakukan',
              icon: 'success',
            }).then((value) => {
              location.href = "<?php echo base_url() ?>Barang";
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

  function hapus_data_barang(id) {
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
          url: "<?= site_url('Barang/hapus/') ?>" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                title: 'HAPUS DATA',
                html: 'Berhasil dilakukan',
                icon: 'success',
              }).then((value) => {
                location.href = "<?php echo base_url() ?>Barang";
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

  function grouping(jenis) {
    location.href = "<?= site_url('Barang/?jenis=') ?>" + jenis;
  }

  function cetak() {
    Swal.fire({
      title: 'CETAK DATA',
      text: "Master Barang ?",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Cetak',
      CancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        window.open('<?= site_url("Barang/cetak") ?>', 'blank');
      }
    })
  }
</script>