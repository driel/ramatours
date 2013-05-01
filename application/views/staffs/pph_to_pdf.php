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
    	<?php
    	if ($this->input->get('period_by') == 'Monthly') {
    	?>
		<span class="site_name">Rama Tours</span>
		<span class="date"><?php echo date("d/m/Y - H:i"); ?></span>
		<span class="cl"></span><br />
		<h2 style="text-align:center">Daftar PPh 21 Bulanan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
	      <thead>
	        <tr>
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
	      foreach ($staff_branch->result() as $row) {
        	$odd = !$odd;
	      ?>
	          <tr <?php echo $odd ? "bgcolor='#e0e0e0'":"";?>>
	            <td><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
	            <td><?php echo $row->staff_name; ?></td>
	            <td><?php echo $row->staff_cabang; ?></td>
	            <td><?php echo $row->staff_jabatan; ?></td>
	            <td><?php echo $row->hari_masuk; ?></td>
	            <td><?php echo floor((strtotime($row->date_end)-strtotime($row->date_start))/(60*60*24)); ?></td>
	            <td><?php echo $row->izin_jumlah_hari; ?></td>
	            <td><?php $total_a = get_total_component_a($row->staff_id,$this->input->get('period')); echo number_format($total_a,0,',','.'); ?></td>
	            <td><?php $total_b = get_total_component_b($row->staff_id,$this->input->get('period')); echo number_format($total_b,0,',','.'); ?></td>
	            <td><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($grand,0,',','.'):number_format(($grand-get_total_monthly_tax($row->staff_id)),0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	      </tbody>
	    </table>
	    <?php
	    } else if ($period_by_selected == 'Yearly') {
    		if ($yearly_by_selected == 'Branch') {
		?>
		<span class="site_name">Rama Tours</span>
		<span class="date"><?php echo date("d/m/Y - H:i"); ?></span>
		<span class="cl"></span><br />
		<h2 style="text-align:center">Rekapitulasi PPh 21 Cabang (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
	      <thead>
	        <tr>
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
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	        </tr>
	      </thead>
	      <tbody>
	      <?php
	      foreach ($branches->result() as $row) {
	      ?>
	          <tr>
	            <td><?php echo $row->branch_name; ?></td>
	            <td><?php $tax_y1 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y1,0,',','.'); ?></td>
	            <td><?php $tax_n1 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n1,0,',','.'); ?></td>
	            <td><?php $tax_y2 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y2,0,',','.'); ?></td>
	            <td><?php $tax_n2 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n2,0,',','.'); ?></td>
	            <td><?php $tax_y3 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y3,0,',','.'); ?></td>
	            <td><?php $tax_n3 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n3,0,',','.'); ?></td>
	            <td><?php $tax_y4 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y4,0,',','.'); ?></td>
	            <td><?php $tax_n4 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n4,0,',','.'); ?></td>
	            <td><?php $tax_y5 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y5,0,',','.'); ?></td>
	            <td><?php $tax_n5 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n5,0,',','.'); ?></td>
	            <td><?php $tax_y6 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y6,0,',','.'); ?></td>
	            <td><?php $tax_n6 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n6,0,',','.'); ?></td>
	            <td><?php $tax_y7 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y7,0,',','.'); ?></td>
	            <td><?php $tax_n7 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n7,0,',','.'); ?></td>
	            <td><?php $tax_y8 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y8,0,',','.'); ?></td>
	            <td><?php $tax_n8 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n8,0,',','.'); ?></td>
	            <td><?php $tax_y9 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y9,0,',','.'); ?></td>
	            <td><?php $tax_n9 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n9,0,',','.'); ?></td>
	            <td><?php $tax_y10 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y10,0,',','.'); ?></td>
	            <td><?php $tax_n10 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n10,0,',','.'); ?></td>
	            <td><?php $tax_y11 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y11,0,',','.'); ?></td>
	            <td><?php $tax_n11 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n11,0,',','.'); ?></td>
	            <td><?php $tax_y12 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y12,0,',','.'); ?></td>
	            <td><?php $tax_n12 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n12,0,',','.'); ?></td>
	            <td><?php $tax_y = $tax_y1+$tax_y2+$tax_y3+$tax_y4+$tax_y5+$tax_y6+$tax_y7+$tax_y8+$tax_y9+$tax_y10+$tax_y11+$tax_y12; echo number_format($tax_y,0,',','.'); ?></td>
	            <td><?php $tax_n = $tax_n1+$tax_n2+$tax_n3+$tax_n4+$tax_n5+$tax_n6+$tax_n7+$tax_n8+$tax_n9+$tax_n10+$tax_n11+$tax_n12; echo number_format($tax_n,0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	      </tbody>
	    </table>
		<?php
   			} else {
   		?>
   		<span class="site_name">Rama Tours</span>
		<span class="date"><?php echo date("d/m/Y - H:i"); ?></span>
		<span class="cl"></span><br />
		<h2 style="text-align:center">Rekapitulasi PPh 21 Karyawan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
	      <thead>
	        <tr>
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
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	          <th>Company</th>
	          <th>Personal</th>
	        </tr>
	      </thead>
	      <tbody>
	      <?php
	      $branch = '';
	      foreach ($staff_branch->result() as $row) {
	      	$pph = get_total_monthly_tax($row->staff_id);
	      ?>
	          <tr>
	            <td><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
	            <td><?php echo $row->staff_name; ?></td>
	            <td><?php echo $row->staff_departement; ?></td>
	            <td><?php echo $row->staff_jabatan; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($pph*12,0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format($pph*12,0,',','.'):'-'; ?></td>
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