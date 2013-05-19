<?php get_header(); ?>
<script type="text/javascript">
$(document).ready(function(){
	
	$('#periode').datepicker({
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'MM yy',
      onClose: function(dateText, inst) { 
          var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
          var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
          $(this).datepicker('setDate', new Date(year, month, 1));
      }
  });
	
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
<style>
.ui-datepicker{width: 220px;}
.ui-datepicker-calendar { display: none;}
.ui-datepicker-inline .ui-datepicker-calendar { display: block;}
#ui-datepicker-div select.ui-datepicker-month, #ui-datepicker-div select.ui-datepicker-year{width: 80px!important; font-size: 12px; height:30px!important;}
#ui-datepicker-div select.ui-datepicker-year{margin-left: 10px!important;}
</style>
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
    	<div class="span2" style="margin-left: 20px;">Period<br />
    	<?php echo $period_by; ?></div>
    	<div id="by_monthly" class="span2" style="margin-left: 20px;">Monthly<br />
    	<?php echo form_input($periode); ?></div>
    	<div id="by_yearly" class="span2" style="margin-left: 20px;display:none;">Yearly <br />
    	<?php echo $yearly; ?></div>
    	<div id="filter_yearly" class="span2" style="margin-left: 20px;display:none;">By<br />
    	<?php echo $yearly_by; ?>
    	</div>
    	<div id="filter_branch" class="span2" style="margin-left: 20px;display:none;">Branch<br />
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