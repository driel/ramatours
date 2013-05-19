<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>
		  <?php echo $title; ?>
		</title>
		<?php echo load_css("report-style.css"); ?>
		<?php echo load_css("dashboard.css"); ?>
		<style type="text/css">
		  table.report {border-collapse: collapse; border: solid 2px #000;}
		  table.report td {padding: 2px; border: solid 1px #ccc;}
		  table.report td.blackshade {background-color: #DFEAF5;}
		  table.report td.pagesummary {background: #FFB;}
		  td, td, p{font-size:9px;}
		</style>
	</head>
    <body>
  		<h3>Detil Gaji Karyawan</h3>
  		<span style="font-size:9px;"><?php echo date("y/m/d"); ?></span>
		<div>
			<table class="report" style="width:100%">
	        <tr>
	          <td rowspan="2" class="blackshade">No</td>
	          <td rowspan="2" class="blackshade">Cabang</td>
	          <td rowspan="2" class="blackshade">Staff</td>
	          <td rowspan="2" class="blackshade">Department</td>
	          <td rowspan="2" class="blackshade">Title</td>
	          <td colspan="3" class="blackshade">Daftar Absensi</td>
	          <td rowspan="2" class="blackshade">Total A</td>
	          <td rowspan="2" class="blackshade">Total B</td>
	          <td rowspan="2" class="blackshade">Grand</td>
	          <td colspan="2" class="blackshade">PPh</td>
	          <td rowspan="2" class="blackshade">Net</td>
	        </tr>
	        <tr>
	          <td class="blackshade">Absen</td>
	          <td class="blackshade">Cuti</td>
	          <td class="blackshade">Izin</td>
	          <td class="blackshade">Perusahaan</td>
	          <td class="blackshade">Pribadi</td>
	        </tr>
	      <?php
	      $branch = '';
	      $i=0;
	      foreach ($staff_branch->result() as $row) {
	      	$i++;
          ?>
    		<tr>
	            <td class="data ta_right"><?php echo $i; ?></td>
	            <td class="data"><?php if ($row->branch_name == $branch) { echo '';} else { $branch = $row->branch_name; echo $row->branch_name;} ?></td>
	            <td class="data"><?php echo $row->staff_name; ?></td>
	            <td class="data"><?php echo $row->staff_departement; ?></td>
	            <td class="data"><?php echo $row->staff_jabatan; ?></td>
	            <td class="data ta_right"><?php echo $row->hari_masuk; ?></td>
	            <td class="data ta_right"><?php echo floor((strtotime($row->date_end)-strtotime($row->date_start))/(60*60*24)); ?></td>
	            <td class="data ta_right"><?php echo $row->izin_jumlah_hari; ?></td>
	            <td class="data ta_right"><?php $total_a = get_total_component_a($row->staff_id,$this->input->get('periode')); echo number_format($total_a,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_b = get_total_component_b($row->staff_id,$this->input->get('periode')); echo number_format($total_b,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($grand,0,',','.'):number_format(($grand-get_total_monthly_tax($row->staff_id)),0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	    </table>
	</body>
</html>