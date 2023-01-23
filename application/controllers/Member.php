<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
{
  public function index()
  {
    $data = [
      'judul' => 'Daftar Anggota',
      'sebagai' => $this->db->get_where('role', ['id_role'=>$this->session->userdata('id_role')])->row(),
      'anggota' => $this->db->query("SELECT u.*, r.role FROM user u JOIN role r ON u.id_role=r.id_role")->result(),
    ];
    $this->template->load('Template/Dashboard', 'Anggota/Data', $data);
  }

  function cetak()
  {
    $date = date("D, d-m-Y");
    $sql = $this->db->query("SELECT u.*, r.role FROM user u JOIN role r ON r.id_role=u.id_role")->result();
    $data = [
      'tanggal' => $date,
      'judul' => 'DATA ANGGOTA',
      'sql' => $sql,
    ];
    $html = $this->template->load("Template/Cetak", "Anggota/Cetak", $data, TRUE);
    $file_pdf = 'DATA ANGGOTA';
    $paper = 'A4';
    $orientation = "landscape";
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }

  public function tambah()
  {
    $data = [
      'judul' => 'Tambah Anggota',
      'sebagai' => $this->db->get('role')->result(),
      'anggota' => $this->db->query("SELECT u.*, r.role FROM user u JOIN role r ON u.id_role=r.id_role")->result(),
    ];
    $this->template->load('Template/Dashboard', 'Anggota/Tambah', $data);
  }

  public function ubah($id)
  {
    $data = [
      'judul' => 'Ubah Anggota',
      'sebagai' => $this->db->get('role')->result(),
      'anggota' => $this->db->query("SELECT u.*, r.role FROM user u JOIN role r ON u.id_role=r.id_role WHERE u.id = '$id'")->row(),
    ];
    $this->template->load('Template/Dashboard', 'Anggota/Ubah', $data);
  }

  public function tambahkan(){
    $username = $this->input->post("username");
    $password = $this->input->post("password");
    $nama = $this->input->post("nama");
    $alamat = $this->input->post("alamat");
    $id_role = $this->input->post("id_role");
    $no_telepon_whatsapp = $this->input->post("no_telepon_whatsapp");
    $data = [
      'username' => $username,
      'password' => md5($password),
      'nama' => $nama,
      'alamat' => $alamat,
      'no_telepon_whatsapp' => $no_telepon_whatsapp,
      'id_role' => $id_role,
      'on_off' => 0
    ];
    $cek = $this->db->insert('user', $data);
    $sql = $this->db->query("SELECT * FROM user ORDER BY id DESC LIMIT 1")->result();
    $username = $this->session->userdata('username');
    foreach ($sql as $s) {
      $dnot = [
        'kunci' => $s->id,
        'pesan' => "Menambahkan Member '" . $s->nama . "'",
        'username' => $username,
        'url' => "Member",
        "icon" => '<i class="fas fa-save text-white"></i>',
        "background" => "bg-primary",
      ];
      $this->db->insert("notif", $dnot);
    }
    if($cek){
      echo json_encode(['status'=>1]);
    } else {
      echo json_encode(['status'=>0]);
    }
  }

  public function ubahkan(){
    $id = $this->input->post("id");
    $username = $this->input->post("username");
    $nama = $this->input->post("nama");
    $alamat = $this->input->post("alamat");
    $id_role = $this->input->post("id_role");
    $no_telepon_whatsapp = $this->input->post("no_telepon_whatsapp");
    $data = [
      'username' => $username,
      'nama' => $nama,
      'alamat' => $alamat,
      'no_telepon_whatsapp' => $no_telepon_whatsapp,
      'id_role' => $id_role,
      'on_off' => 0
    ];
    $where = [
      'id' => $id,
    ];
    $cek = $this->db->update('user', $data, $where);
    $sql = $this->db->query("SELECT * FROM user WHERE id = '$id'")->row();
    $username = $this->session->userdata('username');
    $dnot = [
      'kunci' => $sql->id,
      'pesan' => "Mengubah Member '" . $sql->nama . "'",
      'username' => $username,
      'url' => "Member",
      "icon" => '<i class="fas fa-edit text-white"></i>',
      "background" => "bg-warning",
    ];
    $this->db->insert("notif", $dnot);
    if($cek){
      echo json_encode(['status'=>1]);
    } else {
      echo json_encode(['status'=>0]);
    }
  }

  public function hapus($id)
  {
    $username = $this->session->userdata('username');
    $sql = $this->db->get_where("user", ["id" => $id])->row();
    $dnot = [
      'kunci' => $id,
      'pesan' => "Menghapus Member '" . $sql->nama . "'",
      'username' => $username,
      'url' => "Member",
      "icon" => '<i class="fas fa-trash text-white"></i>',
      "background" => "bg-danger",
    ];
    $this->db->insert("notif", $dnot);
    $cek = $this->db->delete('user', ['id' => $id]);
    if($cek){
      echo json_encode(['status'=>1]);
    } else {
      echo json_encode(['status'=>0]);
    }
  }
}