<?php include('templates/adminHeader.php'); ?>

<div class="container-fluid">
	<h3 style="text-align: center;margin-top: 2em;">ENREGISTREMENT DES COMPTES CLIENTS</h3>
	<hr>
	<div class="row justify-content-center">
		<div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Enregistrement
                    <?php if(isset($this->session->success)){
                        echo  '<h5 class="text-success" style="text-align: center;">'.$this->session->success.'</h5>';

                        }
                        elseif (isset($this->session->error)) {
                            echo  '<h5 class="text-danger" style="text-align: center;">'.$this->session->error.'</h5>';
                        }
                     ?>
                   
                </div>

                <div class="card-body">
                	<!-- <?php echo form_open("register",['class' => 'form-horizontal']) ?> -->
                	<form action="<?php echo site_url('validateRegister') ?>" class="form-horizontal" method="post" accept-charset="utf-8">

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                            	<?php echo form_input(['name' => 'name','id' => 'name','class' => 'form-control',
                            	'placeholder' => 'Name','value' => set_value('name')]); ?>
                            </div>
                            <div class="col-md-3">
                            	<?php echo form_error('name','<div class="text-danger">','</div>'); ?>
                            </div>
                        </div>

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
                        	<label for="email" class="col-md-3 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                            	<?php echo form_input(['name' => 'email','type' => 'email', 'id' => 'email','class' => 'form-control',
                            	'placeholder' => 'E-Mail Address','value' => set_value('email')]); ?>
                            </div>
                            <div class="col-md-3">
                            	<?php echo form_error('email','<div class="text-danger">','</div>'); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                        	<label for="phoneNum" class="col-md-3 col-form-label text-md-right">Phone Number</label>

                            <div class="col-md-6">
                            	<?php echo form_input(['name' => 'phoneNum','id' => 'phoneNum','class' => 'form-control',
                            	'placeholder' => 'Phone Number','value' => set_value('phoneNum')]); ?>
                            </div>
                            <div class="col-md-3">
                            	<?php echo form_error('phoneNum','<div class="text-danger">','</div>'); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="categorie" class="col-md-3 col-form-label text-md-right">Categorie</label>

                            <div class="col-md-6">
                                <?php echo form_dropdown('categorie', $options, 'CLI',['class' => 'form-control']); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo form_error('phoneNum','<div class="text-danger">','</div>'); ?>
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

                        <div class="form-group row">
                        	<label for="password_confirmation" class="col-md-3 col-form-label text-md-right">Confirm Password</label>

                            <div class="col-md-6">
                            	<?php echo form_input(['name' => 'password_confirmation', 'type' => 'password','id' => 'password-confirm','class' => 'form-control',
                            	'placeholder' => 'Confirm Password']); ?>
                            </div>
                            <div class="col-md-3">
                            	<?php echo form_error('password_confirmation','<div class="text-danger">','</div>'); ?>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
</div>

<?php include('templates/adminFooter.php'); ?>