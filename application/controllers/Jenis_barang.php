<?php
class Jenis_barang extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library('pdfgenerator');
  }
  function index()
  {
    $data = [
      'judul' => 'Master Jenis Barang',
      'data'  => $this->db->get("jenis_barang")->result()
    ];
    $this->template->load('Template/Dashboard', 'Jenis_barang/Data', $data);
  }
  function get_data($id){
    $data = $this->db->get_where("jenis_barang", ["id" => $id])->row();
    echo json_encode($data);
  }
  function olahdata($param){
    $username = $this->session->userdata('username');
    $id = $this->input->get("id");
    $jenis_barang = $this->input->get("jenis_barang");
    if($param == 1){
      $data = [
        'jenis_barang' => $jenis_barang,
      ];
      $this->db->insert("jenis_barang", $data);
      $jns = $this->db->query("SELECT * FROM jenis_barang ORDER BY id DESC LIMIT 1")->result();
      foreach($jns as $j){
        $dnot = [
          'kunci' => $j->id,
          'pesan' => "Menambahkan Jenis Barang '".$j->jenis_barang."'",
          'username' => $username,
          'url' => "Jenis_barang",
          "icon" => '<i class="fas fa-save text-white"></i>',
          "background" => "bg-primary",
        ];
        $this->db->insert("notif", $dnot);
      }
      echo json_encode(["status" => 1]);
    } else {
      $this->db->set("jenis_barang", $jenis_barang);
      $this->db->where("id", $id);
      $this->db->update("jenis_barang");
      $dnot = [
        'kunci' => $id,
        'pesan' => "Mengubah Jenis Barang '".$jenis_barang."'",
        'username' => $username,
        'url' => "Jenis_barang",
        "icon" => '<i class="fas fa-edit text-white"></i>',
        "background" => "bg-warning",
      ];
      $this->db->insert("notif", $dnot);
      echo json_encode(["status" => 1]);
    }
  }
  function hapus($id){
    $username = $this->session->userdata('username');
    $jns = $this->db->get_where("jenis_barang", ["id"=>$id])->row();
    $dnot = [
      'kunci' => $id,
      'pesan' => "Menghapus Jenis Barang '".$jns->jenis_barang."'",
      'username' => $username,
      'url' => "Jenis_barang",
      "icon" => '<i class="fas fa-trash text-white"></i>',
      "background" => "bg-danger",
    ];
    $this->db->insert("notif", $dnot);
    $this->db->delete("jenis_barang", ["id" => $id]);
    echo json_encode(["status" => 1]);
  }
  function data_jenis_barang()
  {
    $key = $this->input->post('searchTerm');
    if($key != ''){
      $data = $this->db->query("SELECT id AS id, jenis_barang AS text FROM jenis_barang WHERE id LIKE '%" . $key . "%' OR jenis_barang LIKE '%" . $key . "%' ORDER BY jenis_barang ASC")->result();
    } else {
      $data = $this->db->query("SELECT id AS id, jenis_barang AS text FROM jenis_barang")->result();
    }
    echo json_encode($data);
  }
  function cetak(){
    $date = date("D, d-m-Y");
    $sql = $this->db->get("jenis_barang")->result();
    $data = [
      'tanggal' => $date,
      'judul' => 'MASTER jenis_barang',
      'sql' => $sql,
    ];
    $html = $this->template->load("Template/Cetak", "jenis_barang/cetak", $data, TRUE);
    $file_pdf = 'MASTER jenis_barang';
    $paper = 'A4';
    $orientation = "portrait";
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }
}