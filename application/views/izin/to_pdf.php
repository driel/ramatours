<!DOCTYPE html>
<html lang="en">
	<head>
	<style type="text/css">
	table {border-width: 0 0 1px 1px;border-spacing: 0;border-collapse: collapse;border-style: solid;}
	td, th {margin: 0;padding: 4px;border-width: 1px 1px 0 0;border-style: solid;}
	.site_name{float:left; font-size:22px;}
	.date{float:right; font-size:10px;}
	</style>
	</head>
    <body>
    	<span class="site_name">Rama Tours</span>
		<span class="date"><?php echo date("d/m/Y - H:i"); ?></span>
		<span class="cl"></span><br />
		<h2 style="text-align:center">Daftar Izin Karyawan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
            <thead>
                <tr>
                    <th rowspan="2">Name</th>
		          	<th rowspan="2">Branch</th>
		          	<th rowspan="2">Departement</th>
		          	<th rowspan="2">Title</th>
                    <th width="15%">Date</th>
                    <th width="10%">Jumlah hari</th>
                    <th width="40%">Note</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($izin->result() as $row) {
            $staff = get_staff_detail($row->izin_staff_id);
            ?>
                <tr>
                    <td><?php echo $row->staff_name; ?></td>
		            <td><?php echo $row->staff_cabang; ?></td>
		            <td><?php echo $row->staff_departement; ?></td>
		            <td><?php echo $row->staff_jabatan; ?></td>
                    <td><?php echo date_format(new DateTime($row->izin_date),'j M Y'); ?></td>
                    <td><?php echo $row->izin_jumlah_hari; ?></td>
                    <td><?php echo $row->izin_note; ?></td>
                </tr>
            <?php
			}
			?>
            </tbody>
        </table>
	</body>
</html>