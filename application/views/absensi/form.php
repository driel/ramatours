<?php get_header(); ?>
<script type="text/javascript">
    $(document).ready(function(){
      $(".submit").on("click", function(e){
          e.preventDefault();
          var data = $("form").serialize();
          var url = "<?php echo site_url("absensi/staff_per_branch"); ?>?"+data;
          var action = $(this).data("action");
          var month = $("select[name=periode]").val();
          var year = $("select[name=year]").val();
          if(action == "generate"){
        	  $.getJSON(url, function(data){
          	  var staffs = [];
          	  $.each(data, function(i, v){
            	  var periode_url = "<?php echo site_url("absensi/get_per_periode"); ?>?periode="+year+"-"+month+"&staff_id="+v.staff_id;
            	  var absen = 0;
            	  $.ajax({
            	    url: periode_url,
            	    dataType: "json",
            	    async: false,
            	    success: function(data){
                	  if(data.absen != undefined){
                		  absen = parseInt(data.absen);
                	  }
            	    }
          	    });
          		  staffs.push({"name": v.staff_name, "cabang": v.staff_cabang, "dept": v.staff_departement, "title": v.staff_jabatan, "absen": absen, "sid": v.staff_id});
          	  });
          	  generateHT(staffs);
            });
          }else{
        	  
          }
      });

      $("form").on("submit", function(e){
        e.preventDefault();
        var form = this;
        var data = $("#ht").handsontable("getData");
        var hidden = '';
        for(i in data){
          hidden += '<input type="hidden" name="absensi[]" value="'+data[i].sid+';'+data[i].absen+'" />';
        }
        $("#ht_hidden").html(hidden);
        form.submit();
      });
    });
    function generateHT(data){
      $("#ht").handsontable({
    	  data: data,
    	  startCols: 6,
    	  colWidths: [180, 100, 100, 100, 50, 1],
    	  colHeaders: ["Name", "Branch", "Department", "Title", "Absen", ""],
    	  columns: [{data:"name", readOnly:true},
    	      	  {data:"cabang", readOnly:true},
    	      	  {data:"dept", readOnly:true},
    	      	  {data:"title", readOnly:true},
    	      	  {data:"absen", type:"numeric"},
    	      	  {data:"sid", readOnly:true}]
      });
	  }
</script>
<div class="body">
    <div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-tag"></span>
            </div>
            <h1>Absensi
                <small>Manage absensi</small>
            </h1>
        </div>
        <?php echo $this->session->flashdata('message'); ?>
        <?php echo form_open_multipart($form_action);?>
        <table width="100%">
          <tr>
            <td>Periode</td>
            <td>
              <div class="span2" style="width: 200px;"><?php echo $periode ?></div>
              <div class="span2"><?php echo $year; ?></div>
            </td>
          </tr>
          <tr>
              <td width="20%">Branch</td>
              <td><div class="span3"><?php echo $branch; ?></div></td>
          </tr>
        </table>
        <div id="ht"></div>
        <div id="ht_hidden"></div>
        <div style="float:left; margin-right: 3px;">
        	<a href="" class="btn btn-info submit" data-action="generate">Generate Grid</a>
        </div>
        <div class="input-append file" style="float:left">
          <input type="file" name="csv" style="display:none"/>
        	<a href="" class="btn submit" data-action="upload_csv" style="padding: 4px 12px; margin: 3px 0;">Import CSV</a>
        </div>
        <br class="cl"/>
        <input type="submit" name="save" class="btn btn-primary" />
        <a href="<?php echo site_url('absensi/index'); ?>" class="btn btn-danger">Back</a>
        <?php echo form_close() ?>
    </div>
</div>
<?php get_footer(); ?>
