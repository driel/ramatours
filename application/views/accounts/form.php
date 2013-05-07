<?php get_header(); ?>
<?php echo load_js(array(
    "plugins/ckeditor/ckeditor.js"
));?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#glacc_parent_stat").iphoneStyle({
          checkedLabel: "Yes",
          uncheckedLabel: "No",
          onChange: function(e, checked){
            if(checked){
              $(e).attr("checked", "checked");
            }else{
            	$(e).removeAttr("checked");
            }
          }
        });
    });
</script>
<div class="body">
	<div class="content">
		<?php echo validation_errors(); ?>
		<?php echo $this->session->flashdata('message'); ?>
		<div class="page-header">
			<div class="icon">
				<span class="ico-tag"></span>
			</div>
			<h1>
				Chart of Account <small>Add Chart of Account</small>
			</h1>
		</div>
		<br class="cl" />
		
		<?php echo form_open($form_action) . form_hidden('id', $glacc_id); ?>
		<input type="hidden" id="glacc_id" name="glacc_id" value="<?php echo $glacc_id; ?>" />
		<table width="100%">
			<tr>
				<td width="20%">Account No</td>
				<td><div class="span3">
						<?php echo form_input($glacc_no); ?>
					</div></td>
			</tr>
			<tr>
				<td>Parent Status</td>
				<td><?php echo $glacc_parent_stat; ?></td>
			</tr>
			<tr>
				<td width="20%">Parent</td>
				<td><div class="span2">
						<?php echo $glacc_parent; ?>
					</div></td>
			</tr>
			<tr>
				<td width="20%">Account Name</td>
				<td><div class="span3">
						<?php echo form_input($glacc_name); ?>
					</div></td>
			</tr>
		</table>
		<input type="submit" name="save" value="Save" class="btn btn-primary" />
		<a href="<?php echo site_url('accounts/index'); ?>"
			class="btn btn-danger">Back</a>
		<?php echo form_close() ?>
	</div>
</div>
<?php get_footer(); ?>
