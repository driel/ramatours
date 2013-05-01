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
		<h2 style="text-align:center">Daftar Asset (<?php echo $this->input->get("branch") != FALSE ? $this->input->get("branch"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
		    <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Name</th>
                    <th rowspan="2">Code</th>
                    <th rowspan="2">Branch</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2">Tgl. Beli</th>
                    <th rowspan="2">Tgl. Tempo</th>
                    <th colspan="2">Terakhir digunakan</th>
                </tr>
                <tr>
                    <th>Staff</th>
                    <th>Date</th>
                </tr>
            </thead>
		    <tbody>
		    	<?php
		      	$odd = true;
		      	$i=0;
	          	foreach ($asset_list as $row) {
	              	$row_staff = $staff->where('staff_id', $row->staff_id)->get();
			      	$i++;
		        	$odd = !$odd;
            ?>
        		  <tr <?php echo $odd ? "bgcolor='#e0e0e0'":"";?>>
		              <td align="right"><?php echo $i; ?></td>
	                  <td><?php echo $row->asset_name; ?></td>
	                  <td><?php echo $row->asset_code; ?></td>
	                  <td><?php echo $row->branch; ?></td>
	                  <td><?php echo $row->asset_status == '1'? 'Enable':'Disable'; ?></td>
	                  <td><?php echo $row->date_buy; ?></td>
	                  <td><?php echo $row->date_tempo; ?></td>
	                  <td><?php echo $row_staff->staff_name; ?></td>
	                  <td><?php echo date_format(new DateTime($row->date),'j M Y'); ?></td>
                  </tr>
         	   	<?php
				}
				?>
      		</tbody>
		</table>
	</body>
</html>