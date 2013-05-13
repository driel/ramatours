<?php
header("Content-type:application/javascript");
$url = $_GET["url"];
?>
var terms = 0;
$(document).ready(function(){
  var map = {};
  var selected_item = false;
  $("#invoice_detail").handsontable({
    startRows: 3,
    startCols: 11,
    colHeaders: ["Airline", "Route", "Description", "Price (Rp)", "Price (US)", "Discount (Rp)","Discount (US)", "Komisi (Rp)", "Komisi (US)", "", ""], // airline ID, penjualan ticket detail ID
    colWidths: [150, 150, 400, 100, 100, 100, 100, 100, 100],
    stretchH: 'all',
    minSpareRows: 1,
    onChange: function(update, source){
      if(source == "populateFromArray"){
        $("#invoice_detail").handsontable("setDataAtCell", update[0][0], 9, map[selected_item].id);
      }
    },
    columns: [
      {
        type: 'autocomplete',
        source: function(query, proses){
          var url = "<?php echo $url."/airline/get"; ?>/"+query;
          $.ajax({
            url: url,
            type: "GET",
            dataType: "JSON",
            async: false,
            success: function(data){
              var items = [];
              $.each(data, function(i, v){
                map[v.name] = v;
                items.push(v.name);
              });
              proses(items);
            }
          });
        },
        select: function(){
          var val = this.$menu.find('.active').attr('data-value');
          this.$element.val(this.updater(val)).change();
          selected_item = val;
          return this.hide();
        }
      },
      {},
      {},
      {
        type: 'numeric',
        format: '0,0.00'
      },
      {
        type: 'numeric',
        format: '0,0.00'
      },
      {
        type: 'numeric',
        format: '0,0.00'
      },
      {
        type: 'numeric',
        format: '0,0.00'
      },
      {
        type: 'numeric',
        format: '0,0.00'
      },
      {
        type: 'numeric',
        format: '0,0.00'
      }
    ]
  });
  
  $("form").on("submit", function(e){
    e.preventDefault();
    var form = this;
    
    var data = $("#invoice_detail").handsontable("getData");
    var invoice_items = "";
    for(i in data){
      if(data[i][0]!=null && data[i][1]!=null && data[i][2]!=null){
        invoice_items += '<input type="hidden" name="invoice_items[]" value="'+data[i][0]+';'+data[i][1]+';'+data[i][2]+';'+data[i][3]+';'+data[i][4]+';'+data[i][5]+';'+data[i][6]+';'+data[i][7]+';'+data[i][8]+';'+data[i][9]+'" />';
      }
    }
    $("#invoice_items").html(invoice_items);
    this.submit();
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
	  		  var item = {label:v.tixa_code, name:v.tixa_name, address:v.tixa_address, tid:v.tixa_id, glaccno_dr:v.tixa_glacc_dr, glaccno_cr:v.tixa_glacc_cr, terms:v.tixa_terms};
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
      
      // calculate due date
      var today = new Date();
      today.setDate(today.getDate()+parseInt(ui.item.terms));
      var date = today.getDate();
      var month = today.getMonth();
      var year = today.getFullYear();
      ++month;
      if(month < 10){
        month = "0"+month;
      }
      $("#due_date").val(year+"-"+month+"-"+date);
    }
	});
});