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
		<br />
		<?php echo $submit; ?>
		<?php echo $back; ?>
		<?php echo form_close(); ?>
	</div>
</div>
<?php get_footer(); ?>
