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
	$('#period').datepicker({
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
	
	$("#staff").autocomplete({
        source: function(request, response){
          console.log(request)
          var url = "<?php echo site_url('absensi/get_staff')?>/"+request.term;
          $.getJSON(url, function(data){
            var list = [];
            $.each(data, function(i, v){
              var li = {
                value: v.staff_name,
                staff_id: v.staff_id
              }
              list.push(li);
            });
            response(list);
          });
        },
        select: function(event, ui){
          $("#staff_id").val(ui.item.staff_id);
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
      <h1>Tax
      <small>PPh 21 Report</small>
      </h1>
    </div>
    <form action="" method="post">
    	<div class="span2" style="margin-right: 20px;">Period<br />
    	<?php echo $period_by; ?></div>
    	<div id="by_monthly" class="span2" style="margin-right: 20px;">Monthly<br />
    	<?php echo form_input($period); ?></div>
    	<div id="by_yearly" class="span2" style="margin-right: 20px;display:none;">By <br />
    	<?php echo $yearly_by; ?></div>
    	<div id="filter1_monthly" class="span2" style="margin-right: 20px;">Branch<br />
    	<?php echo $staff_cabang; ?>
    	</div>
    	<div id="filter2_monthly" class="span2" style="margin-right: 20px;">Department<br />
    	<?php echo $staff_departement; ?>
    	</div>
    	<div id="filter3_monthly" class="span2" style="margin-right: 20px;">Title<br />
    	<?php echo $staff_jabatan; ?>
    	</div>
    	<div id="filter4_monthly" class="span2" style="margin-right: 20px;">Name<br />
    	<?php echo $staff; echo $staff_id; ?></div>
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