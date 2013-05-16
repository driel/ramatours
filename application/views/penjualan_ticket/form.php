<?php get_header(); ?>
<?php echo load_js(array(
  "penjualan_ticket.php?url=".site_url()
));?>
<script>
$(document).ready(function(){
	$(".generate_invoice").on("click", function(e){
		  e.preventDefault();
		  var url = "<?php echo site_url("branches/update_invoice_number")."/".$this->session->userdata("branch"); ?>";
		  if($("#invoice_no").val().length == 0){
			  $.ajax({
				  url: url,
				  type: "GET",
				  success: function(data){
					  $("#invoice_no").val(data);
				  }
			  });
		  }
	});
	$(".generate_rti").on("click", function(e){
		  e.preventDefault();
		  var url = "<?php echo site_url("settings/update_tour_id"); ?>";
		  if($("#tour_id").val().length == 0){
  		  $.ajax({
  			  url: url,
  			  type: "GET",
  			  success: function(data){
  				  $("#tour_id").val(data);
  			  }
  		  });
		  }
	});
	<?php
	if($id){
	  $items = get_items($id);
    //print_r($items->result());
    $data = "var data = [";
    foreach($items->result() as $item){
      $price_currency = "Rp";
      $prefix = "rp";
      if($item->tix_price_us > 0){
        $price_currency = "USD";
        $prefix = "us";
      }
    
      $discount_currency = "Rp";
      $discount_prefix = "rp";
      if($item->tix_discount_us > 0){
        $discount_currency = "USD";
        $discount_prefix = "us";
      }
    
      $komisi_currency = "Rp";
      $komisi_prefix = "rp";
      if($item->tix_komisi_us > 0){
        $komisi_currency = "USD";
        $komisi_prefix = "us";
      }
    
      $data .= '["'.$item->name.'", "'.$item->tix_route.'","'.$item->tix_description.'", "'.$price_currency.'", "'.$item->{"tix_price_".$prefix}.'", "'.$discount_currency.'", "'.$item->{"tix_discount_".$discount_prefix}.'", "'.$komisi_currency.'", "'.$item->{"tix_discount_".$komisi_prefix}.'", "'.$item->tix_air.'", "'.$item->tixd_id.'"],';
    }
    $data = substr($data, 0, strlen($data)-1);
    $data .= "];\n";
	}else{
	  $data = "var data = [];\n";
	}
  echo $data;
	?>
	$("#invoice_detail").handsontable("loadData", data);
});
</script>
<div class="body">
	<div class="content">
		<?php if(validation_errors()) echo error_box(validation_errors()); ?>
		<div class="page-header">
			<div class="icon">
				<span class="ico-tag"></span>
			</div>
			<h1>
				Ticketing Sales Transactions <small>Add Ticketing Sales Transactions</small>
			</h1>
		</div>
		<br class="cl" />
		<?php echo form_open($form_action); ?>
		<?php echo $tix_id; ?>
		<?php echo $branch.$staff_id; ?>
		<table width="100%">
			<tr>
				<td width="20%">Tour ID</td>
				<td><div class="input-append span2">
						<?php echo $tour_id; ?> <a href="#" class="btn generate_rti">Generate Tour ID</a>
					</div></td>
			</tr>
			<tr>
				<td width="20%">Invoice number</td>
				<td><div class="input-append span2">
						<?php echo $invoice_no; ?> <a href="#" class="btn generate_invoice">Generate Invoice</a>
					</div></td>
			</tr>
			<tr>
				<td>Transaction date</td>
				<td><div class="span2">
						<?php echo $date; ?>
					</div></td>
			</tr>
			<tr>
				<td>Ticket Agent</td>
				<td><div class="span3">
						<?php echo $agent; ?>
					</div><?php echo $agent_id; ?>
				</td>
			</tr>
			<tr>
				<td>Name</td>
				<td><div class="span3">
						<?php echo $name; ?>
					</div></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><div class="span5">
						<?php echo $address; ?>
					</div></td>
			</tr>
			<tr>
				<td>Due date</td>
				<td><div class="span2">
						<?php echo $due_date; ?>
					</div></td>
			</tr>
			<tr>
				<td>Biaya Surcharge (Rp)</td>
				<td>
					<div class="input-prepend span2">
						<span class="btn">Rp</span>
						<?php echo $biaya_surcharge_rp; ?>
					</div>
				</td>
			</tr>
			<tr>
				<td>Kurs pajak</td>
				<td><div class="input-prepend span2">
						<span class="btn bootstrap-tooltip" data-placement="top" data-title="Kurs USD">Rp</span> <?php echo $kurs_pajak; ?>
					</div></td>
			</tr>
			<tr>
				<td>GL Account Debit</td>
				<td><div class="span2">
						<?php echo $glacc_dr; ?>
					</div></td>
			</tr>
			<tr>
				<td>GL Account Credit</td>
				<td><div class="span2">
						<?php echo $glacc_cr; ?>
					</div></td>
			</tr>
		</table>
		<h5>Detail</h5>
		<div id="invoice_detail"></div>
		<div id="invoice_items"></div>
		<h5>Total : </h5>
		<table width="200">
			<tr>
				<td width="90">Total</td>
				<td width="40">Rp</td>
				<td class="ta_right"><span id="total_rp"></span></td>
			</tr>
			<tr style="border-bottom: 1px solid #E0E0E0;">
				<td>Total</td>
				<td>USD</td>
				<td class="ta_right"><span id="total_us"></span></td>
			</tr>
			<tr>
				<td>Discount</td>
				<td>Rp</td>
				<td class="ta_right"><span id="discount_rp"></span></td>
			</tr>
			<tr style="border-bottom: 1px solid #E0E0E0;">
				<td>Discount</td>
				<td>USD</td>
				<td class="ta_right"><span id="discount_us"></span></td>
			</tr>
			<tr>
				<td>Komisi</td>
				<td>Rp</td>
				<td class="ta_right"><span id="komisi_rp"></span></td>
			</tr>
			<tr>
				<td>Komisi</td>
				<td>USD</td>
				<td class="ta_right"><span id="komisi_us"></span></td>
			</tr>
		</table>
		<br />
		<?php echo $submit; ?>
		<?php echo $back; ?>
		<?php echo form_close(); ?>
	</div>
</div>
<?php get_footer(); ?>
