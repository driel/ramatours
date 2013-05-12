<?php
header("Content-type:application/javascript");
$url = $_GET["url"];
?>

$(document).ready(function(){
  $("#invoice_detail").handsontable({
    startRows: 3,
    startCols: 9,
    colHeaders: ["Airline", "Route", "Description", "Price (Rp)", "Price (US)", "Discount (Rp)","Discount (US)", "Komisi (Rp)", "Komisi (US)"],
    colWidths: [150, 150, 400, 100, 100, 100, 100, 100, 100],
    stretchH: 'all',
    minSpareRows: 1,
    columns: [
      {
        type:autocomplete,
        source: function(query, proses){
          
        }
      }
    ]
  });
  
  $("#status").iphoneStyle({
	  checkedLabel: "Enable",
	  uncheckedLabel: "Disable",
	  onChange: function(e, checked){
		  $("#disable_on").toggle();
	  }
	});

	$("#agent").autocomplete({
    source: function(request, proses){
  	  console.log(request);
  	  var q = request.term;
  	  var url = '<?php echo $url.'/ticket_agent/get_agent'; ?>/'+q;
  	  $.getJSON(url, function(data){
  	  	var items = [];
	  	  $.each(data, function(i, v){
	  		  var item = {label:v.tixa_code, name:v.tixa_name, address:v.tixa_address, tid:v.tixa_id, glaccno_dr:v.tixa_glacc_dr, glaccno_cr:v.tixa_glacc_cr};
	  		  items.push(item);
	  	  });
	  	  proses(items);
  	  });
    },
    select: function(e, ui){
      $("#agent_id").val(ui.item.tid);
      $("#agent_name").val(ui.item.name);
      $("#agent_address").val(ui.item.address);
      // get GL Acc DR
      var dr_url = "<?php echo $url."/accounts/get"; ?>/"+ui.item.glaccno_dr
      $.getJSON(dr_url, function(data){
        $("input[name=glacc_dr]").val(data);
      });
      
      // get GL Acc CR
      var cr_url = "<?php echo $url."/accounts/get"; ?>/"+ui.item.glaccno_cr
      $.getJSON(cr_url, function(data){
        $("input[name=glacc_cr]").val(data);
      });
    }
	});
});