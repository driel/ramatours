<!DOCTYPE html>
<html lang="en">
	<head>
	<style type="text/css">
		table {
			border-width: 0 0 1px 1px;
			border-spacing: 0;
			border-collapse: collapse;
			border-style: solid;
		}
 
		td, th {
			margin: 0;
			padding: 4px;
			border-width: 1px 1px 0 0;
			border-style: solid;
		}
	</style>
	</head>
    <body>
    	<center>
    		<h3>Document Expired Report</h3>
    	</center>
      	<table width="50%" align="center">
      		<?php
      		if ($this->input->get('staff_cabang') != "") {
      		?>
  			<tr>
  				<td>Branch</td>
 				<td><?php echo $this->input->get('staff_cabang'); ?></td>
			</tr>
      		<?php
      		}
      		if ($this->input->get('$staff_departement') != "") {
      		?>
  			<tr>
  				<td>Department</td>
 				<td><?php echo $this->input->get('$staff_departement'); ?></td>
			</tr>
      		<?php
      		}
      		if ($this->input->get('staff_jabatan') != "") {
      		?>
  			<tr>
  				<td>Title</td>
 				<td><?php echo $this->input->get('staff_jabatan'); ?></td>
			</tr>
      		<?php
      		}
      		if ($this->input->get('staff_name') != "") {
      		?>
  			<tr>
  				<td>Name</td>
 				<td><?php echo $this->input->get('staff_name'); ?></td>
			</tr>
      		<?php
      		}
      		?>
      	</table>
      	<br />
		<table width="100%" align="center">
	      <thead>
	        <tr>
	          <th rowspan="2">Name</th>
	          <th rowspan="2">Branch</th>
	          <th rowspan="2">Departement</th>
	          <th rowspan="2">Title</th>
	          <th colspan="2">Nomor</th>
	          <th colspan="2">Nomor</th>
	        </tr>
	        <tr>
	          <th>Passport</th>
	          <th>Expired</th>
	          <th>Passport</th>
	          <th>Expired</th>
	        </tr>
	      </thead>
	      <tbody>
	      <?php
	      foreach ($staff_list as $row) {
	      ?>
	          <tr>
	            <td><?php echo $row->staff_name; ?></td>
	            <td><?php echo $row->staff_cabang; ?></td>
	            <td><?php echo $row->staff_departement; ?></td>
	            <td><?php echo $row->staff_jabatan; ?></td>
	            <td><?php echo $row->no_passport; ?></td>
	            <td><?php echo $row->passport_expired; ?></td>
	            <td><?php echo $row->no_kitas; ?></td>
	            <td><?php echo $row->kitas_expired; ?></td>
	          </tr>
	      <?php
		  }
		  ?>
	      </tbody>
	    </table>
	</body>
</html>