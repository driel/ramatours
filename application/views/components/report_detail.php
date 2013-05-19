<?php get_header(); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('#periode').datepicker({
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'M yy',
      onClose: function(dateText, inst) { 
          var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
          var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
          $(this).datepicker('setDate', new Date(year, month, 1));
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
    <?php echo $this->session->flashdata('message'); ?>
    <div class="page-header">
      <div class="icon">
        <span class="ico-coins"></span>
      </div>
      <h1>Salary
      <small>Detail Salary Report</small>
      </h1>
    </div>
    <form action="" method="post">
    	<div class="span2" style="margin-left: 20px;">Period<br />
    	<?php echo form_input($periode); ?></div>
    	<div class="span2" style="margin-left: 20px;">Branch<br />
    	<?php echo $staff_cabang; ?></div>
    	<div class="span2" style="margin-left: 20px;">Department<br />
    	<?php echo $staff_departement; ?></div>
    	<div class="span2" style="margin-left: 20px;">Title <br />
    	<?php echo $staff_jabatan; ?></div>
    	<div class="cl"></div>
    </form>
    <div style="margin: 10px 0; border-bottom:1px solid #e0e0e0;"></div>
    <a href="#" class="btn btn-info proc" target="_blank" data-to="print">Print</a>
    <a href="#" class="btn btn-primary proc" data-to="pdf">Save PDF</a>
    <a href="#" class="btn proc" data-to="xls">Save XLS</a>
  </div>
</div>

<?php get_footer(); ?>