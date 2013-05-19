<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_total_component_a')) {

    function get_total_component_a($staff_id,$period) {
    	$total = 0;
    	$ci = &get_instance();
    	$ci->db->select('components.comp_id,components.comp_type,absensi.date,absensi.hari_masuk,salary_components_a.staff_id,salary_components_a.gaji_daily_value,salary_components_a.gaji_amount_value');
    	$ci->db->join('components','components.comp_id=salary_components_a.gaji_component_id');
    	$ci->db->join('absensi','absensi.staff_id=salary_components_a.staff_id');
    	$ci->db->where('salary_components_a.staff_id',$staff_id);
    	$ci->db->where("DATE_FORMAT(absensi.date,'%b %Y')=",$period);
  		$comp_a = $ci->db->get("salary_components_a");
		foreach($comp_a->result() as $sal_a) {
			$comp = 0;
			if ($sal_a->comp_type == 'Daily') {
				$comp = $sal_a->hari_masuk*$sal_a->gaji_daily_value;
			} else if ($sal_a->comp_type == 'Monthly') {
				$comp = $sal_a->gaji_amount_value;
			}
			$total += $comp;
		}
		return $total;
    }
}

if (!function_exists('get_total_component_b')) {

    function get_total_component_b($staff_id,$period) {
    	$total = 0;
    	$ci = &get_instance();
    	$ci->db->select('components.comp_id,components.comp_type,absensi.date,absensi.hari_masuk,salary_components_b.staff_id,salary_components_b.gaji_daily_value,salary_components_b.gaji_amount_value');
    	$ci->db->join('components','components.comp_id=salary_components_b.gaji_component_id');
    	$ci->db->join('absensi','absensi.staff_id=salary_components_b.staff_id');
    	$ci->db->where('salary_components_b.staff_id',$staff_id);
    	$ci->db->where("DATE_FORMAT(absensi.date,'%b %Y')=",$period);
  		$comp_b = $ci->db->get("salary_components_b");
		foreach($comp_b->result() as $sal_b) {
			$comp = 0;
			if ($sal_b->comp_type == 'Daily') {
				$comp = $sal_b->hari_masuk*$sal_b->gaji_daily_value;
			} else if ($sal_b->comp_type == 'Monthly') {
				$comp = $sal_b->gaji_amount_value;
			}
			$total += $comp;
		}
		return $total;
    }
}

if (!function_exists('get_total_monthly_tax')) {

    function get_total_monthly_tax($staff_id) {
		//tax const
		$wp 			= 24300000;
		$tj_percent     = floatval("0.05");
		$tj_max 		= 6000000;
		$net1 			= 50000000;
		$net2 			= 250000000;
		$net3 			= 500000000;
		$pph_percent1 	= floatval("0.05");
		$pph_percent2 	= floatval("0.15");
		$pph_percent3 	= floatval("0.25");
		$pph_percent4 	= floatval("0.3");

    	$total = 0;
    	$ci = &get_instance();
    	$ci->db->join('taxes_employees','staffs.staff_status_pajak=taxes_employees.sp_status');
    	$ci->db->join('salary_components_a','salary_components_a.staff_id=staffs.staff_id');
    	$ci->db->join('components','components.comp_id=salary_components_a.gaji_component_id');
    	$ci->db->where('staffs.staff_id',$staff_id);
    	$ci->db->where('components.comp_type','Monthly');
  		$staff_tax = $ci->db->get("staffs")->row();

		$ptkp = $wp + (count($staff_tax) > 0? $staff_tax->sp_ptkp:0);

		$gj = (count($staff_tax) > 0? $staff_tax->gaji_amount_value*12:0);
		$tj = $gj * $tj_percent;

		if ($tj > $tj_max) $tj = $tj_max;

		$net = $gj - $tj - $ptkp;

		if ($net <= $net1) $pph = $net * $pph_percent1;
		else if ($net > $net1 && $net <= $net2) $pph = $net * $pph_percent2;
		else if ($net > $net2 && $net <= $net3) $pph = $net * $pph_percent3;
		else if ($net > $net3) $pph = $net * $pph_percent4;

		return $pph/12;
    }
}

