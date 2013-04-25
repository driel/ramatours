<?php get_header(); ?>
<style type="text/css">
.modal {
	width : 800px;
}
.modal-body{
  max-height: 800px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
  	$("#printPDF").click(function() {
  		document.location.href = '<?php echo base_url('components/report_recap').'?'.$_SERVER['QUERY_STRING'].'&to=pdf'; ?>';
  	});

  	$("#printXLS").click(function() {
  		document.location.href = '<?php echo base_url('components/report_recap').'?'.$_SERVER['QUERY_STRING'].'&to=xls'; ?>';
  	});
});
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
      	<form action="" method="get">
      		<?php
	      	$myUrl = 'http://'.$_SERVER['HTTP_HOST'];
			$requestUri = $_SERVER['REQUEST_URI'];
      		?>
      		<table width="30%" align="center">
      			<tr>
      				<td><span class="search_by">Period</span></td>
     				<td>
     					<div id="search">
		      				<?php
							  $requestUri = str_replace($period_selected,"",$requestUri);
					          echo anchor("$myUrl$requestUri", '<span class="ico-remove"></span>', array(
					            "class"=>"clear-search-report",
					            "data-placement"=>"top",
					            "data-title"=>"Clear search"
					          ));
						    ?>
					 		<?php echo $period; ?>
					 	</div>
					 </td>
   				</tr>
      			<tr>
      				<td><span class="search_by">Branch</span></td>
     				<td>
     					<div id="search">
		      				<?php
						      if(strlen($this->input->get('branch')) > 0){
								$requestUri = str_replace($this->input->get('branch'),"",$requestUri);
						        echo anchor("$myUrl$requestUri", '<span class="ico-remove"></span>', array(
						          "class"=>"clear-search-report",
						          "data-placement"=>"top",
						          "data-title"=>"Clear search"
						        ));
						      }
						    ?>
					 		<?php echo $branch; ?>
					 	</div>
					 </td>
   				</tr>
   				<tr>
   					<td>&nbsp;</td>
	      			<td><input type="submit" name="search" value="Search" class="btn btn-primary" /></td>
     			</tr>
	      	</table>
    	</form>
    </div>
    <div class="row">
		<div class="span10" style="width: 970px; overflow: auto;">
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
		      $branch = '';
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