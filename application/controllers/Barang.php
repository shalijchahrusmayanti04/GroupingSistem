<?php
class Barang extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
  }
  function index()
  {
    $jenisx = $this->input->get("jenis");
    if ($jenisx == '' || $jenisx == null) {
      $jenis   = '';
      $kondisi   = "";
    } else {
      $jenis   = $jenisx;
      $kondisi   = "WHERE id_jenis = '$jenis'";
    }
    $data = [
      'judul' => 'Master Barang',
      'data'  => $this->db->query("SELECT * FROM barang $kondisi")->result(),
      'jenis' => $jenis,
    ];
    $this->template->load('Template/Dashboard', 'Barang/Data', $data);
  }
  function ceknama($nama){
    $data = $this->db->query("SELECT nama FROM barang WHERE nama = '$nama'")->num_rows();
    if($data > 0){
      echo json_encode(['status' => 1]);
    } else {
      echo json_encode(['status' => 0]);
    }
  }
  function get_data($id){
    $data = $this->db->get_where("barang", [ "kode_barang" => $id ])->row();
    echo json_encode($data);
  }
  function hapus($id)
  {
    $username = $this->session->userdata('username');
    $brg = $this->db->get_where("barang", ["id" => $id])->row();
    $dnot = [
      'kunci' => $id,
      'pesan' => "Menghapus Barang '" . $brg->nama . "'",
      'username' => $username,
      'url' => "Barang",
      "icon" => '<i class="fas fa-trash text-white"></i>',
      "background" => "bg-danger",
    ];
    $this->db->insert("notif", $dnot);
    $this->db->delete("barang", [ "id" => $id ]);
    echo json_encode(["status" => 1]);
  }
  function olahdata($param){
    $kode_barang = $this->M_invoice->kode_barang();
    $id = $this->input->post('id');
    $nama = $this->input->post('nama');
    $harga = $this->input->get('harga');
    $jenis = $this->input->post('id_jenis');
    $where = [ "id" => $id ];
    $data = [
      'kode_barang' => $kode_barang,
      'nama' => $nama,
      'harga' => $harga,
      'id_jenis' => $jenis,
    ];
    if($param == 1){
      $cek = $this->db->insert("barang", $data);
      $brg = $this->db->query("SELECT * FROM barang ORDER BY id DESC LIMIT 1")->result();
      $username = $this->session->userdata('username');
      foreach ($brg as $b) {
        $dnot = [
          'kunci' => $b->kode_barang,
          'pesan' => "Menambahkan Barang '" . $b->nama . "'",
          'username' => $username,
          'url' => "Barang",
          "icon" => '<i class="fas fa-save text-white"></i>',
          "background" => "bg-primary",
        ];
        $this->db->insert("notif", $dnot);
      }
      if($cek){
        echo json_encode(["status" => 1]);
      } else {
        echo json_encode(["status" => 0]);
      }
    } else {
      $cek = $this->db->update("barang", $data, $where);
      $brg = $this->db->query("SELECT * FROM barang WHERE id = '$id'")->row();
      $username = $this->session->userdata('username');
      $dnot = [
        'kunci' => $brg->kode_barang,
        'pesan' => "Mengubah Barang '" . $brg->nama . "'",
        'username' => $username,
        'url' => "Barang",
        "icon" => '<i class="fas fa-edit text-white"></i>',
        "background" => "bg-warning",
      ];
      $this->db->insert("notif", $dnot);
      if ($cek) {
        echo json_encode(["status" => 1]);
      } else {
        echo json_encode(["status" => 0]);
      }
    }
  }
  function data_barang()
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query("SELECT kode_barang AS id, CONCAT('[ ',kode_barang,' ] - [ ',nama,' ] - [ ',(SELECT jenis_barang FROM jenis_barang WHERE id=barang.id_jenis),' ] - [ ',FORMAT(harga, 'C0'),' ] - [ ',IF((SELECT stok_hasil FROM transaksi WHERE kode_barang=barang.kode_barang) > 0, (SELECT stok_hasil FROM transaksi WHERE kode_barang=barang.kode_barang), 0),' ]') AS text FROM barang WHERE id LIKE '%" . $key . "%' OR nama LIKE '%" . $key ."%' OR harga LIKE '%" . $key ."%' ORDER BY nama ASC")->result();
    } else {
      $data = $this->db->query("SELECT kode_barang AS id, CONCAT('[ ',kode_barang,' ] - [ ',nama,' ] - [ ',(SELECT jenis_barang FROM jenis_barang WHERE id=barang.id_jenis),' ] - [ ',FORMAT(harga, 'C0'),' ] - [ ',IF((SELECT stok_hasil FROM transaksi WHERE kode_barang=barang.kode_barang) > 0, (SELECT stok_hasil FROM transaksi WHERE kode_barang=barang.kode_barang), 0),' ]') AS text FROM barang LIMIT 5")->result();
    }
    echo json_encode($data);
  }
  function cetak()
  {
    $date = date("D, d-m-Y");
    $sql = $this->db->query("SELECT b.*, (SELECT jenis_barang FROM jenis_barang WHERE id=b.id_jenis) as jenis_barang FROM barang b")->result();
    $data = [
      'tanggal' => $date,
      'judul' => 'MASTER BARANG',
      'sql' => $sql,
    ];
    $html = $this->template->load("Template/Cetak", "Barang/cetak", $data, TRUE);
    $file_pdf = 'MASTER BARANG';
    $paper = 'A4';
    $orientation = "portrait";
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
}
