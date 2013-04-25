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
    		<h3>Salary Recapitulation Report</h3>
    	</center>
      	<table width="50%" align="center">
      		<?php
      		if ($this->input->get('period') != "") {
      		?>
  			<tr>
  				<td>Period</td>
 				<td><?php echo bulan($this->input->get('period')).' '.date('Y'); ?></td>
			</tr>
      		<?php
      		}
      		if ($this->input->get('branch') != "") {
      		?>
  			<tr>
  				<td>Branch</td>
 				<td><?php echo $this->input->get('branch'); ?></td>
			</tr>
      		<?php
      		}
      		?>
      	</table>
    	<br />
		<table width="100%" align="center">
	      <thead>
	        <tr>
	          <th rowspan="2">Cabang</th>
			  <th rowspan="2">Total A</th>
	          <th rowspan="2">Total B</th>
	          <th rowspan="2">Grand</th>
	          <th colspan="2">PPh</th>
	          <th rowspan="2">Net</th>
	        </tr>
	        <tr>
	          <th>Perusahaan</th>
	          <th>Pribadi</th>
	        </tr>
	      </thead>
	      <tbody>
	      <?php
	      $branch = '';
	      foreach ($branches->result() as $row) {
	      ?>
	          <tr>
	            <td><?php echo $row->branch_name; ?></td>
	            <td><?php $total_a = get_branch_recap_component_a($row->branch_name,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); echo number_format($total_a,0,',','.'); ?></td>
	            <td><?php $total_b = get_branch_recap_component_b($row->branch_name,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); echo number_format($total_b,0,',','.'); ?></td>
	            <td><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
	            <td><?php $tax_y = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y,0,',','.'); ?></td>
	            <td><?php $tax_n = get_branch_total_monthly_tax($row->branch_name,'n'); echo number_format($tax_n,0,',','.'); ?></td>
	            <td><?php echo number_format(($grand-$tax_y),0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	      </tbody>
	    </table>
	</body>
</html>