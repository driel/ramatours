<?php get_header(); ?>

<?php echo load_js("search_date.php"); ?>

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
            <h1>Entry Journal
                <small>Manage Entry Journal</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group("#", "journal/add"); ?>
        </div>
        <div id="search_bar" class="widget-header">
            <?php search_form(array("" => "By", "gltr_date" => "Date")); ?>
        </div>
        <table class="table fpTable table-hover">
            <thead>
                <tr>
                    <th width="25%">Date</th>
                    <th>Voucher</th>
                    <th>Status</th>
                    <th width="5%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($journal->result() as $row) {
            ?>
                <tr>
                    <td><?php echo bulan_full(substr($row->gltr_date,4)).' '.substr($row->gltr_date,0,4); ?></td>
                    <td><?php echo $row->gltr_voucher; ?></td>
                    <td><?php echo $row->gltr_status; ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                                <i class="icon-cog"></i>
                                <span class="caret"></span>
                            </a>
                            <?php
                            if ($row->gltr_status == "Open") {
                            ?>
                            <ul class="dropdown-menu pull-right">
                                <li><?php echo anchor('journal/edit/' . $row->gltr_id, '<i class="icon-pencil"></i> Edit'); ?></li>
                                <li><?php echo anchor('journal/delete/' . $row->gltr_id, '<i class="icon-trash"></i> Delete', array('onclick' => "return confirm('Are you sure want to delete?')")); ?></li>
                            </ul>
                            <?php
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            <?php
			}
			?>
            </tbody>
        </table>
        <div class="clearfix"></div>
        <br/>
        <div class="pagination pagination-right">
            <ul>
                <?php echo $this->pagination->create_links(); ?>
            </ul>
        </div>
    </div>
</div>
<?php get_footer(); ?>