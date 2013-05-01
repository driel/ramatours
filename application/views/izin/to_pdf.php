<!DOCTYPE html>
<html lang="en">
	<head>
	<style type="text/css">
	table {border-width: 1px 1px 1px 1px;border-spacing: 0;border-collapse: collapse;border-style: solid; font-size:12px;}
	td, th {margin: 0;padding: 4px;border-width: 1px 1px 0 0;border-style: solid; font-size:10px;}
	.site_name{float:left; font-size:22px;}
	.date{float:right; font-size:10px;}
	h2{margin-top: 0;}
	</style>
	</head>
    <body>
    	<table style="border: 0;" width="100%">
    		<tr>
    			<td style="border: 0;" align="left"><span class="site_name">Rama Tours</span></td>
    			<td style="border: 0;" align="right"><span class="date"><?php echo date("d/m/Y - H:i"); ?></span></td>
    		</tr>
    	</table>
		<span class="cl"></span><br />
		<h2 style="text-align:center">Daftar Izin Karyawan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
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
	      	$odd = true;
	      	$i=0;
            foreach ($izin->result() as $row) {
            	$staff = get_staff_detail($row->izin_staff_id);
		      	$i++;
	        	$odd = !$odd;
            ?>
        		<tr <?php echo $odd ? "bgcolor='#e0e0e0'":"";?>>
		            <td align="right"><?php echo $i; ?></td>
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