<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php if (isset($title)) {  echo $title;  } ?>Siap pharma - Dashboard</title>


    <!-- Bootstrap core CSS-->
    <link href="<?php echo site_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- jquery ui -->
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/css/jquery-ui.min.css'); ?>">

    <!-- Custom fonts for this template-->
    <link href="<?php echo site_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="<?php echo site_url('assets/vendor/css/sb-admin.css'); ?>" rel="stylesheet">

    <!-- Chosen style -->
    <link href="<?php echo site_url('/assets/chosen/chosen.css'); ?>" rel="stylesheet" />

    <!-- website logo for browsers -->
    <link rel="shortcut icon" href="<?php echo site_url('/assets/img/logo.ico'); ?>" type="image/x-icon" />

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="index.html">Siap Pharma</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
<!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="#">Activity Log</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="admindlogout" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="admindashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder"></i>
            <span>Credentials</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">Login Screens:</h6>
            <?php
              if(isset($this->session->id)){
                echo '<a class="dropdown-item" href="admindlogout">Logout</a>';
              }
              else{
                echo '<a class="dropdown-item" href="admindlogin">Login</a>';
              }
            ?>
            <!-- <a class="dropdown-item" href="forgot-password.html">Forgot Password</a> -->
            <div class="dropdown-divider"></div>
          </div>
        </li>
        <?php
          if(isset($this->session->id) && isset($this->session->isAdmin) && $this->session->isAdmin == 1){
              echo '<li class="nav-item">
                <a class="nav-link" href="createclient">
                  <i class="fa fa-registered"></i>
                  <span>Enregistrer un nouveau Client</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="alteruser">
                  <i class="fa fa-user" aria-hidden="true"></i>
                  <span>Modifier les informations d\'un client</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="clients">
                  <i class="fas fa-address-card" aria-hidden="true"></i>
                  <span>Gestion des clients</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="update">
                  <i class="fas fa-capsules" aria-hidden="true"></i>
                  <span>Gestion des articles</span></a>
              </li>
              ';
          }
        ?>
        
      </ul>

