<?php 
class M_semua extends CI_Model{
  public function cekstokmin(){
    $cek = $this->db->query("SELECT * FROM transaksi WHERE stok_hasil <= 5")->result();
    foreach ($cek as $c) {
      $cek2 = $this->db->query("SELECT kunci FROM notif WHERE kunci = '$c->kode_barang'")->num_rows();
      if($cek2 < 1){
        if((int)$c->stok_hasil < 1){
          $hasil = $c->barang . " habis / kosong";
        } else {
          $hasil = $c->barang . " tersisa ".$c->stok_hasil;
        }
        $data = [
          'kunci' => $c->kode_barang,
          'username' => $c->kode_barang,
          'pesan' => $hasil,
          'url' => "Laporan/stok",
          'icon' => '<i class="fas fa-box text-white"></i>',
          'background' => 'bg-danger',
        ];
        return $this->db->insert("notif", $data);
      } else {
        $pesan = $c->barang . " tersisa " . $c->stok_hasil;
        return $this->db->query("UPDATE notif SET pesan = '$pesan' WHERE kunci = '$c->kode_barang'");
      }
    }
  }
  public function delnotif(){
    $cekstok2 = $this->db->query("SELECT * FROM transaksi WHERE stok_hasil > 5")->result();
    foreach ($cekstok2 as $c2) {
      $cek = $this->db->query("SELECT * FROM notif WHERE kunci = '$c2->kode_barang'")->num_rows();
      if($cek > 0){
        return $this->db->query("DELETE FROM notif WHERE kunci = '$c2->kode_barang'");
      }
    }
  }
}
?>