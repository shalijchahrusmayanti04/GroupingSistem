<div class="row" style="font-size: 15px;">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="h4">
          Entri data
          <a href="<?= site_url('Stok/out'); ?>" class="btn btn-danger btn-sm btn-circle float-right" title="Kembali"><i class="fa fa-arrow-left"></i></a>
        </div>
        <hr>
        <form method="POST" id="f_entri_keluar">
          <div class="row">
            <div class="col">
              <div class="row">
                <div class="col-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal Keluar</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" id="tgl" name="tgl" value="<?= date('Y-m-d'); ?>">
                    </div>
                  </div>
                </div>
                <div class="col-6 m-auto">
                  <div class="card float-right bg-primary">
                    <div class="card-body">
                      <span class="h4 font-weight-bold text-white"><?= $invoice; ?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" id="keluar_entri">
                  <thead>
                    <tr class="text-center">
                      <th width="3%">Hapus</th>
                      <th width="27%">Barang</th>
                      <th width="10%">Exp</th>
                      <th width="20%">Harga</th>
                      <th width="20%">Qty</th>
                      <th width="20%">Sub Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-center">
                        <button style='text-align: center;' type="button" class="btn btn-danger btn-sm btn-circle" id="hapus1" disabled><i class="fa fa-trash"></i></button>
                      </td>
                      <td>
                        <select name="kode_barang[]" id="kode_barang1" class="form-control select2_barang" onchange="showbarang(this.value, 1)"></select>
                      </td>
                      <td>
                        <input type='date' class='form-control' value='<?= date('Y-m-d') ?>' id='expire1' name='expire[]'>
                      </td>
                      <td>
                        <input type="text" class="form-control" style="text-align: right;" readonly value="0" id="harga1" name="harga[]">
                      </td>
                      <td>
                        <input type="text" class="form-control" style="text-align: right;" value="1" id="qty1" name="qty[]" onchange="totalline(1)">
                      </td>
                      <td>
                        <input type="text" class="form-control" style="text-align: right;" readonly value="0" id="total1" name="total[]">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <button type="button" class="btn btn-success btn-sm btn-circle" onclick="tambah()" style="margin-left: 20px;"><i class="fa fa-plus"></i></button>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-8 mt-auto">
              <button type="button" class="btn btn-primary btn-sm" onclick="save()" id="btnsave"><i class="fa fa-save"></i> Posting</button>
            </div>
            <div class="col-4">
              <div class="card">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">TOTAL</label>
                    <div class="col-sm-8">
                      <input type="text" style="text-align: right;" class="form-control" id="_vtotal" value="0" name="_vtotal" readonly>
                    </div>
                  </div>
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
  $("#btnsave").attr("disabled", true);

  function showbarang(str, id) {
    $.ajax({
      url: "<?= site_url('Stok/kosong?kode_barang='); ?>" + str,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        if (data.status == 1) {
          Swal.fire({
            title: 'STOK BARANG',
            html: 'Kosong !',
            icon: 'warning'
          }).then((value) => {
            $("#kode_barang" + id).empty();
          });
        } else {
          $.ajax({
            url: "<?= site_url('Barang/get_data/'); ?>" + str,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              $("#harga" + id).val(separateComma(data.harga));
              totalline(id);
            }
          });
        }
      }
    });
  }

  function totalline(id) {
    var kodebarang = $("#kode_barang" + id).val();
    var hargax = $("#harga" + id).val();
    var harga = Number(parseInt(hargax.replace(/[^0-9\.]+/g, "")));
    var qtyx = $("#qty" + id).val();
    var qty = Number(parseInt(qtyx.replace(/[^0-9\.]+/g, "")));
    if (qty <= 0) {
      Swal.fire({
        title: 'QTY',
        html: 'Tidak boleh kurang dari 0 !',
        icon: 'info'
      }).then((value) => {
        $("#qty" + id).val(1)
      });
    } else {
      $.ajax({
        url: "<?= site_url('Stok/cek_stok?kode_barang=') ?>" + kodebarang,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 0) {
            Swal.fire({
              title: 'QTY',
              html: 'Kosong',
              icon: 'info'
            }).then((value) => {
              $("#kode_barang" + id).empty();
              $("#harga" + id).val(0);
            });
          } else {
            if (qty > data.stok_hasil) {
              Swal.fire({
                title: 'QTY',
                html: 'Tidak boleh lebih dari saldo akhir : ' + data.stok_hasil,
                icon: 'info'
              }).then((value) => {
                $("#qty" + id).val(separateComma(data.stok_hasil));
              });
            } else {
              var sub_total = qty * harga;
              $("#total" + id).val(separateComma(sub_total));
              $("#qty" + id).val(separateComma(qty));
              $("#btnsave").attr("disabled", false);
              total();
            }
          }
        }
      });
    }
  }

  function total() {
    var table = document.getElementById('keluar_entri');
    var rowCount = table.rows.length;
    xtotal = 0;
    for (var i = 1; i < rowCount; i++) {
      var row = table.rows[i];
      // var sub_totalx = $("#total" + i).val();
      var sub_totalx = row.cells[5].children[0].value;
      var sub_total = Number(parseInt(sub_totalx.replace(/[^0-9\.]+/g, "")));
      xtotal += sub_total;
    }
    $("#_vtotal").val(separateComma(xtotal));
  }

  var idrow = 2;
  var rowCount;
  var arr = [1];

  function tambah() {
    var table = document.getElementById('keluar_entri');
    rowCount = table.rows.length;
    arr.push(idrow);
    var x = document.getElementById('keluar_entri').insertRow(rowCount);
    var td1 = x.insertCell(0);
    var td2 = x.insertCell(1);
    var td3 = x.insertCell(2);
    var td4 = x.insertCell(3);
    var td5 = x.insertCell(4);
    var td6 = x.insertCell(5);
    td1.innerHTML = "<td class='text-center'><button style='text-align: center; margin-left: 8px;' type='button' class='btn btn-danger btn-sm btn-circle' id='hapus" + idrow + "' onclick='hapus_baris(" + idrow + ")'><i class='fa fa-trash'></i></button></td>";
    td2.innerHTML = "<td><select name='kode_barang[]' id='kode_barang" + idrow + "' class='form-control select2_barang' onchange='showbarang(this.value, " + idrow + ")'></select></td>";
    td3.innerHTML = "<td><input type='date' class='form-control' value='<?= date('Y-m-d') ?>' id='expire" + idrow + "' name='expire[]'></td>";
    td4.innerHTML = "<td><input type='text' class='form-control' style='text-align: right;' readonly value='0' id='harga" + idrow + "' name='harga[]'></td>";
    td5.innerHTML = "<td><input type='text' class='form-control' style='text-align: right;' value='1' id='qty" + idrow + "' name='qty[]' onchange='totalline(" + idrow + ")'></td>";
    td6.innerHTML = "<td><input type='text' class='form-control' style='text-align: right;' readonly value='0' id='total" + idrow + "' name='total[]'></td>";
    initailizeSelect2_barang();
    idrow++;
  }

  function hapus_baris(param) {
    var x = document.getElementById('keluar_entri').deleteRow(arr.indexOf(param) + 1);
    arr.splice(arr.indexOf(param), 1);
    rowCount--;
    total();
  }

  function save() {
    $("#btnsave").attr('disabled', true);
    var kode_barangx = $('#kode_barang1').val();
    var totalnyax = $('#_vtotal').val();
    var totalnya = Number(parseInt(totalnyax.replace(/[^0-9\.]+/g, "")));
    if (kode_barangx == '' || kode_barangx == null) {
      Swal.fire({
        title: 'BARANG',
        html: 'Tidak boleh kosong !',
        icon: 'warning'
      });
      return;
      $("#btnsave").attr('disabled', false);
    }
    if (kode_barangx != '' || kode_barangx != null) {
      $.ajax({
        url: '<?= site_url('Stok/out_header/') ?>' + totalnya,
        data: $('#f_entri_keluar').serialize(),
        type: 'POST',
        dataType: 'JSON',
        success: function(data) {
          if (data.status == 1) {
            $("#btnsave").attr('disabled', false);
            var invoice = data.invoice;
            var table = document.getElementById('keluar_entri');
            rowCount = table.rows.length;
            for (i = 1; i < rowCount; i++) {
              var row = table.rows[i];
              // var kode_barang = $("#kode_barang" + i).val();
              var kode_barang = row.cells[1].children[0].value;
              // var expire = $("#expire" + i).val();
              var expire = row.cells[2].children[0].value;
              // var hargax = $("#harga" + i).val();
              var hargax = row.cells[3].children[0].value;
              var harga = Number(parseInt(hargax.replace(/[^0-9\.]+/g, "")));
              // var qtyx = $("#qty" + i).val();
              var qtyx = row.cells[4].children[0].value;
              var qty = Number(parseInt(qtyx.replace(/[^0-9\.]+/g, "")));
              // var totalx = $("#total" + i).val();
              var totalx = row.cells[5].children[0].value;
              var total = Number(parseInt(totalx.replace(/[^0-9\.]+/g, "")));
              var param = "?invoice_keluar=" + invoice + "&kode_barang=" + kode_barang + "&expire=" + expire + "&harga=" + harga + "&qty=" + qty + "&total=" + total;
              $.ajax({
                url: "<?= site_url('Stok/out_detail') ?>" + param,
                type: "POST",
                dataType: "JSON",
              });
            }
            Swal.fire({
              title: 'KURANGI STOK',
              html: 'Berhasil dilakukan',
              icon: 'success',
            }).then((value) => {
              location.href = "<?php echo base_url() ?>Stok/out";
            });
          } else {
            Swal.fire({
              title: 'KURANGI STOK',
              html: 'Gagal dilakukan !',
              icon: 'error'
            });
            return;
            $("#btnsave").attr('disabled', false);
          }
        }
      });
    }
  }
</script>