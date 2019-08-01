<?php include("templates/adminHeader.php"); ?>

	<div class="container-fluid" onload="initialize();">
		<!-- choix activite -->
		<div class="btn-group" role="group" aria-label="Basic example">
			<a class="btn btn-secondary" href="<?php echo site_url('promotions') ?>">New Promo</a>
			<a class="btn btn-secondary" href="<?php echo site_url('editpromo') ?>">Edit Prromo</a>
		</div>

		<!-- create promotion -->
		<div class="row" id="newpromo">
		
			<div class="col-md-6 offset-md-2" style="margin-top: 6em;">
				<div class="card">
					<div class="card-header" style="background-color: #373c43;color: white;text-align: center;">
						Enregistrement d'une promotion
					</div>
					<div class="card-body" style="padding: 30px;">
						<?php echo validation_errors(); ?>
						<?php echo form_open('newpromo',['class' => 'form-horizontal','method' => "post", 'accept-charset' => "utf-8"]); ?>

							<div class="form-group row">
								<label for="article" class="col-md3 col-form-label text-md-right text-primary">Article</label>
								<div class="col-md-6 offset-md-2" style="margin-left: 90px;">
								<select data-placeholder="Selectionner un article" class="chosen" name="article" style="min-width:200px;" id="nArticleList">
                  <option value="" selected="selected"></option>
                </select><span class="text-danger" style="display: none;" id="arterror">Veillez selectionner un article</span>
									<!-- <?php echo form_input(['name' => 'aricle','id' => 'article','class' => 'form-control',
									'placeholder' => 'article']) ?> -->
								</div>
							</div>

							<div class="form-group row">
								<label for="quantite" class="col-md3 col-form-label text-md-right text-primary">Quantite</label>
								<div class="col-md-6 offset-md-2">
									<?php echo form_input(['name' => 'quantite','id' => 'quantite','class' => 'form-control',
									'placeholder' => 'quantite','style' => "margin-left: -10px;",'onfocus' => 'quantiteFocus(this);','onblur' => 'quantiteBlur(this);']) ?>
									<span class="text-danger" style="display: none;" id="qteerror">Renseignez la quantite commandée</span>
									<span class="text-danger" style="display: none;" id="qteinvalid">La quantite saisie est invalide</span>
								</div>
							</div>

							<div class="form-group row">
								<label for="pourcent" class="col-md3 col-form-label text-md-right text-primary">Pourcentage</label>
								<div class="col-md-6 offset-md-1">
									<?php echo form_input(['name' => 'pourcent','id' => 'pourcent','class' => 'form-control',
									'placeholder' => 'pourcentage','style' => "margin-left: 4px;",'onfocus' => 'pourcentageFocus(this);','onblur' => 'pourcentageBlur(this);']) ?>
									<span class="text-danger" style="display: none;" id="percenterror">Quelle pourcentage faut-il appliquer ?</span>
									<span class="text-danger" style="display: none;" id="percentinvalid">Quelle pourcentage faut-il appliquer ?</span>
								</div>
							</div>

							<div class="form-group row">
								<label for="unitegratuite" class="col-md3 col-form-label text-md-right text-primary">Unite gratuite</label>
								<div class="col-md-6 offset-md-1">
									<?php echo form_input(['name' => 'unitegratuite','id' => 'unitegratuite','class' => 'form-control',
									'placeholder' => 'unite gratuite','onfocus' => 'ugFocus(this);','onblur' => 'ugBlur(this);']) ?>
									<span class="text-danger" style="display: none;" id="ugerror">Precisez la quantite d'UG obtenue </span>
									<span class="text-danger" style="display: none;" id="uginvalid">Le nombre d'UG saisi est invalide</span>
								</div>
							</div>

							<div class="form-group row">
								<label for="datedebut" class="col-md3 col-form-label text-md-right text-primary">Date debut</label>
								<div class="col-md-6 offset-md-1">
									<input type="date" name="datedebut" id="datedebut" onfocus="datedFocus(this);" onblur="datedBlur(this);" class="form-control" style="margin-left: 16px;">
									<span class="text-danger" style="display: none;" id="datedinvalid">La date est invalide</span>
								</div>
							</div>

							<div class="form-group row">
								<label for="datefin" class="col-md3 col-form-label text-md-right text-primary">Date fin</label>
								<div class="col-md-6 offset-md-1">
									<input type="date" name="datefin" id="datefin" onfocus="datefFocus(this);" onblur="datefBlur(this);" class="form-control" style="margin-left: 38px;">
									<span class="text-danger" style="display: none;" id="datefinvalid">La date est invalide</span>
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<button type="submit" class="btn btn-primary" id="newpromosubmit" onclick="saveNewPromo();">New</button>
								</div>
							</div>

						<?php echo form_close(); ?>
					</div>
				</div>
			</div>

			<div class="col-md-4" style="margin-top: 6em;">
				<div class="text-danger" id="errorStatus">Le traitement de votre requete a genere une erreur, les donnees
				n'ont pas ete sauvegardees.
				Veillez reporter cette erreur au concepteur de cette application.
				</div>

				<div class="text-success" id="successStatus">
					Promotion enregistree
				</div>
			</div>		
		</div>
				
		</div>

	</div>
	<script type="text/javascript">

	</script>
<?php include("templates/adminFooter.php"); ?>