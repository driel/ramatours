<?php get_header(); ?>
<div class="body">
    <div class="content">
        <h2 class="rama-title"><?php echo $title; ?></h2>
        <?php echo validation_errors(); ?>
        <?php echo $this->session->flashdata('message'); ?>
        <?php echo form_open($form_action); ?>
        <table width="100%">
          	<tr>
                <td width="20%">Period</td>
                <td><div class="span3"><?php echo $period_month; ?>&nbsp;<?php echo $period_year; ?></div></td>
            </tr>
        </table>
        <input type="submit" name="save" value="Posting" class="btn btn-primary" />
        <a href="<?php echo site_url('/'); ?>" class="btn btn-danger">Back</a>
        <?php echo form_close() ?>
    </div>
</div>
<?php get_footer(); ?>