<div class="row" style="font-size: 15px;">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="h4">
          Update data
          <a href="<?= site_url('Stok/in'); ?>" class="btn btn-danger btn-sm btn-circle float-right" title="Kembali"><i class="fa fa-arrow-left"></i></a>
        </div>
        <hr>
        <form method="POST" id="f_entri_edit">
          <div class="row">
            <div class="col">
              <div class="row">
                <div class="col-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Supplier</label>
                    <div class="col-sm-8">
                      <?php $sql = $this->db->get_where('supplier', ['id'=>$header->id_supplier])->row(); ?>
                      <select name="id_supplier" id="id_supplier" class="form-control select2_supplier">
                        <option value="<?= $header->id_supplier; ?>"><?= $sql->nama; ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal Masuk</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" id="tgl" name="tgl" value="<?= date('Y-m-d', strtotime($header->tgl)); ?>">
                    </div>
                  </div>
                </div>
                <div class="col-6 m-auto">
                  <div class="card float-right bg-warning">
                    <div class="card-body">
                      <span class="h4 font-weight-bold text-white"><?= $header->invoice_masuk; ?></span>
                      <input type="hidden" name="inv" id="inv" value="<?= $header->invoice_masuk; ?>">
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
                <table class="table table-striped table-hover table-bordered" id="masuk_edit">
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
                    <?php $no = 1;
                    foreach ($detail as $d) : ?>
                      <tr>
                        <td class="text-center">
                          <?php if ($no == 1) : ?>
                            <button style='text-align: center;' type="button" class="btn btn-danger btn-sm btn-circle" disabled><i class="fa fa-trash"></i></button>
                          <?php else : ?>
                            <button style='text-align: center;' type="button" class="btn btn-danger btn-sm btn-circle" id="hapus<?= $no; ?>" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>
                          <?php endif; ?>
                        </td>
                        <td>
                          <select name="kode_barang[]" id="kode_barang<?= $no; ?>" class="form-control select2_barang" onchange="showbarang(this.value, <?= $no; ?>)">
                            <option value="<?= $d->kode_barang; ?>">
                              <?php $sql = $this->db->get_where("barang", ["kode_barang" => $d->kode_barang])->row(); ?>
                              <?= $sql->nama; ?>
                            </option>
                          </select>
                        </td>
                        <td>
                          <input type='date' class='form-control' value='<?= date('Y-m-d', strtotime($d->expire)) ?>' id='expire<?= $no; ?>' name='expire[]'>
                        </td>
                        <td>
                          <input type="text" class="form-control" style="text-align: right;" readonly value="<?= number_format($d->harga); ?>" id="harga<?= $no; ?>" name="harga[]">
                        </td>
                        <td>
                          <input type="text" class="form-control" style="text-align: right;" value="<?= number_format($d->qty); ?>" id="qty<?= $no; ?>" name="qty[]" onchange="totalline(1)">
                        </td>
                        <td>
                          <input type="text" class="form-control" style="text-align: right;" readonly value="<?= number_format($d->sub_total); ?>" id="total<?= $no; ?>" name="total[]">
                        </td>
                      </tr>
                    <?php $no++;
                    endforeach; ?>
                  </tbody>
                </table>
                <button type="button" class="btn btn-success btn-sm btn-circle" onclick="tambah()" style="margin-left: 20px;"><i class="fa fa-plus"></i></button>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-8 mt-auto">
              <button type="button" class="btn btn-warning btn-sm" onclick="save()"><i class="fa fa-retweet"></i> Reposting</button>
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
  $(document).ready(function() {
    total();
  });

  var idrow = <?= $jumdata + 1; ?>;
  var rowCount;
  var arr = [1];

  function showbarang(str, id) {
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

  function totalline(id) {
    var hargax = $("#harga" + id).val();
    var harga = Number(parseInt(hargax.replace(/[^0-9\.]+/g, "")));
    var qtyx = $("#qty" + id).val();
    var qty = Number(parseInt(qtyx.replace(/[^0-9\.]+/g, "")));
    var sub_total = qty * harga;
    $("#total" + id).val(separateComma(sub_total));
    $("#qty" + id).val(separateComma(qty));
    total();
  }

  function total() {
    var table = document.getElementById('masuk_edit');
    var rowCount = table.rows.length;
    xtotal = 0;
    for (var i = 1; i < rowCount; i++) {
      var row = table.rows[i];
      sub_totalx = row.cells[5].children[0].value;
      var sub_total = Number(sub_totalx.replace(/[^0-9\.]+/g, ""));
      xtotal += sub_total;
    }
    $("#_vtotal").val(separateComma(xtotal));
  }

  function tambah() {
    var table = document.getElementById('masuk_edit');
    rowCount = table.rows.length;
    arr.push(idrow);
    var x = document.getElementById('masuk_edit').insertRow(rowCount);
    var td1 = x.insertCell(0);
    var td2 = x.insertCell(1);
    var td3 = x.insertCell(2);
    var td4 = x.insertCell(3);
    var td5 = x.insertCell(4);
    var td6 = x.insertCell(5);
    td1.innerHTML = "<td class='text-center'><button style='text-align: center; margin-left: 8px;' type='button' class='btn btn-danger btn-sm btn-circle' id='hapus" + idrow + "' onclick='deleteRow(this)'><i class='fa fa-trash'></i></button></td>";
    td2.innerHTML = "<td><select name='kode_barang[]' id='kode_barang" + idrow + "' class='form-control select2_barang' onchange='showbarang(this.value, " + idrow + ")'></select></td>";
    td3.innerHTML = "<td><input type='date' class='form-control' value='<?= date('Y-m-d') ?>' id='expire" + idrow + "' name='expire[]'></td>";
    td4.innerHTML = "<td><input type='text' class='form-control' style='text-align: right;' readonly value='0' id='harga" + idrow + "' name='harga[]'></td>";
    td5.innerHTML = "<td><input type='text' class='form-control' style='text-align: right;' value='1' id='qty" + idrow + "' name='qty[]' onchange='totalline(" + idrow + ")'></td>";
    td6.innerHTML = "<td><input type='text' class='form-control' style='text-align: right;' readonly value='0' id='total" + idrow + "' name='total[]'></td>";
    initailizeSelect2_barang();
    idrow++;
  }

  function deleteRow(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    total();
  }

  function save() {
    var invoice = $("#inv").val();
    var vendor = $('#id_supplier').val();
    var totalnyax = $('#_vtotal').val();
    var totalnya = Number(parseInt(totalnyax.replace(/[^0-9\.]+/g, "")));
    Swal.fire({
      title: 'UPDATE DATA',
      text: "Yakin ingin mengubah data ini ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Update',
      CancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= site_url('Stok/edit_in_header/') ?>' + totalnya,
          data: $('#f_entri_edit').serialize(),
          type: 'POST',
          dataType: 'JSON',
          success: function(data) {
            if (data.status == 1) {
              var table = document.getElementById('masuk_edit');
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
                var param = "?invoice_masuk=" + invoice + "&kode_barang=" + kode_barang + "&expire=" + expire + "&harga=" + harga + "&qty=" + qty + "&total=" + total;
                $.ajax({
                  url: "<?= site_url('Stok/in_detail') ?>" + param,
                  type: "POST",
                  dataType: "JSON",
                });
              }
              Swal.fire({
                title: 'UPDATE STOK',
                html: 'Berhasil dilakukan',
                icon: 'success',
              }).then((value) => {
                location.href = "<?php echo base_url() ?>Stok/in";
              });
            } else {
              Swal.fire({
                title: 'UPDATE STOK',
                html: 'Gagal dilakukan !',
                icon: 'error'
              });
              return;
            }
          }
        });
      }
    })
  }
</script>