<?php get_header(); ?>
<?php

function HeaderLink($value, $key, $col, $dir) {
    $out = "<a href=\"" . site_url('users/roles') . "?c=";
    //set column query string value
    switch ($key) {
        case "role_name":
            $out .= "1";
            break;
        case "role_id":
            $out .= "2";
            break;
        default:
            $out .= "0";
    }

    $out .= "&d=";

    //reverse sort if the current column is clicked
    if ($key == $col) {
        switch ($dir) {
            case "ASC":
                $out .= "1";
                break;
            default:
                $out .= "0";
        }
    } else {
        //pass on current sort direction
        switch ($dir) {
            case "ASC":
                $out .= "0";
                break;
            default:
                $out .= "1";
        }
    }

    //complete link
    $out .= "\">$value</a>";

    return $out;
}
?>
<div class="body">
    <div class="content">
        <?php echo $this->session->flashdata('message'); ?>
        <div class="page-header">
            <div class="icon">
                <span class="ico-tag"></span>
            </div>
            <h1>Listing Role
                <small>Manage title</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group("#", "users/add_role"); ?>
        </div>
        <div id="search_bar" class="widget-header">
            <?php search_form(array("" => "By", "role_name" => "Name")); ?>
        </div>

        <table class="table fpTable table-hover">
            <thead>
                <tr>
                    <th width="15%"><?php echo HeaderLink("Role ID", "role_id", $col, $dir); ?></th>
                    <th width="80%"><?php echo HeaderLink("Role Name", "role_name", $col, $dir); ?></th>
                    <th width="5%">Action</th>
                </tr>
            </thead>
            <?php
            foreach ($role_list as $row) {
            ?>
                <tr>
                    <td><?php echo $row->role_id; ?></td>
                    <td><?php echo $row->role_name; ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                                <i class="icon-cog"></i>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <!-- <li><?php echo anchor('users/roles/' . $row->role_id . '/role_details/index/', '<i class="icon-list"></i> Add Privileges'); ?></li> -->
                                <li><?php echo anchor('users/edit_role/' . $row->role_id, '<i class="icon-pencil"></i> Edit'); ?></li>
                                <li><?php echo anchor('users/delete_role/' . $row->role_id, '<i class="icon-trash"></i> Delete', array('onclick' => "return confirm('Are you sure want to delete?')")); ?></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <br>
        <?php echo $pagination; ?>
            <br>

        </div>
    </div>
<?php get_footer(); ?>
