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
						<span class="btn">US$. </span><?php echo form_input($limit_us); ?>
					</div></td>
			</tr>
			<tr>
				<td>GL Account No DR</td>
				<td><div class="span2">
						<?php echo $glacc_dr; ?>
					</div></td>
			</tr>
			<tr>
				<td>GL Account No CR</td>
				<td><div class="span2">
						<?php echo $glacc_cr; ?>
					</div></td>
			</tr>
		</table>
		<?php echo $submit.' '.$back; ?>
		<?php echo form_close(); ?>
	</div>
</div>
<?php get_footer(); ?>
