<?php get_header(); ?>
<?php

function HeaderLink($value, $key, $col, $dir) {
    $out = "<a href=\"" . site_url('users') . "?c=";
    //set column query string value
    switch ($key) {
        case "branch_name":
            $out .= "1";
            break;
        case "branch_id":
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
        <?php if(strlen($this->session->flashdata('message')) > 0) echo success_box($this->session->flashdata('message')); ?>
        <div class="page-header">
            <div class="icon">
                <span class="ico-site-map"></span>
            </div>
            <h1>Users
                <small>Manage users</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group("users/to_excel", "users/sign_up"); ?>
        </div>
        <div id="search_bar" class="widget-header">
            <?php search_form(array("" => "By", "username" => "Username")); ?>
        </div>
        <table class="table fpTable table-hover">
            <thead>
                <tr>
                    <th width="45%">User ID</th>
                    <th width="45%">Username</th>
                    <th width="45%">Role</th>
                    <th width="10%" colspan="2" class="action_cell">Action</th>
                </tr>
            </thead>
            <?php
            foreach ($user_list as $row) {
            ?>
                <tr>
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->username; ?></td>
                    <td><?php echo $row->role_id; ?></td>
                    <td>
                    <div class="btn-group">
                      <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                        <i class="icon-cog"></i>
                        <span class="caret"></span>
                      </a>
                    	<ul class="dropdown-menu pull-right">
                      	<li><?php echo anchor('users/edit/' . $row->id, '<i class="icon-pencil"></i> Edit'); ?></li>
                      	<li><?php echo anchor('users/delete/' . $row->id, '<i class="icon-trash"></i> Delete', array('onclick' => "return confirm('Are you sure want to delete?')")); ?></li>
                      </ul>
                    </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <div class="clearfix"></div>
        <br>
        <div class="pagination pagination-right">
            <ul>
                <?php echo $pagination; ?>
            </ul>
        </div>
    </div>
</div>
<?php get_footer(); ?>
