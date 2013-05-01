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
    	<span class="site_name">Rama Tours</span>
		<span class="date"><?php echo date("d/m/Y - H:i"); ?></span>
		<span class="cl"></span><br />
		<h2 style="text-align:center">Daftar Cuti Karyawan (<?php echo $this->input->get("staff_cabang") != FALSE ? $this->input->get("staff_cabang"):"Seluruh cabang"?>)</h2>
		<table width="100%" align="center">
	      <thead>
            <tr>
	          	<th rowspan="2">Name</th>
	          	<th rowspan="2">Branch</th>
	          	<th rowspan="2">Departement</th>
	          	<th rowspan="2">Title</th>
                <th rowspan="2" width="10%">Requested date</th>
                <th colspan="2">Date</th>
                <th colspan="3">Approval</th>
            </tr>
            <tr>
                <th width="10%">From</th>
                <th width="10%">To</th>
                <th width="10%">Status</th>
                <th width="10%">Reason</th>
                <th width="10%">By</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cuti->result() as $row) {
	            $staff = get_staff_detail($row->staff_id);
	            $approve_by = get_user_detail($row->approveby_staff_id);
	            $detail = getDetail($row->id);
	            $comment = "No Comment";
	            if(count($detail)){
	              $comment = $detail->comment;  
	            }
            ?>
                <tr>
		            <td><?php echo $row->staff_name; ?></td>
		            <td><?php echo $row->staff_cabang; ?></td>
		            <td><?php echo $row->staff_departement; ?></td>
		            <td><?php echo $row->staff_jabatan; ?></td>
                    <td><?php echo date_format(new DateTime($row->date_request),'j M Y'); ?></td>
                    <td><?php echo date_format(new DateTime($row->date_start),'j M Y'); ?></td>
                    <td><?php echo date_format(new DateTime($row->date_end),'j M Y'); ?></td>
                    <td><?php echo $row->status; ?></td>
                    <td><?php echo $comment; ?></td>
                    <td><?php echo $approve_by ? $approve_by->username:"-"; ?></td>
                </tr>
            <?php
			}
			?>
	      </tbody>
	    </table>
	</body>
</html>