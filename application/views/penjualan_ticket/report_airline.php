<?php get_header(); ?>
<script>
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
	
	$("#staff").autocomplete({
	  source: function(q, proses){
		  var url = "<?php echo site_url("staffs/get_staff"); ?>/"+q.term;
		  $.getJSON(url, function(data){
			  var items = [];
			  $.each(data, function(i, v){
				  items.push({label:v.staff_name, id:v.staff_id});
			  });
			  proses(items);
		  });
	  },
	  select: function(e, ui){
		  $("#staff_id").val(ui.item.id);
	  }
	});
	
	$(".proc").on("click", function(e){
		e.preventDefault();
		var data = $("form").serialize();
		var target = $(this).attr("target") == "_blank" ? "_blank":"_self";
		var to = $(this).data("to");
		window.open("<?php echo current_url(); ?>/?"+data+"&to="+to, target);
	});

	$("#airline").autocomplete({
		source: function(q, proses){
			var url = "<?php echo site_url("airline/get_airline")?>/"+q.term;
			$.getJSON(url, function(data){
				var items = [];
				$.each(data, function(i, v){
					items.push({label:v.name, id:v.id});
				});
				proses(items);
			});
		},
		select: function(e, ui){
			$("#air_id").val(ui.item.id);
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
			<h1>
				Report Ticket Selling per Airlines<small>Report Daily Ticket Selling</small>
			</h1>
		</div>
		<form action="" method="post">
			<div class="span2">
				Branch<br />
				<?php echo $staff_cabang; ?>
			</div>
			<div class="span2" style="margin-left: 20px;">
				Periode<br />
				<?php echo form_input($periode); ?>
			</div>
			<div class="span2" style="margin-left: 20px;">
				Airline<br />
				<?php echo form_input($airline); ?>
				<input type="hidden" name="air_id" id="air_id" />
			</div>
			<div class="cl"></div>
		</form>
		<div style="margin: 10px 0; border-bottom: 1px solid #e0e0e0;"></div>
		<a href="#" class="btn btn-info proc" target="_blank" data-to="print">Print</a>
		<a href="#" class="btn btn-primary proc" data-to="pdf">Save PDF</a> <a
			href="#" class="btn proc" data-to="xls">Save XLS</a>
	</div>
</div>
<?php get_footer(); ?>