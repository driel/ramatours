<?php get_header(); ?>
<script src="<?php echo base_url(); ?>assets/js/jquery.formatCurrency-1.4.0.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.formatCurrency.all.js" type="text/javascript"></script>
<?php echo load_js(array(
  "journal.php?url=".urlencode(site_url())
)); ?>
<?php
  // load them all
  $detail = get_journal_detail($gltr_id);

  // Journal Detail
  $journal_detail = '';
  if($detail){
    foreach($detail->result() as $trx){
      $account = get_account($trx->gltr_accno);
      $journal_detail .= '["'.$account->glacc_no.' - '.$account->glacc_name.'", "'.$trx->gltr_keterangan.'", "'.$trx->rti.'", "'.number_format($trx->gltr_dr, 2, ".", ",").'", "'.number_format($trx->gltr_cr, 2, ".", ",").'", "'.$trx->id.'", "'.$trx->gltr_accno.'"],';
    }
    $journal_detail = substr($journal_detail, 0, (strlen($journal_detail)-1));
  }
?>

<script type="text/javascript">
  	var journal_detail = [<?php echo $journal_detail; ?>];
	$(document).ready(function() {
		$("#journal_table").handsontable("loadData", journal_detail);
    	calculate_balance($("#journal_table"));
	});
</script>

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
        <?php echo validation_errors(); ?>
        <?php echo $this->session->flashdata('message'); ?>
        <?php echo form_open($form_action,"id=\"frm_journal\"") . form_hidden('id', $gltr_id); ?>
        <input type="hidden" id="act" name="act" value="<?php echo $act; ?>" />
        <input type="hidden" id="gltr_id" name="gltr_id" value="<?php echo $gltr_id; ?>" />
        <table>
            <tr>
                <td>Voucher No</td>
                <td><?php echo form_input($gltr_voucher); ?></td>
            </tr>
          	<tr>
                <td width="20%">Date</td>
                <td><div class="span3"><?php echo form_input($gltr_date); ?></div></td>
            </tr>
            <tr><td colspan="2">&nbsp;</td></tr>
        </table>
		<h5>Transaction</h5>
          <div id="journal_table"></div>
          <div id="total">
            <h5>Total</h5>
          	<div>
          	  <span><b>Debit : </b></span>
          	  <span id="total_debit"></span><input type="hidden" id="tot_debit" name="tot_debit" />
          	</div>
          	<div>
          	  <span><b>Credit : </b></span>
          	  <span id="total_credit"></span><input type="hidden" id="tot_credit" name="tot_credit" />
          	</div>
          </div>
        <br />
        <input type="submit" id="btnSave" name="save" value="Save" class="btn btn-primary" />
        <a href="<?php echo site_url('journal/index'); ?>" class="btn btn-danger">Back</a>
        <?php echo form_close() ?>
    </div>
</div>
<?php get_footer(); ?>