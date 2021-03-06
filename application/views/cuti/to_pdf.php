<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>
		  Report Cuti
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
	          	<td rowspan="2" class="blackshade">No</td>
	          	<td rowspan="2" class="blackshade">Name</td>
	          	<td rowspan="2" class="blackshade">Branch</td>
	          	<td rowspan="2" class="blackshade">Departement</td>
	          	<td rowspan="2" class="blackshade">Title</td>
                <td rowspan="2" width="10%" class="blackshade">Requested date</td>
                <td colspan="2" class="blackshade">Date</td>
                <td colspan="3" class="blackshade">Approval</td>
            </tr>
            <tr>
                <td width="10%" class="blackshade">From</td>
                <td width="10%" class="blackshade">To</td>
                <td width="10%" class="blackshade">Status</td>
                <td width="10%" class="blackshade">Reason</td>
                <td width="10%" class="blackshade">By</td>
            </tr>
        </thead>
        <tbody>
            <?php
	      	$i=0;
            foreach ($cuti->result() as $row) {
	            $staff = get_staff_detail($row->staff_id);
	            $approve_by = get_user_detail($row->approveby_staff_id);
	            $detail = getDetail($row->id);
	            $comment = "No Comment";
	            if(count($detail)){
	              $comment = $detail->comment;  
	            }
		      	$i++;

				$branch = get_branch_detail($row->staff_cabang);
				$dept = get_dept_detail($row->staff_departement);
				$title = get_title_detail($row->staff_jabatan);
            ?>
        		<tr>
		            <td class="data ta_right"><?php echo $i; ?></td>
		            <td class="data ta_right"><?php echo $row->staff_name; ?></td>
	            	<td class="data"><?php echo $branch? $branch->branch_name:'-'; ?></td>
	            	<td class="data"><?php echo $dept? $dept->dept_name:'-'; ?></td>
	            	<td class="data"><?php echo $title? $title->title_name:'-'; ?></td>
                    <td class="data ta_center"><?php echo date_format(new DateTime($row->date_request),'j M Y'); ?></td>
                    <td class="data ta_center"><?php echo date_format(new DateTime($row->date_start),'j M Y'); ?></td>
                    <td class="data ta_center"><?php echo date_format(new DateTime($row->date_end),'j M Y'); ?></td>
                    <td class="data ta_center"><?php echo $row->status; ?></td>
                    <td class="data"><?php echo $comment; ?></td>
                    <td class="data"><?php echo $approve_by ? $approve_by->username:"-"; ?></td>
                </tr>
            <?php
			}
			?>
	      </tbody>
	    </table>
	</body>
</html>