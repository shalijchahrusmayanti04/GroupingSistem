<div class="h3 text-center font-weight-bold"><?= $judul; ?></div>
<div class="h6 text-center"><?= $tanggal; ?></div>
<hr>
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
          <?php
          foreach ($data_header as $dh) :
            $sql = $this->db->get_where('supplier', ['id' => $dh->id_supplier])->row(); ?>
            <tr>
              <td>#</td>
              <td colspan="6"><?= $sql->nama . ' - ' . $sql->no_telepon_whatsapp . ' - ' . $sql->alamat. ' - '.$dh->invoice_masuk; ?></td>
            </tr>
            <?php $no = 1;
            $detail = $this->db->query("SELECT *, (SELECT nama FROM barang WHERE kode_barang=in_detail.kode_barang) as nama_barang FROM in_detail WHERE invoice_masuk = '$dh->invoice_masuk' AND kode_barang IN (SELECT kode_barang FROM barang) ORDER BY invoice_masuk ASC")->result();
            foreach ($detail as $s) :
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
              <td class="table-dark" colspan="6"><?= $dh->invoice_masuk; ?> <span class="float-right"><b>TOTAL</b></span></td>
              <td class="table-dark">Rp. <span class="float-right"><b><?= number_format($dh->total); ?></b></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>