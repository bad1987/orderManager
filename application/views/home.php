<?php include('templates/header.php'); ?>

	<div class="container-fluid">
	<!-- annonce des promotions -->
	<?php if(isset($data) && $data){ ?>
		<section id="annoncepromo">
			<div>Des promotions sont disponibles </div>
		<div><span>en bas de la page</span></div>
		</section>
	<?php } ?>

		<!-- annimer les images -->

		<!-- tous les produits -->
		<div class="row">

			<div class="col-auto col-sm-8 col-md-8" id="li_left">
				<h1 class="li_h1 text-center">Nos produits</h1>
				<a href="<?php echo site_url("/commandeclient"); ?>" class="btn passcmd">PAssez votre commande</a>
				<hr>
			    <ul class="list-inline" id="filter">
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/A") ?>">A</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/B") ?>">B</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/C") ?>">C</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/D") ?>">D</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/E") ?>">E</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/F") ?>">F</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/G") ?>">G</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/H") ?>">H</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/I") ?>">I</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/J") ?>">J</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/K") ?>">K</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/L") ?>">L</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/M") ?>">M</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/N") ?>">N</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/O") ?>">O</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/P") ?>">P</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/Q") ?>">Q</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/R") ?>">R</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/S") ?>">S</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/T") ?>">T</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/U") ?>">U</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/V") ?>">V</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/W") ?>">W</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/X") ?>">X</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/Y") ?>">Y</a></li>
			      <li class="list-inline-item"><a href="<?php echo site_url("filter/Z") ?>">Z</a></li>
			    </ul>
				<hr>
				<div class="row">
					<?php if(isset($listing) && $listing != false){ ?>
						<?php foreach($listing as $value){ ?>
							<?php $uri = '/assets/img/articles/'.$value['imageLink']; ?>
							<div class="thumbnail">
								<img class="img-responsive" src="<?php echo site_url($uri); ?>">
								<div class="caption">
									<p><?php echo $value['designArt']; ?></p>
								</div>
							</div>
						<?php } ?>
					<?php }else{?>
						<p class="card-header">Non disponible pour l'instant</p>
					<?php } ?>
					
				</div>
				<?php if (isset($pagination)) {
  				echo '<br/>'.$pagination;
  			} ?>
			</div>

			<div class="col col-sm-4 col-md-4" id="li_right">
				<!-- <h2>Produits en promotion</h2> -->
				<?php if(isset($data) && $data){ ?>

					<div class="card" id="promo">
						<div class="card-header">
							Promotions
						</div>
						<ul class="list-group list-group-flush">
						<?php foreach($data as $subarray){ ?>
							<li class="list-group-item"><a href="<?php echo site_url("detailpromo").'/'.$subarray['id_article']; ?>"><?php echo $subarray['designArt']; ?></a></li>
						<?php } ?>	
						</ul>
						<div class="card-body">
							<!-- <a href="/toutespromo" onclick="voirPlus();" id="voirplus"  class="btn btn-info" style="border-radius: 10px;text-shadow: 1px 0.5px #012345;">Voir plus</a> -->
							<button onclick="voirPlus()" id="voirplus"  class="btn btn-info" style="border-radius: 10px;text-shadow: 1px 0.5px #012345;">Voir plus</button>
						</div>
					</div>

				<?php }else{ ?>

					<div id="promoNotAv">
						Pas de promotions disponible pour l'instant
					</div>

				<?php } ?>
			</div>

		</div>
	</div>

<?php include('templates/footer.php'); ?>