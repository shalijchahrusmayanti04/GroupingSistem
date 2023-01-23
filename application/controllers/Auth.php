<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->M_semua->cekstokmin();
    $this->M_semua->delnotif();
  }
  public function index()
  {
    $data = [
      'judul' => 'SELAMAT DATANG',
    ];
    $this->template->load('Template/Auth', 'Auth/Login', $data);
  }
  public function regist(){
    $data = [
      'judul' => 'SELAMAT BERGABUNG',
    ];
    $this->template->load('Template/Auth', 'Auth/Regist', $data);
  }
  public function cekuser_regist($username){
    $data = $this->db->get_where("user", ["username"=> $username])->num_rows();
    if($data == 0){
      echo json_encode(["status"=>1]);
    } else {
      echo json_encode(["status"=>0]);
    }
  }
  public function daftarkan(){
    $username = $this->input->post("username");
    $password = $this->input->post("password");
    $nama = $this->input->post("nama");
    $No_Telepon_Whatsapp = $this->input->post("No.Telepon/Whatsapp");
    $alamat = $this->input->post("alamat");
    $data = [
      'username' => $username,
      'password' => md5($password),
      'nama' => $nama,
      'No.Telepon/Whatsapp' => $No_Telepon_Whatsapp,
      'alamat' => $alamat,
      'id_role' => 2,
    ];
    $cek = $this->db->insert("user", $data);
    if($cek){
      echo json_encode(["status"=>1]);
    } else {
      echo json_encode(["status"=>0]);
    }
  }
  public function cekuser($username){
    $data = $this->db->get_where("user", ["username"=>$username]);
    if($data->num_rows() > 0){
      echo json_encode(["status"=>1]);
    } else {
      echo json_encode(["status"=>0]);
    }
  }
  public function cekpassword($username, $password){
    $data = $this->db->get_where("user", ["username"=>$username])->row_array();
    if($data["password"] == md5($password)){
      $this->db->query("UPDATE user set on_off = 1 WHERE username = '$username'");
      $this->session->set_userdata($data);
      echo json_encode(["status"=>1]);
    } else {
      echo json_encode(["status"=>0]);
    }
  }
  public function keluar()
  {
    $this->db->set('on_off', 0);
    $this->db->where('username', $this->session->userdata('username'));
    $this->db->update('user');
    $this->session->sess_destroy();
    echo json_encode(["status"=>1]);
  }
}
