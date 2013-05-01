<!DOCTYPE html>
<html lang="en">
	<head>
	<style type="text/css">
	table {border-width: 0 0 1px 1px;border-spacing: 0;border-collapse: collapse;border-style: solid;}
	td, th {margin: 0;padding: 4px;border-width: 1px 1px 0 0;border-style: solid;}
	.site_name{float:left; font-size:22px;}
	.date{float:right; font-size:10px;}
	h2{margin-top: 0;}
	</style>
	</head>
    <body>
    	<span class="site_name">Rama Tours</span>
		<span class="date"><?php echo date("d/m/Y - H:i"); ?></span>
		<span class="cl"></span><br />
		<h2 style="text-align:center">Daftar Absensi Karyawan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
		    <thead>
                <tr>
                    <th width="10%">Kode Absen</th>
		          	<th>Name</th>
		          	<th>Branch</th>
		          	<th>Departement</th>
		          	<th>Title</th>
                    <th width="20%">Date</th>
                    <th width="10%">Jumlah masuk</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($absensi->result() as $row) {
            ?>
                <tr>
                    <td><?php echo $row->staff_kode_absen; ?></td>
		            <td><?php echo $row->staff_name; ?></td>
		            <td><?php echo $row->staff_cabang; ?></td>
		            <td><?php echo $row->staff_departement; ?></td>
		            <td><?php echo $row->staff_jabatan; ?></td>
                    <td><?php echo date_format(new DateTime($row->date),'j M Y'); ?></td>
                    <td><span class="float-right"><?php echo $row->hari_masuk; ?></span></td>
                </tr>
            <?php
			}
			?>
			</tbody>
		</table>
	</body>
</html>