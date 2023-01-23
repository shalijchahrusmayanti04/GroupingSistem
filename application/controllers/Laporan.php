<?php
class Laporan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library('pdfgenerator');
  }
  function index()
  {
    $data = [
      'judul' => 'Kartu Stok',
      'data'  => $this->db->query("SELECT b.id, b.nama, b.id_jenis, b.harga, (SELECT stok_hasil FROM transaksi WHERE kode_barang = b.kode_barang) as stok FROM barang b")->result()
    ];
    $this->template->load('Template/Dashboard', 'Laporan/Data', $data);
  }
  function stok(){
    $datax = $this->db->query("SELECT b.nama, b.harga, j.jenis_barang, t.stok_in, t.stok_out, t.stok_hasil FROM barang b LEFT JOIN transaksi t ON t.kode_barang=b.kode_barang LEFT JOIN jenis_barang j ON b.id_jenis=j.id  WHERE t.kode_barang IN (SELECT kode_barang FROM barang) ORDER BY nama ASC")->result();
    $data = [
      'judul' => 'Daftar Stok',
      'data'  => $datax
    ];
    $this->template->load('Template/Dashboard', 'Laporan/Stok', $data);
  }
  function cetak_ds(){
    $date = date("D, d-m-Y");
    $sql = $this->db->query("SELECT b.nama, b.harga, j.jenis_barang, t.stok_in, t.stok_out, t.stok_hasil FROM barang b LEFT JOIN transaksi t ON t.kode_barang=b.kode_barang LEFT JOIN jenis_barang j ON b.id_jenis=j.id  WHERE t.kode_barang IN (SELECT kode_barang FROM barang) ORDER BY nama ASC")->result();
    $data = [
      'tanggal' => $date,
      'judul' => 'DAFTAR STOK',
      'sql' => $sql,
    ];
    $html = $this->template->load("Template/Cetak", "Laporan/cetak_ds", $data, TRUE);
    $file_pdf = 'DAFTAR STOK';
    $paper = 'A4';
    $orientation = "landscape";
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
  function kartu_stok(){
    $kode_barang = $this->input->get("kode_barang");
    $dari = $this->input->get("dari");
    $sampaix = $this->input->get("sampai");
    $date1 = str_replace('-', '/', $sampaix);
    $sampai = date('Y-m-d', strtotime($date1 . "+1 days"));
    $cek_saldo = $this->db->query(
      "SELECT sum(masuk - keluar) as tt, tanggal FROM (
        SELECT id.kode_barang, 'MASUK' as keterangan, ih.invoice_masuk as rekanan, ih.tgl as tanggal, ih.jam as jam, id.qty as masuk, 0 as keluar FROM in_header ih JOIN in_detail id ON ih.invoice_masuk=id.invoice_masuk

        UNION ALL

        SELECT od.kode_barang, 'KELUAR' as keterangan, oh.invoice_keluar as rekanan, oh.tgl as tanggal, oh.jam as jam, 0 as masuk, od.qty as keluar FROM out_header oh JOIN out_detail od ON oh.invoice_keluar=od.invoice_keluar
      ) as semua
      WHERE tanggal < '$dari' AND kode_barang = '$kode_barang'
      ORDER BY tanggal, jam ASC"
    )->result();
    if($cek_saldo){
      foreach($cek_saldo as $cs){
        $sa = 0;
        if($dari > $cs->tanggal){
          $sa = $cs->tt;
        } else {
          $sa = 0;
        }
      }
    } else {
      $sa = 0;
    }
    $data_x = $this->db->query(
      "SELECT * FROM (
        SELECT id.kode_barang, 'MASUK' as keterangan, ih.invoice_masuk as rekanan, ih.tgl as tanggal, ih.jam as jam, id.qty as masuk, 0 as keluar FROM in_header ih JOIN in_detail id ON ih.invoice_masuk=id.invoice_masuk

        UNION ALL

        SELECT od.kode_barang, 'KELUAR' as keterangan, oh.invoice_keluar as rekanan, oh.tgl as tanggal, oh.jam as jam, 0 as masuk, od.qty as keluar FROM out_header oh JOIN out_detail od ON oh.invoice_keluar=od.invoice_keluar
      ) as semua
      WHERE tanggal >= '$dari' AND tanggal <= '$sampai' AND kode_barang = '$kode_barang'
      ORDER BY tanggal, jam ASC"
    )->result();
    $barang = $this->db->get_where("barang", ["kode_barang" => $kode_barang])->row();
    $jenis = $this->db->query("SELECT (SELECT jenis_barang FROM jenis_barang WHERE id=b.id_jenis) as jenis FROM barang b WHERE kode_barang = '$kode_barang'")->row();
    $data = [
      'judul' => 'KARTU STOK',
      'title_pdf' => 'KARTU STOK',
      'data_x' => $data_x,
      'dari' => $dari,
      'sampai' => $sampai,
      'kode_barang' => $kode_barang,
      'barang' => $barang->nama,
      'jenis' => $jenis->jenis,
      'sa' => $sa,
    ];
    $html = $this->load->view("Laporan/cetak", $data, TRUE);
    $file_pdf = 'KARTU STOK';
    $paper = 'A4';
    $orientation = "landscape";
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
}