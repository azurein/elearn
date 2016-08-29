<div class="row">
    <div class="col-md-12">
        <h4 class="page-head-line">Nilai</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Data Nilai Ujian Anda</div>
            <div class="panel-body">
                <div class="table-responsive">
                	<table class="table table-striped table-bordered table-hover">
                		<tr>
                			<th>#</th>
                			<th>Mata Pelajaran</th>
                			<th>Judul Ujian</th>
                			<th>Presentase Nilai Pilihan Ganda</th>
                			<th>Presentase Nilai Essay</th>
                			<th>Nilai Total</th>
                		</tr>
                		<?php
                		$no = 1;
                		$sql_cek_nilai = mysqli_query($db, "
                            
                            SELECT * FROM tb_topik_quiz

                            JOIN tb_jawaban 
                            ON tb_topik_quiz.id_tq = tb_jawaban.id_tq

                            LEFT JOIN tb_nilai_pilgan 
                            ON tb_topik_quiz.id_tq = tb_nilai_pilgan.id_tq 
                            AND tb_jawaban.id_tq = tb_nilai_pilgan.id_tq

                            JOIN tb_mapel ON tb_topik_quiz.id_mapel = tb_mapel.id 

                            WHERE tb_topik_quiz.status like 'aktif'
                            AND tb_jawaban.id_siswa = '$_SESSION[siswa]'

                        ") or die ($db->error);
                		if(mysqli_num_rows($sql_cek_nilai) > 0) {
                			while($data_nilai = mysqli_fetch_array($sql_cek_nilai)) { ?>
                				<tr>
	                				<td><?php echo $no++; ?></td>
                					<td><?php echo $data_nilai['mapel']; ?></td>
                					<td><?php echo $data_nilai['judul']; ?></td>
                					<td>
                                        <?php
                                        if(isset($data_nilai['id_pilgan'])) {
                                            echo "Benar : ".$data_nilai['benar']." soal<br />";
                                            echo "Salah : ".$data_nilai['salah']." soal<br />";
                                            echo "Tidak dikerjakan : ".$data_nilai['tidak_dikerjakan']." soal<br />";
                                            echo "Presentase : ".$data_nilai['presentase']; 
                                        } else {
                                            echo "Ujian ini tidak ada soal pilihan ganda";
                                        } ?>
                                    </td>
                					<?php
                					$sql_cek_jawaban = mysqli_query($db, "SELECT * FROM tb_jawaban WHERE id_tq = '$data_nilai[id_tq]' AND id_siswa = '$_SESSION[siswa]'") or die ($db->error);
                					$data_jawaban = mysqli_fetch_array($sql_cek_jawaban);
                					if(mysqli_num_rows($sql_cek_jawaban) > 0) {
                						$sql_cek_nilai_essay = mysqli_query($db, "SELECT * FROM tb_nilai_essay WHERE id_tq = '$data_nilai[id_tq]' AND id_siswa = '$_SESSION[siswa]'") or die ($db->error);
                						$data_nilai_essay = mysqli_fetch_array($sql_cek_nilai_essay);
                						if(mysqli_num_rows($sql_cek_nilai_essay) > 0) { ?>
                							<td><?php  echo $data_nilai_essay['nilai']; ?></td>
                							<td><?php echo ($data_nilai['presentase']+$data_nilai_essay['nilai'])/2; ?></td>
                							<?php
                						} else {
                							echo "<td>Soal essay belum dikoreksi</td>";
                							echo "<td>Menunggu soal essay dikoreksi</td>";
                						}
                					} else { ?>
										<td>Ujian ini tidak ada soal essay</td>
										<td><?php echo $data_nilai['presentase']; ?></td>
                					<?php
                					} ?>
                				</tr>
                			<?php
	                		}
                		} else {
                            echo '<tr><td colspan="6" align="center">Tidak ada data nilai, mungkin Anda belum mengikuti ujian</td></tr>';
                        } ?>
                	</table>
               	</div>
            </div>
        </div>
    </div>
</div>