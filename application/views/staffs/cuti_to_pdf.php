<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>
		  Report Sisa Cuti
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
  		<h3>Report Sisa Cuti Karyawan</h3>
  		<span style="font-size:9px;"><?php echo date("y/m/d"); ?></span>
		<div>
		<table class="report" style="width:100%">
	        <tr>
	          <td class="blackshade">No</td>
	          <td class="blackshade">Branch</td>
	          <td class="blackshade">Departement</td>
	          <td class="blackshade">Name</td>
	          <td class="blackshade">Title</td>
	          <td class="blackshade">Sisa Cuti</td>
	        </tr>
	      <?php
	      $i=0;
	      foreach ($staff_list as $row) {
	      	$i++;

			$branch = get_branch_detail($row->staff_cabang);
			$dept = get_dept_detail($row->staff_departement);
			$title = get_title_detail($row->staff_jabatan);
          ?>
    		<tr>
	            <td class="data ta_right"><?php echo $i; ?></td>
	            <td class="data"><?php echo $branch? $branch->branch_name:'-'; ?></td>
	            <td class="data"><?php echo $dept? $dept->dept_name:'-'; ?></td>
	            <td class="data"><?php echo $row->staff_name; ?></td>
	            <td class="data"><?php echo $title? $title->title_name:'-'; ?></td>
	            <td class="data ta_right"><?php echo $row->saldo_cuti; ?></td>
	          </tr>
	      <?php
		  }
		  ?>
	    </table>
	    </div>
	</body>
</html>