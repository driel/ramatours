<?php get_header(); ?>
<script>
$(document).ready(function(){
	$("#status").iphoneStyle({
	  checkedLabel: "Enable",
	  uncheckedLabel: "Disable",
	  onChange: function(e, checked){
		  $("#disable_on").toggle();
	  }
	});

	$("#agent").autocomplete({
		//tixa_glacc_cr: "7000000"
		//tixa_glacc_dr: "16000000"
    source: function(request, proses){
  	  console.log(request);
  	  var q = request.term;
  	  var url = '<?php echo site_url('ticket_agent/get_agent'); ?>/'+q;
  	  $.getJSON(url, function(data){
  	  	var items = [];
	  	  $.each(data, function(i, v){
	  		  var item = {label:v.tixa_name, tid:v.tixa_id, glaccno_dr:v.tixa_glacc_dr, glaccno_cr:v.tixa_glacc_cr};
	  		  items.push(item);
	  	  });
	  	  proses(items);
  	  });
    },
    select: function(e, ui){
      console.log(ui);
      $("#agent_id").val(ui.item.tid);
      $("input[name=glacc_dr]").val(ui.item.glaccno_dr);
      $("input[name=glacc_cr]").val(ui.item.glaccno_cr);
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
				Penjualan ticket <small>Add penjualan ticket</small>
			</h1>
		</div>
		<br class="cl" />
		<?php echo form_open($form_action); ?>
		<?php echo $tix_id; ?>
		<?php echo $branch.$staff_id; ?>
		<table width="100%">
			<tr>
				<td width="20%">Tour ID</td>
				<td><div class="span2">
						<?php echo form_input($tour_id); ?>
					</div></td>
			</tr>
			<tr>
				<td>Transaction date</td>
				<td><div class="span2">
						<?php echo form_input($date); ?>
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
				<td><div class="span2">
						<?php echo $kurs_pajak; ?>
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
		<table width="100%">
			<tr>
				<td width="20%">Airline</td>
				<td><div class="span3"><?php echo $airline; ?></div></td>
			</tr>
			<tr>
				<td>Route</td>
				<td><div class="span3"><?php echo $route; ?></div></td>
			</tr>
			<tr>
				<td>Invoice description</td>
				<td><div class="span5"><?php echo $description; ?></div></td>
			</tr>
		</table>
		<div class="one_third">
		  <span>Price</span><br />
		  <div class="input-prepend span2">
		    <span class="btn">Rp</span>
		    <?php echo $price_rp; ?>
		  </div><br class="cl" />
		  <div class="input-prepend span2">
		    <span class="btn">US</span>
		    <?php echo $price_us; ?>
		  </div>
		</div>
		<div class="one_third">
		  <span>Discount</span><br />
		  <div class="input-prepend span2">
		    <span class="btn">Rp</span>
		    <?php echo $discount_rp; ?>
		  </div><br class="cl" />
		  <div class="input-prepend span2">
		    <span class="btn">US</span>
		    <?php echo $discount_us; ?>
		  </div>
		</div>
		<div class="one_third lastcolumn">
		  <span>Komisi</span><br />
		  <div class="input-prepend span2">
		    <span class="btn">Rp</span>
		    <?php echo $komisi_rp; ?>
		  </div><br class="cl" />
		  <div class="input-prepend span2">
		    <span class="btn">US</span>
		    <?php echo $komisi_us; ?>
		  </div>
		</div>
		<?php echo $submit; ?>
		<?php echo $back; ?>
		<?php echo form_close(); ?>
	</div>
</div>
<?php get_footer(); ?>
