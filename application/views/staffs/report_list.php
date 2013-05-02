<?php get_header(); ?>
<script>
$(document).ready(function(){
	$("#status").iphoneStyle({
		checkedLabel: "Enable",
		uncheckedLabel: "Disable",
		onChange: function(e, checked){
			if(checked){
				$(e).attr("checked", "checked");
			}else{
				$(e).removeAttr("checked");
			}
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
      <h1>Staff
      <small>Report staff list</small>
      </h1>
    </div>
    <form action="" method="post">
    	<div class="span3">Branch<br />
    	<?php echo $staff_cabang; ?></div>
    	<div class="span3">Department<br />
    	<?php echo $staff_departement; ?></div>
    	<div class="span3">Title <br />
    	<?php echo $staff_jabatan; ?></div>
    	<div class="span3">Marital status<br />
    	<?php echo $marital; ?>
    	</div>
    	<div class="span3">Status <br />
    	<input type="checkbox" name="status" id="status" checked /></div>
    	<div class="cl"></div>
    </form>
    <div style="margin: 10px 0; border-bottom:1px solid #e0e0e0;"></div>
    <a href="#" class="btn btn-info proc" target="_blank" data-to="print">Print</a>
    <a href="#" class="btn btn-primary proc" data-to="pdf">Save PDF</a>
    <a href="#" class="btn proc" data-to="xls">Save XLS</a>
  </div>
</div>
<?php get_footer(); ?>