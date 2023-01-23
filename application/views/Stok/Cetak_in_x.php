<div class="h3 text-center font-weight-bold"><?= $judul; ?></div>
<div class="h6 text-center"><?= $tanggal; ?></div>
<hr>
<div class="row mb-3">
  <div class="col">
    <table>
      <tr>
        <td width="20%"> Invoice </td>
        <td> : </td>
        <td> <?= $data_header->invoice_masuk; ?> </td>
      </tr>
      <?php $sql = $this->db->get_where('supplier', ['id'=> $data_header->id_supplier])->row(); ?>
      <tr>
        <td width="20%"> Supplier </td>
        <td> : </td>
        <td> <?= $sql->nama; ?> </td>
      </tr>
      <tr>
        <td width="20%"> No. Telepon/Whatsapp Supplier </td>
        <td> : </td>
        <td> <?= $sql->no_telepon_whatsapp; ?> </td>
      </tr>
      <tr>
        <td width="20%"> Alamat Supplier </td>
        <td> : </td>
        <td> <?= $sql->alamat; ?> </td>
      </tr>
      <tr>
        <td width="20%"> Waktu Masuk </td>
        <td> : </td>
        <td> <?= date("d-m-Y", strtotime($data_header->tgl)) . ' / ' . $data_header->jam; ?> </td>
      </tr>
    </table>
  </div>
</div>
<br>
<div class="row">
  <div class="col">
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead>
          <tr class="text-center">
            <th class="table-dark" width="5%">NO</th>
            <th class="table-dark">KODE BARANG</th>
            <th class="table-dark">NAMA BARANG</th>
            <th class="table-dark">KADALUARSA</th>
            <th class="table-dark">QTY</th>
            <th class="table-dark">HARGA</th>
            <th class="table-dark">SUB TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($data_detail as $s) :
          ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $s->kode_barang; ?></td>
              <td><?= $s->nama_barang; ?></td>
              <td class="text-center"><?= $s->expire; ?></td>
              <td><span class="float-right"><?= $s->qty; ?></span></td>
              <td>Rp. <span class="float-right"><?= number_format($s->harga); ?></span></td>
              <td>Rp. <span class="float-right"><?= number_format($s->sub_total); ?></span></td>
            </tr>
          <?php endforeach; ?>
          <tr>
            <td class="text-center table-dark" colspan="6"><b>TOTAL</b></td>
            <td class="table-dark">Rp. <span class="float-right"><?= number_format($data_header->total); ?></span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>