<?php include("templates/adminHeader.php"); ?>
	<div class="container-fluid">
		<div class="btn-group" role="group" aria-label="Basic example" style="margin-top: 1px;">
			<a class="btn btn-secondary" href="<?php echo site_url("promotions") ?>">New Promo</a>
			<a class="btn btn-secondary" href="<?php echo site_url("editpromo") ?>">Edit Prromo</a>
		</div>
		<!-- edit existing promotion -->
		<div class="row" id="editpromo">
		
			<div class="col-md-12" style="margin-top: 6em;">
				<div class="card">
					<div class="card-header" style="background-color: #373c43;color: white;text-align: center;">
						Modifier une promotion
					</div>

					<!-- choose an article -->
					<div class="form-group row" style="margin-top: 20px;">
						<label for="article" class="col-md-2 col-form-label text-md-right text-primary">Article</label>
						<div class="col-md-6">
							<select data-placeholder="Selectionner un article" class="chosen form-control" style="min-width:200px;" id="nArticleList">
	              <option value="" selected="selected"></option>
	            </select>
						</div>
						<div class="col-md-4" style="margin-top: -8px;">
							<button onclick="editPromo();" class="btn btn-secondary">Fetch</button>
						</div>
					</div>
					<hr>
					<section id="editdata">
						<table class="table table-responsive">
							<thead>
								<tr><th>Quantite</th>
								<th>Pourcentage</th>
								<th>Unite gratuite</th>
								<th>Sommeil</th>
								<th>Date debut</th>
								<th>Date fin</th></tr>
							</thead>
							<tbody id="editbody">
								
							</tbody>
						</table>
					</section>

					<section id="indisponible">
						<h4>Pas de promotions disponibles pour cet article</h4>
					</section>

				</div>
			</div>
	  </div>
  </div>
<?php include("templates/adminFooter.php"); ?>