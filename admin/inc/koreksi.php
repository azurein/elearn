<?php
error_reporting(0);
if(@$_GET['hal'] == 'essay') { ?>
    <div class="row">
    	<div class="panel panel-default">
    	    <div class="panel-heading">
    	        Koreksi Jawaban Essay &nbsp; <a onclick="self.history.back();" class="btn btn-warning btn-sm">Kembali</a>
    	    </div>
            <form action="" method="post">
    	    <div class="panel-body">
                <div class="table-responsive">
                    <table width="100%">
                        <?php
                        $urut = 1;
                        $sql_jawaban = mysqli_query($db, "

                            SELECT DISTINCT
                            tb_soal_essay.pertanyaan,
                            tb_soal_essay.gambar,
                            tb_jawaban.jawaban,
                            tb_jawaban.gambar as attachment


                            FROM tb_jawaban

                            JOIN tb_soal_essay
                            ON tb_jawaban.id_soal = tb_soal_essay.id_essay
                            AND tb_jawaban.id_tq = tb_soal_essay.id_tq

                            LEFT JOIN tb_nilai_essay
                            ON tb_jawaban.id_siswa = tb_nilai_essay.id_siswa
                            AND tb_soal_essay.id_tq = tb_jawaban.id_tq

                            WHERE tb_jawaban.id_tq = '$id_tq' AND
                            tb_jawaban.id_siswa = '$_GET[id_siswa]'

                        ") or die ($db->error);
                        $jumlah_soal = mysqli_num_rows($sql_jawaban);
                        while($data_jawaban = mysqli_fetch_array($sql_jawaban)) { ?>
                            <tr>
                                <td width="10%" valign="top">( <?php echo $no++; ?> )</td>
                                <td>
                                    <table class="table">
                                        <tr>
                                            <td><b>Pertanyaan :</b></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $data_jawaban['pertanyaan']; ?></td>
                                        </tr>
                                        <?php if($data_jawaban['gambar'] != '') { ?>
                                            <tr>
                                                <td colspan="2">
                                                    <img width="220px" src="../admin/img/gambar_soal_essay/<?php echo $data_jawaban['gambar']; ?>" />
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td><b>Jawaban :</b></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $data_jawaban['jawaban']; ?></td>
                                        </tr>
                                         <?php
                                        if($data_jawaban['attachment'] != '') { ?>
                                            <tr>
                                                <td colspan="2"><a href="../uploads/essay_attachment/<?php echo $data_jawaban['attachment']; ?>"
                                                download>Unduh lampiran</a></td>
                                            </tr>
                                        <?php
                                        } ?>
                                        <tr>
                                            <td><b>Presentase nilai tiap soal :</b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="nilai_essay[<?php echo $urut++; ?>]">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        <?php
                        } ?>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" name="simpan_koreksi" value="Simpan" class="btn btn-primary btn-sm" />
                <input type="reset" value="Reset" class="btn btn-danger btn-sm" />
            </div>
            </form>
            <?php
            $nilai = 0;
            if(@$_POST['simpan_koreksi']) {
                foreach(@$_POST['nilai_essay'] as $key => $value) {
                    $nilai = $nilai + $value;
                }
                $nilai_total = $nilai / $jumlah_soal;
                mysqli_query($db, "INSERT INTO tb_nilai_essay VALUES(NULL, '$id_tq', '$_GET[id_siswa]', '$nilai_total')") or die ($db->error);
                echo "<script>window.location='?page=quiz&action=pesertakoreksi&id_tq=".$id_tq."';</script>";
            }
            ?>
    	</div>
    </div>
<?php
} else if(@$_GET['hal'] == 'editessay') { ?>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit Koreksi Jawaban Essay &nbsp; <a onclick="self.history.back();" class="btn btn-warning btn-sm">Kembali</a>
            </div>
            <form action="" method="post">
            <div class="panel-body">
                <div class="table-responsive">
                    <table width="100%">
                        <?php
                        $urut = 1;
                        $sql_jawaban = mysqli_query($db, "

                            SELECT DISTINCT
                            tb_soal_essay.pertanyaan,
                            tb_soal_essay.gambar,
                            tb_jawaban.jawaban,
                            tb_jawaban.gambar as attachment


                            FROM tb_jawaban

                            JOIN tb_soal_essay
                            ON tb_jawaban.id_soal = tb_soal_essay.id_essay
                            AND tb_jawaban.id_tq = tb_soal_essay.id_tq

                            LEFT JOIN tb_nilai_essay
                            ON tb_jawaban.id_siswa = tb_nilai_essay.id_siswa
                            AND tb_soal_essay.id_tq = tb_jawaban.id_tq

                            WHERE tb_jawaban.id_tq = '$id_tq' AND
                            tb_jawaban.id_siswa = '$_GET[id_siswa]'

                        ") or die ($db->error);
                        $jumlah_soal = mysqli_num_rows($sql_jawaban);
                        while($data_jawaban = mysqli_fetch_array($sql_jawaban)) { ?>
                            <tr>
                                <td width="10%" valign="top">( <?php echo $no++; ?> )</td>
                                <td>
                                    <table class="table">
                                        <tr>
                                            <td><b>Pertanyaan :</b></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $data_jawaban['pertanyaan']; ?></td>
                                        </tr>
                                        <?php if($data_jawaban['gambar'] != '') { ?>
                                            <tr>
                                                <td colspan="2">
                                                    <img width="220px" src="../admin/img/gambar_soal_essay/<?php echo $data_jawaban['gambar']; ?>" />
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td><b>Jawaban :</b></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $data_jawaban['jawaban']; ?></td>
                                        </tr>
                                        <?php
                                        if($data_jawaban['attachment'] != '') { ?>
                                            <tr>
                                                <td colspan="2"><a href="../uploads/essay_attachment
                                                <?php echo $data_jawaban['attachment']; ?>" target="_blank">Unduh lampiran</a></td>
                                            </tr>
                                        <?php
                                        } ?>
                                        <tr>
                                            <td><b>Presentase tiap soal <small>(Untuk mengedit, silahkan masukkan ulang nilainya)</small> :</b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                               <input type="text" name="nilai_essay[<?php echo $urut++; ?>]" value="<?php echo $data_jawaban['nilai']; ?>">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        <?php
                        } ?>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" name="simpan_koreksi" value="Simpan" class="btn btn-primary btn-sm" />
                <input type="reset" value="Reset" class="btn btn-danger btn-sm" />
            </div>
            </form>
            <?php
            $nilai = 0;
            if(@$_POST['simpan_koreksi']) {
                foreach(@$_POST['nilai_essay'] as $key => $value) {
                    $nilai = $nilai + $value;
                }
                $nilai_total = $nilai / $jumlah_soal;
                mysqli_query($db, "UPDATE tb_nilai_essay SET nilai = '$nilai_total' WHERE id = '$_GET[id_nilai]'") or die ($db->error);
                echo "<script>window.location='?page=quiz&action=pesertakoreksi&id_tq=".$id_tq."';</script>";
            }
            ?>
        </div>
    </div>
<?php
} ?>
