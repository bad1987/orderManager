<?php include('templates/header.php'); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-7">
				<!-- section statistiques -->
			  <section id="stat" style="margin-left:auto;margin-right:auto">
		      <div class="card">
		      <div class="card-header text-center" style="background-color: #293042;color: #c7c8c8;">
		        <h1 class="historyHeader" style="text-shadow: 2px 2px 2px #078;">Historique des commandes</h1>
		      </div>
		      <div class="card-body">
		        <div>
		          <?php if(isset($stat) && $stat != false){?>
								<?php foreach ($stat as $key => $value) {?>
									<?php
										setlocale(LC_TIME, 'fr_FR.utf8','fra');
										$le = strftime('%d',strtotime($value['created_at'])).' '.strftime('%h',strtotime($value['created_at'])).' '.strftime('%Y',strtotime($value['created_at']));
										$a = 'à '.strftime('%R',strtotime(date('H:i:s',strtotime($value['created_at']))));
									?>
	                <div class="mstat">
	                	<p>Commande &numero;: <span style="margin-left: 3px;"><?php echo $value['numCmde']; ?></span></p>
	                	<p>Montant HT: <span style="margin-left: 3px;"><?php echo (float)$value['montantHT']; ?></span></p>
	                	<p><?php echo $le.' '.$a; ?></p>
	                	<p><button id="<?php echo $value['id']; ?>" class="btn btn-info btn-sm float-right" onclick="loadLigne(this)">D&eacute;tail</button></p>
	                </div>
	              <?php } ?>
		          <?php } ?>   
		          <?php if(isset($pagination)){?>
		              <div>
		              	<?php echo $pagination;?>
		              </div>
		            <?php } ?>
		        </div>
		      </div>
		      </div>
			  </section>
			</div>
			
			<div class="col-xs-12 col-sm-6 col-md-5">
				<!-- details d'une commande -->
        <div class="card" id="ligneCmde">
        	<div class="card-header" style="background-color: #293042;color: #c7c8c8;">
            <h5 class="card-title">Informations détaillées</h5>        		
        	</div>
          <div class="card-body" id="detailCmde" style="font-weight: bold;">
          	<div id="cmdNumber" style="text-align: center; margin: 5px;">
          		<div class="row">
          			<div class="col-xs-12 col-sm-12 col-md-12">
          				Commande &numero; <span id="numero"></span>
          			</div>
          		</div>
          	</div>
          	<div class="row">
          		<div class="col-xs-6 col-sm-6 col-md-6">
          			PRODUIT
          		</div>
          		<div class="col-xs-6 col-sm-6 col-md-6">
          			QUANTITE
          		</div>
          	</div>
          	<div id="contenuCmde" style="width: 100%"></div>
          </div>
        </div>	
			</div>

		</div>
	</div>
<?php include('templates/footer.php'); ?>
