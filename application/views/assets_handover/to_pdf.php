<!DOCTYPE html>
<html lang="en">
	<head>
	<style type="text/css">
		table {border-width: 0 0 1px 1px;border-spacing: 0;border-collapse: collapse;border-style: solid;}
		td, th {margin: 0;padding: 4px;border-width: 1px 1px 0 0;border-style: solid;}
		.site_name{float:left; font-size:22px;}
		.date{float:right; font-size:10px;}
		h2{margin-top: 0;}

		table.no_border {
			border-style: none;
		}
 
		td.no_border, th.no_border {
			margin: 0;
			padding: 4px;
			border-style: none;
		}
	</style>
	</head>
    <body>
    	<span class="site_name">Rama Tours</span>
		<span class="date"><?php echo date("d/m/Y - H:i"); ?></span>
		<span class="cl"></span><br />
		<h2 style="text-align:center">Daftar Serah Terima Asset</h2>
		<center>
	    	<table align="center" class="no_border">
	            <tr>
	                <td class="no_border" width="50%">Name</td>
	                <td class="no_border"><?php echo $asset->asset_name; ?></td>
	            </tr>
	            <tr>
	                <td class="no_border" width="50%">Code</td>
	                <td class="no_border"><?php echo $asset->asset_code; ?></td>
	            </tr>
	            <tr>
	                <td class="no_border">Status</td>
	                <td class="no_border"><?php echo $asset->asset_status; ?></td>
	            </tr>
	            <tr>
	            	<td class="no_border">Description</td>
	            	<td class="no_border"><?php echo $asset->description; ?></td>
	            </tr>
	        </table>
    	</center>
		<br />
		<table width="100%" align="center">
            <thead>
                <tr>
                    <th rowspan="2" width="15%">Date</th>
                    <th colspan="2">Staff</th>
                    <th rowspan="2">Document Number</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2" width="30%">Note</th>
                </tr>
                <tr>
                    <th>Yang Menyerahkan</th>
                    <th>Yang Menerima</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($assets_handover as $row) {
            ?>
                <tr>
                    <td><?php echo date_format(new DateTime($row->trasset_date_time),'j M Y'); ?></td>
                    <td><?php $row_staff_from = $staff->where('staff_id', $row->trasset_staff_id_from)->get();echo $row_staff_from->staff_name; ?></td>
                    <td><?php $row_staff_to = $staff->where('staff_id', $row->trasset_staff_id_to)->get();
echo $row_staff_to->staff_name; ?></td>
                    <td><?php echo $row->trasset_doc_no; ?></td>
                    <td><?php echo $row->trasset_status; ?></td>
                    <td><?php echo $row->trasset_note; ?></td>
            	</tr>
            <?php
			}
			?>
            </tbody>
		</table>
	</body>
</html>