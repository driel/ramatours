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
		<h2 style="text-align:center">Daftar Sisa Cuti Karyawan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
	      <thead>
	        <tr>
	          <th>Branch</th>
	          <th>Departement</th>
	          <th>Name</th>
	          <th>Title</th>
	          <th>Sisa Cuti</th>
	        </tr>
	      </thead>
	      <tbody>
	      <?php
	      $odd = true;
	      foreach ($staff_list as $row) {
        	$odd = !$odd;
	      ?>
	          <tr <?php echo $odd ? "bgcolor='#e0e0e0'":"";?>>
	            <td><?php echo $row->staff_cabang; ?></td>
	            <td><?php echo $row->staff_departement; ?></td>
	            <td><?php echo $row->staff_name; ?></td>
	            <td><?php echo $row->staff_jabatan; ?></td>
	            <td><?php echo $row->saldo_cuti; ?></td>
	          </tr>
	      <?php
		  }
		  ?>
	      </tbody>
	    </table>
	</body>
</html>