if (!function_exists('get_branch_recap_component_a')) {

    function get_branch_recap_component_a($branch,$period) {
    	$total = 0;
    	$ci = &get_instance();
    	$ci->db->select('components.comp_id,components.comp_type,absensi.date,absensi.hari_masuk,salary_components_a.staff_id,salary_components_a.gaji_daily_value,salary_components_a.gaji_amount_value');
    	$ci->db->join('components','components.comp_id=salary_components_a.gaji_component_id');
    	$ci->db->join('absensi','absensi.staff_id=salary_components_a.staff_id');
    	$ci->db->join('staffs','absensi.staff_id=staffs.staff_id');
    	$ci->db->join('branches','staffs.staff_cabang=branches.branch_id');
    	$ci->db->where('branches.branch_id',$branch);
    	$ci->db->where("DATE_FORMAT(absensi.date,'%b %Y')=",$period);
  		$comp_b = $ci->db->get("salary_components_a");
		foreach($comp_b->result() as $sal_b) {
			$comp = 0;
			if ($sal_b->comp_type == 'Daily') {
				$comp = $sal_b->hari_masuk*$sal_b->gaji_daily_value;
			} else if ($sal_b->comp_type == 'Monthly') {
				$comp = $sal_b->gaji_amount_value;
			}
			$total += $comp;
		}
		return $total;
    }
}

if (!function_exists('get_branch_recap_component_b')) {

    function get_branch_recap_component_b($branch,$period) {
    	$total = 0;
    	$ci = &get_instance();
    	$ci->db->select('components.comp_id,components.comp_type,absensi.date,absensi.hari_masuk,salary_components_b.staff_id,salary_components_b.gaji_daily_value,salary_components_b.gaji_amount_value');
    	$ci->db->join('components','components.comp_id=salary_components_b.gaji_component_id');
    	$ci->db->join('absensi','absensi.staff_id=salary_components_b.staff_id');
    	$ci->db->join('staffs','absensi.staff_id=staffs.staff_id');
    	$ci->db->join('branches','staffs.staff_cabang=branches.branch_id');
    	$ci->db->where('branches.branch_id',$branch);
    	$ci->db->where("DATE_FORMAT(absensi.date,'%b %Y')=",$period);
  		$comp_b = $ci->db->get("salary_components_b");
		foreach($comp_b->result() as $sal_b) {
			$comp = 0;
			if ($sal_b->comp_type == 'Daily') {
				$comp = $sal_b->hari_masuk*$sal_b->gaji_daily_value;
			} else if ($sal_b->comp_type == 'Monthly') {
				$comp = $sal_b->gaji_amount_value;
			}
			$total += $comp;
		}
		return $total;
    }
}

if (!function_exists('get_branch_total_monthly_tax')) {

    function get_branch_total_monthly_tax($branch,$by_company) {
		//tax const
		$wp 			= 24300000;
		$tj_percent     = floatval("0.05");
		$tj_max 		= 6000000;
		$net1 			= 50000000;
		$net2 			= 250000000;
		$net3 			= 500000000;
		$pph_percent1 	= floatval("0.05");
		$pph_percent2 	= floatval("0.15");
		$pph_percent3 	= floatval("0.25");
		$pph_percent4 	= floatval("0.3");

    	$total = 0;
    	$ci = &get_instance();
    	$ci->db->join('taxes_employees','staffs.staff_status_pajak=taxes_employees.sp_id');
    	$ci->db->join('salary_components_a','salary_components_a.staff_id=staffs.staff_id');
    	$ci->db->join('components','components.comp_id=salary_components_a.gaji_component_id');
    	$ci->db->join('branches','staffs.staff_cabang=branches.branch_id');
    	$ci->db->where('branches.branch_id',$branch);
    	$ci->db->where('staffs.pph_by_company',$by_company);
    	$ci->db->where('components.comp_type','Monthly');
  		$staff_tax = $ci->db->get("staffs");

		$total_tax = 0;
		foreach($staff_tax->result() as $row) {
			$ptkp = $wp + (count($staff_tax) > 0? $row->sp_ptkp:0);

			$gj = $row->gaji_amount_value*12;
			$tj = $gj * $tj_percent;

			if ($tj > $tj_max) $tj = $tj_max;

			$net = $gj - $tj - $ptkp;

			if ($net <= $net1) $pph = $net * $pph_percent1;
			else if ($net > $net1 && $net <= $net2) $pph = $net * $pph_percent2;
			else if ($net > $net2 && $net <= $net3) $pph = $net * $pph_percent3;
			else if ($net > $net3) $pph = $net * $pph_percent4;

			$total += $pph/12;
		}
		return $total;
    }
}

