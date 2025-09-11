<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rapor AIS </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>aset/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>aset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>aset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>aset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>aset/dist/css/adminlte.min.css">
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>aset/dist/img/logo.png">
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">
            <?php
            // Ambil tahun ajaran aktif langsung dari database
            $CI =& get_instance();
            $tahunAjaranAktif = $CI->db->get_where('tahun_ajaran', ['status' => 'aktif'])->row();
            $tahunAjaranNama = $tahunAjaranAktif ? $tahunAjaranAktif->nama_tahun : '-';

            // Ambil semester aktif dari database
            $semesterAktif = $CI->db->get_where('semester', ['status' => 'aktif'])->row();
            $semesterNama = $semesterAktif ? $semesterAktif->nama_semester : '-';

            echo "Tahun Ajaran: <b>{$tahunAjaranNama}</b> &nbsp; Semester: <b>{$semesterNama}</b>";
            ?>
          </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo site_url(); ?>" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo site_url('login/logout'); ?>" class="nav-link">Log Out</a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Role: <b><?php echo $this->session->userdata('role'); ?></b></a>
        </li> -->
        <!-- <li class="nav-item d-none d-sm-inline-block">
          <marquee behavior="scroll" direction="right">CEPETAAANNN
            <img src="https://media.tenor.com/h5b-nbmzlT8AAAAi/pepeeee.gif" alt="Wadaws" width="20" height="20">
          </marquee>
        </li> -->
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link" style="color: blue;">Role: <b><?php echo $this->session->userdata('role'); ?></b></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">
            <span id="jam"></span>
          </a>
        </li>
        <script>
          function updateClock() {
            const now = new Date();
            const jam = now.toLocaleTimeString('en-US', {
              hour12: false
            });
            document.getElementById('jam').innerHTML = jam;
          }
          setInterval(updateClock, 1000);
          updateClock();
        </script>
      </ul>
    </nav>
    <!-- /.navbar -->