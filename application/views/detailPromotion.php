<?php include("templates/header.php"); ?>

<div class="container-fluid">
	
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-8">
			<?php if(isset($artDesign)){ ?>
				<h1 class="text-center pagetitle" style="text-shadow: 1px 0.5px;margin-bottom: 20px;">Informations détaillées de la promotion</h1>
				<hr>
				<h2 class="text-success productname" style="text-shadow: 1px 0.5px #012345;"><?php echo $artDesign;?></h2>
			<?php } ?>
			<div>
				<?php if(isset($data) && $data){?>
					<table class="table table-dark tabPromo">
						<thead style="text-transform: uppercase;">
							<tr>
								<th>Quantite Commandee</th>
								<th>Pourcentage</th>
								<th>Unite gratuite</th>
								<th>Periode</th>
							</tr>
						</thead>
						<tbody>
					<?php foreach($data as $row){ ?>
						<?php
							setlocale(LC_TIME, 'fr_FR.utf8','fra');
							$from = 'du '.strftime('%d',strtotime($row['date_debut'])).' '.strftime('%h',strtotime($row['date_debut'])).' '.strftime('%Y',strtotime($row['date_debut']));
							$to = 'au '.strftime('%d',strtotime($row['date_fin'])).' '.strftime('%h',strtotime($row['date_fin'])).' '.strftime('%Y',strtotime($row['date_fin']));
						?>
						<tr>
							<td><?php echo $row['quantite']; ?></td>
							<td><?php echo $row['pourcentage']; ?>%</td>
							<td><?php echo $row['unite_gratuite']; ?></td>
							<!-- <td>Du <?php echo $row['date_debut']; ?><br>au <?php echo $row['date_fin']; ?></td> -->
							<td><?php echo $from; ?><br><?php echo $to; ?></td>
						</tr>
					<?php } ?>
						</tbody>
					</table>
				<?php }else{ ?>
					<h4 class="text-warning text-center" style="text-shadow: 1px 0.5px;">Aucune information n'est disponible pour cette promotion</h4>
				<?php } ?>			
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<?php if(isset($autrepromo) && $autrepromo){ ?>

				<div class="card scroll" id="promo">
					<div class="card-header">
						Autres promotions
					</div>
					<ul class="list-group list-group-flush">
					<?php foreach($autrepromo as $subarray){ ?>
						<li class="list-group-item"><a href="<?php echo site_url("detailpromo").'/'.$subarray['id_article']; ?>"><?php echo $subarray['designArt']; ?></a></li>
					<?php } ?>	
					</ul>
				</div>

			<?php }else{ ?>

				<div id="promoNotAv">
					Pas de promotions disponible pour l'instant
				</div>

			<?php } ?>
		</div>
	</div>

</div>

<?php include("templates/footer.php"); ?>