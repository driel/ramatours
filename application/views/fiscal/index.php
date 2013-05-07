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
            <h1>Kurs Pajak
                <small>Manage Kurs Pajak</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group("#", "fiscal/add"); ?>
        </div>
        <div id="search_bar" class="widget-header">
            <?php search_form(array("" => "By", "kurs_date" => "Kurs Date")); ?>
        </div>
        <table class="table fpTable table-hover">
            <thead>
                <tr>
                    <th width="25%"><?php sorter_link("fiscal/index", "kurs_date", $order, "Kurs Date"); ?></th>
                    <th>Kurs US</th>
                    <th>Kurs Yen</th>
                    <th width="5%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($fiscal->result() as $row) {
            ?>
                <tr>
                    <td><?php echo $row->kurs_date; ?></td>
                    <td><?php echo number_format($row->kurs_us_rp,0,"","."); ?></td>
                    <td><?php echo number_format($row->kurs_yen_rp,0,"","."); ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                                <i class="icon-cog"></i>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><?php echo anchor('fiscal/edit/' . $row->kurs_id, '<i class="icon-pencil"></i> Edit'); ?></li>
                                <li><?php echo anchor('fiscal/delete/' . $row->kurs_id, '<i class="icon-trash"></i> Delete', array('onclick' => "return confirm('Are you sure want to delete?')")); ?></li>
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