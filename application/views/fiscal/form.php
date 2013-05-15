<?php get_header(); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#fiskal_status").iphoneStyle({
          checkedLabel: "Open",
          uncheckedLabel: "Close",
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
        <h2 class="rama-title">Form Tahun Fiskal</h2>
        <?php echo validation_errors(); ?>
        <?php echo $this->session->flashdata('message'); ?>
        <?php echo form_open($form_action) . form_hidden('id', $id); ?>
        <input type="hidden" id="act" name="act" value="<?php echo $act; ?>" />
        <table width="100%">
          	<tr>
                <td width="20%">Fiskal Date</td>
                <td><div class="span3"><?php echo $period_month; ?>&nbsp;<?php echo $period_year; ?></div></td>
            </tr>
			<tr>
				<td>Status</td>
				<td><?php echo $fiskal_status; ?></td>
			</tr>
        </table>
        <input type="submit" name="save" value="Save" class="btn btn-primary" />
        <a href="<?php echo site_url('fiscal/index'); ?>" class="btn btn-danger">Back</a>
        <?php echo form_close() ?>
    </div>
</div>
<?php get_footer(); ?>