if (!function_exists('print_slip_gaji')) {

    function print_slip_gaji($staff,$period) {
    	$staff_id = $staff->staff_id;
    	$ci = &get_instance();
    	$ci->load->model("Absensi_model", "absensi");
    	
    	$branch = $ci->db->get_where("branches",array("branch_id"=>$staff->staff_cabang))->row();
    	$dept = $ci->db->get_where("departments",array("dept_id"=>$staff->staff_departement))->row();
    	$title = $ci->db->get_where("titles",array("title_id"=>$staff->staff_jabatan))->row();

    	$ci->db->select('*');
    	$ci->db->join("salary_components_a","components.comp_id=salary_components_a.gaji_component_id");
    	$ci->db->order_by("comp_id","ASC");
    	$ci->db->where("comp_type !=","Yearly");
    	$ci->db->where("staff_id",$staff_id);
  		$compsa = $ci->db->get("components");

		$compA = array();
		foreach($compsa->result() as $row) {
			$compA[] = $row;
		}

    	$ci->db->select('*');
    	$ci->db->join("salary_components_b","components.comp_id=salary_components_b.gaji_component_id");
    	$ci->db->order_by("comp_id","ASC");
    	$ci->db->where("comp_type !=","Yearly");
    	$ci->db->where("staff_id",$staff_id);
  		$compsb = $ci->db->get("components");

		$compB = array();
		foreach($compsb->result() as $row) {
			$compB[] = $row;
		}

    	$content = "
		<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\"> 
		<html lang=\"en\">
		<head>
		<meta charset=\"UTF-8\" />
		<title>
	  	Slip Gaji Karyawan
		</title>
		</head>
		<body>
		<table width=\"100%\" border=\"0\" align=\"center\">
			<tr>
				<td colspan=\"6\" align=\"center\"><h3>Slip Gaji: ".$_GET["period"]."</h3></td>
			</tr>
			<tr>
				<td width=\"20%\">Branch</td>
				<td width=\"5px\" align=\"center\">:</td>
				<td>".$branch->branch_name."</td>
				<td width=\"20%\">Nama</td>
				<td width=\"5px\" align=\"center\">:</td>
				<td>".$staff->staff_name."</td>
			</tr>
			<tr>
				<td width=\"20%\">Departemen</td>
				<td width=\"5px\" align=\"center\">:</td>
				<td>".$dept->dept_name."</td>
				<td width=\"20%\">Jabatan</td>
				<td width=\"5px\" align=\"center\">:</td>
				<td>".$title->title_name."</td>
			</tr>
			<tr>
				<td colspan=\"6\" align=\"center\">&nbsp;</td>
			</tr>
			<tr>
				<td colspan=\"6\" align=\"center\">
					<table width=\"100%\" style=\"border-width: 0 0 0 0; border-spacing: 0; border-collapse: collapse; border-style: solid;\">
     					<tr>
				            <th align=\"left\" colspan=\"3\" style=\"margin: 0; padding: 4px; border-width: 1px 0 1px 0; border-style: solid;\">Component A</th>
				            <th align=\"left\" colspan=\"3\" style=\"margin: 0; padding: 4px; border-width: 1px 0 1px 0; border-style: solid;\">Component B</th>
          				</tr>";

						$totalA = 0;
						$totalB = 0;

						$lim = count($compA) > count($compB)? count($compA):count($compB);
						for($i=0; $i<$lim; $i++) {
							$staff_absensi = $ci->absensi->get_staff_absensi($staff_id,$period)->row();
							$comp_a = $ci->db->where("staff_id",$staff_id)->where("gaji_component_id",(isset($compA[$i])? $compA[$i]->comp_id:0))->get("salary_components_a")->row();
							$comp_b = $ci->db->where("staff_id",$staff_id)->where("gaji_component_id",(isset($compB[$i])? $compB[$i]->comp_id:0))->get("salary_components_b")->row();
							
							$compA_name = (isset($compA[$i])? $compA[$i]->comp_name:'');
							$compB_name = (isset($compB[$i])? $compB[$i]->comp_name:'');
							
							$totValueA = (isset($compA[$i])? ($compA[$i]->comp_type == 'Daily'? (isset($comp_a)? $comp_a->gaji_daily_value:0)*$staff_absensi->hari_masuk:(isset($comp_a)? $comp_a->gaji_amount_value:0)):0);
							$totValueB = (isset($compB[$i])? ($compB[$i]->comp_type == 'Daily'? (isset($comp_b)? $comp_b->gaji_daily_value:0)*$staff_absensi->hari_masuk:(isset($comp_b)? $comp_b->gaji_amount_value:0)):0);
							
							$totalA += $totValueA;
							$totalB += $totValueB;
							
							$content .= "
     					<tr>
				            <td style=\"margin: 0; padding: 4px;\">".$compA_name."</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">Rp.</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">".number_format($totValueA,0,",",".")."</td>
				            <td style=\"margin: 0; padding: 4px;\">".$compB_name."</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">Rp.</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">".number_format($totValueB,0,",",".")."</td>
          				</tr>";
          				}
          				$grand = $totalA+$totalB;
          				$content .= "
     					<tr>
				            <td align=\"right\" style=\"margin: 0; padding: 4px; border-width: 1px 0 0 0; border-style: solid;\">Total(A) : </td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px; border-width: 1px 0 0 0; border-style: solid;\">Rp.</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px; border-width: 1px 0 0 0; border-style: solid;\">".number_format($totalA,0,",",".")."</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px; border-width: 1px 0 0 0; border-style: solid;\">Total(B) : </td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px; border-width: 1px 0 0 0; border-style: solid;\">Rp.</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px; border-width: 1px 0 0 0; border-style: solid;\">".number_format($totalB,0,",",".")."</td>
          				</tr>
          				<tr><td colspan=\"6\">&nbsp;</td></tr>
     					<tr>
				            <td colspan=\"3\">&nbsp;</td>
				            <td style=\"margin: 0; padding: 4px;\">Grand Total(A+B) : </td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">Rp.</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">".number_format($totalA+$totalB,0,",",".")."</td>
          				</tr>
     					<tr>
     						<td colspan=\"3\">&nbsp;</td>
				            <td style=\"margin: 0; padding: 4px;\">PPh 21 : </td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">Rp.</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">".($staff->pph_by_company == 'y'? number_format(0,0,',','.'):number_format((get_total_monthly_tax($staff->staff_id)),0,',','.'))."</td>
          				</tr>
     					<tr>
     						<td colspan=\"3\">&nbsp;</td>
				            <td style=\"margin: 0; padding: 4px;\">Nett : </td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">Rp.</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">".($staff->pph_by_company == 'y'? number_format($grand,0,',','.'):number_format(($grand-get_total_monthly_tax($staff->staff_id)),0,',','.'))."</td>
          				</tr>
          				<tr><td colspan=\"6\">&nbsp;</td></tr>
     					<tr>
				            <td colspan=\"2\" align=\"center\" style=\"margin: 0; padding: 4px;\">Deliver By</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">&nbsp;</td>
				            <td colspan=\"2\" align=\"center\" style=\"margin: 0; padding: 4px;\">Received By</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">&nbsp;</td>
          				</tr>
          				<tr><td colspan=\"6\">&nbsp;</td></tr>
          				<tr><td colspan=\"6\">&nbsp;</td></tr>
     					<tr>
				            <td colspan=\"2\" align=\"center\" style=\"margin: 0; padding: 4px;\">Sungkono</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">&nbsp;</td>
				            <td colspan=\"2\" align=\"center\" style=\"margin: 0; padding: 4px;\">".$staff->staff_name."</td>
				            <td align=\"right\" style=\"margin: 0; padding: 4px;\">&nbsp;</td>
          				</tr>
				    </table>
				</td>
			</tr>
	    </table>
	    </body>
	    </html>
		";
	    
	    $content .= "<input type=\"hidden\" id=\"staff_id\" value=\"".$staff_id."\" /><input type=\"hidden\" id=\"staff_period\" value=\"".$period."\" />";
	    
	    return $content;
    }
}