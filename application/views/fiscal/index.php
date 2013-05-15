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
            <h1>Tahun Fiskal
                <small>Manage Tahun Fiskal</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group("#", "fiscal/add"); ?>
        </div>
        <div id="search_bar" class="widget-header">
            <?php search_form(array("" => "By", "fiskal_date" => "Fiskal Date")); ?>
        </div>
        <table class="table fpTable table-hover">
            <thead>
                <tr>
                    <th width="25%"><?php sorter_link("fiscal/index", "fiskal_date", $order, "Fiskal Date"); ?></th>
                    <th>Status</th>
                    <th>Earning</th>
                    <th width="5%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($fiscal->result() as $row) {
            ?>
                <tr>
                    <td><?php echo bulan_full(substr($row->fiskal_date,4)).' '.substr($row->fiskal_date,0,4); ?></td>
                    <td><?php echo $row->fiskal_status; ?></td>
                    <td><?php echo number_format($row->fiskal_retained_earning,0,"","."); ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                                <i class="icon-cog"></i>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><?php echo anchor('fiscal/edit/' . $row->fiskal_date, '<i class="icon-pencil"></i> Edit'); ?></li>
                                <li><?php echo anchor('fiscal/delete/' . $row->fiskal_date, '<i class="icon-trash"></i> Delete', array('onclick' => "return confirm('Are you sure want to delete?')")); ?></li>
                            </ul>
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