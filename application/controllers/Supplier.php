<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{
  public function index()
  {
    $data = [
      'judul' => 'Daftar Supplier',
      'vendor' => $this->db->get("supplier")->result(),
    ];
    $this->template->load('Template/Dashboard', 'Supplier/Data', $data);
  }

  function cetak(){
    $date = date("D, d-m-Y");
    $sql = $this->db->query("SELECT * FROM supplier")->result();
    $data = [
      'tanggal' => $date,
      'judul' => 'DATA SUPPLIER',
      'sql' => $sql,
    ];
    $html = $this->template->load("Template/Cetak", "Supplier/cetak", $data, TRUE);
    $file_pdf = 'DATA SUPPLIER';
    $paper = 'A4';
    $orientation = "landscape";
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }

  function data_supplier()
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query("SELECT id AS id, nama AS text FROM supplier WHERE id LIKE '%" . $key . "%' OR nama LIKE '%" . $key . "%' ORDER BY nama ASC")->result();
    } else {
      $data = $this->db->query("SELECT id AS id, nama AS text FROM supplier")->result();
    }
    echo json_encode($data);
  }

  public function tambah()
  {
    $data = [
      'judul' => 'Tambah supplier',
    ];
    $this->template->load('Template/Dashboard', 'Supplier/Tambah', $data);
  }

  public function ubah($id)
  {
    $data = [
      'judul' => 'Ubah supplier',
      'supplier' => $this->db->get_where('supplier', ['id'=>$id])->row(),
    ];
    $this->template->load('Template/Dashboard', 'Supplier/Edit', $data);
  }

  public function ubahkan()
  {
    $id = $this->input->get("id");
    $nama = $this->input->get("nama");
    $alamat = $this->input->get("alamat");
    $no_telepon_whatsapp = $this->input->get("no_telepon_whatsapp");
    $npwp = $this->input->get("npwp");
    $data = [
      'nama' => $nama,
      'alamat' => $alamat,
      'npwp' => $npwp,
      'no_telepon_whatsapp' => $no_telepon_whatsapp,
    ];
    $where = [
      'id' => $id,
    ];
    $cek = $this->db->update('supplier', $data, $where);
    $sql = $this->db->query("SELECT * FROM supplier WHERE id = '$id'")->row();
    $username = $this->session->userdata('username');
    $dnot = [
      'kunci' => $sql->id,
      'pesan' => "Mengubah Supplier '" . $sql->nama . "'",
      'username' => $username,
      'url' => "Supplier",
      "icon" => '<i class="fas fa-edit text-white"></i>',
      "background" => "bg-warning",
    ];
    $this->db->insert("notif", $dnot);
    if ($cek) {
      echo json_encode(['status' => 1, 'sat'=>$data]);
    } else {
      echo json_encode(['status' => 0]);
    }
  }

  public function tambahkan()
  {
    $nama = $this->input->post("nama");
    $no_telepon_whatsapp = $this->input->post("no_telepon_whatsapp");
    $alamat = $this->input->post("alamat");
    $npwp = $this->input->post("npwp");
    $data = [
      'nama' => $nama,
      'no_telepon_whatsapp' => $no_telepon_whatsapp,
      'alamat' => $alamat,
      'npwp' => $npwp,
    ];
    $cek = $this->db->insert('supplier', $data);
    $sql = $this->db->query("SELECT * FROM supplier ORDER BY id DESC LIMIT 1")->result();
    $username = $this->session->userdata('username');
    foreach ($sql as $s) {
      $dnot = [
        'kunci' => $s->id,
        'pesan' => "Menambahkan Supplier '" . $s->nama . "'",
        'username' => $username,
        'url' => "Supplier",
        "icon" => '<i class="fas fa-save text-white"></i>',
        "background" => "bg-primary",
      ];
      $this->db->insert("notif", $dnot);
    }
    if ($cek) {
      echo json_encode(['status' => 1]);
    } else {
      echo json_encode(['status' => 0]);
    }
  }

  public function hapus($id)
  {
    $username = $this->session->userdata('username');
    $sql = $this->db->get_where("supplier", ["id" => $id])->row();
    $dnot = [
      'kunci' => $id,
      'pesan' => "Menghapus Supplier '" . $sql->nama . "'",
      'username' => $username,
      'url' => "Supplier",
      "icon" => '<i class="fas fa-trash text-white"></i>',
      "background" => "bg-danger",
    ];
    $this->db->insert("notif", $dnot);
    $cek = $this->db->delete('supplier', ['id' => $id]);
    if ($cek) {
      echo json_encode(['status' => 1]);
    } else {
      echo json_encode(['status' => 0]);
    }
  }
}