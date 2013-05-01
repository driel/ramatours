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
		<h2 style="text-align:center">Daftar Sisa Cuti Karyawan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
	      <thead>
	        <tr>
	          <th>No</th>
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
	      $i=0;
	      foreach ($staff_list as $row) {
	      	$i++;
        	$odd = !$odd;
          ?>
    		<tr <?php echo $odd ? "bgcolor='#e0e0e0'":"";?>>
	            <td align="right"><?php echo $i; ?></td>
	            <td><?php echo $row->staff_cabang; ?></td>
	            <td><?php echo $row->staff_departement; ?></td>
	            <td><?php echo $row->staff_name; ?></td>
	            <td><?php echo $row->staff_jabatan; ?></td>
	            <td align="right"><?php echo $row->saldo_cuti; ?></td>
	          </tr>
	      <?php
		  }
		  ?>
	      </tbody>
	    </table>
	</body>
</html>