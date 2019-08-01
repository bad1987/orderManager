<?php include('templates/header.php'); ?>

<div class="container-fluid">
	<div class="row">
		<div class="col text-center cmdeTittle" style="background-color: #293042;color: #c7c8c8;">
			<h1>Preparer et envoyer votre commande</h1>
		</div>
	</div>

	<?php if($this->session->cat_Ref == 'COM'){ ?>
		<div class="row forCom">
			<div class="col-md-4 col-lg-3">
        <p class="text-info" style="text-transform: uppercase;font-weight: bold;">Selectionner le client</p>
        <select data-placeholder="Selectionner un client" class="chosen" style="min-width:200px;" id="clientList">
            <option value="" selected="selected"></option>
        </select><span class="text-danger" style="padding: 1px;display: none;font-weight: bold;" id="cl_error"> vous devez selectionner un client
          pour l'envoi de votre commande</span>
			</div>

			<div class="col-md-5 col-lg-3 offset-md-3 offset-lg-6 valeurPanier">
				<div class="card" style="border-radius: 15px;text-align: center;">
					<div class="card-header" style="background-color: #296e2b;color: white;">
		        <h4>Valeur HT du panier</h4>
		      </div>
		      <div class="card-body">
		      	<p class="card-text" style="color: #3657cd;font-weight: bold;"><span id="valeur">0</span> FCFA</p>
		      	<button class="btn btn-success btn-sm float-right" style="marging-top:10px;font-weight: bold;" id="confirm" onclick="send()">Valider</button>

		      	<br>
            <div id="pbar" style="margin-top:5px;display:none;">
                <span class="text-info">Envoi encours...</span>
                <img src="<?php echo site_url("assets/img/loader32.gif") ?>" class="rounded float-right" alt="">
            </div>
            <div id="panierVide" style="display:none;">
            	<p class="text-danger">Votre panier est vide</p>
            </div>
            <div style="margin-top:10px;">
                <p id='sendResult' class="alert alert-success" style="display:none;">mail successfully sent</p>
            </div>
		      </div>
				</div>
			</div>
		</div>
	<?php }else{ ?>
		<div class="row valeurPanier">
			<div class="col-md-5 col-lg-3 offset-lg-9 offset-md-7">
				<div class="card" style="border-radius: 15px;text-align: center;">
					<div class="card-header" style="background-color: #296e2b;color: white;">
		        <h4>Valeur HT du panier</h4>
		      </div>
		      <div class="card-body">
		      	<p class="card-text" style="color: #3657cd;font-weight: bold;"><span id="valeur">0</span> FCFA</p>
		      	<button class="btn btn-success btn-sm float-right" style="marging-top:10px;font-weight: bold;" id="confirm" onclick="send()">Valider</button>

		      	<br>
            <div id="pbar" style="margin-top:5px;display:none;">
                <span class="text-info">Envoi encours...</span>
                <img src="<?php echo site_url("assets/img/loader32.gif") ?>" class="rounded float-right" alt="">
            </div>
            <div id="panierVide" style="display:none">
            	<p class="text-danger">Votre panier est vide</p>
            </div>
            <div style="margin-top:10px;" id="sendInfo">
                <p id='sendResult' class="alert alert-success" style="display:none;">mail successfully sent</p>
            </div>
		      </div>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="row form">
		<div class="col-sm-4 col-md-4" style="margin-top: 5px;">
			<select data-placeholder="Selectionner un produit" class="chosen" style="min-width:200px;" id="prod"></select>
		</div>
		<div class="col-sm-2 col-md-2" style="margin-top: 5px;">
			<input type="text" class="input-sm" size="8" id="entree" placeholder="Quantité" style="border-radius:8px;">
		</div>
		<div class="col-sm-2 col-md-1">
			<button class="myButton" id="target" onclick="save()">Ajouter</button>      
		</div>
	</div>

	<div class="row" style="margin-top: 10px;">		
		<div class="col-sm-8 col-md-12">
			<div class="alert alert-danger" id="error"></div>
		</div>
	</div>

	<div class="row panier">
		
	</div>

	<!-- sauvegarder la categorie de l'utilisateur connecte -->
                    
  <?php if(isset($this->session->cat_Ref)){ ?>
    <span id="user" name="<?php echo  $this->session->cat_Ref ?>" hidden></span>
  <?php } ?>
</div>

<?php include('templates/footer.php'); ?>