<div class="main-content">
	<section class="section">
	  <div class="section-header">
	    <h1>Daftar Pasien</h1>
	  </div>

	  <a href="<?php echo base_url('admin/daftar_pasien/tambah_pasien') ?>" class="btn btn-primary mb-3">Tambah Data</a>
	  <?php echo $this->session->flashdata('pesan') ?>
	  <table class="table table-hover table-striped table-borderd">
	  	<thead>
	  		<tr>
		  		<th>No</th>
		  		<th>No Pasien</th>
		  		<th>Email</th>
		  		<th>Role</th>
		  		<th>Aksi</th>
	  		</tr>
	  	</thead>
	  	<tbody>
	  		<?php 
	  			$no=1;
	  			foreach ($pasien as $ps) : ?>
	  			<tr>
		  			<td><?php echo $no++ ?></td>
		  			<td><?php echo $ps->no_user ?></td>
		  			<td><?php echo $ps->email ?></td>
		  			<td><?php echo $ps->id_role ?></td>
		  			<td>
		  				<a href="" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
		  				<a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
		  				<a href="" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
		  			</td>
	  			</tr>
		  	<?php endforeach; ?>
	  	</tbody>
	  </table>
	</section>
</div>