<?php get_header(); ?>
<script type="text/javascript">
$(document).ready(function(){
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
      <small>Slip Gaji</small>
      </h1>
    </div>
    <form action="" method="post">
    	<div class="span3">Period<br />
    	<?php echo $period_month; ?>&nbsp;<?php echo $period_year; ?></div>
    	<div class="span3">Staff<br />
    	<?php echo $staff_list; ?></div>
    	<div class="cl"></div>
    </form>
    <div style="margin: 10px 0; border-bottom:1px solid #e0e0e0;"></div>
    <a href="#" class="btn btn-info proc" target="_blank" data-to="print">Print</a>
    <a href="#" class="btn btn-primary proc" data-to="pdf">Save PDF</a>
    <a href="#" class="btn proc" data-to="xls">Save XLS</a>
  </div>
</div>

<?php get_footer(); ?>