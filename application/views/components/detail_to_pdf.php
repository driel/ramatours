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
		<h2 style="text-align:center">Detil Gaji Karyawan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<h2 style="text-align:center">Periode : <?php echo ($this->input->get("period_year") != FALSE && $this->input->get("period_month") != FALSE) ? bulan_full($this->input->get('period_month')).' '.$this->input->get("period_year"):"-"?></h2>
		<table width="100%" align="center">
	      <thead>
	        <tr>
	          <th rowspan="2">No</th>
	          <th rowspan="2">Cabang</th>
	          <th rowspan="2">Staff</th>
	          <th rowspan="2">Department</th>
	          <th rowspan="2">Title</th>
	          <th colspan="3">Daftar Absensi</th>
	          <th rowspan="2">Total A</th>
	          <th rowspan="2">Total B</th>
	          <th rowspan="2">Grand</th>
	          <th colspan="2">PPh</th>
	          <th rowspan="2">Net</th>
	        </tr>
	        <tr>
	          <th>Absen</th>
	          <th>Cuti</th>
	          <th>Izin</th>
	          <th>Perusahaan</th>
	          <th>Pribadi</th>
	        </tr>
	      </thead>
	      <tbody>
	      <?php
	      $branch = '';
	      $odd = true;
	      $i=0;
	      foreach ($staff_branch->result() as $row) {
	      	$i++;
        	$odd = !$odd;
          ?>
    		<tr <?php echo $odd ? "bgcolor='#e0e0e0'":"";?>>
	            <td align="right"><?php echo $i; ?></td>
	            <td><?php if ($row->branch_name == $branch) { echo '';} else { $branch = $row->branch_name; echo $row->branch_name;} ?></td>
	            <td><?php echo $row->staff_name; ?></td>
	            <td><?php echo $row->staff_departement; ?></td>
	            <td><?php echo $row->staff_jabatan; ?></td>
	            <td align="right"><?php echo $row->hari_masuk; ?></td>
	            <td align="right"><?php echo floor((strtotime($row->date_end)-strtotime($row->date_start))/(60*60*24)); ?></td>
	            <td align="right"><?php echo $row->izin_jumlah_hari; ?></td>
	            <td align="right"><?php $total_a = get_total_component_a($row->staff_id,$this->input->get('period_year').'-'.$this->input->get('period_month')); echo number_format($total_a,0,',','.'); ?></td>
	            <td align="right"><?php $total_b = get_total_component_b($row->staff_id,$this->input->get('period_year').'-'.$this->input->get('period_month')); echo number_format($total_b,0,',','.'); ?></td>
	            <td align="right"><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
	            <td align="right"><?php echo $row->pph_by_company == 'y'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
	            <td align="right"><?php echo $row->pph_by_company == 'n'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
	            <td align="right"><?php echo $row->pph_by_company == 'y'? number_format($grand,0,',','.'):number_format(($grand-get_total_monthly_tax($row->staff_id)),0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	      </tbody>
	    </table>
	</body>
</html>