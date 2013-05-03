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
				Airlines <small>Manage Airlines</small>
			</h1>
		</div>
		<br class="cl" />
		<div class="head blue">
			<?php echo header_btn_group("#", "airline/add"); ?>
		</div>
		<div id="search_bar" class="widget-header">
			<?php search_form(array("" => "By", "asset_name" => "Name")); ?>
		</div>

		<table class="fpTable table table-hover">
			<thead>
				<tr>
					<th width="20%"><?php sorter_link("airline/index", "name", $order, "Name"); ?>
					</th>
					<th width="25%"><?php sorter_link("airline/index", "address", $order, "Address"); ?>
					</th>
					<th width="15%"><?php sorter_link("airline/index", "phone", $order, "Phone"); ?>
					</th>
					<th width="15%"><?php sorter_link("airline/index", "fax", $order, "Fax"); ?>
					</th>
					<th width="15%"><?php sorter_link("airline/index", "email", $order, "Email"); ?>
					</th>
					<th width="5%">CP</th>
					<th width="5%">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($airline->result() as $row): ?>
				<tr>
					<td><?php echo $row->name; ?></td>
					<td><?php echo $row->address; ?></td>
					<td><?php echo $row->phone; ?></td>
					<td><?php echo $row->fax; ?></td>
					<td><?php echo $row->email; ?></td>
					<td style="text-align: center;"><?php echo anchor("#", "CP", array("class"=>"show_cp btn btn-primary", "data-id"=>$row->id))?>
					</td>
					<td>
						<div class="btn-group">
							<a href="#" data-toggle="dropdown"
								class="btn btn-mini dropdown-toggle"> <i class="icon-cog"></i> <span
								class="caret"></span>
							</a>
							<ul class="dropdown-menu pull-right">
								<li><?php echo anchor('airline/edit/' . $row->id, '<i class="icon-pencil"></i> Edit'); ?>
								</li>
								<li><?php echo anchor('airline/delete/' . $row->id, '<i class="icon-trash"></i> Delete', array("class"=>"delete")); ?>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot class="foot_pagi">
				<tr>
					<th colspan="7"><?php echo $this->pagination->create_links(); ?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php get_footer(); ?>
