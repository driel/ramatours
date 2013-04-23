<?php get_header(); ?>
<?php

function HeaderLink($value, $key, $col, $dir) {
    $out = "<a href=\"" . site_url('components') . "?c=";
    //set column query string value
    switch ($key) {
        case "comp_name":
            $out .= "1";
            break;
        case "comp_type":
            $out .= "2";
            break;
        case "comp_id":
            $out .= "3";
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
        <span class="ico-money-bag"></span>
      </div>
      <h1>Salary component
      <small>Manage salary component</small>
      </h1>
    </div>
    <br class="cl" />
    <div class="head blue">
      <?php echo header_btn_group("components/to_excel", "components/add");?>
    </div>
    <div id="search_bar" class="widget-header">
      <?php search_form(array(""=>"By","comp_name"=>"Component name", "comp_type"=>"Component Type")); ?>
    </div>
    <table class="table fpTable table-hover">
      <thead>
        <tr>
          <th width="10%"><?php echo HeaderLink("Comp ID", "comp_id", $col, $dir); ?></th>
          <th width="40%"><?php echo HeaderLink("Comp Name", "comp_name", $col, $dir); ?></th>
          <th width="40%"><?php echo HeaderLink("Comp Type", "comp_type", $col, $dir); ?></th>
          <th width="5%" colspan="2" class="action_cell">Action</th>
        </tr>
      </thead>
      <?php
      foreach ($components as $row) {
      ?>
          <tr>
            <td><?php echo $row->comp_id; ?></td>
            <td><?php echo $row->comp_name; ?></td>
            <td><?php echo $row->comp_type; ?></td>
            <td>
              <div class="btn-group">
                  <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                      <i class="icon-cog"></i>
                      <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu pull-right">
                      <li><?php echo anchor('components/edit/'.$row->comp_id, '<i class="icon-pencil"></i> Edit'); ?></li>
                      <li><?php echo anchor('components/delete/'.$row->comp_id, '<i class="icon-trash"></i> Delete', array("class"=>"delete")); ?></li>
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
