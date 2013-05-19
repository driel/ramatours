<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>
		  <?php echo $report_title; ?>
		</title>
		<?php echo load_css("report-style.css"); ?>
		<?php echo load_css("dashboard.css"); ?>
		<style type="text/css">
		  table.report {border-collapse: collapse; border: solid 2px #000;}
		  table.report td {padding: 2px; border: solid 1px #ccc;}
		  table.report td.blackshade {background-color: #DFEAF5;}
		  table.report td.pagesummary {background: #FFB;}
		  td, th, p{font-size:9px;}
		</style>
	</head>
    <body>
  <h3><?php echo $report_title; ?></h3>
  <span style="font-size:9px;"><?php echo date("y/m/d"); ?></span>
	<div>
		<table class="report" style="width:100%">
	        <tr>
	          <td class="blackshade">No</td>
	          <td class="blackshade">Name</td>
	          <td class="blackshade">Branch</td>
	          <td class="blackshade">Departement</td>
	          <td class="blackshade">Title</td>
	          <td class="blackshade">Sex</td>
	          <td class="blackshade">Birth Date</td>
	          <td class="blackshade">Address</td>
	          <td class="blackshade">Email</td>
	          <td class="blackshade">Home Phone</td>
	          <td class="blackshade">Cellular Phone</td>
	          <td class="blackshade">Start</td>
	          <td class="blackshade">Umur</td>
	          <td class="blackshade">Marital</td>
	          <td class="blackshade">Status</td>
	          <td class="blackshade">Active</td>
	        </tr>
	      <?php
	      $i=0;
	      foreach ($staff_list as $row) {
	      	$i++;
        	$date_out = date_format(new DateTime($row->date_out),'j M Y');
			$contract_to = $row->contract_to;
			
			$born = new DateTime($row->staff_birthdate);
			$now = new DateTime();
			$interval = $now->diff($born);
			$age = $interval->y;
			
			$branch = get_branch_detail($row->staff_cabang);
			$dept = get_dept_detail($row->staff_departement);
			$title = get_title_detail($row->staff_jabatan);
			$marital = get_marital_detail($row->staff_status_nikah);
			$emp_status = get_employee_status_detail($row->staff_status_karyawan);
			
			$staff_status = ($date_out != '0000-00-00' && $contract_to < date('Y-m-d')? 'Active':'Inactive');
	      ?>
	          <tr <?php echo $staff_status == 'Inactive'? 'style="font-style: italic;"':''; ?>>
	            <td class="data ta_right"><?php echo $i; ?></td>
	            <td class="data"><?php echo $row->staff_name; ?></td>
	            <td class="data"><?php echo $branch? $branch->branch_name:'-'; ?></td>
	            <td class="data"><?php echo $dept? $dept->dept_name:'-'; ?></td>
	            <td class="data"><?php echo $title? $title->title_name:'-'; ?></td>
	            <td class="data"><?php echo $row->staff_sex; ?></td>
	            <td class="data"><?php echo $row->staff_birthplace.', '.date_format(new DateTime($row->staff_birthdate),'j M Y'); ?></td>
	            <td class="data"><?php echo $row->staff_address; ?></td>
	            <td class="data"><?php echo $row->staff_email; ?></td>
	            <td class="data ta_center"><?php echo $row->staff_phone_home; ?></td>
	            <td class="data ta_center"><?php echo $row->staff_phone_hp; ?></td>
	            <td align="center"><?php date_format(new DateTime($row->mulai_kerja),'j M Y'); ?></td>
	          	<td class="data ta_right"><?php echo $age;?></td>
	            <td class="data"><?php echo $marital? $marital->sn_name:'-'; ?></td>
	            <td class="data"><?php echo $emp_status? $emp_status->sk_name:'-'; ?></td>
	            <td class="data ta_center"><?php echo $staff_status; ?></td>
	          </tr>
	      <?php
		  }
		  ?>
			<tr>
				<td colspan="16" class="pagesummary">Summary</td>
			</tr>
	    </table>
	</body>
</html>