<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>
	  <?php echo $title; ?>
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
  <h3><?php echo $title; ?></h3>
  <span style="font-size:9px;"><?php echo date("y/m/d"); ?></span>
	<div>
		<table class="report" style="width:100%">
			<tr>
			  <td class="blackshade">No</td>
				<td class="blackshade" >Branch</td>
				<td class="blackshade">Staff</td>
				<td class="blackshade">Tour ID</td>
				<td class="blackshade">Invoice number</td>
				<td class="blackshade">Date</td>
				<td class="blackshade">Agent</td>
				<td class="blackshade">Name</td>
				<td class="blackshade">Due date</td>
				<td class="blackshade">Airline</td>
				<td class="blackshade">Description</td>
				<td class="blackshade">Surcharge Fee</td>
				<td class="blackshade">Total</td>
				<td class="blackshade">Discount</td>
				<td class="blackshade">Komisi</td>
			</tr>
			<?php $i = 1; foreach($results->result() as $row): ?>
			<?php $airline = get_airline($row->tix_air); ?>
			<tr>
			  <td class="data"><?php echo $i; ?></td>
				<td class="data"><?php echo $row->branch_name; ?></td>
				<td class="data"><?php echo $row->staff_name; ?></td>
				<td class="data ta_right"><?php echo $row->tix_tour_id; ?></td>
				<td class="data ta_right"><?php echo $row->tix_invoice_no; ?></td>
				<td class="data"><?php echo $row->tix_date_time; ?></td>
				<td class="data"><?php echo $row->tix_name; ?></td>
				<td class="data"><?php echo $row->tixa_name; ?></td>
				<td class="data"><?php echo $row->tix_due_date; ?></td>
				<td class="data"><?php echo $airline ? $airline->name:"-"; ?></td>
				<td class="data"><?php echo $row->tix_route."<br />".$row->tix_description; ?></td>
				<td class="data ta_right"><?php echo $row->tix_biaya_surcharge_rp; ?></td>
				<td class="data">
				  <table class="report" width="100%">
				  	<tr>
				  		<td class="blackshade">Rp</td>
				  		<td class="blackshade">USD</td>
				  	</tr>
				  	<tr>
				  		<td class="data ta_right"><?php echo sum_total("tix_price_rp", $row->tix_id)?></td>
				  		<td class="data ta_right"><?php echo sum_total("tix_price_us", $row->tix_id)?></td>
				  	</tr>
				  </table>
				</td>
				<td class="data">
				  <table class="report" width="100%">
				  	<tr>
				  		<td class="blackshade">Rp</td>
				  		<td class="blackshade">USD</td>
				  	</tr>
				  	<tr>
				  		<td class="data ta_right"><?php echo sum_total("tix_discount_rp", $row->tix_id)?></td>
				  		<td class="data ta_right"><?php echo sum_total("tix_discount_us", $row->tix_id)?></td>
				  	</tr>
				  </table>
				</td>
				<td class="data">
				  <table class="report" width="100%">
				  	<tr>
				  		<td class="blackshade">Rp</td>
				  		<td class="blackshade">USD</td>
				  	</tr>
				  	<tr>
				  		<td class="data ta_right"><?php echo sum_total("tix_komisi_rp", $row->tix_id)?></td>
				  		<td class="data ta_right"><?php echo sum_total("tix_komisi_us", $row->tix_id)?></td>
				  	</tr>
				  </table>
				</td>
			</tr>
			<?php $i++; endforeach; ?>
			<tr>
				<td colspan="15" class="pagesummary">Summary</td>
			</tr>
		</table>
	</div>
</body>
</html>