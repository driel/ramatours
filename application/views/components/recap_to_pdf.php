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
    	<?php
    	if ($this->input->get('period_by') == 'Monthly') {
    	?>
  		<h3>Rekap Gaji Bulanan Karyawan</h3>
  		<span style="font-size:9px;"><?php echo date("y/m/d"); ?></span>
		<div>
			<table class="report" style="width:100%">
	        <tr>
	          <td rowspan="2" class="blackshade">No</td>
	          <td rowspan="2" class="blackshade">Cabang</td>
			  <td rowspan="2" class="blackshade">Total A</td>
	          <td rowspan="2" class="blackshade">Total B</td>
	          <td rowspan="2" class="blackshade">Grand</td>
	          <td colspan="2" class="blackshade">PPh</td>
	          <td rowspan="2" class="blackshade">Net</td>
	        </tr>
	        <tr>
	          <td class="blackshade">Perusahaan</td>
	          <td class="blackshade">Pribadi</td>
	        </tr>
	      <?php
	      $branch = '';
	      $i=0;
	      foreach ($branches->result() as $row) {
	      	$i++;
          ?>
    		<tr>
	            <td class="data ta_right"><?php echo $i; ?></td>
	            <td class="data"><?php echo $row->branch_name; ?></td>
	            <td class="data ta_right"><?php $total_a = get_branch_recap_component_a($row->branch_id,$this->input->get('period')); echo number_format($total_a,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_b = get_branch_recap_component_b($row->branch_id,$this->input->get('period')); echo number_format($total_b,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
	            <td class="data ta_right"><?php $tax_y = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n = get_branch_total_monthly_tax($row->branch_id,'n'); echo number_format($tax_n,0,',','.'); ?></td>
	            <td class="data ta_right"><?php echo number_format(($grand-$tax_y),0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	    </table>
	    </div>
	    <?php
	    } else if ($period_by_selected == 'Yearly') {
    		if ($yearly_by_selected == 'Branch') {
		?>
  		<h3>Rekap Gaji Tahunan</h3>
  		<span style="font-size:9px;"><?php echo date("y/m/d"); ?></span>
		<div>
			<table class="report" style="width:100%">
	        <tr>
	          <td rowspan="2" class="blackshade">No</td>
	          <td rowspan="2" class="blackshade">Cabang</td>
	          <td colspan="2" class="blackshade">Januari</td>
	          <td colspan="2" class="blackshade">Februari</td>
	          <td colspan="2" class="blackshade">Maret</td>
	          <td colspan="2" class="blackshade">April</td>
	          <td colspan="2" class="blackshade">Mei</td>
	          <td colspan="2" class="blackshade">Juni</td>
	          <td colspan="2" class="blackshade">Juli</td>
	          <td colspan="2" class="blackshade">Agustus</td>
	          <td colspan="2" class="blackshade">September</td>
	          <td colspan="2" class="blackshade">Oktober</td>
	          <td colspan="2" class="blackshade">November</td>
	          <td colspan="2" class="blackshade">Desember</td>
	          <td colspan="2" class="blackshade">Total</td>
	        </tr>
	        <tr>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	        </tr>
	      <?php
	      $i=0;
	      foreach ($branches->result() as $row) {
	      	$i++;
          ?>
    		<tr>
	            <td class="data ta_right"><?php echo $i; ?></td>
	            <td class="data"><?php echo $row->branch_name; ?></td>
	            <td class="data ta_right"><?php $total_a1 = get_branch_recap_component_a($row->branch_id,'Jan '.$this->input->get('yearly')); $total_b1 = get_branch_recap_component_b($row->branch_name,'Jan '.$this->input->get('yearly')); $grand1 = ($total_a1+$total_b1); echo $grand1; ?></td>
	            <td class="data ta_right"><?php $tax_y1 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand1 > 0? $grand1-$tax_y1:0),0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a2 = get_branch_recap_component_a($row->branch_id,'Feb '.$this->input->get('yearly')); $total_b2 = get_branch_recap_component_b($row->branch_name,'Feb '.$this->input->get('yearly')); $grand2 = ($total_a2+$total_b2); echo $grand2; ?></td>
	            <td class="data ta_right"><?php $tax_y2 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand2 > 0? $grand2-$tax_y2:0),0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a3 = get_branch_recap_component_a($row->branch_id,'Mar '.$this->input->get('yearly')); $total_b3 = get_branch_recap_component_b($row->branch_name,'Mar '.$this->input->get('yearly')); $grand3 = ($total_a3+$total_b3); echo $grand3; ?></td>
	            <td class="data ta_right"><?php $tax_y3 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand3 > 0? $grand3-$tax_y3:0),0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a4 = get_branch_recap_component_a($row->branch_id,'Apr '.$this->input->get('yearly')); $total_b4 = get_branch_recap_component_b($row->branch_name,'Apr '.$this->input->get('yearly')); $grand4 = ($total_a4+$total_b4); echo $grand4; ?></td>
	            <td class="data ta_right"><?php $tax_y4 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand4 > 0? $grand4-$tax_y4:0),0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a5 = get_branch_recap_component_a($row->branch_id,'May '.$this->input->get('yearly')); $total_b5 = get_branch_recap_component_b($row->branch_name,'May '.$this->input->get('yearly')); $grand5 = ($total_a5+$total_b5); echo $grand5; ?></td>
	            <td class="data ta_right"><?php $tax_y5 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand5 > 0? $grand5-$tax_y5:0),0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a6 = get_branch_recap_component_a($row->branch_id,'Jun '.$this->input->get('yearly')); $total_b6 = get_branch_recap_component_b($row->branch_name,'Jun '.$this->input->get('yearly')); $grand6 = ($total_a6+$total_b6); echo $grand6; ?></td>
	            <td class="data ta_right"><?php $tax_y6 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand6 > 0? $grand6-$tax_y6:0),0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a7 = get_branch_recap_component_a($row->branch_id,'Jul '.$this->input->get('yearly')); $total_b7 = get_branch_recap_component_b($row->branch_name,'Jul '.$this->input->get('yearly')); $grand7 = ($total_a7+$total_b7); echo $grand7; ?></td>
	            <td class="data ta_right"><?php $tax_y7 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand7 > 0? $grand7-$tax_y7:0),0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a8 = get_branch_recap_component_a($row->branch_id,'Aug '.$this->input->get('yearly')); $total_b8 = get_branch_recap_component_b($row->branch_name,'Aug '.$this->input->get('yearly')); $grand8 = ($total_a8+$total_b8); echo $grand8; ?></td>
	            <td class="data ta_right"><?php $tax_y8 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand8 > 0? $grand8-$tax_y8:0),0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a9 = get_branch_recap_component_a($row->branch_id,'Sep '.$this->input->get('yearly')); $total_b9 = get_branch_recap_component_b($row->branch_name,'Sep '.$this->input->get('yearly')); $grand9 = ($total_a9+$total_b9); echo $grand9; ?></td>
	            <td class="data ta_right"><?php $tax_y9 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand9 > 0? $grand9-$tax_y9:0),0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a10 = get_branch_recap_component_a($row->branch_id,'Oct '.$this->input->get('yearly')); $total_b10 = get_branch_recap_component_b($row->branch_name,'Oct '.$this->input->get('yearly')); $grand10 = ($total_a10+$total_b10); echo $grand10; ?></td>
	            <td class="data ta_right"><?php $tax_y10 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand10 > 0? $grand10-$tax_y10:0),0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a11 = get_branch_recap_component_a($row->branch_id,'Nov '.$this->input->get('yearly')); $total_b11 = get_branch_recap_component_b($row->branch_name,'Nov '.$this->input->get('yearly')); $grand11 = ($total_a11+$total_b11); echo $grand11; ?></td>
	            <td class="data ta_right"><?php $tax_y11 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand11 > 0? $grand11-$tax_y11:0),0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a12 = get_branch_recap_component_a($row->branch_id,'Dec '.$this->input->get('yearly')); $total_b12 = get_branch_recap_component_b($row->branch_name,'Dec '.$this->input->get('yearly')); $grand12 = ($total_a12+$total_b12); echo $grand12; ?></td>
	            <td class="data ta_right"><?php $tax_y12 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand12 > 0? $grand12-$tax_y12:0),0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a = $total_a1+$total_a2+$total_a4+$total_a5+$total_a6+$total_a7+$total_a8+$total_a9+$total_a10+$total_a11+$total_a12; $total_b = $total_b1+$total_b2+$total_b3+$total_b4+$total_b5+$total_b6+$total_b7+$total_b8+$total_b9+$total_b10+$total_b11+$total_b12; $grand = ($total_a+$total_b); echo $grand; ?></td>
	            <td class="data ta_right"><?php $tax_y = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format(($grand > 0? $grand-$tax_y:0),0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	    </table>
	    </div>
		<?php
   			} else {
		?>
  		<h3>Rekap Gaji Tahunan</h3>
  		<span style="font-size:9px;"><?php echo date("y/m/d"); ?></span>
		<div>
			<table class="report" style="width:100%">
	        <tr>
	          <td rowspan="2" class="blackshade">No</td>
	          <td rowspan="2" class="blackshade">Cabang</td>
	          <td rowspan="2" class="blackshade">Staff</td>
	          <td rowspan="2" class="blackshade">Department</td>
	          <td rowspan="2" class="blackshade">Title</td>
	          <td colspan="2" class="blackshade">Januari</td>
	          <td colspan="2" class="blackshade">Februari</td>
	          <td colspan="2" class="blackshade">Maret</td>
	          <td colspan="2" class="blackshade">April</td>
	          <td colspan="2" class="blackshade">Mei</td>
	          <td colspan="2" class="blackshade">Juni</td>
	          <td colspan="2" class="blackshade">Juli</td>
	          <td colspan="2" class="blackshade">Agustus</td>
	          <td colspan="2" class="blackshade">September</td>
	          <td colspan="2" class="blackshade">Oktober</td>
	          <td colspan="2" class="blackshade">November</td>
	          <td colspan="2" class="blackshade">Desember</td>
	          <td colspan="2" class="blackshade">Total</td>
	        </tr>
	        <tr>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
	          <td class="blackshade">Grand</td>
	          <td class="blackshade">Net</td>
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
	            <td class="data ta_right"><?php $total_a1 = get_total_component_a($row->staff_id,'Jan '.$this->input->get('yearly')); $total_b1 = get_total_component_b($row->staff_id,'Jan '.$this->input->get('yearly')); $grand1 = ($total_a1+$total_b1); echo $grand1; ?></td>
	            <td class="data ta_right"><?php $net1 = $grand1 > 0? ($grand1-get_total_monthly_tax($row->staff_id)):0; echo number_format($net1,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a2 = get_total_component_a($row->staff_id,'Feb '.$this->input->get('yearly')); $total_b2 = get_total_component_b($row->staff_id,'Feb '.$this->input->get('yearly')); $grand2 = ($total_a2+$total_b2); echo $grand2; ?></td>
	            <td class="data ta_right"><?php $net2 = $grand2 > 0? ($grand2-get_total_monthly_tax($row->staff_id)):0; echo number_format($net2,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a3 = get_total_component_a($row->staff_id,'Mar '.$this->input->get('yearly')); $total_b3 = get_total_component_b($row->staff_id,'Mar '.$this->input->get('yearly')); $grand3 = ($total_a3+$total_b3); echo $grand3; ?></td>
	            <td class="data ta_right"><?php $net3 = $grand3 > 0? ($grand3-get_total_monthly_tax($row->staff_id)):0; echo number_format($net3,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a4 = get_total_component_a($row->staff_id,'Apr '.$this->input->get('yearly')); $total_b4 = get_total_component_b($row->staff_id,'Apr '.$this->input->get('yearly')); $grand4 = ($total_a4+$total_b4); echo $grand4; ?></td>
	            <td class="data ta_right"><?php $net4 = $grand4 > 0? ($grand4-get_total_monthly_tax($row->staff_id)):0; echo number_format($net4,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a5 = get_total_component_a($row->staff_id,'May '.$this->input->get('yearly')); $total_b5 = get_total_component_b($row->staff_id,'May '.$this->input->get('yearly')); $grand5 = ($total_a5+$total_b5); echo $grand5; ?></td>
	            <td class="data ta_right"><?php $net5 = $grand5 > 0? ($grand5-get_total_monthly_tax($row->staff_id)):0; echo number_format($net5,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a6 = get_total_component_a($row->staff_id,'Jun '.$this->input->get('yearly')); $total_b6 = get_total_component_b($row->staff_id,'Jun '.$this->input->get('yearly')); $grand6 = ($total_a6+$total_b6); echo $grand6; ?></td>
	            <td class="data ta_right"><?php $net6 = $grand6 > 0? ($grand6-get_total_monthly_tax($row->staff_id)):0; echo number_format($net6,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a7 = get_total_component_a($row->staff_id,'Jul '.$this->input->get('yearly')); $total_b7 = get_total_component_b($row->staff_id,'Jul '.$this->input->get('yearly')); $grand7 = ($total_a7+$total_b7); echo $grand7; ?></td>
	            <td class="data ta_right"><?php $net7 = $grand7 > 0? ($grand7-get_total_monthly_tax($row->staff_id)):0; echo number_format($net7,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a8 = get_total_component_a($row->staff_id,'Aug '.$this->input->get('yearly')); $total_b8 = get_total_component_b($row->staff_id,'Aug '.$this->input->get('yearly')); $grand8 = ($total_a8+$total_b8); echo $grand8; ?></td>
	            <td class="data ta_right"><?php $net8 = $grand8 > 0? ($grand8-get_total_monthly_tax($row->staff_id)):0; echo number_format($net8,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a9 = get_total_component_a($row->staff_id,'Sep '.$this->input->get('yearly')); $total_b9 = get_total_component_b($row->staff_id,'Sep '.$this->input->get('yearly')); $grand9 = ($total_a9+$total_b9); echo $grand9; ?></td>
	            <td class="data ta_right"><?php $net9 = $grand9 > 0? ($grand9-get_total_monthly_tax($row->staff_id)):0; echo number_format($net9,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a10 = get_total_component_a($row->staff_id,'Oct '.$this->input->get('yearly')); $total_b10 = get_total_component_b($row->staff_id,'Oct '.$this->input->get('yearly')); $grand10 = ($total_a10+$total_b10); echo $grand10; ?></td>
	            <td class="data ta_right"><?php $net10 = $grand10 > 0? ($grand10-get_total_monthly_tax($row->staff_id)):0; echo number_format($net10,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a11 = get_total_component_a($row->staff_id,'Nov '.$this->input->get('yearly')); $total_b11 = get_total_component_b($row->staff_id,'Nov '.$this->input->get('yearly')); $grand11 = ($total_a11+$total_b11); echo $grand11; ?></td>
	            <td class="data ta_right"><?php $net11 = $grand11 > 0? ($grand11-get_total_monthly_tax($row->staff_id)):0; echo number_format($net11,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a12 = get_total_component_a($row->staff_id,'Dec '.$this->input->get('yearly')); $total_b12 = get_total_component_b($row->staff_id,'Dec '.$this->input->get('yearly')); $grand12 = ($total_a12+$total_b12); echo $grand12; ?></td>
	            <td class="data ta_right"><?php $net12 = $grand12 > 0? ($grand12-get_total_monthly_tax($row->staff_id)):0; echo number_format($net12,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_a = $total_a1+$total_a2+$total_a3+$total_a4+$total_a5+$total_a6+$total_a7+$total_a8+$total_a9+$total_a10+$total_a11+$total_a12; $total_b = $total_b1+$total_b2+$total_b3+$total_b4+$total_b5+$total_b6+$total_b7+$total_b8+$total_b9+$total_b10+$total_b11+$total_b12; $grand = ($total_a+$total_b); echo $grand; ?></td>
	            <td class="data ta_right"><?php $net = $grand > 0? ($grand-(abs(get_total_monthly_tax($row->staff_id)*12))):0; echo number_format($net,0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	    </table>
	    </div>
		<?php
   			}
	    }
	    ?>
	</body>
</html>