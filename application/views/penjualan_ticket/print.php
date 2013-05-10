<?php 
$setting = new Setting();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Print Invoice</title>
	<style>
	  body{font:12px verdana}
	  #invoice_text{text-align:center; font-size:20px; letter-spacing: 15px; margin-top: 30px}
	  #invoice_head_left{border-radius: 5px; padding: 5px; border:1px solid #000; float: left; width: 48%; margin-right:2%}
	</style>
</head>
<body>
	<?php if($penjualan): ?>
	<?php 
	  $agent = get_agent_detail($penjualan->tix_agent_id);
	  print_r($agent);
	?>
	<div style="font:bold 17px verdana"><?php echo $setting->get_val("company_name"); ?></div>
	<?php echo $setting->get_val("address"); ?><br />
	Telp. <?php echo $setting->get_val("company_name");?> Fax <?php echo $setting->get_val("company_name"); ?>
	<?php endif; ?>
	<div id="invoice_text">INVOICE</div>
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
</body>
</html>