<?php include('templates/adminHeader.php'); ?>

<div id="content-wrapper">
	<div class="container-fluid">
	  <!-- Breadcrumbs-->
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item">
	      <a href="#">Dashboard</a>
	    </li>
	    <li class="breadcrumb-item active">Overview</li>
	  </ol>
	  <!-- Left content -->
	  <div class="row">
	  	<div class="col-xs-12 col-sm-6 col-md-3 pbox">
  			<?php if(isset($recentOrder) && $recentOrder != FALSE){ ?>
  				<div class="box">
		  			<h6 class="recentTitle" style="text-shadow: 2px 2px 3px #000000;">Commande Recente</h6>
		  			<hr>
		  			<p><?php echo $recentOrder['nom'] ?></p>
		  			<p>Statut: <?php echo $recentOrder['statut'] ?></p>
		  			<p>Montant: <?php echo floatval($recentOrder['montantht']) ?></p>
		  			<p><?php echo $recentOrder['date'] ?></p>
		  		</div>
	  		<?php }else{?>
	  			<p class="h6 text-info">Pas de commandes passees</p>
	  		<?php } ?>

	  		<div class="listbox">
	  			<h6 class="recentTitle" style="text-shadow: 1px 1px 1px #000000;">Liste de commandes par</h6>
	  			<ul class="list-group">
	  				<li class="list-group-item"><a href="#">Clients</a></li>
	  				<li class="list-group-item"><a href="#">Commerciaux</a></li>
	  			</ul>	  			
	  		</div>
	  	</div>

	  	<div class="col-xs-12 col-sm-6 col-md-9">
	  		<h4 class="text-center" style="text-shadow: 2px 2px 2px #078;">Historiques des commandes</h4>
	  		<?php if(isset($commandes) && $commandes != FALSE){ ?>
	  			<?php foreach ($commandes as $key => $value) { ?>
	  				<div class="mbox">
			  			<p style="color: #001122;text-shadow: 2px 2px 2px #078;"><?php echo strtoupper($value['name']) ?></p>
			  			<p>Montant: <?php echo floatval($value['montantHT']) ?></p>
			  			<p><?php echo $value['updated_at'] ?></p>
			  		</div>
	  			<?php } ?>
	  			<?php if (isset($pagination)) {
	  				echo '<br/>'.$pagination;
	  			} ?>
	  		<?php }else{?>
	  			<p class="h6 text-info">Pas de commandes trouvees</p>
	  		<?php } ?>
	  	</div>
	  </div>
	  <!-- Middle content -->
	  
	</div>
</div>

<?php include('templates/adminFooter.php'); ?>
