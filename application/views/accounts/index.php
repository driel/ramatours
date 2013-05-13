<?php get_header(); ?>

<div class="body">
    <div class="content">
        <?php echo $this->session->flashdata('message'); ?>
        <div class="page-header">
            <div class="icon">
                <span class="ico-tag"></span>
            </div>
            <h1>Chart of Account
                <small>Manage Chart of Account</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group("#", "accounts/add"); ?>
        </div>
        <div id="search_bar" class="widget-header">
            <?php search_form(array("" => "By", "glacc_no" => "No", "glacc_name" => "Name")); ?>
        </div>
        <table class="table fpTable table-hover">
            <thead>
                <tr>
                    <th width="25%">Parent</th>
                    <th width="10%">Parent Status</th>
                    <th width="25%">Account No</th>
                    <th width="35%">Account Name</th>
                    <th width="5%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($account_list as $row) {
              $parent = $account->where('glacc_id', $row->glacc_parent)->get();
            ?>
                <tr>
                    <td><?php echo $parent->glacc_no; ?></td>
                    <td><?php echo strtoupper($row->glacc_parent_stat); ?></td>
                    <td><?php echo $row->glacc_parent_stat == 'y' && $row->glacc_parent == 0? $row->glacc_no:($row->glacc_parent_stat == 'y' && $row->glacc_parent > 0? '&nbsp;&nbsp;&nbsp;&nbsp;'.$row->glacc_no:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row->glacc_no); ?></td>
                    <td><?php echo $row->glacc_parent_stat == 'y' && $row->glacc_parent == 0? $row->glacc_name:($row->glacc_parent_stat == 'y' && $row->glacc_parent > 0? '&nbsp;&nbsp;&nbsp;&nbsp;'.$row->glacc_name:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row->glacc_name); ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                                <i class="icon-cog"></i>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><?php echo anchor('accounts/edit/' . $row->glacc_id, '<i class="icon-pencil"></i> Edit'); ?></li>
                                <li><?php echo anchor('accounts/delete/' . $row->glacc_id, '<i class="icon-trash"></i> Delete', array('onclick' => "return confirm('Are you sure want to delete?')")); ?></li>
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
                <?php echo $pagination; ?>
            </ul>
        </div>
    </div>
</div>
<?php get_footer(); ?>
