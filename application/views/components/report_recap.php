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
			$("#filter_monthly").show();
			$("#filter_yearly").hide();
		} else {
			$("#by_monthly").hide();
			$("#by_yearly").show();
			$("#filter_monthly").hide();
			$("#filter_yearly").show();
		}
	});

  	$("#printPDF").click(function() {
  		document.location.href = '<?php echo site_url('components/report_recap').'?'.$_SERVER['QUERY_STRING'].'&to=pdf'; ?>';
  	});

  	$("#printXLS").click(function() {
  		document.location.href = '<?php echo site_url('components/report_recap').'?'.$_SERVER['QUERY_STRING'].'&to=xls'; ?>';
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
      <h1>Salary
      <small>Salary Recapitulation Report</small>
      </h1>
    </div>
    <br class="cl" />
    <div class="head blue">
      <?php echo header_btn_group_report();?>
    </div>
    <div id="search_bar" class="widget-header">
    	<?php
  		//var_dump($this->input->get());
      	$block = $this->input->get() != false ? ' style="display:block"':'';
  		?>
  		<div id="filtering"<?php echo $block; ?>>
	      	<form action="" method="get">
	      		<table width="30%" align="center">
	      			<tr>
	      				<td><span class="search_by">Period</span></td>
	     				<td><?php echo $period_by; ?></td>
	   				</tr>
	      			<tr id="by_monthly" <?php echo $this->input->get('period_by') == 'Yearly'? 'style="display:none;"':'';?>>
	      				<td><span class="search_by">&nbsp;</span></td>
	     				<td><?php echo $period; ?></td>
	   				</tr>
	      			<tr id="by_yearly" <?php echo $this->input->get('period_by') == 'Yearly'? '':'style="display:none;"';?>>
	      				<td><span class="search_by">&nbsp;</span></td>
	     				<td><?php echo $yearly ;?></td>
	   				</tr>
	      			<tr id="filter_monthly" <?php echo $this->input->get('period_by') == 'Yearly'? 'style="display:none;"':'';?>>
	      				<td><span class="search_by">Branch</span></td>
	     				<td><?php echo $branch; ?></td>
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
	    	</form>
    	</div>
    </div>
    <br />
    <div class="row">
    	<?php
    	if ($period_by_selected == 'Monthly') {
    	?>
		<div id="monthly_detail" class="report_overflow">
		    <table class="table fpTable table-hover">
		      <thead>
		        <tr>
		          <th rowspan="2">Cabang</th>
		          <th rowspan="2">Total A</th>
		          <th rowspan="2">Total B</th>
		          <th rowspan="2">Grand</th>
		          <th colspan="2">PPh</th>
		          <th rowspan="2">Net</th>
		        </tr>
		        <tr>
		          <th>Perusahaan</th>
		          <th>Pribadi</th>
		        </tr>
		      </thead>
		      <tbody>
		      <?php
		      foreach ($branches->result() as $row) {
		      ?>
		          <tr>
		            <td><?php echo $row->branch_name; ?></td>
		            <td><?php $total_a = get_branch_recap_component_a($row->branch_name,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); echo number_format($total_a,0,',','.'); ?></td>
		            <td><?php $total_b = get_branch_recap_component_b($row->branch_name,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); echo number_format($total_b,0,',','.'); ?></td>
		            <td><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
		            <td><?php $tax_y = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y,0,',','.'); ?></td>
		            <td><?php $tax_n = get_branch_total_monthly_tax($row->branch_name,'n'); echo number_format($tax_n,0,',','.'); ?></td>
		            <td><?php echo number_format(($grand-$tax_y),0,',','.'); ?></td>
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
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		        </tr>
		      </thead>
		      <tbody>
		      <?php
		      foreach ($branches->result() as $row) {
		      ?>
		          <tr>
		            <td><?php echo $row->branch_name; ?></td>
		            <td><?php $total_a1 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-01'); $total_b1 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-01'); $grand1 = ($total_a1+$total_b1); echo $grand1; ?></td>
		            <td><?php $tax_y1 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand1 > 0? $grand1-$tax_y1:0),0,',','.'); ?></td>
		            <td><?php $total_a2 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-02'); $total_b2 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-02'); $grand2 = ($total_a2+$total_b2); echo $grand2; ?></td>
		            <td><?php $tax_y2 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand2 > 0? $grand2-$tax_y2:0),0,',','.'); ?></td>
		            <td><?php $total_a3 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-03'); $total_b3 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-03'); $grand3 = ($total_a3+$total_b3); echo $grand3; ?></td>
		            <td><?php $tax_y3 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand3 > 0? $grand3-$tax_y3:0),0,',','.'); ?></td>
		            <td><?php $total_a4 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-04'); $total_b4 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-04'); $grand4 = ($total_a4+$total_b4); echo $grand4; ?></td>
		            <td><?php $tax_y4 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand4 > 0? $grand4-$tax_y4:0),0,',','.'); ?></td>
		            <td><?php $total_a5 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-05'); $total_b5 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-05'); $grand5 = ($total_a5+$total_b5); echo $grand5; ?></td>
		            <td><?php $tax_y5 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand5 > 0? $grand5-$tax_y5:0),0,',','.'); ?></td>
		            <td><?php $total_a6 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-06'); $total_b6 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-06'); $grand6 = ($total_a6+$total_b6); echo $grand6; ?></td>
		            <td><?php $tax_y6 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand6 > 0? $grand6-$tax_y6:0),0,',','.'); ?></td>
		            <td><?php $total_a7 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-07'); $total_b7 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-07'); $grand7 = ($total_a7+$total_b7); echo $grand7; ?></td>
		            <td><?php $tax_y7 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand7 > 0? $grand7-$tax_y7:0),0,',','.'); ?></td>
		            <td><?php $total_a8 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-08'); $total_b8 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-08'); $grand8 = ($total_a8+$total_b8); echo $grand8; ?></td>
		            <td><?php $tax_y8 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand8 > 0? $grand8-$tax_y8:0),0,',','.'); ?></td>
		            <td><?php $total_a9 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-09'); $total_b9 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-09'); $grand9 = ($total_a9+$total_b9); echo $grand9; ?></td>
		            <td><?php $tax_y9 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand9 > 0? $grand9-$tax_y9:0),0,',','.'); ?></td>
		            <td><?php $total_a10 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-10'); $total_b10 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-10'); $grand10 = ($total_a10+$total_b10); echo $grand10; ?></td>
		            <td><?php $tax_y10 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand10 > 0? $grand10-$tax_y10:0),0,',','.'); ?></td>
		            <td><?php $total_a11 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-11'); $total_b11 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-11'); $grand11 = ($total_a11+$total_b11); echo $grand11; ?></td>
		            <td><?php $tax_y11 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand11 > 0? $grand11-$tax_y11:0),0,',','.'); ?></td>
		            <td><?php $total_a12 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-12'); $total_b12 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-12'); $grand12 = ($total_a12+$total_b12); echo $grand12; ?></td>
		            <td><?php $tax_y12 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand12 > 0? $grand12-$tax_y12:0),0,',','.'); ?></td>
		            <td><?php $total_a = $total_a1+$total_a2+$total_a4+$total_a5+$total_a6+$total_a7+$total_a8+$total_a9+$total_a10+$total_a11+$total_a12; $total_b = $total_b1+$total_b2+$total_b3+$total_b4+$total_b5+$total_b6+$total_b7+$total_b8+$total_b9+$total_b10+$total_b11+$total_b12; $grand = ($total_a+$total_b); echo $grand; ?></td>
		            <td><?php $tax_y = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand > 0? $grand-$tax_y:0),0,',','.'); ?></td>
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
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Grand</th>
		          <th rowspan="2">Net</th>
		        </tr>
		      </thead>
		      <tbody>
		      <?php
		      $branch = '';
		      foreach ($staff_branch->result() as $row) {
		      ?>
		          <tr>
		            <td><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
		            <td><?php echo $row->staff_name; ?></td>
		            <td><?php echo $row->staff_departement; ?></td>
		            <td><?php echo $row->staff_jabatan; ?></td>
		            <td><?php $total_a1 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-01'); $total_b1 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-01'); $grand1 = ($total_a1+$total_b1); echo $grand1; ?></td>
		            <td><?php $net1 = $grand1 > 0? ($grand1-get_total_monthly_tax($row->staff_id)):0; echo number_format($net1,0,',','.'); ?></td>
		            <td><?php $total_a2 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-02'); $total_b2 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-02'); $grand2 = ($total_a2+$total_b2); echo $grand2; ?></td>
		            <td><?php $net2 = $grand2 > 0? ($grand2-get_total_monthly_tax($row->staff_id)):0; echo number_format($net2,0,',','.'); ?></td>
		            <td><?php $total_a3 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-03'); $total_b3 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-03'); $grand3 = ($total_a3+$total_b3); echo $grand3; ?></td>
		            <td><?php $net3 = $grand3 > 0? ($grand3-get_total_monthly_tax($row->staff_id)):0; echo number_format($net3,0,',','.'); ?></td>
		            <td><?php $total_a4 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-04'); $total_b4 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-04'); $grand4 = ($total_a4+$total_b4); echo $grand4; ?></td>
		            <td><?php $net4 = $grand4 > 0? ($grand4-get_total_monthly_tax($row->staff_id)):0; echo number_format($net4,0,',','.'); ?></td>
		            <td><?php $total_a5 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-05'); $total_b5 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-05'); $grand5 = ($total_a5+$total_b5); echo $grand5; ?></td>
		            <td><?php $net5 = $grand5 > 0? ($grand5-get_total_monthly_tax($row->staff_id)):0; echo number_format($net5,0,',','.'); ?></td>
		            <td><?php $total_a6 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-06'); $total_b6 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-06'); $grand6 = ($total_a6+$total_b6); echo $grand6; ?></td>
		            <td><?php $net6 = $grand6 > 0? ($grand6-get_total_monthly_tax($row->staff_id)):0; echo number_format($net6,0,',','.'); ?></td>
		            <td><?php $total_a7 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-07'); $total_b7 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-07'); $grand7 = ($total_a7+$total_b7); echo $grand7; ?></td>
		            <td><?php $net7 = $grand7 > 0? ($grand7-get_total_monthly_tax($row->staff_id)):0; echo number_format($net7,0,',','.'); ?></td>
		            <td><?php $total_a8 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-08'); $total_b8 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-08'); $grand8 = ($total_a8+$total_b8); echo $grand8; ?></td>
		            <td><?php $net8 = $grand8 > 0? ($grand8-get_total_monthly_tax($row->staff_id)):0; echo number_format($net8,0,',','.'); ?></td>
		            <td><?php $total_a9 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-09'); $total_b9 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-09'); $grand9 = ($total_a9+$total_b9); echo $grand9; ?></td>
		            <td><?php $net9 = $grand9 > 0? ($grand9-get_total_monthly_tax($row->staff_id)):0; echo number_format($net9,0,',','.'); ?></td>
		            <td><?php $total_a10 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-10'); $total_b10 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-10'); $grand10 = ($total_a10+$total_b10); echo $grand10; ?></td>
		            <td><?php $net10 = $grand10 > 0? ($grand10-get_total_monthly_tax($row->staff_id)):0; echo number_format($net10,0,',','.'); ?></td>
		            <td><?php $total_a11 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-11'); $total_b11 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-11'); $grand11 = ($total_a11+$total_b11); echo $grand11; ?></td>
		            <td><?php $net11 = $grand11 > 0? ($grand11-get_total_monthly_tax($row->staff_id)):0; echo number_format($net11,0,',','.'); ?></td>
		            <td><?php $total_a12 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-12'); $total_b12 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-12'); $grand12 = ($total_a12+$total_b12); echo $grand12; ?></td>
		            <td><?php $net12 = $grand12 > 0? ($grand12-get_total_monthly_tax($row->staff_id)):0; echo number_format($net12,0,',','.'); ?></td>
		            <td><?php $total_a = $total_a1+$total_a2+$total_a3+$total_a4+$total_a5+$total_a6+$total_a7+$total_a8+$total_a9+$total_a10+$total_a11+$total_a12; $total_b = $total_b1+$total_b2+$total_b3+$total_b4+$total_b5+$total_b6+$total_b7+$total_b8+$total_b9+$total_b10+$total_b11+$total_b12; $grand = ($total_a+$total_b); echo $grand; ?></td>
		            <td><?php $net = $grand > 0? ($grand-(abs(get_total_monthly_tax($row->staff_id)*12))):0; echo number_format($net,0,',','.'); ?></td>
		          </tr>
		      <?php } ?>
		      </tbody>
		    </table>
  		</div>
		<?
    		}
   		?>
   		<?php
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
			<h3 id="myModalLabel">Salary Recapitulation Report</h3>
		</div>
		<div class="modal-body">
			<div class="row">
		    	<?php
		    	if ($period_by_selected == 'Monthly') {
		    	?>
				<div class="span10">
				    <table width="1500px;" style="border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;">
				      <thead>
				        <tr>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Cabang</th>
 						  <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Total A</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Total B</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">PPh</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				        </tr>
				        <tr>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Perusahaan</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Pribadi</th>
				        </tr>
				      </thead>
				      <tbody>
				      <?php
				      $branch = '';
				      foreach ($branches->result() as $row) {
				      ?>
				          <tr>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->branch_name; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a = get_branch_recap_component_a($row->branch_name,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); echo number_format($total_a,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_b = get_branch_recap_component_b($row->branch_name,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); echo number_format($total_b,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format($tax_y,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_n = get_branch_total_monthly_tax($row->branch_name,'n'); echo number_format($tax_n,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo number_format(($grand-$tax_y),0,',','.'); ?></td>
				          </tr>
				      <?php } ?>
				      </tbody>
				    </table>
		  		</div>
		  		<?php
	  			} else if ($period_by_selected == 'Yearly') {
    				if ($yearly_by_selected == 'Branch') {
				?>
				<div class="span10">
				    <table width="1500px;" style="border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;">
				      <thead>
				        <tr>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Cabang</th>
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
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				        </tr>
				      </thead>
				      <tbody>
				      <?php
				      foreach ($branches->result() as $row) {
				      ?>
				          <tr>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->branch_name; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a1 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-01'); $total_b1 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-01'); $grand1 = ($total_a1+$total_b1); echo $grand1; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y1 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand1 > 0? $grand1-$tax_y1:0),0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a2 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-02'); $total_b2 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-02'); $grand2 = ($total_a2+$total_b2); echo $grand2; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y2 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand2 > 0? $grand2-$tax_y2:0),0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a3 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-03'); $total_b3 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-03'); $grand3 = ($total_a3+$total_b3); echo $grand3; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y3 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand3 > 0? $grand3-$tax_y3:0),0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a4 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-04'); $total_b4 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-04'); $grand4 = ($total_a4+$total_b4); echo $grand4; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y4 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand4 > 0? $grand4-$tax_y4:0),0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a5 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-05'); $total_b5 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-05'); $grand5 = ($total_a5+$total_b5); echo $grand5; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y5 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand5 > 0? $grand5-$tax_y5:0),0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a6 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-06'); $total_b6 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-06'); $grand6 = ($total_a6+$total_b6); echo $grand6; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y6 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand6 > 0? $grand6-$tax_y6:0),0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a7 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-07'); $total_b7 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-07'); $grand7 = ($total_a7+$total_b7); echo $grand7; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y7 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand7 > 0? $grand7-$tax_y7:0),0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a8 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-08'); $total_b8 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-08'); $grand8 = ($total_a8+$total_b8); echo $grand8; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y8 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand8 > 0? $grand8-$tax_y8:0),0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a9 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-09'); $total_b9 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-09'); $grand9 = ($total_a9+$total_b9); echo $grand9; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y9 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand9 > 0? $grand9-$tax_y9:0),0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a10 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-10'); $total_b10 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-10'); $grand10 = ($total_a10+$total_b10); echo $grand10; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y10 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand10 > 0? $grand10-$tax_y10:0),0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a11 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-11'); $total_b11 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-11'); $grand11 = ($total_a11+$total_b11); echo $grand11; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y11 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand11 > 0? $grand11-$tax_y11:0),0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a12 = get_branch_recap_component_a($row->branch_name,$this->input->get('yearly').'-12'); $total_b12 = get_branch_recap_component_b($row->branch_name,$this->input->get('yearly').'-12'); $grand12 = ($total_a12+$total_b12); echo $grand12; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y12 = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand12 > 0? $grand12-$tax_y12:0),0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a = $total_a1+$total_a2+$total_a4+$total_a5+$total_a6+$total_a7+$total_a8+$total_a9+$total_a10+$total_a11+$total_a12; $total_b = $total_b1+$total_b2+$total_b3+$total_b4+$total_b5+$total_b6+$total_b7+$total_b8+$total_b9+$total_b10+$total_b11+$total_b12; $grand = ($total_a+$total_b); echo $grand; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $tax_y = get_branch_total_monthly_tax($row->branch_name,'y'); echo number_format(($grand > 0? $grand-$tax_y:0),0,',','.'); ?></td>
				          </tr>
				      <?php } ?>
				      </tbody>
				    </table>
    			</div>
				<?php
   					} else {
   				?>
				<div class="span10">
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
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
					          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
					        </tr>
					      </thead>
					      <tbody>
					      <?php
					      $branch = '';
					      foreach ($staff_branch->result() as $row) {
					      ?>
					          <tr>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_name; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_departement; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_jabatan; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a1 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-01'); $total_b1 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-01'); $grand1 = ($total_a1+$total_b1); echo $grand1; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net1 = $grand1 > 0? ($grand1-get_total_monthly_tax($row->staff_id)):0; echo number_format($net1,0,',','.'); ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a2 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-02'); $total_b2 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-02'); $grand2 = ($total_a2+$total_b2); echo $grand2; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net2 = $grand2 > 0? ($grand2-get_total_monthly_tax($row->staff_id)):0; echo number_format($net2,0,',','.'); ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a3 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-03'); $total_b3 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-03'); $grand3 = ($total_a3+$total_b3); echo $grand3; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net3 = $grand3 > 0? ($grand3-get_total_monthly_tax($row->staff_id)):0; echo number_format($net3,0,',','.'); ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a4 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-04'); $total_b4 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-04'); $grand4 = ($total_a4+$total_b4); echo $grand4; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net4 = $grand4 > 0? ($grand4-get_total_monthly_tax($row->staff_id)):0; echo number_format($net4,0,',','.'); ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a5 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-05'); $total_b5 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-05'); $grand5 = ($total_a5+$total_b5); echo $grand5; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net5 = $grand5 > 0? ($grand5-get_total_monthly_tax($row->staff_id)):0; echo number_format($net5,0,',','.'); ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a6 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-06'); $total_b6 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-06'); $grand6 = ($total_a6+$total_b6); echo $grand6; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net6 = $grand6 > 0? ($grand6-get_total_monthly_tax($row->staff_id)):0; echo number_format($net6,0,',','.'); ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a7 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-07'); $total_b7 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-07'); $grand7 = ($total_a7+$total_b7); echo $grand7; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net7 = $grand7 > 0? ($grand7-get_total_monthly_tax($row->staff_id)):0; echo number_format($net7,0,',','.'); ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a8 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-08'); $total_b8 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-08'); $grand8 = ($total_a8+$total_b8); echo $grand8; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net8 = $grand8 > 0? ($grand8-get_total_monthly_tax($row->staff_id)):0; echo number_format($net8,0,',','.'); ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a9 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-09'); $total_b9 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-09'); $grand9 = ($total_a9+$total_b9); echo $grand9; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net9 = $grand9 > 0? ($grand9-get_total_monthly_tax($row->staff_id)):0; echo number_format($net9,0,',','.'); ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a10 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-10'); $total_b10 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-10'); $grand10 = ($total_a10+$total_b10); echo $grand10; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net10 = $grand10 > 0? ($grand10-get_total_monthly_tax($row->staff_id)):0; echo number_format($net10,0,',','.'); ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a11 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-11'); $total_b11 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-11'); $grand11 = ($total_a11+$total_b11); echo $grand11; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net11 = $grand11 > 0? ($grand11-get_total_monthly_tax($row->staff_id)):0; echo number_format($net11,0,',','.'); ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a12 = get_total_component_a($row->staff_id,$this->input->get('yearly').'-12'); $total_b12 = get_total_component_b($row->staff_id,$this->input->get('yearly').'-12'); $grand12 = ($total_a12+$total_b12); echo $grand12; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net12 = $grand12 > 0? ($grand12-get_total_monthly_tax($row->staff_id)):0; echo number_format($net12,0,',','.'); ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a = $total_a1+$total_a2+$total_a3+$total_a4+$total_a5+$total_a6+$total_a7+$total_a8+$total_a9+$total_a10+$total_a11+$total_a12; $total_b = $total_b1+$total_b2+$total_b3+$total_b4+$total_b5+$total_b6+$total_b7+$total_b8+$total_b9+$total_b10+$total_b11+$total_b12; $grand = ($total_a+$total_b); echo $grand; ?></td>
					            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $net = $grand > 0? ($grand-(abs(get_total_monthly_tax($row->staff_id)*12))):0; echo number_format($net,0,',','.'); ?></td>
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