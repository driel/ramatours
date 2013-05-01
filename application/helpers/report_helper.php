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
    	$ci->db->where("DATE_FORMAT(absensi.date,'%Y-%m')",$period);
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
    	$ci->db->where("DATE_FORMAT(absensi.date,'%Y-%m')",$period);
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
    	$ci->db->join('branches','staffs.staff_cabang=branches.branch_name');
    	$ci->db->where('branches.branch_name',$branch);
    	$ci->db->where("DATE_FORMAT(absensi.date,'%Y-%m')",$period);
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
    	$ci->db->join('branches','staffs.staff_cabang=branches.branch_name');
    	$ci->db->where('branches.branch_name',$branch);
    	$ci->db->where("DATE_FORMAT(absensi.date,'%Y-%m')",$period);
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
    	$ci->db->join('taxes_employees','staffs.staff_status_pajak=taxes_employees.sp_status');
    	$ci->db->join('salary_components_a','salary_components_a.staff_id=staffs.staff_id');
    	$ci->db->join('components','components.comp_id=salary_components_a.gaji_component_id');
    	$ci->db->join('branches','staffs.staff_cabang=branches.branch_name');
    	$ci->db->where('branches.branch_name',$branch);
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
    	$content = "
		<table width=\"500px\" border=\"0\" align=\"center\">
			<tr>
				<td colspan=\"3\" align=\"center\">PT Rama Tours</td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\">Slip Gaji</td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\">&nbsp;</td>
			</tr>
			<tr>
				<td width=\"20%\">Nama</td>
				<td width=\"5px\" align=\"center\">:</td>
				<td>".$staff->staff_name."</td>
			</tr>
			<tr>
				<td width=\"20%\">Departemen</td>
				<td width=\"5px\" align=\"center\">:</td>
				<td>".$staff->staff_departement."</td>
			</tr>
			<tr>
				<td width=\"20%\">Jabatan</td>
				<td width=\"5px\" align=\"center\">:</td>
				<td>".$staff->staff_jabatan."</td>
			</tr>
			<tr>
				<td width=\"20%\">Cabang</td>
				<td width=\"5px\" align=\"center\">:</td>
				<td>".$staff->staff_cabang."</td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\">&nbsp;</td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\">
					<table width=\"500px;\" style=\"border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;\">
     					<tr>
				            <td style=\"margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;\">Jenis</td>
				            <td style=\"margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;\" width=\"10px\">Jml Hari</td>
				            <td style=\"margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;\">Jumlah</td>
          				</tr>";

				    	$ci->db->select('*');
				    	$ci->db->join("salary_components_a","components.comp_id=salary_components_a.gaji_component_id");
				    	$ci->db->order_by("comp_id","ASC");
				    	$ci->db->where("comp_type !=","Yearly");
				    	$ci->db->where("staff_id",$staff_id);
				  		$compsa = $ci->db->get("components");

						foreach($compsa->result() as $comp) {
							$staff_absensi = $ci->absensi->get_staff_absensi($staff_id,$period)->row();
							$comp_a = $ci->db->where("staff_id",$staff_id)->where("gaji_component_id",$comp->comp_id)->get("salary_components_a")->row();
							
							$content .= "
     					<tr>
				            <td style=\"margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;\">".$comp->comp_name."</td>
				            <td style=\"margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;\" width=\"10px\">".($comp->comp_type == 'Daily'? $staff_absensi->hari_masuk:'-')."</td>
				            <td style=\"margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;\">".($comp->comp_type == 'Daily'? number_format($comp_a->gaji_daily_value*$staff_absensi->hari_masuk,0,",","."):number_format($comp_a->gaji_amount_value,0,",","."))."</td>
          				</tr>";
          				}
          				$content .= "
     					<tr>
				            <td style=\"margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;\" colspan=\"3\">Lainnya</td>
          				</tr>";

				    	$ci->db->select('*');
				    	$ci->db->join("salary_components_b","components.comp_id=salary_components_b.gaji_component_id");
				    	$ci->db->order_by("comp_id","ASC");
				    	$ci->db->where("comp_type !=","Yearly");
				    	$ci->db->where("staff_id",$staff_id);
				  		$compsb = $ci->db->get("components");

						foreach($compsb->result() as $comp) {
							$staff_absensi = $ci->absensi->get_staff_absensi($staff_id,$period)->row();
							$comp_a = $ci->db->where("staff_id",$staff_id)->where("gaji_component_id",$comp->comp_id)->get("salary_components_b")->row();
						
							$content .= "
     					<tr>
				            <td style=\"margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;\">".$comp->comp_name."</td>
				            <td style=\"margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;\" width=\"10px\">".($comp->comp_type == 'Daily'? $staff_absensi->hari_masuk:'-')."</td>
				            <td style=\"margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;\">".($comp->comp_type == 'Daily'? number_format($comp_a->gaji_daily_value*$staff_absensi->hari_masuk,0,",","."):number_format($comp_a->gaji_amount_value,0,",","."))."</td>
          				</tr>";
          				}
          				$content .= "
				    </table>
				</td>
			</tr>
	    </table>";
	    
	    $content .= "<input type=\"hidden\" id=\"staff_id\" value=\"".$staff_id."\" /><input type=\"hidden\" id=\"staff_period\" value=\"".$period."\" />";
	    
	    return $content;
    }
}