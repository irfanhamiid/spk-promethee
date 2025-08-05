 <!-- End of Topbar -->

 <!-- Begin Page Content -->
 <div class="container-fluid">
 	<h1 class="h3 mb-4 text-gray-800">Data Penilaian</h1>
 	<?php 	if ($this->session->flashdata('pesan')) { ?>
 		<div class="col-md-12" >
 			<div class="alert alert-success alert-message" id="auto-close-alert" align="center">Penilaian Berhasil <?= $this->session->flashdata('pesan') ?>
 		</div>
 	</div>
 <?php } ?>

 <!-- Page Heading -->
 <div class="card shadow mb-4">
 	<div class="card-header py-3">
 		<a href="" data-toggle="modal" data-target="#tambah" class="btn btn-primary btn-icon-split">
 			<span class="icon text-white-50">
 				<i class="fas fa-plus"></i>
 			</span>
 			<span class="text">Alternatif</span>
 		</a>
 	</div>
 	<div class="card-body">
 		<div class="table-responsive">
 			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
 				<thead>
 					<tr>
 						<th></th>
 						<?php foreach($kriteria as $key) : ?>
 							<th><?= $key['kode_kriteria'] ?></th>
 						<?php endforeach ?>

 						<th>Opsi</th>
 					</tr>
 				</thead>
 				<tbody>
 					<?php  foreach($penilaian as $key) : ?>
 					<tr>
 						<td><?= $key['kode'] ?></td>
 						<?php
 						$id_alternatif = $key['id_alternatif'];
 						$nilai_values = array();
 						foreach ($kriteria as $kriteria_item) {
 							$id_kriteria = $kriteria_item['id_kriteria'];
 							$detail = $this->db
 							->where('id_alternatif', $id_alternatif)
 							->where('id_kriteria', $id_kriteria)
 							->get('penilaian_alternatif')
 							->result_array();
 							foreach ($detail as $det) {
 								$nilai_values[] = $det['nilai'];
 							}
 						}
 						?>
 						<?php foreach ($nilai_values as $nilai) : ?>
 							<td><?= $nilai ?></td>
 						<?php endforeach ?>
 						<td>
 							<center>
 								<a href="" data-toggle="modal" data-target="#edit<?= $key['id_alternatif']?>" class="btn btn-primary btn-circle"><i class="fas fa-fw fa-edit"></i></a>
 									<a href="<?= base_url('admin/deletepenilaian/'.$key['id_alternatif'])?>" class="btn btn-danger btn-circle"><i class="fas fa-fw fa-trash"></i></a>
 								</center>
 							</td>
 						</tr>
<div class="modal fade" id="edit<?= $key['id_alternatif']; ?>" tabindex="-1" aria-labelledby="VeirivikasiLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="EditKriteriaLabel">Edit Nilai</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="<?= base_url('admin/updatenilai') ?>" method="post">
        	<div class="form-group">
    <label for="">Nama Alternatif</label>
    <input type="text" readonly class="form-control" name="nama_alternatif" value="<?= htmlspecialchars($key['nama_alternatif']) ?>">
    </div>
    <?php
    // Assuming $this->db is an instance of the database connection
    $query = $this->db->query("SELECT * FROM penilaian_alternatif a, kriteria_penilaian b WHERE a.id_kriteria=b.id_kriteria AND a.id_alternatif=?", [$key['id_alternatif']]);
    $items = $query->result_array();
    ?>
    
    <?php foreach ($items as $index => $item_data) : ?>
    	<div class="form-group">
        <label><?= htmlspecialchars($item_data['nama_kriteria']) ?></label>
        <input type="hidden" name="id_penilaian[]" value="<?= $item_data['id_penilaian'] ?>">
        <input type="hidden" name="id_alternatif" value="<?= $item_data['id_alternatif'] ?>">
        <input type="hidden" value="<?= htmlspecialchars($item_data['id_kriteria']) ?>" name="id_kriteria[]" required>
        <select name="nilai[]" class="form-control" required="" id="">
		<option value="<?= isset($item_data['nilai']) ? htmlspecialchars($item_data['nilai']) : '' ?>">Tidak Berubah</option>
		<?php $id_kriteria=$item_data['id_kriteria'];
		$subkriteria = $this->db->query("SELECT * FROM subkriteria where id_kriteria='$id_kriteria' order by nilai desc")->result_array() ?>
							<?php foreach($subkriteria as $sub) : ?>
								<option value="<?= $sub['nilai'] ?>"><?= $sub['nama_subkriteria'] ?></option>
							<?php endforeach ?>
						</select>
						</div>
    <?php endforeach ?>
    
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
    </div>
  </div>
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


<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="VeirivikasiLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="EditKriteriaLabel">Tambah Nilai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('admin/tambahpenilaian') ?>" method="post">
					<div class="form-group">
					<label for="">Alternatif</label>
					<select name="id_alternatif" id="id_alternatif" class="form-control" required="">
						<option value="">--Pilih Alternatif--</option>
						<?php foreach($alternatif as $key) : ?>
							<option value="<?= $key['id_alternatif'] ?>"><?= $key['kode']  ?></option>
						<?php endforeach ?>
					</select>
					</div>
					
					<?php foreach($kriteria as $kriteria) : ?>
						<div class="form-group">
						<label><?= $kriteria['nama_kriteria'] ?></label>
						<input type="hidden" value="<?= $kriteria['id_kriteria'] ?>" name="id_kriteria[]" id="id_kriteria" required="">
						<select name="nilai[]" class="form-control" required="" id="">
							<option value="">-- Pilih Nilai --</option>
							<?php $id_kriteria=$kriteria['id_kriteria'];
							$subkriteria = $this->db->query("SELECT * FROM subkriteria where id_kriteria='$id_kriteria' order by nilai desc")->result_array() ?>
							<?php foreach($subkriteria as $sub) : ?>
								<option value="<?= $sub['nilai'] ?>"><?= $sub['nama_subkriteria'] ?></option>
							<?php endforeach ?>
						</select>
						</div>
					<?php endforeach ?>
					
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="submit"  class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>  