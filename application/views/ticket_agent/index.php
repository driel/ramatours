<?php get_header(); ?>
<script>
$(window).load(function(){
	$(".customscroll").mCustomScrollbar({
	  horizontalScroll: true
	});
});
</script>
<div class="body">
	<div class="content customscroll" style="overflow: auto;">
		<?php 
		if($this->session->flashdata('denied')) echo error_box($this->session->flashdata('denied'));
		if($this->session->flashdata('message')) echo success_box($this->session->flashdata('message'));
		?>
		<div class="page-header">
			<div class="icon">
				<span class="ico-tag"></span>
			</div>
			<h1>
				Ticket agent <small>Manage Ticket agent</small>
			</h1>
		</div>
		<br class="cl" />
		<div class="head blue">
			<?php echo header_btn_group("#", "ticket_agent/add"); ?>
		</div>
		<div id="search_bar" class="widget-header">
			<?php search_form(array("" => "By", "tixa_code" => "Code", "tixa_name"=>"Name")); ?>
		</div>
		<table class="table fpTable table-hover">
			<thead>
				<tr>
					<th width="80"><?php sorter_link("ticket_agent/index", "tixa_code", $order, "Code"); ?>
					</th>
					<th width="150"><?php sorter_link("ticket_agent/index", "tixa_name", $order, "Name"); ?>
					</th>
					<th width="250"><?php sorter_link("ticket_agent/index", "tixa_address", $order, "Address"); ?>
					</th>
					<th width="100"><?php sorter_link("ticket_agent/index", "tixa_city", $order, "City"); ?>
					</th>
					<th width="80"><?php sorter_link("ticket_agent/index", "tixa_since", $order, "Since"); ?>
					</th>
					<th width="80"><?php sorter_link("ticket_agent/index", "tixa_disable_date", $order, "Disable on"); ?>
					</th>
					<th width="120"><?php sorter_link("ticket_agent/index", "tixa_credit_limit_rp", $order, "Credit Limit (Rp)"); ?>
					</th>
					<th width="120"><?php sorter_link("ticket_agent/index", "tixa_credit_limit_us", $order, "Credit Limit (US$)"); ?>
					</th>
					<th width="100"><?php sorter_link("ticket_agent/index", "tixa_glacc_dr", $order, "GL Acc DR No"); ?>
					</th>
					<th width="100"><?php sorter_link("ticket_agent/index", "tixa_glacc_cr", $order, "GL Acc CR No"); ?>
					</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if($agents->num_rows() > 0): ?>
				<?php foreach($agents->result() as $row): ?>
				<?php 
				  $dr = get_account_detail($row->tixa_glacc_dr);
				  $cr = get_account_detail($row->tixa_glacc_cr);
				?>
				<tr>
					<td><?php echo $row->tixa_code; ?></td>
					<td><?php echo $row->tixa_name; ?></td>
					<td><?php echo $row->tixa_address; ?></td>
					<td><?php echo $row->tixa_city; ?></td>
					<td><?php echo $row->tixa_since; ?></td>
					<td><?php echo $row->tixa_disable_date; ?></td>
					<td><?php echo number_format($row->tixa_credit_limit_rp, 2, ".", ","); ?>
					</td>
					<td><?php echo number_format($row->tixa_credit_limit_us, 2, ".", ","); ?>
					</td>
					<td><?php echo $dr->glacc_no; ?></td>
					<td><?php echo $cr->glacc_no; ?></td>
					<td>
						<div class="btn-group">
							<a href="#" data-toggle="dropdown"
								class="btn btn-mini dropdown-toggle"> <i class="icon-cog"></i> <span
								class="caret"></span>
							</a>
							<ul class="dropdown-menu pull-right">
								<li><?php echo anchor('ticket_agent/edit/' . $row->tixa_id, '<i class="icon-pencil"></i> Edit'); ?>
								</li>
								<li><?php echo anchor('ticket_agent/delete/' . $row->tixa_id, '<i class="icon-trash"></i> Delete', array('class' => "delete")); ?>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td colspan="11" class="no-data">No Data yet</td>
				</tr>
				<?php endif; ?>
			</tbody>
			<tfoot class="foot_pagi">
				<tr>
					<th colspan="11"><?php echo $this->pagination->create_links(); ?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php get_footer(); ?>
