<?php include("templates/adminHeader.php"); ?>

<div class="container-fluid">
	
    <div class="inline-menu">
        <ul>
           <li><a href="<?php echo site_url('update') ?>" class="btn btn-info">Mise à jour des articles</a></li>
           <li><a href="<?php echo site_url('articleimage') ?>" class="btn btn-info">Images des articles</a></li>
           <li><a href="<?php echo site_url('promotions') ?>" class="btn btn-info">Promotions</a></li>
           <li><a href="<?php echo site_url('interrupt') ?>" class="btn btn-info">Gestion rupture</a></li>
        </ul>
    </div>
    <h3 style="text-align: center;">Gestion des articles</h3>
    <hr>
	<div class="row justify-content-center">
		<div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Mettre à jour les articles
                    <?php if(isset($success)){
                        echo  '<h5 class="text-success" style="text-align: center;">'.$success.'</h5>';

                        }
                        elseif (isset($error)) {
                            echo  '<h5 class="text-danger" style="text-align: center;">'.$error.'</h5>';
                        }
                     ?>
                   
                </div>

                <div class="card-body">
                	<!-- <?php echo form_open("register",['class' => 'form-horizontal']) ?> -->
                	<form action="<?php echo site_url('updateArticles') ?>" class="form-horizontal" method="post" enctype="multipart/form-data">

                        <div class="form-group row">
							<input type="file" name="userfile" size="20" />
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Upload
                                </button>
                            </div>
                        </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("templates/adminFooter.php") ?>