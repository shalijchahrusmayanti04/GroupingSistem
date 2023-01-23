<?php
class M_invoice extends CI_Model
{
  public function kode_barang()
  {
    $sql = "SELECT kode_barang FROM barang ORDER BY kode_barang DESC LIMIT 1";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
      $row = $query->row();
      $n = (substr($row->kode_barang, 3)) + 1;
      $no = sprintf("%'.04d", $n);
    } else {
      $no = "0001";
    }
    $invoice = 'BRG' . $no;
    return $invoice;
  }
  public function invoice_masuk()
  {
    $sql = "SELECT invoice_masuk FROM in_header ORDER BY invoice_masuk DESC LIMIT 1";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
      $row = $query->row();
      $n = (substr($row->invoice_masuk, 12)) + 1;
      $no = sprintf("%'.03d", $n);
    } else {
      $no = "001";
    }
    $invoice = 'TER-'.date("Ymd") . $no;
    return $invoice;
  }
  public function invoice_keluar()
  {
    $sql = "SELECT invoice_keluar FROM out_header ORDER BY invoice_keluar DESC LIMIT 1";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
      $row = $query->row();
      $n = (substr($row->invoice_keluar, 12)) + 1;
      $no = sprintf("%'.03d", $n);
    } else {
      $no = "001";
    }
    $invoice = 'KEL-'.date("Ymd") . $no;
    return $invoice;
  }
}