 <!-- End of Topbar -->

 <!-- Begin Page Content -->
 <div class="container-fluid">
 	<h1 class="h3 mb-4 text-gray-800">
 		<?php foreach ($kriteria as $key) : ?>
 			<?= $key['nama_kriteria'] ?>
 			<?php break;endforeach ?>
 		</h1>
 		<?php 	if ($this->session->flashdata('pesan')) { ?>
 			<div class="col-md-12" >
 				<div class="alert alert-success alert-message" id="auto-close-alert" align="center">Subkriteria Berhasil <?= $this->session->flashdata('pesan') ?>
 			</div>
 		</div>
 	<?php } ?>

 	<!-- Page Heading -->
 	<div class="card shadow mb-4">
 		<div class="card-header py-3">
 			<a href="<?= base_url('admin/kriteria') ?>" class="btn btn-success btn-icon-split">
 				<span class="icon text-white-50">
 					<i class="fas fa-undo"></i>
 				</span>
 				<span class="text">Kembali</span>
 			</a>
 		</div>
 		<div class="card-body">
 			<div class="table-responsive">
 				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
 					<thead>
 						<tr>
 							<th>No</th>
 							<th>Subkriteria</th>
 							<th>Kode</th>
 							<th>Opsi</th>
 						</tr>
 					</thead>
 					<tbody>
 						<?php $no=1; foreach($kriteria as $key) : ?>
 						<tr>
 							<td><?= $no++ ?></td>
 							<td><?= $key['nama_subkriteria'] ?></td>
 							<td><?= $key['nilai'] ?></td>
 							<td>
 								<center>
 									<a href="" data-toggle="modal" data-target="#edit<?= $key['id_kriteria']?>" class="btn btn-primary btn-circle"><i class="fas fa-fw fa-edit"></i></a>
 									<a href="<?= base_url('admin/deletesubkriteria/'.$key['id_subkriteria'].'/'.$key['id_kriteria'])?>" class="btn btn-danger btn-circle"><i class="fas fa-fw fa-trash"></i></a>
 								</center>
 							</td>
 						</tr>
 						<div class="modal fade" id="edit<?= $key['id_kriteria'] ?>">
 							<div class="modal-dialog">
 								<div class="modal-content">
 									<div class="modal-header">
 										<h4 class="modal-title">Edit kriteria</h4>
 										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
 											<span aria-hidden="true">&times;</span>
 										</button>
 									</div>
 									<div class="modal-body">
 										<form action="<?= base_url('admin/updatekriteria') ?>" method="post">
 											<div class="form-group">
 												<label for="">Nama Kriteria</label>
 												<input type="hidden" name="id_kriteria" value="<?= $key['id_kriteria'] ?>">
 												<input type="text" class="form-control" name="nama_kriteria" value="<?= $key['nama_kriteria'] ?>">
 											</div>
 										</div>
 										<div class="modal-footer justify-content-between">
 											<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
 											<button type="submit"  class="btn btn-primary">Update</button>
 										</div>
 									</form>
 								</div>
 								<!-- /.modal-content -->
 							</div>
 							<!-- /.modal-dialog -->
 						</div>
 					<?php endforeach ?>
 				</tbody>
 			</table>
 		</div>
 	</div>
 </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<div class="modal fade" id="modal-default">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Tambah Subkriteria</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('admin/tambahsubkriteria') ?>" method="post">
					<div class="form-group">
						<label for="">Subkriteria</label>
						<input type="text" class="form-control" name="subkriteria" placeholder="Tuliskan Subkriteria" required="">
					</div>
					<div class="form-group">
						<label for="">Nilai</label>
						<input type="text" class="form-control" name="nilai" placeholder="Tuliskan Nilai" required="">
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="submit"  class="btn btn-primary">Tambah</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

