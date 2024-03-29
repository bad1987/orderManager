<?php include('templates/adminHeader.php'); ?>

	<div class="container" style="margin-top: 10em;">
      <div class="row justify-content-center">
		<div class="col-md-8">
            <div class="card">
                <div class="card-header">
                	Connexion
                	<h5 class="text-danger" style="text-align: center;"><?php if(isset($err)){echo $err;} ?></h5>
                </div>

                <div class="card-body">
                	<?php echo form_open("checkadminlogin",['class' => 'form-horizontal','method' => "post", 'accept-charset' => "utf-8"]) ?>
                	<!-- <form action="checkadminlogin" class="form-horizontal" method="post" accept-charset="utf-8"> -->
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
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>

<?php include('templates/adminFooter.php'); ?>
