<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?= $judul; ?></title>
  <link href="<?= site_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?= site_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/tables/DataTables-1.11.5/css/jquery.dataTables.min.css" type="text/css">
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/tables/DataTables-1.11.5/css/dataTables.bootstrap4.min.css" type="text/css">
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/tables/Buttons-2.2.2/css/buttons.bootstrap4.min.css" type="text/css">
  <script src="<?= base_url('assets'); ?>/sweetalert/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/sweetalert/dist/sweetalert2.min.css">
  <script src="<?= base_url('assets'); ?>/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets'); ?>/js/Chart.js"></script>
  <script src="<?= base_url('assets'); ?>/js/jquery-3.5.1.js"></script>
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/select2/dist/css/select2.min.css">
  <script src="<?= base_url('assets'); ?>/select2/dist/js/select2.min.js" type="text/javascript"></script>
</head>

<body id="page-top">
  <?php 
    $this->M_semua->cekstokmin();
    $this->M_semua->delnotif(); 
  ?>
  <div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('Dashboard'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fa fa-object-group"></i>
        </div>
        <div class="sidebar-brand-text mx-3">GROUPING SISTEM</div>
      </a>
      <hr class="sidebar-divider my-0">
      <?php if ($this->uri->segment(1) == 'Dashboard' || $this->uri->segment(1) == '') : ?>
        <li class="nav-item active">
          <a class="nav-link" href="<?= site_url('Dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        </li>
      <?php else : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url('Dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        </li>
      <?php endif; ?>
      <?php if ($this->session->userdata('id_role') == 1) : ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
          Master
        </div>
        <?php if ($this->uri->segment(1) == 'Jenis_barang' || $this->uri->segment(1) == 'jenis_barang' || $this->uri->segment(1) == 'Supplier' || $this->uri->segment(1) == 'Barang' || $this->uri->segment(1) == 'Member') : ?>
          <li class="nav-item active">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-fw fa-cogs"></i>
              <span>Master Data</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Komponen:</h6>
                <a class="collapse-item" href="<?= site_url('Jenis_barang'); ?>">Data Kelompok Barang</a>
                <a class="collapse-item" href="<?= site_url('Barang'); ?>">Data Barang</a>
                <a class="collapse-item" href="<?= site_url('Member'); ?>">Anggota</a>
                <a class="collapse-item" href="<?= site_url('Supplier'); ?>">Supplier</a>
              </div>
            </div>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-fw fa-cogs"></i>
              <span>Master Data</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Komponen:</h6>
                <a class="collapse-item" href="<?= site_url('Jenis_barang'); ?>">Data Kelompok Barang</a>
                <a class="collapse-item" href="<?= site_url('Barang'); ?>">Data Barang</a>
                <a class="collapse-item" href="<?= site_url('Member'); ?>">Anggota</a>
                <a class="collapse-item" href="<?= site_url('Supplier'); ?>">Supplier</a>
              </div>
            </div>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      <?php if ($this->session->userdata('id_role') == 2 || $this->session->userdata('id_role') == 1) : ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
          Transaksi
        </div>
        <?php if ($this->uri->segment(1) == 'Stok') : ?>
          <li class="nav-item active">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTree" aria-expanded="true" aria-controls="collapseTree">
              <i class="fas fa-fw fa-retweet"></i>
              <span>Stok Barang</span>
            </a>
            <div id="collapseTree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Komponen:</h6>
                <a class="collapse-item" href="<?= site_url('Stok/in'); ?>">Masuk</a>
                <a class="collapse-item" href="<?= site_url('Stok/out'); ?>">Keluar</a>
              </div>
            </div>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTree" aria-expanded="true" aria-controls="collapseTree">
              <i class="fas fa-fw fa-retweet"></i>
              <span>Stok Barang</span>
            </a>
            <div id="collapseTree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Komponen:</h6>
                <a class="collapse-item" href="<?= site_url('Stok/in'); ?>">Masuk</a>
                <a class="collapse-item" href="<?= site_url('Stok/out'); ?>">Keluar</a>
              </div>
            </div>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      <?php if ($this->session->userdata('id_role') == 1) : ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
          Laporan
        </div>
        <?php if ($this->uri->segment(1) == 'Laporan' && $this->uri->segment(2) == '') : ?>
          <li class="nav-item active">
            <a class="nav-link" href="<?= site_url('Laporan'); ?>">
              <i class="fas fa-fw fa-book-open"></i>
              <span>Kartu Stok</span></a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('Laporan'); ?>">
              <i class="fas fa-fw fa-book-open"></i>
              <span>Kartu Stok</span></a>
          </li>
        <?php endif; ?>
        <?php if ($this->uri->segment(1) == 'Laporan' && $this->uri->segment(2) == 'stok') : ?>
          <li class="nav-item active">
            <a class="nav-link" href="<?= site_url('Laporan/stok'); ?>">
              <i class="fas fa-fw fa-book"></i>
              <span>Daftar Stok</span></a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('Laporan/stok'); ?>">
              <i class="fas fa-fw fa-book"></i>
              <span>Daftar Stok</span></a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      <hr class="sidebar-divider my-0">
      <hr class="sidebar-divider d-none d-md-block">
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <?php $jml_pesan = $this->db->get("notif")->num_rows(); ?>
                <?php if ($jml_pesan > 0) : ?>
                  <span class="badge badge-danger badge-counter" id="jmlp"><?= $jml_pesan; ?></span>
                <?php endif; ?>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Notifikasi
                  <?php if ($jml_pesan > 0) : ?>
                    <a type="button" class="float-right text-white" style="text-decoration:none" onclick="baca_all()">Baca Semua</a>
                  <?php endif; ?>
                </h6>
                <div style="height: 300px; overflow-y: scroll;">
                  <?php $notif = $this->db->query("SELECT * FROM notif ORDER BY id DESC")->result(); ?>
                  <?php if ($jml_pesan > 0) : ?>
                    <?php foreach ($notif as $n) : ?>
                      <a class="dropdown-item d-flex align-items-center" href="<?= $n->url; ?>" type="button" onclick="hapus_notif(<?= $n->id; ?>)">
                        <div class="mr-3">
                          <div class="icon-circle <?= $n->background; ?>">
                            <?= $n->icon; ?>
                          </div>
                        </div>
                        <div>
                          <div class="small text-gray-500"><?= date("d-m-Y, H:i:s", strtotime($n->tgl)); ?></div>
                          <?php $userr = $this->db->get_where("user", ["username" => $n->username])->row(); ?>
                          <?php if($userr) : ?>
                            <span class="font-weight-bold"><?= $userr->nama . ", " . $n->pesan; ?></span>
                          <?php else : ?>
                            <span class="font-weight-bold"><?= $n->pesan; ?></span>
                          <?php endif; ?>
                        </div>
                      </a>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <a class="dropdown-item d-flex align-items-center" href="#" type="button">
                      <div class="mr-3">
                        <div class="icon-circle bg-secondary">
                          <i class="fas fa-ban text-white"></i>
                        </div>
                      </div>
                      <div>
                        <div class="small text-gray-500">--/--/----</div>
                        <span class="font-weight-bold">Tidak Ada Notif</span>
                      </div>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->session->userdata("nama"); ?></span>
                <img class="img-profile rounded-circle" src="<?= base_url("assets/img/user/") . $this->session->userdata('image'); ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <!-- <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a> -->
                <a class="dropdown-item" href="<?= site_url('Profile/ubah_password') ?>">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Ubah Password
                </a>
                <div class="dropdown-divider"></div>
                <button type="button" class="dropdown-item" onclick="keluar()">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Keluar
                </button>
              </div>
            </li>

          </ul>
        </nav>
        <div class="container-fluid">
          <h1 class="h3 mb-4 text-gray-800"><?= $content; ?></h1>
        </div>
      </div>
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Kerja Praktek</span>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script>
    function hapus_notif(id) {
      $.ajax({
        url: "<?= site_url('Dashboard/hapus_notif/') ?>" + id,
        type: "POST",
        dataType: "JSON",
      });
    }

    function baca_all() {
      $.ajax({
        url: "<?= site_url('Dashboard/hapus_notif_semua/') ?>",
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $('#jmlp').text('');
            var link = "<?= $this->uri->segment(1); ?>";
            if (link == 'Stok' || link == 'stok') {
              var link2 = "/" + "<?= $this->uri->segment(2); ?>";
            } else {
              var link2 = "";
            }
            location.href = "<?= site_url() ?>" + link + link2;

          }
        }
      });
    }

    function keluar() {
      Swal.fire({
        title: 'KELUAR',
        text: "Yakin ingin keluar ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Keluar',
        CancelButtonText: 'Tidak'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= site_url('Auth/keluar') ?>",
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              if (data.status == 1) {
                Swal.fire({
                  title: 'KELUAR',
                  html: 'Berhasil dilakukan',
                  icon: 'success',
                }).then((value) => {
                  location.href = "<?php echo base_url() ?>Auth";
                });
              } else {
                Swal.fire(
                  'KELUAR',
                  'Gagal dilakukan !',
                  'danger'
                );
              }
            }
          });
        }
      })
    }
  </script>

  <script>
    initailizeSelect2_jenis();
    initailizeSelect2_barang();
    initailizeSelect2_supplier();

    function initailizeSelect2_jenis() {
      $('.select2_jenis').select2({
        allowClear: true,
        multiple: false,
        placeholder: '--- Pilih Jenis Barang ---',
        // minimumInputLength: 2,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?php echo base_url(); ?>Jenis_barang/data_jenis_barang",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },

          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_supplier() {
      $('.select2_supplier').select2({
        allowClear: true,
        multiple: false,
        placeholder: '--- Pilih Supplier ---',
        // minimumInputLength: 2,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?php echo base_url(); ?>Supplier/data_supplier",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },

          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_barang() {
      $('.select2_barang').select2({
        allowClear: true,
        multiple: false,
        placeholder: '--- Pilih Barang ---',
        // minimumInputLength: 2,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?php echo base_url(); ?>Barang/data_barang",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },

          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function separateComma(val) {
      var sign = 1;
      if (val < 0) {
        sign = -1;
        val = -val;
      }
      let num = val.toString().includes('.') ? val.toString().split('.')[0] : val.toString();
      let len = num.toString().length;
      let result = '';
      let count = 1;
      for (let i = len - 1; i >= 0; i--) {
        result = num.toString()[i] + result;
        if (count % 3 === 0 && count !== 0 && i !== 0) {
          result = ',' + result;
        }
        count++;
      }
      if (val.toString().includes('.')) {
        result = result + '.' + val.toString().split('.')[1];
      }
      return sign < 0 ? '-' + result : result;
    }
  </script>
  <!-- <script src="<?= site_url('assets/'); ?>vendor/jquery/jquery.min.js"></script> -->
  <script src="<?= site_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= site_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?= site_url('assets/'); ?>js/sb-admin-2.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/DataTables-1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/DataTables-1.11.5/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/Buttons-2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/Buttons-2.2.2/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/JSZip-2.5.0/jszip.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/Buttons-2.2.2/js/buttons.html5.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/Buttons-2.2.2/js/buttons.print.min.js"></script>
  <script src="<?= base_url('assets'); ?>/tables/Buttons-2.2.2/js/buttons.colVis.min.js"></script>
  <script src="<?= base_url('assets'); ?>/sweetalert/dist/sweetalert2.all.min.js"></script>

  <script>
    var table;
    var table = $('#master_datatable').DataTable({
      "columnDefs": [{
        "targets": [-1],
        "orderable": true,
      }],
      "oLanguage": {
        "sEmptyTable": "<div class='text-center'>Data Kosong</div>",
        "sInfoEmpty": "",
        "sInfoFiltered": "<div style='font-size: 15px;'> - Dipilih dari _MAX_ data</div>",
        "sSearch": "<div style='font-size: 15px;'>Pencarian Data : </div>",
        "sInfo": "<div style='font-size: 15px;'> Jumlah _TOTAL_ Data (_START_ - _END_)</div>",
        "sLengthMenu": "<div style='font-size: 15px;'>_MENU_ Baris</div>",
        "sZeroRecords": "<div class='text-center'>Tida ada data</div>",
      },
      paging: false,
      ordering: true,
      info: false,
    });
  </script>

</body>

</html>