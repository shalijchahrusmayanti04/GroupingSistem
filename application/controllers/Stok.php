<?php
class Stok extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
  }
  function in()
  {
    $data = [
      'judul' => 'Stok Masuk',
      'data'  => $this->db->query("SELECT b.id, b.nama, b.id_jenis, b.harga FROM barang b")->result(),
      'data_detail'  => $this->db->query("SELECT * FROM in_detail WHERE kode_barang IN (SELECT kode_barang FROM barang) ORDER BY invoice_masuk ASC")->result(),
      'data_header' => $this->db->query("SELECT * FROM in_header ORDER BY tgl, jam DESC")->result(),
    ];
    $this->template->load('Template/Dashboard', 'Stok/Masuk', $data);
  }
  function cetak_in(){
    $date = date("D, d-m-Y");
    $header = $this->db->query("SELECT * FROM in_header ORDER BY tgl, jam DESC")->result();
    $data = [
      'tanggal' => $date,
      'judul' => 'STOK MASUK',
      'data_header' => $header,
    ];
    $html = $this->template->load("Template/Cetak", "Stok/cetak_in", $data, TRUE);
    $file_pdf = 'STOK MASUK';
    $paper = 'A4';
    $orientation = "landscape";
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
  function cetak_in_x($im){
    $date = date("D, d-m-Y");
    $header = $this->db->query("SELECT * FROM in_header WHERE invoice_masuk = '$im'")->row();
    $detail = $this->db->query("SELECT *, (SELECT nama FROM barang WHERE kode_barang=in_detail.kode_barang) as nama_barang FROM in_detail WHERE invoice_masuk = '$im'")->result();
    $data = [
      'tanggal' => $date,
      'judul' => 'STOK MASUK',
      'data_header' => $header,
      'data_detail' => $detail,
    ];
    $html = $this->template->load("Template/Cetak", "Stok/cetak_in_x", $data, TRUE);
    $file_pdf = 'STOK MASUK';
    $paper = 'A4';
    $orientation = "landscape";
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
  function in_entri(){
    $data = [
      'judul' => 'Stok Masuk',
      'data'  => $this->db->query("SELECT b.id, b.nama, b.id_jenis, b.harga FROM barang b")->result(),
      'data_detail'  => $this->db->query("SELECT * FROM in_detail WHERE kode_barang IN (SELECT kode_barang FROM barang) ORDER BY invoice_masuk ASC")->result(),
      'invoice' => $this->M_invoice->invoice_masuk(),
      'data_header' => $this->db->query("SELECT * FROM in_header ORDER BY tgl, jam DESC")->result(),
    ];
    $this->template->load('Template/Dashboard', 'Stok/Masuk_entri', $data);
  }
  function in_header($total){
    $invoice = $this->M_invoice->invoice_masuk();
    $id_supplier = $this->input->post("id_supplier");
    $username = $this->session->userdata('username');
    $tgl = $this->input->post("tgl");
    $data = [
      'username' => $username,
      'invoice_masuk' => $invoice,
      'id_supplier' => $id_supplier,
      'tgl' => $tgl,
      'total' => $total,
    ];
    $cek = $this->db->insert("in_header", $data);
    $sql = $this->db->query("SELECT * FROM in_header ORDER BY id DESC LIMIT 1")->result();
    foreach ($sql as $s) {
      $dnot = [
        'kunci' => $s->id,
        'pesan' => "Menambahkan Stok Masuk Dengan Invoice '" . $s->invoice_masuk . "'",
        'username' => $username,
        'url' => "Stok/in",
        "icon" => '<i class="fas fa-save text-white"></i>',
        "background" => "bg-primary",
      ];
      $this->db->insert("notif", $dnot);
    }
    if($cek){
      echo json_encode(["status" => 1, "invoice" => $invoice]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }
  function in_detail(){
    $invoice_masuk = $this->input->get("invoice_masuk");
    $kode_barang = $this->input->get("kode_barang");
    $expire = $this->input->get("expire");
    $harga = $this->input->get("harga");
    $qty = $this->input->get("qty");
    $sub_total = $this->input->get("total");
    $data = [
      'invoice_masuk' => $invoice_masuk,
      'kode_barang' => $kode_barang,
      'expire' => $expire,
      'qty' => $qty,
      'harga' => $harga,
      'sub_total' => $sub_total,
    ];
    $cek = $this->db->insert("in_detail", $data);
    if($cek) {
      $cekstok = $this->db->query("SELECT * FROM transaksi WHERE kode_barang = '$kode_barang'");
      if($cekstok->num_rows() > 0){
        $transaksi = $cekstok->row();
        $masuk = (int)$transaksi->stok_in + (int)$qty;
        $hasil = (int)$transaksi->stok_hasil + (int)$qty;
        $this->db->query("UPDATE transaksi set stok_in=$masuk, stok_hasil=$hasil where kode_barang='$kode_barang'");
      } else {
        $barang = $this->db->get_where("barang", ["kode_barang"=>$kode_barang])->row();
        $datastok = [
          'kode_barang' => $kode_barang,
          'barang' => $barang->nama,
          'stok_in' => $qty,
          'stok_out' => 0,
          'stok_hasil' => $qty,
        ];
        $this->db->insert("transaksi", $datastok);
      }
    }
  }
  function in_hapus($invoice)
  {
    $username = $this->session->userdata('username');
    $sql = $this->db->get_where("in_header", ["invoice_masuk" => $invoice])->row();
    $dnot = [
      'kunci' => $sql->id,
      'pesan' => "Menghapus Stok Masuk Dengan Invoice '" . $sql->invoice_masuk . "'",
      'username' => $username,
      'url' => "Stok/in",
      "icon" => '<i class="fas fa-trash text-white"></i>',
      "background" => "bg-danger",
    ];
    $this->db->insert("notif", $dnot);
    $detail = $this->db->get_where("in_detail", ["invoice_masuk"=>$invoice])->result();
    foreach($detail as $d){
      $stok = $this->db->get_where("transaksi", ["kode_barang"=>$d->kode_barang])->row();
      if($stok){
        $stok_masuk = (int)$stok->stok_in - (int)$d->qty;
        $stok_hasil = (int)$stok->stok_hasil - (int)$d->qty;
        $this->db->query("UPDATE transaksi set stok_in=$stok_masuk, stok_hasil=$stok_hasil where kode_barang='$d->kode_barang'");
      }
    }
    $this->db->delete("in_detail", ["invoice_masuk" => $invoice]);
    $this->db->delete("in_header", ["invoice_masuk" => $invoice]);
    echo json_encode(["status"=>1]);
  }
  function in_edit($inv)
  {
    $data = [
      'judul' => 'Stok Masuk',
      'data'  => $this->db->query("SELECT b.id, b.nama, b.id_jenis, b.harga FROM barang b")->result(),
      'detail'  => $this->db->query("SELECT * FROM in_detail WHERE invoice_masuk = '$inv'")->result(),
      'jumdata' => $this->db->query("SELECT * FROM in_detail WHERE invoice_masuk = '$inv'")->num_rows(),
      'invoice' => $this->M_invoice->invoice_masuk(),
      'header' => $this->db->query("SELECT * FROM in_header WHERE invoice_masuk = '$inv'")->row(),
    ];
    $this->template->load('Template/Dashboard', 'Stok/Masuk_edit', $data);
  }
  function edit_in_header($total)
  {
    $invoice = $this->input->post("inv");
    $id_supplier = $this->input->post("id_supplier");
    $tgl = $this->input->post("tgl");
    $where = ['invoice_masuk'=>$invoice];
    $data = [
      'id_supplier' => $id_supplier,
      'tgl' => $tgl,
      'total' => $total,
    ];
    $cek = $this->db->update("in_header", $data, $where);
    if ($cek) {
      $sql = $this->db->query("SELECT * FROM in_header WHERE invoice_masuk = '$invoice'")->row();
      $username = $this->session->userdata('username');
      $dnot = [
        'kunci' => $sql->id,
        'pesan' => "Mengubah Stok Masuk Dengan Invoice '" . $sql->invoice_masuk . "'",
        'username' => $username,
        'url' => "Stok/in",
        "icon" => '<i class="fas fa-edit text-white"></i>',
        "background" => "bg-warning",
      ];
      $this->db->insert("notif", $dnot);
      $detail = $this->db->get_where("in_detail", ["invoice_masuk" => $invoice])->result();
      foreach ($detail as $d) {
        $stok = $this->db->get_where("transaksi", ["kode_barang" => $d->kode_barang])->row();
        if ($stok) {
          $stok_masuk = (int)$stok->stok_in - (int)$d->qty;
          $stok_hasil = (int)$stok->stok_hasil - (int)$d->qty;
          $this->db->query("UPDATE transaksi set stok_in=$stok_masuk, stok_hasil=$stok_hasil where kode_barang='$d->kode_barang'");
        }
      }
      $this->db->delete("in_detail", ["invoice_masuk" => $invoice]);
      echo json_encode(["status" => 1, "invoice" => $invoice]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }
  function out()
  {
    $data = [
      'judul' => 'Stok Keluar',
      'data'  => $this->db->query("SELECT b.id, b.nama, b.id_jenis, b.harga FROM barang b")->result(),
      'data_detail'  => $this->db->query("SELECT * FROM out_detail WHERE kode_barang IN (SELECT kode_barang FROM barang) ORDER BY invoice_keluar ASC")->result(),
      'data_header' => $this->db->query("SELECT * FROM out_header ORDER BY tgl, jam DESC")->result(),
    ];
    $this->template->load('Template/Dashboard', 'Stok/Keluar', $data);
  }
  function cetak_out()
  {
    $date = date("D, d-m-Y");
    $header = $this->db->query("SELECT * FROM out_header ORDER BY tgl, jam DESC")->result();
    $data = [
      'tanggal' => $date,
      'judul' => 'STOK KELUAR',
      'data_header' => $header,
    ];
    $html = $this->template->load("Template/Cetak", "Stok/cetak_out", $data, TRUE);
    $file_pdf = 'STOK KELUAR';
    $paper = 'A4';
    $orientation = "landscape";
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
  function cetak_out_x($im)
  {
    $date = date("D, d-m-Y");
    $header = $this->db->query("SELECT * FROM out_header WHERE invoice_keluar = '$im'")->row();
    $detail = $this->db->query("SELECT *, (SELECT nama FROM barang WHERE kode_barang=out_detail.kode_barang) as nama_barang FROM out_detail WHERE invoice_keluar = '$im'")->result();
    $data = [
      'tanggal' => $date,
      'judul' => 'STOK KELUAR',
      'data_header' => $header,
      'data_detail' => $detail,
    ];
    $html = $this->template->load("Template/Cetak", "Stok/cetak_out_x", $data, TRUE);
    $file_pdf = 'STOK KELUAR';
    $paper = 'A4';
    $orientation = "landscape";
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
  function out_entri()
  {
    $data = [
      'judul' => 'Stok Keluar',
      'data'  => $this->db->query("SELECT b.id, b.nama, b.id_jenis, b.harga FROM barang b")->result(),
      'data_detail'  => $this->db->query("SELECT * FROM out_detail WHERE kode_barang IN (SELECT kode_barang FROM barang) ORDER BY invoice_keluar ASC")->result(),
      'invoice' => $this->M_invoice->invoice_keluar(),
      'data_header' => $this->db->query("SELECT * FROM out_header ORDER BY tgl, jam DESC")->result(),
    ];
    $this->template->load('Template/Dashboard', 'Stok/Keluar_entri', $data);
  }
  function kosong(){
    $id = $this->input->get("kode_barang");
    $data = $this->db->get_where("transaksi", ["kode_barang" => $id]);
    if($data->num_rows() > 0){
      $data = $data->row();
      if($data->stok_hasil == 0){
        echo json_encode(["status" => 1]);
      }else{
        echo json_encode(["status" => 0]);
      }
    } else {
      echo json_encode(["status" => 0]);
    }
  }
  function cek_stok(){
    $id = $this->input->get("kode_barang");
    $data = $this->db->get_where("transaksi", ["kode_barang" => $id])->row();
    if($data){
      echo json_encode($data);
    } else {
      echo json_encode(["status"=>0]);
    }
  }
  function out_header($total)
  {
    $invoice = $this->M_invoice->invoice_keluar();
    $tgl = $this->input->post("tgl");
    $username = $this->session->userdata('username');
    $data = [
      'invoice_keluar' => $invoice,
      'username' => $username,
      'tgl' => $tgl,
      'total' => $total,
    ];
    $cek = $this->db->insert("out_header", $data);
    if ($cek) {
      $sql = $this->db->query("SELECT * FROM out_header ORDER BY id DESC LIMIT 1")->result();
      foreach ($sql as $s) {
        $dnot = [
          'kunci' => $s->id,
          'pesan' => "Menambahkan Stok Keluar Dengan Invoice '" . $s->invoice_keluar . "'",
          'username' => $username,
          'url' => "Stok/out",
          "icon" => '<i class="fas fa-save text-white"></i>',
          "background" => "bg-primary",
        ];
        $this->db->insert("notif", $dnot);
      }
      echo json_encode(["status" => 1, "invoice" => $invoice]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }
  function out_detail()
  {
    $invoice_keluar = $this->input->get("invoice_keluar");
    $kode_barang = $this->input->get("kode_barang");
    $expire = $this->input->get("expire");
    $harga = $this->input->get("harga");
    $qty = $this->input->get("qty");
    $sub_total = $this->input->get("total");
    $data = [
      'invoice_keluar' => $invoice_keluar,
      'kode_barang' => $kode_barang,
      'expire' => $expire,
      'qty' => $qty,
      'harga' => $harga,
      'sub_total' => $sub_total,
    ];
    $cek = $this->db->insert("out_detail", $data);
    if ($cek) {
      $cekstok = $this->db->query("SELECT * FROM transaksi WHERE kode_barang = '$kode_barang'");
      if ($cekstok->num_rows() > 0) {
        $transaksi = $cekstok->row();
        $keluar = (int)$transaksi->stok_out + (int)$qty;
        $hasil = (int)$transaksi->stok_hasil - (int)$qty;
        $this->db->query("UPDATE transaksi set stok_out=$keluar, stok_hasil=$hasil where kode_barang='$kode_barang'");
      } else {
        $barang = $this->db->get_where("barang", ["kode_barang" => $kode_barang])->row();
        $datastok = [
          'kode_barang' => $kode_barang,
          'barang' => $barang->nama,
          'stok_in' => 0,
          'stok_out' => $qty,
          'stok_hasil' => 0 - $qty,
        ];
        $this->db->insert("transaksi", $datastok);
      }
    }
  }
  function out_hapus($invoice)
  {
    $username = $this->session->userdata('username');
    $sql = $this->db->get_where("out_header", ["invoice_keluar" => $invoice])->row();
    $dnot = [
      'kunci' => $sql->id,
      'pesan' => "Menghapus Stok Keluar Dengan Invoice '" . $sql->invoice_keluar . "'",
      'username' => $username,
      'url' => "Stok/out",
      "icon" => '<i class="fas fa-trash text-white"></i>',
      "background" => "bg-danger",
    ];
    $this->db->insert("notif", $dnot);
    $detail = $this->db->get_where("out_detail", ["invoice_keluar" => $invoice])->result();
    foreach ($detail as $d) {
      $stok = $this->db->get_where("transaksi", ["kode_barang" => $d->kode_barang])->row();
      if ($stok) {
        $stok_out = (int)$stok->stok_out - (int)$d->qty;
        $stok_hasil = (int)$stok->stok_hasil + (int)$d->qty;
        $this->db->query("UPDATE transaksi set stok_out=$stok_out, stok_hasil=$stok_hasil where kode_barang='$d->kode_barang'");
      }
    }
    $this->db->delete("out_detail", ["invoice_keluar" => $invoice]);
    $this->db->delete("out_header", ["invoice_keluar" => $invoice]);
    echo json_encode(["status" => 1]);
  }
  function out_edit($inv)
  {
    $data = [
      'judul' => 'Stok Keluar',
      'data'  => $this->db->query("SELECT b.id, b.nama, b.id_jenis, b.harga FROM barang b")->result(),
      'detail'  => $this->db->query("SELECT * FROM out_detail WHERE invoice_keluar = '$inv'")->result(),
      'jumdata' => $this->db->query("SELECT * FROM out_detail WHERE invoice_keluar = '$inv'")->num_rows(),
      'invoice' => $this->M_invoice->invoice_keluar(),
      'header' => $this->db->query("SELECT * FROM out_header WHERE invoice_keluar = '$inv'")->row(),
    ];
    $this->template->load('Template/Dashboard', 'Stok/Keluar_edit', $data);
  }
  function edit_out_header($total)
  {
    $invoice = $this->input->post("inv");
    $tgl = $this->input->post("tgl");
    $where = ['invoice_keluar' => $invoice];
    $data = [
      'tgl' => $tgl,
      'total' => $total,
    ];
    $cek = $this->db->update("out_header", $data, $where);
    if ($cek) {
      $sql = $this->db->query("SELECT * FROM out_header WHERE invoice_keluar = '$invoice'")->row();
      $username = $this->session->userdata('username');
      $dnot = [
        'kunci' => $sql->id,
        'pesan' => "Mengubah Stok Keluar Dengan Invoice '" . $sql->invoice_keluar . "'",
        'username' => $username,
        'url' => "Stok/out",
        "icon" => '<i class="fas fa-edit text-white"></i>',
        "background" => "bg-warning",
      ];
      $this->db->insert("notif", $dnot);
      $detail = $this->db->get_where("out_detail", ["invoice_keluar" => $invoice])->result();
      foreach ($detail as $d) {
        $stok = $this->db->get_where("transaksi", ["kode_barang" => $d->kode_barang])->row();
        if ($stok) {
          $stok_out = (int)$stok->stok_out - (int)$d->qty;
          $stok_hasil = (int)$stok->stok_hasil + (int)$d->qty;
          $this->db->query("UPDATE transaksi set stok_out=$stok_out, stok_hasil=$stok_hasil where kode_barang='$d->kode_barang'");
        }
      }
      $this->db->delete("out_detail", ["invoice_keluar" => $invoice]);
      echo json_encode(["status" => 1, "invoice" => $invoice]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  function get_data($kode_barang){
    $data = $this->db->query("SELECT s.*, (SELECT id FROM barang WHERE kode_barang=s.kode_barang) as id_barang FROM Stok_in s WHERE kode_barang ='$kode_barang'")->row();
    echo json_encode($data);
  }
}