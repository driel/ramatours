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
		<h2 style="text-align:center">Daftar Karyawan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
	      <thead>
	        <tr>
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
	          <?php
	          if ($this->input->get("staff_birthdate") != "") {
	          ?>
	          <th>Yang Ke</th>
	          <?php
	          }
	          ?>
	          <th>Marital</th>
	          <th>Status</th>
	          <th>Active</th>
	        </tr>
	      </thead>
	      <tbody>
	      <?php
	      $odd = true;
	      foreach ($staff_list as $row) {
        	$odd = !$odd;
	      ?>
	          <tr <?php echo $odd ? "bgcolor='#e0e0e0'":"";?>>
	            <td><?php echo $row->staff_name; ?></td>
	            <td><?php echo $row->staff_cabang; ?></td>
	            <td><?php echo $row->staff_departement; ?></td>
	            <td><?php echo $row->staff_jabatan; ?></td>
	            <td><?php echo $row->staff_sex; ?></td>
	            <td><?php echo $row->staff_birthplace.', '.date_format(new DateTime($row->staff_birthdate),'j M Y'); ?></td>
	            <td><?php echo $row->staff_address; ?></td>
	            <td><?php echo $row->staff_email; ?></td>
	            <td><?php echo $row->staff_phone_home; ?></td>
	            <td><?php echo $row->staff_phone_hp; ?></td>
	            <td><?php date_format(new DateTime($row->mulai_kerja),'j M Y'); ?></td>
	          	<?php
	          	if ($this->input->get("staff_birthdate") != "") {
	          	?>
	          	<td><?php $birthyear = date('Y', strtotime($row->staff_birthdate)); echo intval(date('Y')-intval($birthyear)); ?></td>
	          	<?php
	          	}
	          	?>
	            <td><?php echo $row->staff_status_nikah; ?></td>
	            <td><?php echo $row->staff_status_karyawan; ?></td>
	            <td><?php $date_out = date_format(new DateTime($row->date_out),'j M Y'); $contract_to = $row->contract_to; echo ($date_out != '' && $contract_to < date('Y-m-d')? 'Active':'Inactive'); ?></td>
	          </tr>
	      <?php
		  }
		  ?>
	      </tbody>
	    </table>
	</body>
</html>