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
		<h2 style="text-align:center">Daftar Karyawan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
	      <thead>
	        <tr>
	          <th>No</th>
	          <th>Name</th>
	          <th>Branch</th>
	          <th>Departement</th>
	          <th>Title</th>
	          <th>Sex</th>
	          <th>Birth Date</th>
	          <th>Address</th>
	          <th>Email</th>
	          <th>Home Phone</th>
	          <th>Cellular Phone</th>
	          <th>Start</th>
	          <th>Ulang Tahun Ke</th>
	          <th>Marital</th>
	          <th>Status</th>
	          <th>Active</th>
	        </tr>
	      </thead>
	      <tbody>
	      <?php
	      $odd = true;
	      $i=0;
	      foreach ($staff_list as $row) {
	      	$i++;
        	$odd = !$odd;
        	$date_out = date_format(new DateTime($row->date_out),'j M Y');
			$contract_to = $row->contract_to;
			$staff_status = ($date_out != '' && $contract_to < date('Y-m-d')? 'Active':'Inactive');
	      ?>
	          <tr <?php echo $odd ? "bgcolor='#e0e0e0'":"";?> <?php echo $staff_status == 'Inactive'? 'style="font-style: italic;"':''; ?>>
	            <td align="right"><?php echo $i; ?></td>
	            <td><?php echo $row->staff_name; ?></td>
	            <td><?php echo $row->staff_cabang; ?></td>
	            <td><?php echo $row->staff_departement; ?></td>
	            <td><?php echo $row->staff_jabatan; ?></td>
	            <td><?php echo $row->staff_sex; ?></td>
	            <td><?php echo $row->staff_birthplace.', '.date_format(new DateTime($row->staff_birthdate),'j M Y'); ?></td>
	            <td><?php echo $row->staff_address; ?></td>
	            <td><?php echo $row->staff_email; ?></td>
	            <td align="center"><?php echo $row->staff_phone_home; ?></td>
	            <td align="center"><?php echo $row->staff_phone_hp; ?></td>
	            <td align="center"><?php date_format(new DateTime($row->mulai_kerja),'j M Y'); ?></td>
	          	<td align="right"><?php $birthyear = date('Y', strtotime($row->staff_birthdate)); echo date('m', strtotime($row->staff_birthdate)) == date('m')? intval(date('Y')-intval($birthyear)):'-'; ?></td>
	            <td><?php echo $row->staff_status_nikah; ?></td>
	            <td><?php echo $row->staff_status_karyawan; ?></td>
	            <td align="center"><?php echo $staff_status; ?></td>
	          </tr>
	      <?php
		  }
		  ?>
	      </tbody>
	    </table>
	</body>
</html>