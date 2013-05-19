<?php get_header(); ?>
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
		if ($("#staff_id").val() != "") {
			e.preventDefault();
			var data = $("form").serialize();
			var target = $(this).attr("target") == "_blank" ? "_blank":"_self";
			var to = $(this).data("to");
			window.open("<?php echo current_url(); ?>/?"+data+"&to="+to, target);
		} else {
			e.preventDefault();
			alert("Please, select staff first!!!");
		}
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
      <small>Slip Gaji</small>
      </h1>
    </div>
    <form action="" method="post">
    	<div class="span2" style="margin-left: 20px;">Period<br />
    	<?php echo form_input($period); ?></div>
    	<div class="span2" style="margin-left: 20px;">Staff<br />
    	<?php echo $staff; echo $staff_id; ?></div>
    	<div class="cl"></div>
    </form>
    <div style="margin: 10px 0; border-bottom:1px solid #e0e0e0;"></div>
    <a href="#" class="btn btn-info proc" target="_blank" data-to="print">Print</a>
    <a href="#" class="btn btn-primary proc" data-to="pdf">Save PDF</a>
    <a href="#" class="btn proc" data-to="xls">Save XLS</a>
  </div>
</div>

<?php get_footer(); ?>