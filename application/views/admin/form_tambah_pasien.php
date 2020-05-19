<div class="main-content">
	<section class="section">
	  <div class="section-header">
	    <h1>Tambah Pasien</h1>
	  </div>

	  <div class="card">
	  	<div class="card-body">
	  		<form method="POST" action="<?php echo base_url('admin/daftar_pasien/tambah_pasien_aksi') ?>" entype="multipart/form-data">
	  		<div class="row">
	  			<div class="col-md-6">
	  				<div class="form-group">
	  					<label>Role User</label>
	  					<select name="id_role" class="form-control">
	  						<option value="">--Pilih Role User--</option>
	  						<?php foreach ($role as $rl) : ?>
	  							<option value="<?php echo $rl->id_role ?>"><?php echo $rl->nama_role ?></option>
	  						<?php endforeach; ?>
	  					</select>
	  					<?php echo form_error('id_role', '<div class="text-small text-danger">','</div>') ?>
	  				</div>
	  				<div class="form-group">
	  					<label>No User</label>
	  					<input type="text" name="no_user" class="form-control">
	  					<?php echo form_error('no_user', '<div class="text-small text-danger">','</div>') ?>
	  				</div>
	  				<div class="form-group">
	  					<label>Email</label>
	  					<input type="email" name="email" class="form-control">
	  					<?php echo form_error('email', '<div class="text-small text-danger">','</div>') ?>
	  				</div>
	  				<div class="form-group">
	  					<label>Password</label>
	  					<input type="password" name="password" class="form-control">
	  					<?php echo form_error('password', '<div class="text-small text-danger">','</div>') ?>
	  				</div>
	  				<button type="submit" class="btn btn-primary mt-4">Simpan</button>
	  				<button type="reset" class="btn btn-danger mt-4">Reset</button>
	  			</div>
	  		</div>
	  		</form>
	  	</div>
	  </div>
	</section>
</div>