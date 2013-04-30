<?php get_header(); ?>
<?php

function HeaderLink($value, $key, $col, $dir) {
    $out = "<a href=\"" . site_url('staffs') . "?c=";
    //set column query string value
    switch ($key) {
        case "staff_nik":
            $out .= "1";
            break;
        case "staff_name":
            $out .= "2";
            break;
        case "no_passport":
            $out .= "3";
            break;
        case "passport_expired":
            $out .= "4";
            break;
        case "no_kitas":
            $out .= "5";
            break;
        case "kitas_expired":
            $out .= "6";
            break;
        case "staff_cabang":
            $out .= "7";
            break;
        case "staff_departement":
            $out .= "8";
            break;
        case "staff_jabatan":
            $out .= "9";
            break;
        case "staff_id":
            $out .= "10";
            break;
        default:
            $out .= "0";
    }

    $out .= "&d=";

    //reverse sort if the current column is clicked
    if ($key == $col) {
        switch ($dir) {
            case "ASC":
                $out .= "1";
                break;
            default:
                $out .= "0";
        }
    } else {
        //pass on current sort direction
        switch ($dir) {
            case "ASC":
                $out .= "0";
                break;
            default:
                $out .= "1";
        }
    }

    //complete link
    $out .= "\">$value</a>";

    return $out;
}
?>
<style type="text/css">
.modal {
	width : 600px;
}
.modal-body{
  max-height: 600px!important;
}
.report_overflow {
	overflow: auto;
	position:relative;
	margin:0 auto;
	height:200px;
	left:30px;
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
	$("#staff_birthdate" ).datepicker({
    	dateFormat: "yy-mm-dd"
  	});

  	$("#printPDF").click(function() {
  		document.location.href = '<?php echo base_url('staffs/report_list').'?'.$_SERVER['QUERY_STRING'].'&to=pdf'; ?>';
  	});

  	$("#printXLS").click(function() {
  		document.location.href = '<?php echo base_url('staffs/report_list').'?'.$_SERVER['QUERY_STRING'].'&to=xls'; ?>';
  	});
});
(function($){
	$(window).load(function(){
		$("#staff_detail").mCustomScrollbar({
			horizontalScroll:true,
			scrollButtons:{
			enable:true
			}
		});
	});
})(jQuery);
</script>
<div class="body">
  <div class="content">
    <?php echo $this->session->flashdata('message'); ?>
    <div class="page-header">
      <div class="icon">
        <span class="ico-coins"></span>
      </div>
      <h1>Staff
      <small>Report staff list</small>
      </h1>
    </div>
    <br class="cl" />
    <div class="head blue">
      <?php echo header_btn_group_report();?>
    </div>
    <div id="search_bar" class="widget-header">
      	<form action="" method="get">
      		<?php
      		//var_dump($this->input->get());
	      	$block = $this->input->get() != false ? ' style="display:block"':'';
      		?>
      		<div id="filtering"<?php echo $block; ?>>
				<table width="30%" align="center">
      				<tr>
	      				<td><span class="search_by">Branch</span></td>
	     				<td><?php echo $staff_cabang; ?></td>
   					</tr>
      				<tr>
	      				<td><span class="search_by">Department</span></td>
	     				<td><?php echo $staff_departement; ?></td>
   					</tr>
      				<tr>
	      				<td><span class="search_by">Title</span></td>
	     				<td><?php echo $staff_jabatan; ?></td>
   					</tr>
      				<tr>
	      				<td><span class="search_by">Name</span></td>
	     				<td><?php echo form_input(array('name' => 'staff_name', 'value' => $this->input->get('staff_name'), 'size' => '28'));?></td>
   					</tr>
   					<tr>
   						<td>&nbsp;</td>
	      				<td>
						  	<?php
  						      	if($this->input->get() != FALSE){
			                      echo anchor(current_url(), 'reset', array(
			                        "class"=>"bootstrap-tooltip btn btn-danger",
			                        "data-placement"=>"top",
			                        "data-title"=>"Clear search"
			                      ));
           				     	}
					      	?>
						  	<input type="submit" name="search" value="Search" class="btn btn-primary" />
					  	</td>
     				</tr>
	      		</table>
	      	</div>
    	</form>
    </div>
    <div class="row">
		<div id="staff_detail" class="report_overflow">
		    <table class="table fpTable table-hover">
		      <thead>
		        <tr>
		          <th rowspan="2" width="20%"><?php echo HeaderLink("Name", "staff_name", $col, $dir); ?></th>
		          <th rowspan="2" width="10%"><?php echo HeaderLink("Branch", "staff_cabang", $col, $dir); ?></th>
		          <th rowspan="2" width="10%"><?php echo HeaderLink("Departement", "staff_departement", $col, $dir); ?></th>
		          <th rowspan="2" width="10%"><?php echo HeaderLink("Title", "staff_jabatan", $col, $dir); ?></th>
		          <th colspan="2">Nomor</th>
		          <th colspan="2">Nomor</th>
		        </tr>
		        <tr>
		          <th width="10%"><?php echo HeaderLink("Passport", "no_passport", $col, $dir); ?></th>
		          <th width="10%"><?php echo HeaderLink("Expired", "passport_expired", $col, $dir); ?></th>
		          <th width="10%"><?php echo HeaderLink("Kitas", "no_kitas", $col, $dir); ?></th>
		          <th width="10%"><?php echo HeaderLink("Expired", "kitas_expired", $col, $dir); ?></th>
				</tr>
		      </thead>
		      <tbody>
		      <?php
		      foreach ($staff_list as $row) {
		      ?>
		          <tr>
		            <td><?php echo $row->staff_name; ?></td>
		            <td><?php echo $row->staff_cabang; ?></td>
		            <td><?php echo $row->staff_departement; ?></td>
		            <td><?php echo $row->staff_jabatan; ?></td>
		            <td><?php echo $row->no_passport; ?></td>
		            <td><?php echo $row->passport_expired; ?></td>
		            <td><?php echo $row->no_kitas; ?></td>
		            <td><?php echo $row->kitas_expired; ?></td>
		          </tr>
		      <?php } ?>
		      </tbody>
		    </table>
  		</div>
    </div>
    <div class="clearfix"></div>
    <div class="pagination pagination-right">
      <ul>
        <?php echo $pagination; ?>
      </ul>
    </div>
    <!-- Modal -->
	<div id="printModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Document Expired Report</h3>
		</div>
		<div class="modal-body">
			<div id="modal_staff_detail" class="report_overflow">
			    <table style="border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;">
			      <thead>
			        <tr>
			          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Name</th>
			          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Branch</th>
			          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Departement</th>
			          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Title</th>
			          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Nomor</th>
			          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Nomor</th>
			        </tr>
			        <tr>
			          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Passport</th>
			          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Expired</th>
			          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Passport</th>
			          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Expired</th>
			        </tr>
			      </thead>
			      <tbody>
			      <?php
			      foreach ($staff_list as $row) {
			      ?>
			          <tr>
			            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_name; ?></td>
			            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_cabang; ?></td>
			            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_departement; ?></td>
			            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_jabatan; ?></td>
			            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->no_passport; ?></td>
			            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->passport_expired; ?></td>
			            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->no_kitas; ?></td>
			            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->kitas_expired; ?></td>
			          </tr>
			      <?php } ?>
			      </tbody>
			    </table>
	  		</div>
		</div>
		<div class="modal-footer">
			<button id="printPDF" class="btn btn-primary">Save as PDF</button>
			<button id="printXLS" class="btn btn-primary">Save as Excel</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>
  </div>
</div>
<script type="text/javascript">
	$('#printModal').on('shown', function () {
		$("#modal_staff_detail").mCustomScrollbar({
			horizontalScroll:true,
			scrollButtons:{
			enable:true
			}
		});
	});
</script>

<?php get_footer(); ?>