<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title><?= $this->session->userdata("username"); ?> | Sistem Manajemen Aset</title>

  <link rel="icon" href="<?= base_url("assets/"); ?>files/364.jpg" type="image/jpg">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/dist/css/adminlte.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select 2 -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/select2/css/select2.css">
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.css">
  <!-- Daterangepicker -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/daterangepicker/daterangepicker.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    body {
      padding-right: 0px !important;
    }

    /* width */
    ::-webkit-scrollbar {
      width: 8px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px grey;
      border-radius: 5px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #e3e3e3;
      border-radius: 5px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #a1a1a1;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
  <input type="hidden" id="base_link" value="<?= base_url(); ?>">
  <!-- jQuery -->
  <script src="<?= base_url("assets"); ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url("assets"); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url("assets"); ?>/dist/js/adminlte.min.js"></script>
  <!-- Custom -->
  <script src="<?= base_url("assets"); ?>/dist/js/ubah_pass.js"></script>
  <!-- Wysihtml5 -->
  <script src="<?= base_url("assets"); ?>/dist/ckeditor/ckeditor.js"></script>

  <!-- Modal Konfirmasi Ya Tidak -->
  <div class="modal fade" id="frmKonfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="jdlKonfirm">Konfirmasi Hapus</h4>
        </div>
        <div class="modal-body">
          <div id="isiKonfirm"></div>
          <input type="hidden" name="id" id="id">
          <input type="hidden" name="mode" id="mode">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal" id="yaKonfirm">Iya</button>
          <button data-dismiss="modal" class="btn btn-danger" id="tidakKonfirm">Tidak</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="frmKonfirm3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="jdlKonfirm3">Konfirmasi Logout</h4>
        </div>
        <div class="modal-body">
          <div id="isiKonfirm3"></div>
          <input type="hidden" name="id" id="id3">
          <input type="hidden" name="mode" id="mode3">
        </div>
        <div class="modal-footer">
          <a href="<?= base_url('Login/logout') ?>" type="button" class="btn btn-info">Keluar</a>
          <button data-dismiss="modal" class="btn btn-danger" id="tidakKonfirm3">Tidak</button>
        </div>
      </div>
    </div>
  </div>

  <input type="hidden" name="base_link" id="base_link" value="<?= base_url() ?>">

  <!-- Bootstrap modal -->
  <div class="modal fade" id="ubah_pass" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Ubah Password</h3>
        </div>
        <form method="post" id="frm_ubahpass">
          <div class="modal-body form">
            <input type="hidden" name="pgnID" value="<?php $this->session->userdata("id_user"); ?>">
            <div class="form-group">
              <label>Password Lama</label>
              <input type="password" class="form-control infonya" name="log_pass" id="log_pass" placeholder="Password Lama" value="" required>
            </div>
            <div class="form-group">
              <label>Password Baru</label>
              <input type="password" class="form-control infonya" name="log_passBaru" id="log_passBaru" placeholder="Password Baru" value="" required>

            </div>
            <div class="form-group">
              <label>Konfirmasi Password Baru</label>
              <input type="password" class="form-control infonya" name="log_passBaru2" id="log_passBaru2" placeholder="Konfirmasi Password Baru" value="" required>
            </div>
            <div class="alert alert-danger animated fadeInDown" role="alert" id="up_infoalert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <div id="up_pesan"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="up_simpan" class="btn btn-info">Simpan</a>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-info">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <?php if ($this->session->userdata("id_user")) { ?>
        <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item" title="Logout">
            <a class="nav-link" href="#" role="button" onClick="logout(<?= $this->session->userdata("id_user") ?>)">
              <i class="fas fa-sign-out-alt"></i>
            </a>
          </li>
        </ul>
      <?php } else { ?>
        <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url("Login"); ?>" role="button">
              <i class="fas fa-user"></i> Login
            </a>
          </li>
        </ul>
      <?php } ?>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">
      <a href="<?= base_url() ?>" class="brand-link">
        <img src="<?= base_url("assets"); ?>/files/364.jpg" alt="Logo" class="brand-image img-circle">
        <span class="brand-text font-weight-light"><b>Dashboard</b></span>
      </a>
      <!-- Sidebar -->

      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <!-- <?php if (!$this->session->userdata('foto')) { ?>
              <img src="<?= $this->session->userdata('foto'); ?>" class="img-circle elevation-2" alt="User Image">
            <?php  } else { ?>
              <img src="<?= base_url('assets/dist/img/user-blank.png'); ?>" class="img-circle elevation-2" alt="User Image">
            <?php } ?> -->
            <img src="<?= base_url('assets/dist/img/user-blank.png'); ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= $this->session->userdata("nama"); ?></a>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="<?= base_url("Dashboard/tampil"); ?>" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url("ObjekWisata/tampil") ?>" class="nav-link">
                <i class="nav-icon fas fa-map-signs"></i>
                <p>
                  Data Objek Wisata
                </p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?= base_url("Kriteria/tampil") ?>" class="nav-link">
                <i class="nav-icon fas fa-tasks"></i>
                <p>
                  Data Kriteria
                </p>
              </a>
            </li> -->
            <li class="nav-item">
              <a href="<?= base_url("Alternatif/tampil") ?>" class="nav-link">
                <i class="nav-icon fas fa-map-marked-alt"></i>
                <p>
                Data Kriteria
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url("FormulaACO/tampil") ?>" class="nav-link">
                <i class="nav-icon fas fa-square-root-alt"></i>
                <p>
                Formula ACO/AHP
                </p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?= base_url("FormulaACO/tampil") ?>" class="nav-link">
                <i class="nav-icon fas fa-square-root-alt"></i>
                <p>
                Formula AHP
                </p>
              </a>
            </li> -->
        </nav>
        <nav class="mt-2 pt-3" style="border-top:1px solid #595959;">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="#" data-target="#ubah_pass" data-toggle="modal" class="nav-link">
                <i class="nav-icon fas fa-key"></i>
                <p>
                  Ubah Password
                </p>
              </a>
          </ul>
        </nav>
      </div>
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container">
          <div class="col-md-12 row-mb-2" style="background:white;border-radius:5px; color:black;">
            <b>Sistem Informasi Pencarian Rute Objek Wisata</b>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content pt-2">

        <script>
          function logout(id) {
            event.preventDefault();
            $("#peg_id").val(id);
            $("#jdlKonfirm3").html("Konfirmasi Logout");
            $("#isiKonfirm3").html("Apakah anda ingin Keluar Aplikasi ?");
            $("#frmKonfirm3").modal({
              show: true,
              keyboard: false,
              backdrop: 'static'
            });
          }
        </script>