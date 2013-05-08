<?php get_header(); ?>
<div class="body">
	<div class="content">
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
					<th><?php sorter_link("ticket_agent/index", "tixa_code", $order, "Code"); ?>
					</th>
					<th><?php sorter_link("ticket_agent/index", "tixa_name", $order, "Name"); ?>
					</th>
					<th><?php sorter_link("ticket_agent/index", "tixa_address", $order, "Address"); ?>
					</th>
					<th><?php sorter_link("ticket_agent/index", "tixa_city", $order, "City"); ?>
					</th>
					<th><?php sorter_link("ticket_agent/index", "tixa_since", $order, "Since"); ?>
					</th>
					<th><?php sorter_link("ticket_agent/index", "tixa_disable_date", $order, "Disable on"); ?>
					</th>
					<th><?php sorter_link("ticket_agent/index", "tixa_credit_limit_rp", $order, "Credit Limit (Rp)"); ?>
					</th>
					<th><?php sorter_link("ticket_agent/index", "tixa_credit_limit_us", $order, "Credit Limit (US$)"); ?>
					</th>
					<th><?php sorter_link("ticket_agent/index", "tixa_glacc_dr", $order, "GL Acc DR"); ?>
					</th>
					<th><?php sorter_link("ticket_agent/index", "tixa_glacc_cr", $order, "GL Acc CR"); ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php if($agents->num_rows() > 0): ?>
				<?php foreach($agents->result() as $row): ?>
				<tr>
					<td><?php echo $row->tixa_code; ?></td>
					<td><?php echo $row->tixa_name; ?></td>
					<td><?php echo $row->tixa_address; ?></td>
					<td><?php echo $row->tixa_city; ?></td>
					<td><?php echo $row->tixa_since; ?></td>
					<td><?php echo $row->tixa_disable_date; ?></td>
					<td><?php echo $row->tixa_credit_limit_rp; ?></td>
					<td><?php echo $row->tixa_credit_limit_us; ?></td>
					<td><?php echo $row->tixa_glacc_dr; ?></td>
					<td><?php echo $row->tixa_glacc_cr; ?></td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td colspan="10" class="no-data">No Data yet</td>
				</tr>
				<?php endif; ?>
			</tbody>
			<tfoot class="foot_pagi">
				<tr>
					<th colspan="10"><?php echo $this->pagination->create_links(); ?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php get_footer(); ?>
