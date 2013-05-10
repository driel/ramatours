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
	$("#glacc_dr").autocomplete({
	  source: function(query, proses){
		  var q = query.term;
		  var url = "<?php echo site_url('accounts/get_account_number'); ?>/"+q;
		  $.getJSON(url, function(data){
			  var items = [];
			  $.each(data, function(i, v){
				  var item = {label:v.glacc_no, id:v.glacc_id};
				  items.push(item);
			  });
			  proses(items);
		  });
	  },
	  select: function(e, ui){
		  $("#glacc_dr_hidden").val(ui.item.id);
	  }
	});
	$("#glacc_cr").autocomplete({
		  source: function(query, proses){
			  var q = query.term;
			  var url = "<?php echo site_url('accounts/get_account_number'); ?>/"+q;
			  $.getJSON(url, function(data){
				  var items = [];
				  $.each(data, function(i, v){
					  var item = {label:v.glacc_no, id:v.glacc_id};
					  items.push(item);
				  });
				  proses(items);
			  });
		  },
		  select: function(e, ui){
			  $("#glacc_cr_hidden").val(ui.item.id);
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
				Ticket Agent <small>Add ticket agent</small>
			</h1>
		</div>
		<br class="cl" />
		<?php echo form_open($form_action); ?>
		<?php echo $id; ?>
		<table width="100%">
			<tr>
				<td width="20%">Code</td>
				<td><div class="span2">
						<?php echo form_input($code); ?>
					</div></td>
			</tr>
			<tr>
				<td>Name</td>
				<td><div class="span3">
						<?php echo form_input($name); ?>
					</div></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><div class="span5">
						<?php echo form_textarea($address); ?>
					</div></td>
			</tr>
			<tr>
				<td>City</td>
				<td><div class="span2">
						<?php echo form_input($city); ?>
					</div></td>
			</tr>
			<tr>
				<td>Since</td>
				<td><div class="span2">
						<?php echo form_input($since); ?>
					</div></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><input type="checkbox" id="status" checked />
					<div id="disable_on" style="display: none;">
						<div class="span2">
							<?php echo form_input($disable_date); ?>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Credit limit (Rp)</td>
				<td><div class="input-prepend span2">
						<span class="btn">Rp. </span><?php echo form_input($limit_rp); ?>
					</div></td>
			</tr>
			<tr>
				<td>Credit limit (US$)</td>
				<td><div class="input-prepend span2">
						<span class="btn">US. </span><?php echo form_input($limit_us); ?>
					</div></td>
			</tr>
			<tr>
				<td>GL Account No DR</td>
				<td><div class="span2">
						<?php echo $glacc_dr.$glacc_dr_hidden; ?>
					</div></td>
			</tr>
			<tr>
				<td>GL Account No CR</td>
				<td><div class="span2">
						<?php echo $glacc_cr.$glacc_cr_hidden; ?>
					</div></td>
			</tr>
		</table>
		<?php echo $submit.' '.$back; ?>
		<?php echo form_close(); ?>
	</div>
</div>
<?php get_footer(); ?>
