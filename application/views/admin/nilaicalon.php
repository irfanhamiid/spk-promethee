 <!-- End of Topbar -->

 <!-- Begin Page Content -->
 <div class="container-fluid">
 	<h1 class="h3 mb-4 text-gray-800"></h1>
 	<?php 	if ($this->session->flashdata('pesan')) { ?>
 		<div class="col-md-12" >
 			<div class="alert alert-success alert-message" id="auto-close-alert" align="center">Penilaian Berhasil <?= $this->session->flashdata('pesan') ?>
 		</div>
 	</div>
 <?php } ?>

 <!-- Page Heading -->
 <div class="card shadow mb-4">
 	<div class="card-header py-3">
        <h3>Nilai Calon Alternatif</h3>
 	</div>
 	<div class="card-body">
 		<div class="table-responsive">
 			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        <?php foreach($alternatif->result_array() as $key) : ?>
                            <th><?= $key['kode'] ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                 <?php foreach ($kriteria as $key) { 
                    $id_kriteria = $key['id_kriteria'];
                    ?>
                    <tr>
                        <td><?= $key['kode_kriteria'] ?></td>
                        <?php foreach($alternatif->result_array() as $alt) : 
                            $id_alternatif = $alt['id_alternatif'];
                            $nilai = $nilai_per_kriteria_alternatif[$id_kriteria][$id_alternatif] ?? 'Nilai';
                            ?>
                            <td><?= $nilai ?></td>
                        <?php endforeach ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Page Heading -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h3>Nilai Preferensi Kriteria</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
               <thead>
                <tr>
                    <th rowspan="2" width="10%">Kriteria</th>
                    <?php
                    $alternatif_count = $alternatif->num_rows();
                    foreach ($alternatif->result_array() as $key1) {
                        $kode_alternatif1 = $key1['kode'];
                        foreach ($alternatif->result_array() as $key2) {
                            $kode_alternatif2 = $key2['kode'];
                            // Memeriksa apakah kode alternatif1 tidak sama dengan kode alternatif2 sebelum melakukan perbandingan
                            if ($kode_alternatif1 != $kode_alternatif2) {
                                ?>
                                <th colspan="2"><?= $kode_alternatif1 ?>,<?= $kode_alternatif2 ?></th>
                                <?php
                            }
                        }
                    } ?>
                </tr>
                <tr>
                    <?php
                    foreach ($alternatif->result_array() as $key1) {
                        $kode_alternatif1 = $key1['kode'];
                        foreach ($alternatif->result_array() as $key2) {
                            $kode_alternatif2 = $key2['kode'];
                            // Memeriksa apakah kode alternatif1 tidak sama dengan kode alternatif2 sebelum melakukan perbandingan
                            if ($kode_alternatif1 != $kode_alternatif2) {
                                ?>
                                <th width="2%">x</th>
                                <th width="2%">p(x)</th>
                                <?php
                            }
                        }
                    } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Tambahkan variabel array untuk menyimpan total p(x) per perbandingan
                $total_px_per_perbandingan = array();

                foreach ($kriteria as $key) {
                    $id_kriteria = $key['id_kriteria'];
                    ?>
                    <tr>
                        <td><?= $key['kode_kriteria'] ?></td>
                        <?php
                        foreach ($alternatif->result_array() as $key1) {
                            $id_alternatif1 = $key1['id_alternatif'];
                            $nilai_alternatif1 = $nilai_per_kriteria_alternatif[$id_kriteria][$id_alternatif1] ?? 0;

                            foreach ($alternatif->result_array() as $key2) {
                                $id_alternatif2 = $key2['id_alternatif'];
                                $nilai_alternatif2 = $nilai_per_kriteria_alternatif[$id_kriteria][$id_alternatif2] ?? 0;

                                // Memeriksa apakah kode alternatif1 tidak sama dengan kode alternatif2 sebelum melakukan perbandingan
                                if ($id_alternatif1 != $id_alternatif2) {
                                    $nilai_x = $nilai_alternatif1 - $nilai_alternatif2;

                                    if ($nilai_x <= 0) {
                                        $px = 0;
                                    } else {
                                        $px = 1;
                                    }

                                    // Buat kunci unik untuk setiap perbandingan (misalnya, gabungan dari id_alternatif1 dan id_alternatif2)
                                    $perbandingan_key = $id_alternatif1 . '_' . $id_alternatif2;

                                    // Tambahkan nilai p(x) ke total p(x) untuk perbandingan ini
                                    if (!isset($total_px_per_perbandingan[$perbandingan_key])) {
                                        $total_px_per_perbandingan[$perbandingan_key] = $px;
                                    } else {
                                        $total_px_per_perbandingan[$perbandingan_key] += $px;
                                    }
                                    ?>
                                    <td><?= $nilai_x ?></td>
                                    <td><?= $px ?></td>
                                    <?php
                                }
                            }
                        } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h3>Index Preferensi Multikriteria </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <?php foreach($alternatif->result_array() as $key) : ?>
                            <th><?= $key['kode'] ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                   <?php
                   $total_px_per_perbandingan = array();

                   foreach ($kriteria as $key) {
                    $id_kriteria = $key['id_kriteria'];

                    foreach ($alternatif->result_array() as $key1) {
                        $id_alternatif1 = $key1['id_alternatif'];
                        $nilai_alternatif1 = $nilai_per_kriteria_alternatif[$id_kriteria][$id_alternatif1] ?? 0;

                        foreach ($alternatif->result_array() as $key2) {
                            $id_alternatif2 = $key2['id_alternatif'];
                            $nilai_alternatif2 = $nilai_per_kriteria_alternatif[$id_kriteria][$id_alternatif2] ?? 0;

            // Memeriksa apakah alternatif1 tidak sama dengan alternatif2 sebelum melakukan perbandingan
                            if ($id_alternatif1 != $id_alternatif2) {
                                $nilai_x = $nilai_alternatif1 - $nilai_alternatif2;

                                if ($nilai_x <= 0) {
                                    $px = 0;
                                } else {
                                    $px = 1;
                                }

                // Buat kunci unik untuk setiap perbandingan (misalnya, gabungan dari id_alternatif1 dan id_alternatif2)
                                $perbandingan_key = $id_alternatif1 . '_' . $id_alternatif2;

                // Tambahkan nilai p(x) ke total p(x) untuk perbandingan ini
                                if (!isset($total_px_per_perbandingan[$perbandingan_key])) {
                                    $total_px_per_perbandingan[$perbandingan_key] = $px;
                                } else {
                                    $total_px_per_perbandingan[$perbandingan_key] += $px;
                                }
                            }
                        }
                    }
                }
                ?>
                <?php $hitung = $this->db->query("SELECT * FROM kriteria_penilaian")->num_rows() ?>
                <?php foreach ($alternatif->result_array() as $key1) {
                    $id_alternatif1 = $key1['id_alternatif'];
                    ?>
                    <tr>
                        <th><?= $key1['kode'] ?></th>
                        <?php foreach ($alternatif->result_array() as $key2) {
                            $id_alternatif2 = $key2['id_alternatif'];
                                // Jika alternatif sama, tampilkan kolom kosong
                            if ($id_alternatif1 == $id_alternatif2) {
                                echo "<td></td>";
                            } else {
                                $perbandingan_key = $id_alternatif1 . '_' . $id_alternatif2;
                                $total_px = 1/$hitung*$total_px_per_perbandingan[$perbandingan_key] ?? 0;
                                echo "<td>$total_px</td>";
                            }
                        }
                        ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<?php $a = $this->db->query("SELECT * FROM alternatif")->num_rows();
$b = $a-1; ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Leaving Flow</th>
                        <th>Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alternatif->result_array() as $key) { ?>
                        <tr>
                            <td><?= $key['kode'] ?></td>
                            <?php
                            $bobot = 0;

                            foreach ($alternatif->result_array() as $key2) {
                                $id_alternatif2 = $key2['id_alternatif'];
                // Jika alternatif sama, skip perhitungan
                                if ($key['id_alternatif'] == $id_alternatif2) {
                                } else {
                                    $perbandingan_key = $key['id_alternatif'] . '_' . $id_alternatif2;
                                    $total_px = 1 / $hitung * $total_px_per_perbandingan[$perbandingan_key] ?? 0;

                    // Tambahkan nilai total_px ke variabel $bobot
                                    $bobot += $total_px;
                                }
                            }
                            ?>
                            <?php $c = 1/$b*$bobot; ?>
                            <td><?= $c ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Entering Flow</th>
                        <th>Bobot</th>
                    </tr>
                </thead>
                <?php
                $total_px_per_perbandingan = array();
                $flow = array();

                foreach ($kriteria as $key) {
                    $id_kriteria = $key['id_kriteria'];

                    foreach ($alternatif->result_array() as $key1) {
                        $id_alternatif1 = $key1['id_alternatif'];
                        $nilai_alternatif1 = $nilai_per_kriteria_alternatif[$id_kriteria][$id_alternatif1] ?? 0;

                        foreach ($alternatif->result_array() as $key2) {
                            $id_alternatif2 = $key2['id_alternatif'];
                            $nilai_alternatif2 = $nilai_per_kriteria_alternatif[$id_kriteria][$id_alternatif2] ?? 0;

                            if ($id_alternatif1 != $id_alternatif2) {
                                $nilai_x = $nilai_alternatif1 - $nilai_alternatif2;
                                $px = ($nilai_x <= 0) ? 0 : 1;

                                $perbandingan_key = $id_alternatif1 . '_' . $id_alternatif2;

                                if (!isset($total_px_per_perbandingan[$perbandingan_key])) {
                                    $total_px_per_perbandingan[$perbandingan_key] = $px;
                                } else {
                                    $total_px_per_perbandingan[$perbandingan_key] += $px;
                                }
                            }
                        }
                    }
                }

                $hitung = $this->db->query("SELECT * FROM kriteria_penilaian")->num_rows();
                ?>
                <tbody>
                    <?php foreach ($alternatif->result_array() as $key1) {
                        $id_alternatif1 = $key1['id_alternatif'];
                        ?>
                        <tr>
                            <?php foreach ($alternatif->result_array() as $key2) {
                                $id_alternatif2 = $key2['id_alternatif'];
                                if ($id_alternatif1 == $id_alternatif2) {
                                } else {
                                    $perbandingan_key = $id_alternatif1 . '_' . $id_alternatif2;
                                    $total_px = 1 / $hitung * $total_px_per_perbandingan[$perbandingan_key] ?? 0;
                                    $flow_value = $total_px;
                                    $col_idx = $id_alternatif2;
                                    if (!isset($flow[$col_idx])) {
                                        $flow[$col_idx] = $total_px;
                                    } else {
                                        $flow[$col_idx] += $total_px;
                                    }
                                }
                            }
                            ?>

                        </tr>
                    <?php } ?>

                    <!-- Tambahkan baris untuk menampilkan nilai $flow -->
                    <?php foreach ($alternatif->result_array() as $key2) {
                        $id_alternatif2 = $key2['id_alternatif'];
                        $flow_value = 1/$b*$flow[$id_alternatif2] ?? 0;
                        echo "<tr><td>" . $key2['kode'] . "</td><td>" . $flow_value . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Net Flow</th>
                        <th>Bobot</th>
                        <th>Ranking</th>
                    </tr>
                </thead>
                <?php
                $total_px_per_perbandingan = array();
                $flow = array();

                foreach ($kriteria as $key) {
                    $id_kriteria = $key['id_kriteria'];

                    foreach ($alternatif->result_array() as $key1) {
                        $id_alternatif1 = $key1['id_alternatif'];
                        $nilai_alternatif1 = $nilai_per_kriteria_alternatif[$id_kriteria][$id_alternatif1] ?? 0;

                        foreach ($alternatif->result_array() as $key2) {
                            $id_alternatif2 = $key2['id_alternatif'];
                            $nilai_alternatif2 = $nilai_per_kriteria_alternatif[$id_kriteria][$id_alternatif2] ?? 0;

                            if ($id_alternatif1 != $id_alternatif2) {
                                $nilai_x = $nilai_alternatif1 - $nilai_alternatif2;
                                $px = ($nilai_x <= 0) ? 0 : 1;

                                $perbandingan_key = $id_alternatif1 . '_' . $id_alternatif2;

                                if (!isset($total_px_per_perbandingan[$perbandingan_key])) {
                                    $total_px_per_perbandingan[$perbandingan_key] = $px;
                                } else {
                                    $total_px_per_perbandingan[$perbandingan_key] += $px;
                                }
                            }
                        }
                    }
                }

                $hitung = $this->db->query("SELECT * FROM kriteria_penilaian")->num_rows();
                ?>
                <tbody>
                    <?php foreach ($alternatif->result_array() as $key1) {
                        $id_alternatif1 = $key1['id_alternatif'];
                        ?>
                        <tr>
                            <?php foreach ($alternatif->result_array() as $key2) {
                                $id_alternatif2 = $key2['id_alternatif'];
                                if ($id_alternatif1 == $id_alternatif2) {
                                } else {
                                    $perbandingan_key = $id_alternatif1 . '_' . $id_alternatif2;
                                    $total_px = 1 / $hitung * $total_px_per_perbandingan[$perbandingan_key] ?? 0;
                                    $flow_value = $total_px;
                                    $col_idx = $id_alternatif2;
                                    if (!isset($flow[$col_idx])) {
                                        $flow[$col_idx] = $total_px;
                                    } else {
                                        $flow[$col_idx] += $total_px;
                                    }
                                }
                            }
                            ?>

                        </tr>
                    <?php } ?>

                    <!-- Tambahkan baris untuk menampilkan nilai $flow -->
                    <?php  

                    // Create an array to store the calculated cek values and the related 'kode' values for each alternative.
                    $alternatif_with_ceks = array();

                    foreach ($alternatif->result_array() as $key2) {
                        $id_alternatif2 = $key2['id_alternatif'];
                        $flow_value = 1 / $b * $flow[$id_alternatif2] ?? 0;
                        $cek = $c - $flow_value;
                        
                        // Store the 'kode' and 'cek' values in a temporary array.
                        $alternatif_with_ceks[] = array(
                            'kode' => $key2['kode'],
                            'cek' => $cek,
                        );
                    }

                    // Sort the $alternatif_with_ceks array in descending order based on the cek values.
                    usort($alternatif_with_ceks, function ($a, $b) {
                        return $b['cek'] <=> $a['cek'];
                    });

                    // Initialize the rank counter.
                    $ranking = 1;

                    
                    foreach ($alternatif_with_ceks as $alternative) {
                        echo "<tr><td>" . $alternative['kode'] . "</td><td>" . $alternative['cek'] . "</td><td>" . $ranking++ . "</td></tr>";
                    }
                    


                    // $ranking =1;foreach ($alternatif->result_array() as $key2) {
                    //     $id_alternatif2 = $key2['id_alternatif'];
                    //     $flow_value = 1/$b*$flow[$id_alternatif2] ?? 0;
                    //     $cek = $c - $flow_value;

                    //     echo "<tr><td>" . $key2['kode'] . "</td><td>" . $cek . "</td><td>". $ranking++ ."</td></tr>";
                    // }



                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Page Heading -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h3>HASIL SELEKSI</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        <th>Leaving Flow</th>
                        <th>Entering Flow</th>
                        <th>Net Flow</th>
                        <th>Ranking</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <?php
                $total_px_per_perbandingan = array();
                $flow = array();

                foreach ($kriteria as $key) {
                    $id_kriteria = $key['id_kriteria'];

                    foreach ($alternatif->result_array() as $key1) {
                        $id_alternatif1 = $key1['id_alternatif'];
                        $nilai_alternatif1 = $nilai_per_kriteria_alternatif[$id_kriteria][$id_alternatif1] ?? 0;

                        foreach ($alternatif->result_array() as $key2) {
                            $id_alternatif2 = $key2['id_alternatif'];
                            $nilai_alternatif2 = $nilai_per_kriteria_alternatif[$id_kriteria][$id_alternatif2] ?? 0;

                            if ($id_alternatif1 != $id_alternatif2) {
                                $nilai_x = $nilai_alternatif1 - $nilai_alternatif2;
                                $px = ($nilai_x <= 0) ? 0 : 1;

                                $perbandingan_key = $id_alternatif1 . '_' . $id_alternatif2;

                                if (!isset($total_px_per_perbandingan[$perbandingan_key])) {
                                    $total_px_per_perbandingan[$perbandingan_key] = $px;
                                } else {
                                    $total_px_per_perbandingan[$perbandingan_key] += $px;
                                }
                            }
                        }
                    }
                }

                $hitung = $this->db->query("SELECT * FROM kriteria_penilaian")->num_rows();
                ?>
                <tbody>
                    <?php foreach ($alternatif->result_array() as $key1) {
                        $id_alternatif1 = $key1['id_alternatif'];
                        ?>
                        <tr>
                            <?php foreach ($alternatif->result_array() as $key2) {
                                $id_alternatif2 = $key2['id_alternatif'];
                                if ($id_alternatif1 == $id_alternatif2) {
                                } else {
                                    $perbandingan_key = $id_alternatif1 . '_' . $id_alternatif2;
                                    $total_px = 1 / $hitung * $total_px_per_perbandingan[$perbandingan_key] ?? 0;
                                    $flow_value = $total_px;
                                    $col_idx = $id_alternatif2;
                                    if (!isset($flow[$col_idx])) {
                                        $flow[$col_idx] = $total_px;
                                    } else {
                                        $flow[$col_idx] += $total_px;
                                    }
                                }
                            }
                            ?>

                        </tr>
                    <?php } ?>
                    <?php
                    $alternatif_with_ceks = array();

                    foreach ($alternatif->result_array() as $key2) {
                        $id_alternatif2 = $key2['id_alternatif'];
                        $flow_value = 1 / $b * $flow[$id_alternatif2] ?? 0;
                        $cek = $c - $flow_value;
                        $alternatif_with_ceks[] = array(
                            'kode' => $key2['kode'],
                            'bobot' => $bobot,
                            'flow_value' => $flow_value,
                            'cek' => $cek,
                        );
                    }
                    usort($alternatif_with_ceks, function ($a, $b) {
                        return $b['cek'] <=> $a['cek'];
                    });
                    $ranking = 1;
                    
                    foreach ($alternatif_with_ceks as $alternative) {
                        if ($ranking > 1) {
                            $keterangan= "TIDAK DIPILIH";
                        }else{
                            $keterangan= "DIPILIH";
                        }
                        echo "<tr><td>" . $alternative['kode'] . "</td><td>" . $alternative['bobot'] . "</td><td>" . $alternative['flow_value'] . "</td><td>" . $alternative['cek'] . "</td><td>" . $ranking++ . "</td><td>".$keterangan."</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


