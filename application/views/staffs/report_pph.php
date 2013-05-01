<?php get_header(); ?>
<style type="text/css">
.modal {
	width : 800px;
}
.modal-body{
  max-height: 800px!important;
}
.report_overflow {
	overflow: auto;
	position:relative;
	margin:0 auto;
	width: 970px;
	height:200px;
	left:0%;
	top:0px;
	-webkit-box-sizing:border-box; 
	-moz-box-sizing:border-box; 
	box-sizing:border-box; 
	overflow:auto;
	background:transparent;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
  	$("#period_by").change(function() {
		if ($(this).val() == 'Monthly') {
			$("#by_monthly").show();
			$("#by_yearly").hide();
			$("#filter1_monthly").show();
			$("#filter2_monthly").show();
			$("#filter3_monthly").show();
			$("#filter4_monthly").show();
			$("#filter_yearly").hide();
		} else {
			$("#by_monthly").hide();
			$("#by_yearly").show();
			$("#filter1_monthly").hide();
			$("#filter2_monthly").hide();
			$("#filter3_monthly").hide();
			$("#filter4_monthly").hide();
			$("#filter_yearly").show();
		}
	});

	$(".proc").on("click", function(e){
		e.preventDefault();
		var data = $("form").serialize();
		var target = $(this).attr("target") == "_blank" ? "_blank":"_self";
		var to = $(this).data("to");
		window.open("<?php echo current_url(); ?>/?"+data+"&to="+to, target);
	});
});
</script>
<div class="body">
  <div class="content">
    <?php echo $this->session->flashdata('message'); ?>
    <div class="page-header">
      <div class="icon">
        <span class="ico-coins"></span>
      </div>
      <h1>Tax
      <small>PPh 21 Report</small>
      </h1>
    </div>
    <form action="" method="post">
    	<div class="span3">Period<br />
    	<?php echo $period_by; ?></div>
    	<div id="by_monthly" class="span3">Monthly<br />
    	<?php echo $period; ?></div>
    	<div id="by_yearly" class="span3" style="display:none;">By <br />
    	<?php echo $yearly_by; ?></div>
    	<div id="filter1_monthly" class="span3">Branch<br />
    	<?php echo $staff_cabang; ?>
    	</div>
    	<div id="filter2_monthly" class="span3">Department<br />
    	<?php echo $staff_departement; ?>
    	</div>
    	<div id="filter3_monthly" class="span3">Title<br />
    	<?php echo $staff_jabatan; ?>
    	</div>
    	<div id="filter4_monthly" class="span3">Name<br />
    	<?php echo form_input(array('name' => 'staff_name', 'value' => $this->input->get('staff_name'), 'size' => '28'));?>
    	</div>
    	<div class="cl"></div>
    </form>
    <div style="margin: 10px 0; border-bottom:1px solid #e0e0e0;"></div>
    <a href="#" class="btn btn-info proc" target="_blank" data-to="print">Print</a>
    <a href="#" class="btn btn-primary proc" data-to="pdf">Save PDF</a>
    <a href="#" class="btn proc" data-to="xls">Save XLS</a>
  </div>
</div>

<?php get_footer(); ?>