<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>
		  Report Asset
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
  	  <h3>Report Asset</h3>
  	  <span style="font-size:9px;"><?php echo date("y/m/d"); ?></span>
	  <div>
		<table class="report" style="width:100%">
            <tr>
                <td rowspan="2" class="blackshade">No</td>
                <td rowspan="2" class="blackshade">Name</td>
                <td rowspan="2" class="blackshade">Code</td>
                <td rowspan="2" class="blackshade">Branch</td>
                <td rowspan="2" class="blackshade">Status</td>
                <td rowspan="2" class="blackshade">Tgl. Beli</td>
                <td rowspan="2" class="blackshade">Tgl. Tempo</td>
                <td colspan="2" class="blackshade">Terakhir digunakan</td>
            </tr>
            <tr>
                <td class="blackshade">Staff</td>
                <td class="blackshade">Date</td>
            </tr>
	    	<?php
	      	$i=0;
          	foreach ($asset_list as $row) {
              	$row_staff = $staff->where('staff_id', $row->staff_id)->get();
		      	$i++;
        	?>
    		  <tr>
	              <td class="data ta_right"><?php echo $i; ?></td>
                  <td class="data"><?php echo $row->asset_name; ?></td>
                  <td class="data"><?php echo $row->asset_code; ?></td>
                  <td class="data"><?php echo $row->branch; ?></td>
                  <td class="data"><?php echo $row->asset_status == '1'? 'Enable':'Disable'; ?></td>
                  <td class="data"><?php echo $row->date_buy; ?></td>
                  <td class="data"><?php echo $row->date_tempo; ?></td>
                  <td class="data"><?php echo $row_staff->staff_name; ?></td>
                  <td class="data ta_center"><?php echo date_format(new DateTime($row->date),'j M Y'); ?></td>
              </tr>
     	   	<?php
			}
			?>
		</table>
		</div>
	</body>
</html>