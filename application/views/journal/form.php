<?php get_header(); ?>
<div class="body">
    <div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-tag"></span>
            </div>
            <h1>Entry Journal
                <small>Input Entry Journal</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group_detail(); ?>
        </div>
        <?php echo validation_errors(); ?>
        <?php echo $this->session->flashdata('message'); ?>
        <?php echo form_open($form_action) . form_hidden('id', $kurs_id); ?>
        <input type="hidden" id="act" name="act" value="<?php echo $act; ?>" />
        <input type="hidden" id="kurs_id" name="kurs_id" value="<?php echo $kurs_id; ?>" />
        <table width="100%">
          	<tr>
                <td width="20%">Kurs Date</td>
                <td><div class="span3"><?php echo form_input($kurs_date); ?></div></td>
            </tr>
            <tr>
                <td>Kurs Dollar</td>
                <td><?php echo form_input($kurs_us_rp); ?></td>
            </tr>
            <tr>
                <td>Kurs Yen</td>
                <td><?php echo form_input($kurs_yen_rp); ?></td>
            </tr>
        </table>
        <input type="submit" name="save" value="Save" class="btn btn-primary" />
        <a href="<?php echo site_url('fiscal/index'); ?>" class="btn btn-danger">Back</a>
        <?php echo form_close() ?>
    </div>
</div>
<?php get_footer(); ?>