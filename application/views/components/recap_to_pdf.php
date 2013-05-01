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
    	<?php
    	if ($this->input->get('period_by') == 'Monthly') {
    	?>
		<h2 style="text-align:center">Rekap Gaji Bulanan Karyawan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
	      <thead>
	        <tr>
	          <th rowspan="2">No</th>
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
	      $odd = true;
	      $i=0;
	      foreach ($branches->result() as $row) {
	      	$i++;
        	$odd = !$odd;
          ?>
    		<tr <?php echo $odd ? "bgcolor='#e0e0e0'":"";?>>
	            <td align="right"><?php echo $i; ?></td>
	            <td><?php echo $row->branch_name; ?></td>
	            <td align="right"><?php $total_a = get_branch_recap_component_a($row->branch_name,$this->input->get('period') == ''? $period_year_selected.'-'.$period_month_selected:$this->input->get('period_year').'-'.$this->input->get('period_month')); echo number_format($total_a,0,',','.'); ?></td>
	            <td align="right"><?php $total_b = get_branch_recap_component_b($row->branch_name,$this->input->get('period') == ''? $period_year_selected.'-'.$period_month_selected:$this->input->get('period_year').'-'.$this->input->get('period_month')); echo number_format($total_b,0,',','.'); ?></td>
	            <td align="right"><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
	            <td align="right"><?php $tax_y = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y,0,',','.'); ?></td>
	            <td align="right"><?php $tax_n = get_branch_total_monthly_tax($row->branch_name,'n'); echo number_format($tax_n,0,',','.'); ?></td>
	            <td align="right"><?php echo number_format(($grand-$tax_y),0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	      </tbody>
	    </table>
	    <?php
	    } else if ($period_by_selected == 'Yearly') {
    		if ($yearly_by_selected == 'Branch') {
		?>
		<h2 style="text-align:center">Rekap Gaji Tahunan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
	      <thead>
	        <tr>
	          <th rowspan="2">No</th>
	          <th rowspan="2">Cabang</th>
	          <th colspan="2">Januari</th>
	          <th colspan="2">Februari</th>
	          <th colspan="2">Maret</th>
	          <th colspan="2">April</th>
	          <th colspan="2">Mei</th>
	          <th colspan="2">Juni</th>
	          <th colspan="2">Juli</th>
	          <th colspan="2">Agustus</th>
	          <th colspan="2">September</th>
	          <th colspan="2">Oktober</th>
	          <th colspan="2">November</th>
	          <th colspan="2">Desember</th>
	          <th colspan="2">Total</th>
	        </tr>
	        <tr>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	        </tr>
	      </thead>
	      <tbody>
	      <?php
	      $odd = true;
	      $i=0;
	      foreach ($branches->result() as $row) {
	      	$i++;
        	$odd = !$odd;
          ?>
    		<tr <?php echo $odd ? "bgcolor='#e0e0e0'":"";?>>
	            <td align="right"><?php echo $i; ?></td>
	            <td><?php echo $row->branch_name; ?></td>
	            <td align="right"><?php $total_a1 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-01'); $total_b1 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-01'); $grand1 = ($total_a1+$total_b1); echo $grand1; ?></td>
	            <td align="right"><?php $tax_y1 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand1 > 0? $grand1-$tax_y1:0),0,',','.'); ?></td>
	            <td align="right"><?php $total_a2 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-02'); $total_b2 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-02'); $grand2 = ($total_a2+$total_b2); echo $grand2; ?></td>
	            <td align="right"><?php $tax_y2 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand2 > 0? $grand2-$tax_y2:0),0,',','.'); ?></td>
	            <td align="right"><?php $total_a3 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-03'); $total_b3 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-03'); $grand3 = ($total_a3+$total_b3); echo $grand3; ?></td>
	            <td align="right"><?php $tax_y3 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand3 > 0? $grand3-$tax_y3:0),0,',','.'); ?></td>
	            <td align="right"><?php $total_a4 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-04'); $total_b4 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-04'); $grand4 = ($total_a4+$total_b4); echo $grand4; ?></td>
	            <td align="right"><?php $tax_y4 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand4 > 0? $grand4-$tax_y4:0),0,',','.'); ?></td>
	            <td align="right"><?php $total_a5 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-05'); $total_b5 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-05'); $grand5 = ($total_a5+$total_b5); echo $grand5; ?></td>
	            <td align="right"><?php $tax_y5 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand5 > 0? $grand5-$tax_y5:0),0,',','.'); ?></td>
	            <td align="right"><?php $total_a6 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-06'); $total_b6 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-06'); $grand6 = ($total_a6+$total_b6); echo $grand6; ?></td>
	            <td align="right"><?php $tax_y6 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand6 > 0? $grand6-$tax_y6:0),0,',','.'); ?></td>
	            <td align="right"><?php $total_a7 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-07'); $total_b7 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-07'); $grand7 = ($total_a7+$total_b7); echo $grand7; ?></td>
	            <td align="right"><?php $tax_y7 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand7 > 0? $grand7-$tax_y7:0),0,',','.'); ?></td>
	            <td align="right"><?php $total_a8 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-08'); $total_b8 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-08'); $grand8 = ($total_a8+$total_b8); echo $grand8; ?></td>
	            <td align="right"><?php $tax_y8 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand8 > 0? $grand8-$tax_y8:0),0,',','.'); ?></td>
	            <td align="right"><?php $total_a9 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-09'); $total_b9 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-09'); $grand9 = ($total_a9+$total_b9); echo $grand9; ?></td>
	            <td align="right"><?php $tax_y9 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand9 > 0? $grand9-$tax_y9:0),0,',','.'); ?></td>
	            <td align="right"><?php $total_a10 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-10'); $total_b10 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-10'); $grand10 = ($total_a10+$total_b10); echo $grand10; ?></td>
	            <td align="right"><?php $tax_y10 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand10 > 0? $grand10-$tax_y10:0),0,',','.'); ?></td>
	            <td align="right"><?php $total_a11 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-11'); $total_b11 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-11'); $grand11 = ($total_a11+$total_b11); echo $grand11; ?></td>
	            <td align="right"><?php $tax_y11 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand11 > 0? $grand11-$tax_y11:0),0,',','.'); ?></td>
	            <td align="right"><?php $total_a12 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-12'); $total_b12 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-12'); $grand12 = ($total_a12+$total_b12); echo $grand12; ?></td>
	            <td align="right"><?php $tax_y12 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand12 > 0? $grand12-$tax_y12:0),0,',','.'); ?></td>
	            <td align="right"><?php $total_a = $total_a1+$total_a2+$total_a4+$total_a5+$total_a6+$total_a7+$total_a8+$total_a9+$total_a10+$total_a11+$total_a12; $total_b = $total_b1+$total_b2+$total_b3+$total_b4+$total_b5+$total_b6+$total_b7+$total_b8+$total_b9+$total_b10+$total_b11+$total_b12; $grand = ($total_a+$total_b); echo $grand; ?></td>
	            <td align="right"><?php $tax_y = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand > 0? $grand-$tax_y:0),0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	      </tbody>
	    </table>
		<?php
   			} else {
		?>
		<h2 style="text-align:center">Rekap Gaji Tahunan Karyawan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
	      <thead>
	        <tr>
	          <th rowspan="2">No</th>
	          <th rowspan="2">Cabang</th>
	          <th rowspan="2">Staff</th>
	          <th rowspan="2">Department</th>
	          <th rowspan="2">Title</th>
	          <th colspan="2">Januari</th>
	          <th colspan="2">Februari</th>
	          <th colspan="2">Maret</th>
	          <th colspan="2">April</th>
	          <th colspan="2">Mei</th>
	          <th colspan="2">Juni</th>
	          <th colspan="2">Juli</th>
	          <th colspan="2">Agustus</th>
	          <th colspan="2">September</th>
	          <th colspan="2">Oktober</th>
	          <th colspan="2">November</th>
	          <th colspan="2">Desember</th>
	          <th colspan="2">Total</th>
	        </tr>
	        <tr>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
	          <th>Grand</th>
	          <th>Net</th>
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
	            <td><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
	            <td><?php echo $row->staff_name; ?></td>
	            <td><?php echo $row->staff_departement; ?></td>
	            <td><?php echo $row->staff_jabatan; ?></td>
	            <td align="right"><?php $total_a1 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-01'); $total_b1 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-01'); $grand1 = ($total_a1+$total_b1); echo $grand1; ?></td>
	            <td align="right"><?php $net1 = $grand1 > 0? ($grand1-get_total_monthly_tax($row->staff_id)):0; echo number_format($net1,0,',','.'); ?></td>
	            <td align="right"><?php $total_a2 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-02'); $total_b2 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-02'); $grand2 = ($total_a2+$total_b2); echo $grand2; ?></td>
	            <td align="right"><?php $net2 = $grand2 > 0? ($grand2-get_total_monthly_tax($row->staff_id)):0; echo number_format($net2,0,',','.'); ?></td>
	            <td align="right"><?php $total_a3 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-03'); $total_b3 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-03'); $grand3 = ($total_a3+$total_b3); echo $grand3; ?></td>
	            <td align="right"><?php $net3 = $grand3 > 0? ($grand3-get_total_monthly_tax($row->staff_id)):0; echo number_format($net3,0,',','.'); ?></td>
	            <td align="right"><?php $total_a4 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-04'); $total_b4 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-04'); $grand4 = ($total_a4+$total_b4); echo $grand4; ?></td>
	            <td align="right"><?php $net4 = $grand4 > 0? ($grand4-get_total_monthly_tax($row->staff_id)):0; echo number_format($net4,0,',','.'); ?></td>
	            <td align="right"><?php $total_a5 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-05'); $total_b5 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-05'); $grand5 = ($total_a5+$total_b5); echo $grand5; ?></td>
	            <td align="right"><?php $net5 = $grand5 > 0? ($grand5-get_total_monthly_tax($row->staff_id)):0; echo number_format($net5,0,',','.'); ?></td>
	            <td align="right"><?php $total_a6 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-06'); $total_b6 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-06'); $grand6 = ($total_a6+$total_b6); echo $grand6; ?></td>
	            <td align="right"><?php $net6 = $grand6 > 0? ($grand6-get_total_monthly_tax($row->staff_id)):0; echo number_format($net6,0,',','.'); ?></td>
	            <td align="right"><?php $total_a7 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-07'); $total_b7 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-07'); $grand7 = ($total_a7+$total_b7); echo $grand7; ?></td>
	            <td align="right"><?php $net7 = $grand7 > 0? ($grand7-get_total_monthly_tax($row->staff_id)):0; echo number_format($net7,0,',','.'); ?></td>
	            <td align="right"><?php $total_a8 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-08'); $total_b8 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-08'); $grand8 = ($total_a8+$total_b8); echo $grand8; ?></td>
	            <td align="right"><?php $net8 = $grand8 > 0? ($grand8-get_total_monthly_tax($row->staff_id)):0; echo number_format($net8,0,',','.'); ?></td>
	            <td align="right"><?php $total_a9 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-09'); $total_b9 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-09'); $grand9 = ($total_a9+$total_b9); echo $grand9; ?></td>
	            <td align="right"><?php $net9 = $grand9 > 0? ($grand9-get_total_monthly_tax($row->staff_id)):0; echo number_format($net9,0,',','.'); ?></td>
	            <td align="right"><?php $total_a10 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-10'); $total_b10 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-10'); $grand10 = ($total_a10+$total_b10); echo $grand10; ?></td>
	            <td align="right"><?php $net10 = $grand10 > 0? ($grand10-get_total_monthly_tax($row->staff_id)):0; echo number_format($net10,0,',','.'); ?></td>
	            <td align="right"><?php $total_a11 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-11'); $total_b11 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-11'); $grand11 = ($total_a11+$total_b11); echo $grand11; ?></td>
	            <td align="right"><?php $net11 = $grand11 > 0? ($grand11-get_total_monthly_tax($row->staff_id)):0; echo number_format($net11,0,',','.'); ?></td>
	            <td align="right"><?php $total_a12 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-12'); $total_b12 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-12'); $grand12 = ($total_a12+$total_b12); echo $grand12; ?></td>
	            <td align="right"><?php $net12 = $grand12 > 0? ($grand12-get_total_monthly_tax($row->staff_id)):0; echo number_format($net12,0,',','.'); ?></td>
	            <td align="right"><?php $total_a = $total_a1+$total_a2+$total_a3+$total_a4+$total_a5+$total_a6+$total_a7+$total_a8+$total_a9+$total_a10+$total_a11+$total_a12; $total_b = $total_b1+$total_b2+$total_b3+$total_b4+$total_b5+$total_b6+$total_b7+$total_b8+$total_b9+$total_b10+$total_b11+$total_b12; $grand = ($total_a+$total_b); echo $grand; ?></td>
	            <td align="right"><?php $net = $grand > 0? ($grand-(abs(get_total_monthly_tax($row->staff_id)*12))):0; echo number_format($net,0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	      </tbody>
	    </table>
		<?php
   			}
	    }
	    ?>
	</body>
</html>