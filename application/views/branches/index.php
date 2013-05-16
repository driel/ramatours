<?php get_header(); ?>
<?php

function HeaderLink($value, $key, $col, $dir) {
    $out = "<a href=\"" . site_url('branches') . "?c=";
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
        <span class="ico-site-map"></span>
      </div>
      <h1>Branch
      <small>Manage branch</small>
      </h1>
    </div>
    <br class="cl" />
    <div class="head blue">
      <?php echo header_btn_group("branches/to_excel", "branches/add");?>
    </div>
    <div id="search_bar" class="widget-header">
      <?php search_form(array(""=>"By","branch_name"=>"Branch name")); ?>
    </div>
    <table class="table fpTable table-hover">
        <thead>
            <tr>
                <th width="30%"><?php echo HeaderLink("Branch Name", "branch_name", $col, $dir); ?></th>
                <th width="30%"><?php echo HeaderLink("Invoice name", "branch_invoice_name", $col, $dir); ?></th>
                <th width="30%"><?php echo HeaderLink("Invoice title", "branch_invoice_title", $col, $dir); ?></th>
                <th width="5%" class="action_cell">Action</th>
            </tr>
        </thead>
        <?php
        foreach ($branch_list as $row) {
        ?>
            <tr>
                <td><?php echo $row->branch_name; ?></td>
                <td><?php echo $row->branch_invoice_name; ?></td>
                <td><?php echo $row->branch_invoice_title; ?></td>
                <td>
                  <div class="btn-group">
                      <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                          <i class="icon-cog"></i>
                          <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu pull-right">
                          <li><?php echo anchor('branches/edit/'.$row->branch_id, '<i class="icon-pencil"></i> Edit'); ?></li>
                          <li><?php echo anchor('branches/delete/'.$row->branch_id, '<i class="icon-trash"></i> Delete', array("class"=>"delete")); ?></li>
                      </ul>
                  </div>
                </td>
            </tr>
        <?php } ?>
        <tfoot class="foot_pagi">
        	<tr>
        		<th colspan="4"><?php echo $pagination; ?></th>
        	</tr>
        </tfoot>
    </table>
    <div class="clearfix"></div>
  </div>
</div>
<?php get_footer(); ?>
