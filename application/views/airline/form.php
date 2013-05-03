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
				Airline <small>Add airline</small>
			</h1>
		</div>
		<br class="cl" />
		<?php echo form_open($form_action); ?>
		<table width="100%">
			<tr>
				<td width="20%">Name</td>
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
				<td>Phone</td>
				<td><div class="span2">
						<?php echo form_input($phone); ?>
					</div></td>
			</tr>
			<tr>
				<td>Fax</td>
				<td><div class="span2">
						<?php echo form_input($fax); ?>
					</div></td>
			</tr>
			<tr>
				<td>Email</td>
				<td>
					<div class="span2">
						<?php echo form_input($email); ?>
					</div>
				</td>
			</tr>
		</table>
		<div class="one_half">
			<h5>Contact Person 1</h5>
			<table width="100%">
				<tr>
					<td width="20%">Name</td>
					<td><div class="span3">
							<?php echo form_input($cp_name1); ?>
						</div></td>
				</tr>
				<tr>
					<td>Title</td>
					<td><div class="span2">
							<?php echo form_input($cp_title1); ?>
						</div></td>
				</tr>
				<tr>
					<td>Phone</td>
					<td><div class="span2">
							<?php echo form_input($cp_phone1); ?>
						</div></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><div class="span2">
							<?php echo form_input($cp_email1); ?>
						</div></td>
				</tr>
			</table>
		</div>
		<div class="one_half lastcolumn">
			<h5>Contact Person 2</h5>
			<table width="100%">
				<tr>
					<td width="20%">Name</td>
					<td><div class="span3">
							<?php echo form_input($cp_name2); ?>
						</div></td>
				</tr>
				<tr>
					<td>Title</td>
					<td><div class="span2">
							<?php echo form_input($cp_title2); ?>
						</div></td>
				</tr>
				<tr>
					<td>Phone</td>
					<td><div class="span2">
							<?php echo form_input($cp_phone2); ?>
						</div></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><div class="span2">
							<?php echo form_input($cp_email2); ?>
						</div></td>
				</tr>
			</table>
		</div>
		<?php echo $submit; ?> <?php echo $back; ?>
		<?php echo form_close(); ?>
	</div>
</div>
<?php get_footer(); ?>
