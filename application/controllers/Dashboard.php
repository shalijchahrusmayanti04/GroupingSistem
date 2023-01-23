<?php
class Dashboard extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
  }
  function index()
  {
    $data = [
      'judul' => 'Selamat Datang',
      'barang' => $this->db->get("barang")->num_rows(),
      'in' => $this->db->query("SELECT SUM(qty) AS s_in FROM in_detail")->row(),
      'out' => $this->db->query("SELECT SUM(qty) AS s_out FROM out_detail")->row(),
    ];
    $this->template->load('Template/Dashboard', 'Dashboard/Dashboard', $data);
  }

  public function hapus_notif($id){
    $this->db->delete("notif", ["id"=> $id]);
  }

  public function hapus_notif_semua(){
    $this->db->empty_table("notif");
    echo json_encode(['status'=>1]);
  }
}