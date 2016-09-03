<div class="row">
	<div class="panel panel-default">
	    <div class="panel-heading">
	        Data Siswa yang Mengikuti Ujian &nbsp; <a href="?page=quiz" class="btn btn-danger btn-sm">Kembali</a>
	    </div>
	    <div class="panel-body">
            <div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status Hasil</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
					$sql_siswa_mengikuti_tes = mysqli_query($db, "
                        
                        SELECT DISTINCT
                        tb_siswa.id_siswa,
                        tb_siswa.nama_lengkap,
                        tb_nilai_pilgan.presentase,
                        tb_nilai_essay.nilai as 'nilai_essay',
                        tb_kelas.nama_kelas

                        FROM tb_topik_quiz

                        LEFT JOIN tb_nilai_pilgan 
                        ON tb_topik_quiz.id_tq = tb_nilai_pilgan.id_tq

                        LEFT JOIN tb_nilai_essay
                        ON tb_topik_quiz.id_tq = tb_nilai_essay.id_tq 
                        
                        JOIN tb_siswa 
                        ON tb_nilai_pilgan.id_siswa = tb_nilai_pilgan.id_siswa
                        OR tb_nilai_essay.id_siswa = tb_siswa.id_siswa 
                        
                        JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas 

                        WHERE tb_topik_quiz.status like 'aktif'
                        AND tb_topik_quiz.id_tq = '$id_tq'

                    ") or die ($db->error);
                    if(mysqli_num_rows($sql_siswa_mengikuti_tes) > 0) {
    					while($data_siswa_mengikuti_tes = mysqli_fetch_array($sql_siswa_mengikuti_tes)) {
    						?>
                            <tr>
                                <td align="center" width="40px"><?php echo $no++; ?></td>
                                <td><?php echo $data_siswa_mengikuti_tes['nama_lengkap']; ?></td>
                                <td><?php echo $data_siswa_mengikuti_tes['nama_kelas']; ?></td>
                            	<?php
                            	$sql_pilgan = mysqli_query($db, "SELECT * FROM tb_nilai_pilgan WHERE id_siswa = '$data_siswa_mengikuti_tes[id_siswa]' AND id_tq = '$id_tq'") or die ($db->error);
                            	$data_pilgan = mysqli_fetch_array($sql_pilgan);
                                $sql_jwb = mysqli_query($db, "SELECT * FROM tb_jawaban WHERE id_siswa = '$data_siswa_mengikuti_tes[id_siswa]' AND id_tq = '$id_tq'") or die ($db->error);
                            	$sql_essay = mysqli_query($db, "SELECT * FROM tb_nilai_essay WHERE id_siswa = '$data_siswa_mengikuti_tes[id_siswa]' AND id_tq = '$id_tq'") or die ($db->error);
                            	$data_essay = mysqli_fetch_array($sql_essay);
                            	?>
                            	<td>
                            		Nilai soal pilihan ganda : 
                                    <?php
                                    if(mysqli_num_rows($sql_pilgan) > 0) {
                                        echo round($data_pilgan['presentase']);
                                    } else {
                                        echo "Ujian ini tidak ada soal pilihan ganda";
                                    } ?>
                                    <br />
                            		Nilai soal essay : 
                            		<?php
                                    if(mysqli_num_rows($sql_jwb) > 0) {
                                		if(mysqli_num_rows($sql_essay) > 0) {
                                			echo round($data_essay['nilai']);
                                		} else {
                                			echo "(belum dikoreksi)";
                                		}
                                    } else {
                                        echo "Ujian ini tidak ada soal essay";
                                    } ?>
                            	</td>
                                <td align="center" width="220px">
                                    <?php
                                    if(mysqli_num_rows($sql_jwb) > 0) {
                                        if(mysqli_num_rows($sql_essay) > 0) { ?>
                                            <a href="?page=quiz&action=koreksi&hal=editessay&id_tq=<?php echo $id_tq; ?>&id_siswa=<?php echo $data_siswa_mengikuti_tes['id_siswa']; ?>&id_nilai=<?php echo $data_essay['id']; ?>" class="badge" style="background-color:#f60;">Edit Koreksi Essay</a>
                                        <?php
                                        } else { ?>
                                            <a href="?page=quiz&action=koreksi&hal=essay&id_tq=<?php echo $id_tq; ?>&id_siswa=<?php echo $data_siswa_mengikuti_tes['id_siswa']; ?>" class="badge" style="background-color:#f60;">Koreksi Jawaban Essay</a>
                                        <?php
                                        }
                                    } ?>
                                    <a onclick="return confirm('Yakin akan menghapus siswa ini dari daftar peserta ujian?');" href="?page=quiz&action=hapuspeserta&id_tq=<?php echo $id_tq; ?>&id_siswa=<?php echo $data_siswa_mengikuti_tes['id_siswa']; ?>" class="badge" style="background-color:#f00;">Hapus Siswa dari Peserta Ujian</a>
                                </td>
                            </tr>
    					<?php
    					}
                    } else {
                        echo '<tr><td colspan="5" align="center">Data tidak ditemukan</td></tr>';
                    } ?>
                    </tbody>
                </table>
                <?php if(mysqli_num_rows($sql_siswa_mengikuti_tes) > 0) { ?>
                    <a href="./laporan/cetak.php?data=quiz&id_tq=<?php echo $id_tq; ?>" target="_blank" class="btn btn-default btn-sm">Cetak</a>
                <?php } ?>
            </div>
        </div>
	</div>
</div>