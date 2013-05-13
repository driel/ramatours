<?php 
$setting = new Setting();
$branch = get_branch_detail($penjualan->tix_branch_id);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Print Invoice</title>
	<style>
	  body{font:12px verdana}
	  hr{border: 1px solid #000; margin-top: 30px;}
	  hr.thin{border: 0; border-bottom: 1px solid #000; margin: 0}
	  .cl{clear: both;}
	  .ta_center{text-align: center;}
	  .ta_right{text-align: right;}
	  #invoice_text{text-align:center; font-size:20px; letter-spacing: 15px; margin-top: 30px}
	  #invoice_head_left{border-radius: 5px; padding: 5px; border:1px solid #000; float: left; width: 48%; margin-right:1%}
	  #invoice_head_right{padding: 5px; float: left; width: 30%;}
	  #invoice_items{/*border: 1px solid #000;*/}
	  #invoice_items tr th{border-width: 1px; border-style: solid; border-color: #000; border-right: 0;}
	  #invoice_items tr th:last-child{border-right: 1px solid #000;}
	  #invoice_items tr th.merge{border-bottom: 0}
	  #invoice_items tr td{padding: 5px;}
	  #invoice_note{border-radius: 5px; padding: 5px; border:1px solid #000; float: left; min-width: 400px; margin-top: 50px;}
	</style>
</head>
<body>
	<?php if($penjualan): ?>
	<?php 
	  $agent = get_agent_detail($penjualan->tix_agent_id);
	?>
	<div style="font:bold 17px verdana"><?php echo $setting->get_val("company_name"); ?></div>
	<?php echo $setting->get_val("address"); ?><br />
	Telp. <?php echo $setting->get_val("phone");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax <?php echo $setting->get_val("fax"); ?>
	<?php endif; ?>
	<div id="invoice_text">INVOICE</div><br />
	<div id="invoice_head_left">
	  <table>
	  	<tr>
	  		<td>Bill To</td>
	  		<td>:</td>
	  		<td>
	  		  <?php echo $agent ? $agent->tixa_name:''; ?>
	  		</td>
	  	</tr>
	  	<tr>
	  		<td>Address</td>
	  		<td>:</td>
	  		<td>
	  		  <?php echo $agent ? $agent->tixa_address:''; ?>
	  		</td>
	  	</tr>
	  	<tr>
	  		<td>Attn</td>
	  		<td>:</td>
	  		<td></td>
	  	</tr>
	  </table>
	</div>
	<div id="invoice_head_right">
	  <table>
	  	<tr>
	  		<td>Invoice No</td>
	  		<td>:</td>
	  		<td>
	  		  <?php echo invoice_number_format($penjualan->tix_invoice_no, $branch->branch_prefix_invoice, $penjualan->tix_date_time); ?>
	  		</td>
	  	</tr>
	  	<tr>
	  		<td>Date</td>
	  		<td>:</td>
	  		<td>
	  		  <?php echo $penjualan->tix_date_time; ?>
	  		</td>
	  	</tr>
	  	<tr>
	  		<td>Terms</td>
	  		<td>:</td>
	  		<td>
	  		  <?php echo $agent->tixa_terms; ?> Days
	  		</td>
	  	</tr>
	  </table>
	</div>
	<br class="cl" /><br />
	<table cellspacing="0" cellpadding="1" width="100%" id="invoice_items">
		<tr>
			<th width="30" rowspan="2">No</th>
			<th width="150" rowspan="2">Airline</th>
			<th width="150" rowspan="2">Route</th>
			<th rowspan="2" width="300">Description</th>
			<th colspan="2" class="merge">Price</th>
			<th colspan="2" class="merge">Discount</th>
			<th colspan="2" class="merge">Komisi</th>
		</tr>
		<tr>
		  <th width="100">RP</th>
		  <th width="80">US$</th>
		  <th width="100">RP</th>
		  <th width="80">US$</th>
		  <th width="100">RP</th>
		  <th width="80">US$</th>
		</tr>
		<?php 
		  $items = get_items($penjualan->tix_id);
		  $no = 1;
		  $total_rp = 0;
		  $total_us = 0;
		  $total_discount_rp = 0;
		  $total_discount_us = 0;
		  $total_komisi_rp = 0;
		  $total_komisi_us = 0;
		  foreach($items->result() as $row):
		  $airline = get_airline($row->tix_air);
		?>
		<tr>
			<td class="ta_center"><?php echo $no; ?></td>
			<td><?php echo $airline->name; ?></td>
			<td><?php echo $row->tix_route; ?></td>
			<td><?php echo $row->tix_description; ?></td>
			<td class="ta_right"><?php echo number_format($row->tix_price_rp, 2, ".", ","); ?></td>
			<td class="ta_right"><?php echo number_format($row->tix_price_us, 2, ".", ","); ?></td>
			<td class="ta_right"><?php echo number_format($row->tix_discount_rp, 2, ".", ","); ?></td>
			<td class="ta_right"><?php echo number_format($row->tix_discount_us, 2, ".", ","); ?></td>
			<td class="ta_right"><?php echo number_format($row->tix_komisi_rp, 2, ".", ","); ?></td>
			<td class="ta_right"><?php echo number_format($row->tix_komisi_us, 2, ".", ","); ?></td>
		</tr>
		<?php
		$total_rp += $row->tix_price_rp; 
		$total_us += $row->tix_price_us;
		$total_discount_rp += $row->tix_discount_rp;
		$total_discount_us += $row->tix_discount_us;
		$total_komisi_rp += $row->tix_komisi_rp;
		$total_komisi_us += $row->tix_komisi_us;
		$no++; 
		endforeach; 
		
		// subtotal
		$subtotal_rp = $total_rp - $total_discount_rp;
		$subtotal_us = $total_us - $total_discount_us;
		
		// ppn
		$ppn_rp = $subtotal_rp /100 * 10;
		$ppn_us = $subtotal_us /100 * 10;
		
		// grandtotal 
		$grand_total_rp = $subtotal_rp + $ppn_rp;
		$grand_total_us = $subtotal_us + $ppn_us;
		?>
	</table>
	<hr />
	<div id="invoice_note">
	  <?php echo $setting->get_val("invoice_note");?>
	</div>
	<div style="float: right; width: 300px;">
		<table width="100%">
			<tr>
				<td width="100" class="ta_right"><b>Subtotal</b></td>
				<td width="5"><b>:</b></td>
				<td>
				  <table width="100%">
				  	<tr>
				  		<td>Rp</td>
				  		<td class="ta_right"><?php echo number_format($total_rp, 2, ".", ","); ?></td>
				  	</tr>
				  	<tr>
				  		<td>US$</td>
				  		<td class="ta_right"><?php echo number_format($total_us, 2, ".", ","); ?></td>
				  	</tr>
				  </table>
				</td>
			</tr>
			<tr>
				<td class="ta_right"><b>Discount</b></td>
				<td><b>:</b></td>
				<td>
				  <table width="100%">
				  	<tr>
				  		<td>Rp</td>
				  		<td class="ta_right"><?php echo number_format($total_discount_rp, 2, ".", ","); ?></td>
				  	</tr>
				  	<tr>
				  		<td>US$</td>
				  		<td class="ta_right"><?php echo number_format($total_discount_us, 2, ".", ","); ?></td>
				  	</tr>
				  </table>
				</td>
			</tr>
			<!-- <tr>
				<td class="ta_right"><b>Komisi</b></td>
				<td><b>:</b></td>
				<td>
				  <table width="100%">
				  	<tr>
				  		<td>Rp</td>
				  		<td class="ta_right"><?php echo number_format($total_komisi_rp, 2, ".", ","); ?></td>
				  	</tr>
				  	<tr>
				  		<td>US$</td>
				  		<td class="ta_right"><?php echo number_format($total_komisi_us, 2, ".", ","); ?></td>
				  	</tr>
				  </table>
				</td>
			</tr> -->
		</table>
		<hr class="thin" />
		<table width="100%">
			<tr>
				<td width="100" class="ta_right"><b>Subtotal</b></td>
				<td width="5"><b>:</b></td>
				<td>
				  <table width="100%">
				  	<tr>
				  		<td>Rp</td>
				  		<td class="ta_right"><?php echo number_format($subtotal_rp, 2, ".", ","); ?></td>
				  	</tr>
				  	<tr>
				  		<td>US$</td>
				  		<td class="ta_right"><?php echo number_format($subtotal_us, 2, ".", ","); ?></td>
				  	</tr>
				  </table>
				</td>
			</tr>
			<tr>
				<td class="ta_right"><b>PPn</b></td>
				<td><b>:</b></td>
				<td>
				  <table width="100%">
				  	<tr>
				  		<td>Rp</td>
				  		<td class="ta_right"><?php echo number_format($ppn_rp, 2, ".", ","); ?></td>
				  	</tr>
				  	<tr>
				  		<td>US$</td>
				  		<td class="ta_right"><?php echo number_format($ppn_us, 2, ".", ","); ?></td>
				  	</tr>
				  </table>
				</td>
			</tr>
		</table>
		<hr class="thin" />
		<table width="100%">
			<tr>
				<td width="100" class="ta_right"><b>Grand Total</b></td>
				<td width="5"><b>:</b></td>
				<td>
				  <table width="100%">
				  	<tr>
				  		<td>Rp</td>
				  		<td class="ta_right"><?php echo number_format($grand_total_rp, 2, ".", ","); ?></td>
				  	</tr>
				  	<tr>
				  		<td>US$</td>
				  		<td class="ta_right"><?php echo number_format($grand_total_us, 2, ".", ","); ?></td>
				  	</tr>
				  </table>
				</td>
			</tr>
		</table>
		<hr class="thin" />
		<br /><br />
		<?php echo "<b>".$branch->branch_name."</b> , ".date("d-M-Y"); ?>
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<div class="ta_center">(Director name)</div>
		<hr class="thin" />
		<div class="ta_center">Director</div>
	</div>
</body>
</html>