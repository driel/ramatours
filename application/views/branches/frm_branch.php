<?php get_header(); ?>
<div class="body">
    <div class="content">
      <div class="page-header">
      <div class="icon">
        <span class="ico-site-map"></span>
      </div>
      <h1>Add Branch
      <small>Add new branch</small>
      </h1>
    </div>
    <br class="cl" />
      <?php echo $this->session->flashdata('message'); ?>
      <?php echo form_open($form_action) . form_hidden('id', $id); ?>
      <div class="one_half">
      	<table width="100%">
      	  <tr>
      	    <td width="30%">Branch</td>
      	    <td>
      	      <div class="span3"><?php echo form_input($branch_name); ?></div>
      	    </td>
      	  </tr>
      	  <tr>
      	    <td>Nomor invoice ticketing</td>
      	    <td>
      	      <div class="span2"><?php echo form_input($branch_number_invoice_ticketing); ?></div>
      	    </td>
      	  </tr>
      	  <tr>
      	    <td>Nomor invoice</td>
      	    <td>
      	      <div class="span2"><?php echo form_input($branch_number_invoice); ?></div>
      	    </td>
      	  </tr>
      	  <tr>
      	    <td>Nomor invoice optional</td>
      	    <td>
      	      <div class="span2"><?php echo form_input($branch_number_invoice_optional); ?></div>
      	    </td>
      	  </tr>
      	  <tr>
      	    <td>Nomor voucher</td>
      	    <td>
      	      <div class="span2"><?php echo form_input($branch_number_voucher); ?></div>
      	    </td>
      	  </tr>
      	  <tr>
      	    <td>Prefix invoice</td>
      	    <td>
      	      <div class="span2"><?php echo form_input($branch_prefix_invoice); ?></div>
      	    </td>
      	  </tr>
      	</table>
      </div>
      <div class="one_half lastcolumn">
        <table width="100%">
      	  <tr>
      	    <td width="30%">Name in invoice</td>
      	    <td>
      	      <div class="span3"><?php echo form_input($branch_invoice_name); ?></div>
      	    </td>
      	  </tr>
      	  <tr>
      	    <td>Title in invoice</td>
      	    <td>
      	      <div class="span3"><?php echo form_input($branch_invoice_title); ?></div>
      	    </td>
      	  </tr>
      	</table>
      </div>
      <br class="cl" />
      <?php echo form_submit($btn_save); ?> <?php echo $link_back; ?>
      <?php echo form_close() ?>
    </div>
</div>
<?php get_footer(); ?>
