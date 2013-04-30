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
  		document.location.href = '<?php echo site_url('components/report_detail').'?'.$_SERVER['QUERY_STRING'].'&to=pdf'; ?>';
  	});

  	$("#printXLS").click(function() {
  		document.location.href = '<?php echo site_url('components/report_detail').'?'.$_SERVER['QUERY_STRING'].'&to=xls'; ?>';
  	});

  	$("#printPDFSlipGaji").click(function() {
  		document.location.href = "<?php echo site_url("components/slip_gaji/");?>/"+$("#staff_id").val()+"/"+$("#staff_period").val()+"/?to=pdf";
  	});
});

function printSlipGaji(staff_id,period) {
	$.ajax({
        url     : "<?php echo site_url("components/slip_gaji/");?>/"+staff_id+"/"+period,
        success : function(data) {
        	$("#slipBody").html(data);
        }
    });
    $('#printSlipGajiModal').modal('show');
}
</script>
<!-- Modal -->
<div id="printSlipGajiModal" class="modal hide fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Slip Gaji</h3>
	</div>
	<div id="slipBody" class="modal-body"></div>
	<div class="modal-footer">
		<button id="printPDFSlipGaji" class="btn btn-primary">Save</button>
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>
<div class="body">
  <div class="content">
    <?php echo $this->session->flashdata('message'); ?>
    <div class="page-header">
      <div class="icon">
        <span class="ico-coins"></span>
      </div>
      <h1>Salary
      <small>Detail Salary Report</small>
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
	     				<td><?php echo $period; ?></td>
	   				</tr>
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
		<div class="span10" style="width: 970px; overflow: auto;">
		    <table class="table fpTable table-hover">
		      <thead>
		        <tr>
		          <th rowspan="2">Cabang</th>
		          <th rowspan="2">Staff</th>
		          <th rowspan="2">Department</th>
		          <th rowspan="2">Title</th>
		          <th colspan="3">Daftar Absensi</th>
		          <th rowspan="2">Total A</th>
		          <th rowspan="2">Total B</th>
		          <th rowspan="2">Grand</th>
		          <th colspan="2">PPh</th>
		          <th rowspan="2">Net</th>
		          <th rowspan="2">Slip Gaji</th>
		        </tr>
		        <tr>
		          <th>Absen</th>
		          <th>Cuti</th>
		          <th>Izin</th>
		          <th>Perusahaan</th>
		          <th>Pribadi</th>
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
		            <td><?php echo $row->hari_masuk; ?></td>
		            <td><?php echo floor((strtotime($row->date_end)-strtotime($row->date_start))/(60*60*24)); ?></td>
		            <td><?php echo $row->izin_jumlah_hari; ?></td>
		            <td><?php $total_a = get_total_component_a($row->staff_id,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); echo number_format($total_a,0,',','.'); ?></td>
		            <td><?php $total_b = get_total_component_b($row->staff_id,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); echo number_format($total_b,0,',','.'); ?></td>
		            <td><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'n'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
		            <td><?php echo $row->pph_by_company == 'y'? number_format($grand,0,',','.'):number_format(($grand-get_total_monthly_tax($row->staff_id)),0,',','.'); ?></td>
		            <td><a href="javascript:printSlipGaji('<?php echo $row->staff_id; ?>','<?php echo $this->input->get('period') == ''? $period_selected:$this->input->get('period');?>');" class="btn btn-primary">Cetak</a></td>
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
			<h3 id="myModalLabel">Detail Salary Report</h3>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="span10">
				    <table width="1500px;" style="border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;">
				      <thead>
				        <tr>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Cabang</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Staff</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Title</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="3">Daftar Absensi</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Total A</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Total B</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Grand</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">PPh</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Net</th>
				        </tr>
				        <tr>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Absen</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Cuti</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Izin</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Perusahaan</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Pribadi</th>
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
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_jabatan; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->hari_masuk; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo floor((strtotime($row->date_end)-strtotime($row->date_start))/(60*60*24)); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->izin_jumlah_hari; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_a = get_total_component_a($row->staff_id,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); echo number_format($total_a,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $total_b = get_total_component_b($row->staff_id,$this->input->get('period') == ''? $period_selected:$this->input->get('period')); echo number_format($total_b,0,',','.'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'n'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->pph_by_company == 'y'? number_format($grand,0,',','.'):number_format(($grand-get_total_monthly_tax($row->staff_id)),0,',','.'); ?></td>
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