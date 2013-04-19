<?php get_header(); ?>
<div class="body">
  <div class="content">
    <div class="page-header">
      <div class="icon">
        <span class="ico-money-bag"></span>
      </div>
      <h1>Add Salary component
      <small>Add new salary component</small>
      </h1>
    </div>
    <br class="cl" />
    <?php echo form_open($form_action) . form_hidden('id', $id); ?>
    <table width="100%">
      <tr>
        <td width="20%">Component Name</td>
        <td><div class="span3"><?php echo form_input($comp_name); ?></div></td>
      </tr>
      <tr>
        <td width="20%">Component Type</td>
        <td><?php echo $comp_type; ?></td>
      </tr>
    </table>
    <?php echo form_submit($btn_save); ?> <?php echo $link_back; ?>
    <?php echo form_close() ?>
  </div>
</div>
<?php get_footer(); ?>
