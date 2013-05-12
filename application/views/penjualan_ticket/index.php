<?php get_header(); ?>
<script>
$(window).load(function(){
	$(".customscroll").mCustomScrollbar({
		  horizontalScroll: true
	});
});
</script>
<div class="body" style="overflow: auto;">
	<div class="content customscroll" style="overflow: auto;">
		<?php 
		if(validation_errors()) echo error_box(validation_errors());
		if($this->session->flashdata('denied')) echo error_box($this->session->flashdata('denied'));
		if($this->session->flashdata('message')) echo success_box($this->session->flashdata('message'));
		?>
		<div class="page-header">
			<div class="icon">
				<span class="ico-tag"></span>
			</div>
			<h1>
				Ticketing Sales Transactions <small>Manage Ticketing Sales Transactions</small>
			</h1>
		</div>
		<br class="cl" />
		<div class="head blue">
			<?php echo header_btn_group("#", "penjualan_ticket/add"); ?>
		</div>
		<div id="search_bar" class="widget-header">
			<?php search_form(array("" => "By", "name" => "Name")); ?>
		</div>

		<table class="fpTable table table-hover" style="width: 1800px">
			<thead>
				<tr>
					<th width="150"><?php sorter_link("penjualan_ticket/index", "tix_branch_id", $order, "Branch"); ?>
					</th>
					<th width="200"><?php sorter_link("penjualan_ticket/index", "tix_staff", $order, "Staff"); ?>
					</th>
					<th width="100"><?php sorter_link("penjualan_ticket/index", "tix_tour_id", $order, "Tour ID"); ?>
					</th>
					<th width="150"><?php sorter_link("penjualan_ticket/index", "tix_invoice", $order, "Invoice No"); ?>
					</th>
					<th width="200"><?php sorter_link("penjualan_ticket/index", "tix_date_time", $order, "Date"); ?>
					</th>
					<th width="200"><?php sorter_link("penjualan_ticket/index", "tix_agent_id", $order, "Agent"); ?>
					</th>
					<th width="200"><?php sorter_link("penjualan_ticket/index", "tix_name", $order, "Name"); ?>
					</th>
					<th width="350"><?php sorter_link("penjualan_ticket/index", "tix_address", $order, "Address"); ?>
					</th>
					<th width="150"><?php sorter_link("penjualan_ticket/index", "tix_due_date", $order, "Due date"); ?>
					</th>
					<th width="150"><?php sorter_link("penjualan_ticket/index", "tix_biaya_surcharge", $order, "Surcharge fee"); ?>
					</th>
					<th width="150"><?php sorter_link("penjualan_ticket/index", "tix_kurs_pajak", $order, "Kurs pajak"); ?>
					</th>
					<th width="100"><?php sorter_link("penjualan_ticket/index", "tix_status", $order, "Status"); ?>
					</th>
					<th width="100"><?php sorter_link("penjualan_ticket/index", "tix_glacc_dr", $order, "GL Acc DR"); ?>
					</th>
					<th width="100"><?php sorter_link("penjualan_ticket/index", "tix_glacc_cr", $order, "GL Acc CR"); ?>
					</th>
					<th width="50">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if($penjualan->num_rows() > 0) :?>
				<?php foreach($penjualan->result() as $row): 
				  $staff = get_staff_detail($row->tix_staff);
				  $branch = get_branch_detail($row->tix_branch_id);
				  $agent = get_agent_detail($row->tix_agent_id);
				?>
				<tr>
					<td><?php echo $branch->branch_name; ?></td>
					<td><?php echo $staff->staff_name; ?></td>
					<td><?php echo $row->tix_tour_id; ?></td>
					<td><?php echo $row->tix_invoice_no; ?></td>
					<td><?php echo $row->tix_date_time; ?></td>
					<td><?php echo $agent ? $agent->tixa_name:'-'; ?></td>
					<td><?php echo $row->tix_name ?></td>
					<td><?php echo $row->tix_address ?></td>
					<td><?php echo $row->tix_due_date ?></td>
					<td><?php echo $row->tix_biaya_surcharge_rp ?></td>
					<td><?php echo $row->tix_kurs_pajak ?></td>
					<td><?php echo $row->tix_status ?></td>
					<td><?php echo $row->tix_glaccno_dr ?></td>
					<td><?php echo $row->tix_glaccno_cr ?></td>
					<td>
						<div class="btn-group">
							<a href="#" data-toggle="dropdown"
								class="btn btn-mini dropdown-toggle"> <i class="icon-cog"></i> <span
								class="caret"></span>
							</a>
							<ul class="dropdown-menu pull-right">
								<li><?php echo anchor('penjualan_ticket/edit/' . $row->tix_id, '<i class="icon-pencil"></i> Edit'); ?>
								</li>
								<li><?php echo anchor('penjualan_ticket/delete/' . $row->tix_id, '<i class="icon-trash"></i> Delete', array("class"=>"delete")); ?>
								</li>
								<li><?php echo anchor('penjualan_ticket/print/' . $row->tix_id, '<i class="icon-print"></i> Print'); ?>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td colspan="15" class="no-data">No Data yet</td>
				</tr>
				<?php endif; ?>
			</tbody>
			<tfoot class="foot_pagi">
				<tr>
					<th colspan="15"><?php echo $this->pagination->create_links(); ?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php get_footer(); ?>
