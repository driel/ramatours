<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>
		  Report PPh 21
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
  		<h3>Daftar PPh 21 Bulanan</h3>
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
	            <td class="data"><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
	            <td class="data"><?php echo $row->staff_name; ?></td>
	            <td class="data"><?php echo $row->staff_cabang; ?></td>
	            <td class="data"><?php echo $row->staff_jabatan; ?></td>
	            <td class="data ta_right"><?php echo $row->hari_masuk; ?></td>
	            <td class="data ta_right"><?php echo floor((strtotime($row->date_end)-strtotime($row->date_start))/(60*60*24)); ?></td>
	            <td class="data ta_right"><?php echo $row->izin_jumlah_hari; ?></td>
	            <td class="data ta_right"><?php $total_a = get_total_component_a($row->staff_id,$this->input->get('period')); echo number_format($total_a,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $total_b = get_total_component_b($row->staff_id,$this->input->get('period')); echo number_format($total_b,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($grand,0,',','.'):number_format(($grand-get_total_monthly_tax($row->staff_id)),0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	    </table>
	    </div>
	    <?php
	    } else if ($period_by_selected == 'Yearly') {
    		if ($yearly_by_selected == 'Branch') {
		?>
  		<h3>Rekapitulasi PPh 21 Cabang</h3>
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
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	        </tr>
	      <?php
	      $i=0;
	      foreach ($branches->result() as $row) {
	      	$i++;
          ?>
    		<tr>
	            <td class="data ta_right"><?php echo $i; ?></td>
	            <td class="data"><?php echo $row->branch_name; ?></td>
	            <td class="data ta_right"><?php $tax_y1 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y1,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n1 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_n1,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_y2 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y2,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n2 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_n2,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_y3 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y3,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n3 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_n3,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_y4 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y4,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n4 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_n4,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_y5 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y5,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n5 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_n5,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_y6 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y6,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n6 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_n6,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_y7 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y7,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n7 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_n7,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_y8 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y8,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n8 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_n8,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_y9 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y9,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n9 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_n9,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_y10 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y10,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n10 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_n10,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_y11 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y11,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n11 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_n11,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_y12 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_y12,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n12 = get_branch_total_monthly_tax($row->branch_id,'y'); echo number_format($tax_n12,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_y = $tax_y1+$tax_y2+$tax_y3+$tax_y4+$tax_y5+$tax_y6+$tax_y7+$tax_y8+$tax_y9+$tax_y10+$tax_y11+$tax_y12; echo number_format($tax_y,0,',','.'); ?></td>
	            <td class="data ta_right"><?php $tax_n = $tax_n1+$tax_n2+$tax_n3+$tax_n4+$tax_n5+$tax_n6+$tax_n7+$tax_n8+$tax_n9+$tax_n10+$tax_n11+$tax_n12; echo number_format($tax_n,0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	    </table>
	    </div>
		<?php
   			} else {
   		?>
  		<h3>Rekapitulasi PPh 21 Karyawan</h3>
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
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	          <td class="blackshade">Company</td>
	          <td class="blackshade">Personal</td>
	        </tr>
	      <?php
	      $branch = '';
	      $i=0;
	      foreach ($staff_branch->result() as $row) {
	      	$pph = get_total_monthly_tax($row->staff_id);
	      	$i++;
          ?>
    		<tr>
	            <td class="data ta_right"><?php echo $i; ?></td>
	            <td class="data"><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
	            <td class="data"><?php echo $row->staff_name; ?></td>
	            <td class="data"><?php echo $row->staff_departement; ?></td>
	            <td class="data"><?php echo $row->staff_jabatan; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'y'? number_format($pph*12,0,',','.'):'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->pph_by_company == 'n'? number_format($pph*12,0,',','.'):'-'; ?></td>
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