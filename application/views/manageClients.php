<?php include("templates/adminHeader.php"); ?>

<div class="container-fluid">
	<h3 style="text-align: center;margin-top: 2em;">Gestion des clients</h3>
	<hr>
	<div class="row justify-content-center">
		<div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Creer la table des clients
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
                	<form action="createClient" class="form-horizontal" method="post" enctype="multipart/form-data">

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


<?php include("templates/adminFooter.php") ?>