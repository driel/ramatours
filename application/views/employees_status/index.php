<?php get_header(); ?>
<?php

function HeaderLink($value, $key, $col, $dir) {
    $out = "<a href=\"" . site_url('employees_status') . "?c=";
    //set column query string value
    switch ($key) {
        case "sk_name":
            $out .= "1";
            break;
        case "sk_id":
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
    <?php 
      if($this->session->flashdata('denied')){
        echo error_box($this->session->flashdata('denied'));          
      }
      if($this->session->flashdata('message')){
        echo success_box($this->session->flashdata('message'));          
      }        
    ?>
    <div class="page-header">
      <div class="icon">
        <span class="ico-group"></span>
      </div>
      <h1>Employee Status
      <small>Manage employee status</small>
      </h1>
    </div>
    <br class="cl" />
    <div class="head blue">
      <?php echo header_btn_group("employees_status/to_excel", "employees_status/add");?>
    </div>
    <div id="search_bar" class="widget-header">
      <?php search_form(array(""=>"By","sk_name"=>"Status")); ?>
    </div>
    <table class="table fpTable table-hover">
      <thead>
        <tr>
          <th width="5%"><?php echo HeaderLink("SK ID", "sk_id", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Status", "sk_name", $col, $dir); ?></th>
          <th width="5%" class="action_cell">Action</th>
        </tr>
      </thead>
      <?php
      foreach ($es_list as $row) {
      ?>
          <tr>
            <td><?php echo $row->sk_id; ?></td>
            <td><?php echo $row->sk_name; ?></td>
            <td>
              <div class="btn-group">
                  <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                      <i class="icon-cog"></i>
                      <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu pull-right">
                      <li><?php echo anchor('employees_status/edit/'.$row->sk_id, '<i class="icon-pencil"></i> Edit'); ?></li>
                      <li><?php echo anchor('employees_status/delete/'.$row->sk_id, '<i class="icon-trash"></i> Delete', array("class"=>"delete")); ?></li>
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
