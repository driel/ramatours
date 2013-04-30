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

  	$("#printPDF").click(function() {
  		document.location.href = '<?php echo site_url('staffs/report_pph').'?'.$_SERVER['QUERY_STRING'].'&to=pdf'; ?>';
  	});

  	$("#printXLS").click(function() {
  		document.location.href = '<?php echo site_url('staffs/report_pph').'?'.$_SERVER['QUERY_STRING'].'&to=xls'; ?>';
  	});
});
(function($){
	$(window).load(function(){
		$("#yearly_detail").mCustomScrollbar({
			horizontalScroll:true,
			scrollButtons:{
			enable:true
			}
		});
		$("#yearly_branch_detail").mCustomScrollbar({
			horizontalScroll:true,
			scrollButtons:{
			enable:true
			}
		});
	});
	$('#printModal').on('shown', function () {
		$("#model_yearly_detail").mCustomScrollbar({
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
      <h1>Tax
      <small>PPh 21 Report</small>
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
	      				<td><span class="search_by">Period</span></td>
	     				<td><?php echo $period_by; ?></td>
	   				</tr>
	      			<tr id="by_monthly" <?php echo $this->input->get('period_by') == 'Yearly'? 'style="display:none;"':'';?>>
	      				<td><span class="search_by">&nbsp;</span></td>
	     				<td><?php echo $period; ?></td>
	   				</tr>
	      			<tr id="filter1_monthly" <?php echo $this->input->get('period_by') == 'Yearly'? 'style="display:none;"':'';?>>
	      				<td><span class="search_by">Branch</span></td>
	     				<td><?php echo $staff_cabang; ?></td>
	   				</tr>
	      			<tr id="filter2_monthly" <?php echo $this->input->get('period_by') == 'Yearly'? 'style="display:none;"':'';?>>
	      				<td><span class="search_by">Department</span></td>
	     				<td><?php echo $staff_departement; ?></td>
	   				</tr>
	      			<tr id="filter3_monthly" <?php echo $this->input->get('period_by') == 'Yearly'? 'style="display:none;"':'';?>>
	      				<td><span class="search_by">Title</span></td>
	     				<td><?php echo $staff_jabatan; ?></td>
	   				</tr>
	      			<tr id="filter4_monthly" <?php echo $this->input->get('period_by') == 'Yearly'? 'style="display:none;"':'';?>>
	      				<td><span class="search_by">Name</span></td>
	     				<td><?php echo form_input(array('name' => 'staff_name', 'value' => $this->input->get('staff_name'), 'size' => '28'));?></td>
	   				</tr>
	      			<tr id="by_yearly" <?php echo $this->input->get('period_by') == 'Yearly'? '':'style="display:none;"';?>>
	      				<td><span class="search_by">&nbsp;</span></td>
	     				<td><?php echo $yearly ;?></td>
	   				</tr>
	      			<tr id="filter_yearly" <?php echo $this->input->get('period_by') == 'Yearly'? '':'style="display:none;"';?>>
	      				<td><span class="search_by">By</span></td>
	     				<td><?php echo $yearly_by; ?></td>
	   				</tr>
	   				<tr>
	   					<td>&nbsp;</td>
		      			<td>
						  	<?php
		                      echo anchor(current_url(), 'reset', array(
		                        "class"=>"bootstrap-tooltip btn btn-danger",
		                        "data-placement"=>"top",
		                        "data-title"=>"Clear search"
		                      )); //'<a href="'.current_url().'" class="btn btn-danger">reset</a>';
					      	?>
						  	<input type="submit" name="search" value="Search" class="btn btn-primary" />
			  			</td>
	     			</tr>
		      	</table>
	      	</div>
    	</form>
    </div>
    <div class="row">
		<?php
    	if ($period_by_selected == 'Monthly') {
    	?>
		<div id="monthly_detail" class="report_overflow">
		    <table class="table fpTable table-hover">
		      <thead>
		        <tr>
		          <th rowspan="2">Cabang</th>
		          <th rowspan="2">Staff</th>
		          <th rowspan="2">Department</th>
		          <th rowspan="2">Title</th>
		          <th rowspan="2">Company</th>
		          <th colspan="2">PPh 21</th>
		          <th rowspan="2">Total PPh</th>
		        </tr>
		        <tr>
		          <th>Perusahaan</th>
		          <th>Pribadi</th>
		        </tr>
		      </thead>
		      <tbody>
		      <?php
		      $branch = '';
		      foreach ($staff_branch->result() as $row) {
		      	$pph = get_total_monthly_tax($row->staff_id);
		      ?>
		          <tr>
		            <td><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
		            <td><?php echo $row->staff_name; ?></td>
		            <td><?php echo $row->staff_departement; ?></td>
		            <td><?php echo $row->staff_jabatan; ?></td>
		            <td><?php $total_a = get_total_component_a($row->staff_id,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); $total_b = get_total_component_b($row->staff_id,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); $grand = ($total_a+$total_b); echo $grand; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo number_format($pph,0,',','.'); ?></td>
		          </tr>
		      <?php } ?>
		      </tbody>
		    </table>
    	</div>
    	<?php
    	} else if ($period_by_selected == 'Yearly') {
    		if ($yearly_by_selected == 'Branch') {
		?>
		<div id="yearly_branch_detail" class="report_overflow">
		    <table class="table fpTable table-hover">
		      <thead>
		        <tr>
		          <th rowspan="2">Cabang</th>
		          <th colspan="2">Januari</th>
		          <th colspan="2">Februari</th>
		          <th colspan="2">Maret</th>
		          <th colspan="2">April</th>
		          <th colspan="2">Mei</th>
		          <th colspan="2">Juni</th>
		          <th colspan="2">Juli</th>
		          <th colspan="2">Agustus</th>
		          <th colspan="2">September</th>
		          <th colspan="2">Oktober</th>
		          <th colspan="2">November</th>
		          <th colspan="2">Desember</th>
		          <th colspan="2">Total</th>
		        </tr>
		        <tr>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		        </tr>
		      </thead>
		      <tbody>
		      <?php
		      foreach ($branches->result() as $row) {
		      ?>
		          <tr>
		            <td><?php echo $row->branch_name; ?></td>
		            <td><?php $tax_y1 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y1,0,',','.'); ?></td>
		            <td><?php $tax_n1 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n1,0,',','.'); ?></td>
		            <td><?php $tax_y2 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y2,0,',','.'); ?></td>
		            <td><?php $tax_n2 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n2,0,',','.'); ?></td>
		            <td><?php $tax_y3 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y3,0,',','.'); ?></td>
		            <td><?php $tax_n3 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n3,0,',','.'); ?></td>
		            <td><?php $tax_y4 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y4,0,',','.'); ?></td>
		            <td><?php $tax_n4 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n4,0,',','.'); ?></td>
		            <td><?php $tax_y5 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y5,0,',','.'); ?></td>
		            <td><?php $tax_n5 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n5,0,',','.'); ?></td>
		            <td><?php $tax_y6 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y6,0,',','.'); ?></td>
		            <td><?php $tax_n6 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n6,0,',','.'); ?></td>
		            <td><?php $tax_y7 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y7,0,',','.'); ?></td>
		            <td><?php $tax_n7 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n7,0,',','.'); ?></td>
		            <td><?php $tax_y8 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y8,0,',','.'); ?></td>
		            <td><?php $tax_n8 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n8,0,',','.'); ?></td>
		            <td><?php $tax_y9 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y9,0,',','.'); ?></td>
		            <td><?php $tax_n9 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n9,0,',','.'); ?></td>
		            <td><?php $tax_y10 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y10,0,',','.'); ?></td>
		            <td><?php $tax_n10 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n10,0,',','.'); ?></td>
		            <td><?php $tax_y11 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y11,0,',','.'); ?></td>
		            <td><?php $tax_n11 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n11,0,',','.'); ?></td>
		            <td><?php $tax_y12 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y12,0,',','.'); ?></td>
		            <td><?php $tax_n12 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n12,0,',','.'); ?></td>
		            <td><?php $tax_y = $tax_y1+$tax_y2+$tax_y3+$tax_y4+$tax_y5+$tax_y6+$tax_y7+$tax_y8+$tax_y9+$tax_y10+$tax_y11+$tax_y12; echo number_format($tax_y,0,',','.'); ?></td>
		            <td><?php $tax_n = $tax_n1+$tax_n2+$tax_n3+$tax_n4+$tax_n5+$tax_n6+$tax_n7+$tax_n8+$tax_n9+$tax_n10+$tax_n11+$tax_n12; echo number_format($tax_n,0,',','.'); ?></td>
		          </tr>
		      <?php } ?>
		      </tbody>
		    </table>
  		</div>
		<?php
   			} else {
   		?>
   		<div id="yearly_detail" class="report_overflow">
		    <table class="table fpTable table-hover">
		      <thead>
		        <tr>
		          <th rowspan="2">Cabang</th>
		          <th rowspan="2">Staff</th>
		          <th rowspan="2">Department</th>
		          <th rowspan="2">Title</th>
		          <th colspan="2">Januari</th>
		          <th colspan="2">Februari</th>
		          <th colspan="2">Maret</th>
		          <th colspan="2">April</th>
		          <th colspan="2">Mei</th>
		          <th colspan="2">Juni</th>
		          <th colspan="2">Juli</th>
		          <th colspan="2">Agustus</th>
		          <th colspan="2">September</th>
		          <th colspan="2">Oktober</th>
		          <th colspan="2">November</th>
		          <th colspan="2">Desember</th>
		          <th colspan="2">Total</th>
		        </tr>
		        <tr>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		          <th>Company</th>
		          <th>Personal</th>
		        </tr>
		      </thead>
		      <tbody>
		      <?php
		      $branch = '';
		      foreach ($staff_branch->result() as $row) {
		      	$pph = get_total_monthly_tax($row->staff_id);
		      ?>
		          <tr>
		            <td><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
		            <td><?php echo $row->staff_name; ?></td>
		            <td><?php echo $row->staff_departement; ?></td>
		            <td><?php echo $row->staff_jabatan; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($pph*12,0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format($pph*12,0,',','.'):'-'; ?></td>
		          </tr>
		      <?php } ?>
		      </tbody>
		    </table>
  		</div>
		<?php	
   			}
    	}
    	?>
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
			<h3 id="myModalLabel">PPh 21 Report</h3>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="span10">
				    <?php
			    	if ($period_by_selected == 'Monthly') {
			    	?>
					<table width="1500px;" style="border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;">
				      <thead>
				        <tr>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Cabang</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Staff</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Department</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Title</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">PPh 21</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Total PPh</th>
				        </tr>
				        <tr>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Perusahaan</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Pribadi</th>
				        </tr>
				      </thead>
				      <tbody>
				      <?php
				      $branch = '';
				      foreach ($staff_branch->result() as $row) {
				      	$pph = get_total_monthly_tax($row->staff_id);
				      ?>
				          <tr>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_name; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_departement; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_jabatan; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a = get_total_component_a($row->staff_id,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); $total_b = get_total_component_b($row->staff_id,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); $grand = ($total_a+$total_b); echo $grand; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo number_format($pph,0,',','.'); ?></td>
				          </tr>
				      <?php } ?>
				      </tbody>
				    </table>
				    <?php
				    } else if ($period_by_selected == 'Yearly') {
    					if ($yearly_by_selected == 'Branch') {
				    ?>
				    <table width="1500px;" style="border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;">
				      <thead>
				        <tr>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  rowspan="2">Cabang</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">Januari</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">Februari</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">Maret</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">April</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">Mei</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">Juni</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">Juli</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">Agustus</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">September</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">Oktober</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">November</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">Desember</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"  colspan="2">Total</th>
				        </tr>
				        <tr>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" >Personal</th>
				        </tr>
				      </thead>
				      <tbody>
				      <?php
				      foreach ($branches->result() as $row) {
				      ?>
				          <tr>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php echo $row->branch_name; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y1 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y1,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n1 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n1,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y2 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y2,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n2 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n2,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y3 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y3,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n3 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n3,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y4 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y4,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n4 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n4,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y5 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y5,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n5 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n5,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y6 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y6,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n6 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n6,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y7 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y7,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n7 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n7,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y8 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y8,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n8 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n8,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y9 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y9,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n9 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n9,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y10 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y10,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n10 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n10,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y11 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y11,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n11 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n11,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y12 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y12,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n12 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_n12,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_y = $tax_y1+$tax_y2+$tax_y3+$tax_y4+$tax_y5+$tax_y6+$tax_y7+$tax_y8+$tax_y9+$tax_y10+$tax_y11+$tax_y12; echo number_format($tax_y,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" ><?php $tax_n = $tax_n1+$tax_n2+$tax_n3+$tax_n4+$tax_n5+$tax_n6+$tax_n7+$tax_n8+$tax_n9+$tax_n10+$tax_n11+$tax_n12; echo number_format($tax_n,0,',','.'); ?></td>
				          </tr>
				      <?php } ?>
				      </tbody>
				    </table>
				    <?php
				    	} else {
		    		?>
		    		<table width="1500px;" style="border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;">
				      <thead>
				        <tr>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Cabang</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Staff</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Department</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Title</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Januari</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Februari</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Maret</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">April</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Mei</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Juni</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Juli</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Agustus</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">September</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Oktober</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">November</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Desember</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Total</th>
				        </tr>
				        <tr>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Company</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Personal</th>
				        </tr>
				      </thead>
				      <tbody>
				      <?php
				      $branch = '';
				      foreach ($staff_branch->result() as $row) {
				      	$pph = get_total_monthly_tax($row->staff_id);
				      ?>
				          <tr>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_name; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_departement; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_jabatan; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($pph*12,0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format($pph*12,0,',','.'):'-'; ?></td>
				          </tr>
				      <?php } ?>
				      </tbody>
				    </table>
		    		<?php
				    	}
			    	}
				    ?>
		  		</div>
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

<?php get_footer(); ?>