<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>
		  Report Serah Terima Aset
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
  		<h3>Report Serah Terima Aset (<?php echo $asset_data->asset_name; ?>)</h3>
	  	<span style="font-size:9px;"><?php echo date("y/m/d"); ?></span>
		<div>
			<table class="report" style="width:100%">
                <tr>
                    <td rowspan="2" class="blackshade">No</td>
                    <td rowspan="2" width="15%" class="blackshade">Date</td>
                    <td colspan="2" class="blackshade">Staff</td>
                    <td rowspan="2" class="blackshade">Document Number</td>
                    <td rowspan="2" class="blackshade">Status</td>
                    <td rowspan="2" width="30%" class="blackshade">Note</td>
                </tr>
                <tr>
                    <td class="blackshade">Yang Menyerahkan</td>
                    <td class="blackshade">Yang Menerima</td>
                </tr>
	            <?php
		      	$i=0;
	            foreach ($assets_handover as $row) {
			      	$i++;
	            ?>
	        		<tr>
			            <td class="data ta_right"><?php echo $i; ?></td>
	                    <td class="data"><?php echo date_format(new DateTime($row->trasset_date_time),'j M Y'); ?></td>
	                    <td class="data"><?php $row_staff_from = $staff->where('staff_id', $row->trasset_staff_id_from)->get();echo $row_staff_from->staff_name; ?></td>
	                    <td class="data"><?php $row_staff_to = $staff->where('staff_id', $row->trasset_staff_id_to)->get();
	echo $row_staff_to->staff_name; ?></td>
	                    <td class="data"><?php echo $row->trasset_doc_no; ?></td>
	                    <td class="data"><?php echo $row->trasset_status; ?></td>
	                    <td class="data"><?php echo $row->trasset_note; ?></td>
	            	</tr>
	            <?php
				}
				?>
			</table>
		</div>
	</body>
</html>