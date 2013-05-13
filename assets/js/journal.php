<?php
  header("Content-type: application/javascript");
  $url = urldecode($_GET["url"]);
?>
/*
** deleted_data is a global variable located on hansontable script, added by myself 
*/
var errors = 0;
$(document).ready(function(){
  /*Salaries*/
  $("#journal_table").handsontable({
    contextMenu: true,
    startCols: 6,
    startRows: 3,
    minSpareRows: 1,
    colHeaders: ["Account", "Description", "RTI", "Debit (Rp)", "Credit (Rp)", "", ""], // ID, FLAG, COMPONENT ID
    colWidths: [120, 150, 80, 80, 80],
    columns: [
      {
        type: 'autocomplete',
        source: function(req, process){
          var url = "<?php echo $url.'/journal/get_coa'; ?>"
          $.getJSON(url, function(data){
            var items = [];
            $.each(data, function(i, v){
              items.push(v.glacc_name);
            });
            process(items);
          });
        }
      },
      {},
      {},
      {type: "numeric", format: "0,0.00"},
      {type: "numeric", format: "0,0.00"}
    ],
    onChange: function(update, source){
      calculate_balance($("#journal_table"));
      if(source=="edit" && update[0][1]==0){
        var url = "<?php echo $url.'/journal/get_where_account'; ?>/"+update[0][2];
        $.getJSON(url, function(data){
          $("#journal_table").handsontable("setDataAtCell", update[0][0], 6, data.glacc_no);
        });
      }
      if(source != "alter" && update){
        var row = update[0][0];
        var data = $("#journal_table").handsontable("getData")[row];
        var url = "<?php echo $url.'/journal/update_journal_detail'; ?>";
        $.post(url, {
          id: data[5],
          account: data[0],
          description: data[1],
          rti: data[2],
          debit: data[3],
          credit: data[4],
        });
      }
      
      // delete row ajax
      if(source == "alter"){
        var id = deleted_row[0][5];
        var url = "<?php echo $url.'/journal/delete_journal_detail/'; ?>"+id;
        $.get(url);
      }
    }
  });
  
  $("form").on("submit", function(e){
    e.preventDefault();
    var form = this;
    // get component A
    getJournalDetail();
    form.submit();
  });
});

function getJournalDetail(){
  var $instance = $("#journal_table");
  var data = $instance.handsontable('getData');
  var row_length = data.length;
  var journal_detail = "";
  for(i=0; i<row_length; i++){
    journal_detail += '<input type="hidden" name="journal_detail[]" value="'+data[i][5]+';'+data[i][0]+';'+data[i][1]+';'+data[i][2]+';'+data[i][3]+';'+data[i][4]+'">';
  }
  $("#journal_table").html(journal_detail);
}

function calculate_balance($instance){
  var rows = $instance.handsontable("countRows");
  var data = $instance.handsontable("getData");
  var total_debit = 0;
  var total_credit = 0;
  
  for(i = 0; i < data.length; i++){
	  total_debit += data[i][3] == null ? 0:parseInt(data[i][3].toString().replace(/,/g, ""));
	  total_credit += data[i][4] == null ? 0:parseInt(data[i][4].toString().replace(/,/g, ""));
  }
  $("#total_debit").html(accounting.formatMoney(total_debit, "Rp. "));
  $("#total_credit").html(accounting.formatMoney(total_credit, "Rp. "));
  $("#tot_debit").val(total_debit);
  $("#tot_credit").val(total_credit);
}