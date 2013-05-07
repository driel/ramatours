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
		<?php echo $branch.$staff_id; ?>
		<table width="100%">
			<tr>
				<td width="20%">Tour ID</td>
				<td><div class="span2"><?php echo form_input($tour_id); ?></div></td>
			</tr>
			<tr>
				<td>Transaction date</td>
				<td><div class="span2"><?php echo form_input($date); ?></div></td>
			</tr>
			<tr>
				<td>Agent</td>
				<td><?php echo $agent_id; ?></td>
			</tr>
			<tr>
				<td>Ticket Agent</td>
				<td><?php echo $name; ?></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><div class="span5"><?php echo $address; ?></div></td>
			</tr>
			<tr>
				<td>Due date</td>
				<td><div class="span2"><?php echo $due_date; ?></div></td>
			</tr>
			<tr>
				<td>Biaya Surcharge (Rp) </td>
				<td>
				  <div class="input-prepend span2">
				    <span class="btn">Rp</span><?php echo $biaya_surcharge_rp; ?>
				  </div>
				</td>
			</tr>
			<tr>
				<td>Kurs pajak</td>
				<td><div class="span2"><?php echo $kurs_pajak; ?></div></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
		</table>
		<?php echo $submit; ?> <?php echo $back; ?>
		<?php echo form_close(); ?>
	</div>
</div>
<?php get_footer(); ?>
