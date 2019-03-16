<?php include('templates/adminHeader.php'); ?>

	<div class="container" style="margin-top: 5em;">
      <div class="row justify-content-center">
		<div class="col-md-8">
            <div class="card">
                <div class="card-header">
                	recherche d'un client
                </div>

                <div class="card-body">
                <!-- action="searchuser" -->
                	<!-- <form id="searchform" class="form-horizontal" method="post" accept-charset="utf-8"> -->
                        <div class="form-group row">
                        	<label for="username" class="col-md-3 col-form-label">
                        		Search By:
                        		<select class="form-control" name="key">
                        			<option value="name">name</option>
                        			<option value="username">username</option>
                        			<option value="email">email</option>
                        			<option value="phoneNum">phone number</option>
                        		</select>
                        	</label>
                        	<label for="motif" class="col-md-6 col-form-label">
                        		motif:
                        		<?php echo form_input(['name' => 'motif', 'type' => 'text','id' => 'motif','class' => 'form-control',
                            	'placeholder' => 'motif','required' => 'required']); ?>
                        	</label>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="findClient()">
                                    Search
                                </button>
                            </div>
                        </div>
                    <!-- <?php echo form_close() ?> -->
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="notfound" style="display: none;margin-top: 2em;">
    	<div class="row justify-content-center">
		<div class="col-md-12">
            <div class="card-header">
                <h5 class="text-danger">No matching record found</h5>
            </div>
        </div>
        </div>
    </div>

    <div class="container" id="Searchresult" style="display: none;margin-top: 2em;">
    	<div class="row justify-content-center">
		<div class="col-md-10">
            <div class="card">
                <div class="card-body">
                <table class="table table-dark">
                	<tbody id="tbsearch"></tbody>
                </table>
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="container-fluid" id="modification" style="display: none;">
	<h3 style="text-align: center;margin-top: 2em;">MODIFICATION DU COMPTE CLIENT</h3>
	<hr>
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card-header">
				<h5 id="saveSuccess" class="text-success" style="display: none;">Client records have been saved !</h5>
				<h5 id="saveError" class="text-error" style="display: none;">unable to save client records, an error occured!</h5>
			</div>
            <div class="card">
                <div class="card-body">
                	<!-- <?php echo form_open("register",['class' => 'form-horizontal']) ?> -->

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                            	<?php echo form_input(['name' => 'name','id' => 'name','class' => 'form-control','required' => 'required']); ?>
                            </div>
                            <div class="col-md-6 offset-md-3" style="display: none;text-align: center;">
                            	<div id="nameerror" class="text-danger">this field is required</div>
                            </div>
                        </div>

                        <div class="form-group row">
                        	<label for="username" class="col-md-3 col-form-label text-md-right">Username</label>

                            <div class="col-md-6">
                            	<?php echo form_input(['name' => 'username','id' => 'username','class' => 'form-control','required' => 'required']); ?>
                            </div>
                            <div class="col-md-6 offset-md-3" style="display: none;text-align: center;">
                            	<div id="usernameerror" class="text-danger">this field is required</div>
                            </div>
                        </div>

                        <div class="form-group row">
                        	<label for="email" class="col-md-3 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                            	<?php echo form_input(['name' => 'email','type' => 'email', 'id' => 'email','class' => 'form-control','required' => 'required']); ?>
                            </div>
                            <div class="col-md-6 offset-md-3" style="display: none;text-align: center;">
                            	<div id="emailerror" class="text-danger">this field is required</div>
                            </div>
                        </div>

                        <div class="form-group row">
                        	<label for="phoneNum" class="col-md-3 col-form-label text-md-right">Phone Number</label>

                            <div class="col-md-6">
                            	<?php echo form_input(['name' => 'phoneNum','id' => 'phoneNum','class' => 'form-control','required' => 'required']); ?>
                            </div>
                            <div class="col-md-6 offset-md-3" style="display: none;text-align: center;">
                            	<div id="phoneerror" class="text-danger">this field is required</div>
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
                            	<?php echo form_input(['name' => 'password', 'type' => 'password','id' => 'password','class' => 'form-control']); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                        	<label for="password_confirmation" class="col-md-3 col-form-label text-md-right">Confirm Password</label>

                            <div class="col-md-6">
                            	<?php echo form_input(['name' => 'password_confirmation', 'type' => 'password','id' => 'password-confirm','class' => 'form-control']); ?>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-3" style="display: none;text-align: center;margin-bottom: 2em;">
                            	<div id="passworderror" class="text-danger"></div>
                         </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="saveClientData()">
                                    Save
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
	</div>

<?php include('templates/adminFooter.php'); ?>
