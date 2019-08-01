<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Siap Pharma <?php if (isset($title)) {  echo $title;  } ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo site_url('/assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/css/jquery-ui.min.css'); ?>">
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
    

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo site_url('/assets/css/business-casual.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo site_url('/assets/css/footable.bootstrap.min.css'); ?>">

    <!-- website logo for browsers -->
    <link rel="shortcut icon" href="<?php echo site_url('/assets/img/logo.ico'); ?>" type="image/x-icon" />

    <link rel="stylesheet" href="<?php echo site_url('/assets/css/myStyle.css'); ?>">
    <link href="<?php echo site_url('/assets/chosen/chosen.css'); ?>" rel="stylesheet" />
    <script src="<?php echo site_url('/assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo site_url('/assets/js/jquery-ui.min.js'); ?>"></script>
    <script src="<?php echo site_url('/assets/chosen/chosen.jquery.js'); ?>"></script>
    <script src="<?php echo site_url('/assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo site_url('/assets/js/moment.js'); ?>"></script>
    <script src="<?php echo site_url('/assets/js/footable.min.js'); ?>"></script>
    
    <script>
      $(document).ready(function(){
          $(".chosen").chosen({no_results_text: "Oops, pas de resultat!"});
      });
    </script>
  </head>

  <body>

   <!--  <h1 class="site-heading text-center text-white d-none d-lg-block">
      <span class="site-heading-upper text-primary mb-3">Société Interafricaine des Produits Pharmaceutiques et Parapharmaceutiques</span>
      <span class="site-heading-lower">SIAP PHARMA</span>
    </h1> -->

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
      <div class="container">
        <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="<?php echo site_url("home") ?>">Siap pharma</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav mx-auto">
            <?php if(isset($this->session->id)){
                echo '
                  <li class="nav-item active px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="'.site_url("home").'">Acceuil
                      <span class="sr-only">(current)</span>
                    </a>
                  </li>
                  <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="'.site_url("statCommandes").'">Statistiques</a>
                  </li>
                  <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="'.site_url("commandeclient").'">Passer une commande</a>
                  </li>
                  <li class="nav-item px-lg-4">
                  <a class="nav-link text-uppercase text-expanded" href="'.site_url("logout").'">Se déconnecter</a>
                  </li>
                ';
              }
              else{
                    echo '<li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="'.site_url("login").'">Connexion</a>
                  </li>';
                } ?>
          </ul>
        </div>
      </div>
    </nav>
<!-- retrieving the base url for javascript -->
<p hidden id="baseurl"><?php echo site_url(); ?></p>