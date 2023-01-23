<?php 
class Profile extends CI_Controller{
  function __construct()
  {
    parent::__construct();
  }
  function ubah_password(){
    $data = [
      'judul' => "Ubah Password"
    ];
    $this->template->load("Template/Dashboard", "Profile/Password", $data);
  }
  function simpan_password(){
    $id = $this->session->userdata('id');
    $new_password = md5($this->input->post('password1'));
    $this->db->set('password', $new_password);
    $this->db->where('id', $id);
    $this->db->update('user');
    echo json_encode(['status' => 1]);
  }
}
?>