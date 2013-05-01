<?php get_header(); ?>
<script type="text/javascript">
$(document).ready(function(){
	$("#period_by").change(function() {
		if ($(this).val() == 'Monthly') {
			$("#by_monthly").show();
			$("#by_yearly").hide();
			$("#filter_yearly").hide();
			$("#filter_branch").hide();
		} else {
			$("#by_monthly").hide();
			$("#by_yearly").show();
			$("#filter_yearly").show();

			if ($("#yearly_by").val() == 'Staff') {
				$("#filter_branch").show();
			} else {
				$("#filter_branch").hide();
			}
		}
	});

	$("#yearly_by").change(function() {
		if ($(this).val() == 'Staff') {
			$("#filter_branch").show();
		} else {
			$("#filter_branch").hide();
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
    <div class="page-header">
      <div class="icon">
        <span class="ico-coins"></span>
      </div>
      <h1>Salary
      <small>Salary Recapitulation Report</small>
      </h1>
    </div>
    <form action="" method="post">
    	<div class="span3">Period<br />
    	<?php echo $period_by; ?></div>
    	<div id="by_monthly" class="span3">Monthly<br />
    	<?php echo $period_month; ?>&nbsp;<?php echo $period_year; ?></div>
    	<div id="by_yearly" class="span3" style="display:none;">Yearly <br />
    	<?php echo $yearly; ?></div>
    	<div id="filter_yearly" class="span3" style="display:none;">By<br />
    	<?php echo $yearly_by; ?>
    	</div>
    	<div id="filter_branch" class="span3" style="display:none;">Branch<br />
    	<?php echo $branch; ?>
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