<?php include('templates/header.php'); ?>

<div class="container-fluid">
	<h3 style="text-align: center;margin-top: 2em;">Connectez vous à votre espace client</h3>
	<hr>
	<div class="row justify-content-center">
		<div class="col-md-8">
            <div class="card">
                <div class="card-header">
                	Connexion
                	<h5 class="text-danger" style="text-align: center;"><?php if(isset($err)){echo $err;} ?></h5>
                </div>

                <div class="card-body">
                	<?php echo form_open("validatelogin",['class' => 'form-horizontal','method' => "post", 'accept-charset' => "utf-8"]) ?>
                	<!-- <form action="validatelogin" class="form-horizontal" method="post" accept-charset="utf-8"> -->
                        <div class="form-group row">
                        	<label for="username" class="col-md-3 col-form-label text-md-right">Username</label>

                            <div class="col-md-6">
                            	<?php echo form_input(['name' => 'username','id' => 'username','class' => 'form-control',
                            	'placeholder' => 'Username','value' => set_value('username')]); ?>
                            </div>
                            <div class="col-md-3">
                            	<?php echo form_error('username','<div class="text-danger">','</div>'); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                        	<label for="password" class="col-md-3 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                            	<?php echo form_input(['name' => 'password', 'type' => 'password','id' => 'password','class' => 'form-control',
                            	'placeholder' => 'Password']); ?>
                            </div>
                            <div class="col-md-3">
                            	<?php echo form_error('password','<div class="text-danger">','</div>'); ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                        <!-- <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="
                        <?php echo $this->security->get_csrf_hash();?>"> -->
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
</div>

<?php include('templates/footer.php'); ?>