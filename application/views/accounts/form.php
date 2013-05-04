<?php get_header(); ?>
<?php echo load_js(array(
  "plugins/ckeditor/ckeditor.js"
));?>
<script type="text/javascript">
    $(document).ready(function(){
    	if ($("#glacc_parent").val() == '0') {
    		$("#parent").hide();
    	} else {
    		$("#parent").show();
    	}

        $("#glacc_parent_stat").iphoneStyle({
			checkedLabel: "Yes",
			uncheckedLabel: "No",
			onChange: function(e, checked){
				if(checked){
					$(e).attr("checked", "checked");
					$("#parent").hide();
				}else{
					$(e).removeAttr("checked");
					$("#parent").show();
				}
			}
		});
	/*$("#glacc_parent_stat").change(function() {
      		if ($(this).is(":checked")) {
      			$("#glacc_parent").attr("disabled","true");
      		} else {
      			$("#glacc_parent").attr("disabled","false");
      		}
      	});*/
    });
</script>
<div class="body">
    <div class="content">
        <h2 class="rama-title">Form Chart of Account</h2>
        <?php echo validation_errors(); ?>
        <?php echo $this->session->flashdata('message'); ?>
        <?php echo form_open($form_action) . form_hidden('id', $glacc_id); ?>
        <input type="hidden" id="glacc_id" name="glacc_id" value="<?php echo $glacc_id; ?>" />
        <table width="100%">
          	<tr>
                <td width="20%">Account No</td>
                <td><div class="span3"><?php echo form_input($glacc_no); ?></div></td>
            </tr>
            <tr>
                <td>Parent Status</td>
                <td><?php echo $glacc_parent_stat; ?></td>
            </tr>
            <tr id="parent">
                <td width="20%">Parent</td>
                <td><div class="span2"><?php echo $glacc_parent; ?></div></td>
            </tr>
          	<tr>
                <td width="20%">Account Name</td>
                <td><div class="span3"><?php echo form_input($glacc_name); ?></div></td>
            </tr>
        </table>
        <input type="submit" name="save" value="Save" class="btn btn-primary" />
        <a href="<?php echo site_url('accounts/index'); ?>" class="btn btn-danger">Back</a>
        <?php echo form_close() ?>
    </div>
</div>
<?php get_footer(); ?>
