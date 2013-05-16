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
    colHeaders: ["Airline", "Route", "Description", "Currency", "Price", "Currency","Discount", "Currency", "Komisi", "", ""], // airline ID, penjualan ticket detail ID
    colWidths: [150, 150, 300, 60, 100, 60, 100, 60, 100],
    stretchH: 'all',
    minSpareRows: 1,
    contextMenu: true,
    onChange: function(update, source){
      if(source == "populateFromArray"){
        if(selected_item){
          $("#invoice_detail").handsontable("setDataAtCell", update[0][0], 9, map[selected_item].id);
        }
        var tixd_id = $("#invoice_detail").handsontable("getDataAtCell", update[0][0], 10);
        if(tixd_id != null){ // tixd_id is not null, meanig this row is from database
          var air_id = $("#invoice_detail").handsontable("getDataAtCell", update[0][0], 9);
          var route = $("#invoice_detail").handsontable("getDataAtCell", update[0][0], 1);
          var description = $("#invoice_detail").handsontable("getDataAtCell", update[0][0], 2);
          var currency_price = $("#invoice_detail").handsontable("getDataAtCell", update[0][0], 3);
          var price = $("#invoice_detail").handsontable("getDataAtCell", update[0][0], 4);
          var currency_discount = $("#invoice_detail").handsontable("getDataAtCell", update[0][0], 5);
          var discount = $("#invoice_detail").handsontable("getDataAtCell", update[0][0], 6);
          var currency_komisi = $("#invoice_detail").handsontable("getDataAtCell", update[0][0], 7);
          var komisi = $("#invoice_detail").handsontable("getDataAtCell", update[0][0], 8);
          var data = {
            air_id:air_id, 
            tixd_id:tixd_id, 
            route:route, 
            description:description,
            currency_price:currency_price,
            price:price,
            currency_discount:currency_discount,
            discount:discount,
            currency_komisi:currency_komisi,
            komisi:komisi
          }
          var url = '<?php echo $url."/penjualan_ticket/update_item/"?>';
          $.ajax({
            url: url,
            type: "POST",
            data: data,
            success:function(d){console.log(d);}
          });
        }
      }
      
      if(source == "edit" || source == "loadData"){
        var data = $("#invoice_detail").handsontable("getData");
        var total_rp = 0, total_us = 0, discount_rp = 0, discount_us = 0, komisi_rp = 0, komisi_us = 0;
        for(i = 0; i<data.length-1; i++){
          if(data[i][3] != null && data[i][3].toLowerCase()=="rp"){
            total_rp += parseInt(data[i][4]);
          }else{
            total_us += parseInt(data[i][4]);
          }
          
          if(data[i][5] != null && data[i][5].toLowerCase()=="rp"){
            discount_rp += parseInt(data[i][6]);
          }else{
            discount_us += parseInt(data[i][6]);
          }
          
          if(data[i][7] != null && data[i][7].toLowerCase()=="rp"){
            komisi_rp += parseInt(data[i][8]);
          }else{
            komisi_us += parseInt(data[i][8]);
          }
        }
        $("#total_rp").text(accounting.formatMoney(total_rp, ""));
        $("#total_us").text(accounting.formatMoney(total_us, ""));
        
        $("#discount_rp").text(accounting.formatMoney(discount_rp, ""));
        $("#discount_us").text(accounting.formatMoney(discount_us, ""));
        
        $("#komisi_rp").text(accounting.formatMoney(komisi_rp, ""));
        $("#komisi_us").text(accounting.formatMoney(komisi_us, ""));
      }
      
      if(source == "alter"){
        var id = deleted_row[0][10]
        var url = "<?php echo $url;?>/penjualan_ticket/delete_item/"+id;
        $.ajax({
          url: url,
          type: "GET"
        });
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
        type: 'autocomplete',
        source: ['Rp', 'USD'],
        strict: true
      },
      {
        type: 'numeric',
        format: '0,0.00'
      },
      {
        type: 'autocomplete',
        source: ['Rp', 'USD'],
        strict: true
      },
      {
        type: 'numeric',
        format: '0,0.00'
      },
      {
        type: 'autocomplete',
        source: ['Rp', 'USD'],
        strict: true
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
      if(data[i][0]!=null && data[i][1]!=null && data[i][3]!=null && data[i][5]!=null && data[i][7]!=null){
        invoice_items += '<input type="hidden" name="invoice_items[]" value="'+data[i][0]+';'+data[i][1]+';'+data[i][2]+';'+data[i][3]+';'+data[i][4]+';'+data[i][5]+';'+data[i][6]+';'+data[i][7]+';'+data[i][8]+';'+data[i][9]+';'+data[i][10]+'" />';
      }
    }
    $("#invoice_items").html(invoice_items);
    this.submit();
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