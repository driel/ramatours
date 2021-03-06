<?php get_header(); ?>
<script>
$(window).load(function(){
	$(".customscroll").mCustomScrollbar({
	  horizontalScroll:true
	});
});
</script>
<?php

function HeaderLink($value, $key, $col, $dir) {
    $out = "<a href=\"" . site_url('staffs') . "?c=";
    //set column query string value
    switch ($key) {
        case "staff_nik":
            $out .= "1";
            break;
        case "staff_name":
            $out .= "2";
            break;
        case "staff_address":
            $out .= "3";
            break;
        case "staff_email":
            $out .= "4";
            break;
        case "staff_phone_home":
            $out .= "5";
            break;
        case "staff_phone_hp":
            $out .= "6";
            break;
        case "staff_cabang":
            $out .= "7";
            break;
        case "staff_departement":
            $out .= "8";
            break;
        case "staff_jabatan":
            $out .= "9";
            break;
        case "staff_id":
            $out .= "10";
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
  <div class="content customscroll" style="overflow:auto">
    <?php echo $this->session->flashdata('message'); ?>
    <div class="page-header">
      <div class="icon">
        <span class="ico-coins"></span>
      </div>
      <h1>Staff
      <small>Manage staff</small>
      </h1>
    </div>
    <br class="cl" />
    <div class="head blue">
      <?php echo header_btn_group("staffs/to_excel", "staffs/add");?>
    </div>
    <div id="search_bar" class="widget-header">
      <?php search_form(array(""=>"By","staff_name"=>"Name", "staff_nik"=>"NIK")); ?>
    </div>
    <table class="table fpTable table-hover" style="width:1500px">
      <thead>
        <tr>
          <th><?php echo HeaderLink("NIK", "staff_nik", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Name", "staff_name", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Address", "staff_address", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Email", "staff_email", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Phone Home", "staff_phone_home", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Phone HP", "staff_phone_hp", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Branch", "staff_cabang", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Departement", "staff_departement", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Title", "staff_jabatan", $col, $dir); ?></th>
          <th>Action</th>
        </tr>
      </thead>
      <?php
      foreach ($staff_list as $row) {
      $branch = get_branch_detail($row->staff_cabang);
      $dept = get_dept_detail($row->staff_departement);
      $title = get_title_detail($row->staff_jabatan);
      ?>
          <tr>
            <td><?php echo $row->staff_nik; ?></td>
            <td><?php echo $row->staff_name; ?></td>
            <td><?php echo $row->staff_address; ?></td>
            <td><?php echo $row->staff_email; ?></td>
            <td><?php echo $row->staff_phone_home; ?></td>
            <td><?php echo $row->staff_phone_hp; ?></td>
            <td><?php echo $branch ? $branch->branch_name:'-'; ?></td>
            <td><?php echo $dept ? $dept->dept_name:'-'; ?></td>
            <td><?php echo $title ? $title->title_name:'-'; ?></td>
            <td>
              <div class="btn-group">
                <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                  <i class="icon-cog"></i>
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu pull-right">
                  <!-- <li><?php echo anchor('staffs/' . $row->staff_id . '/families/index', '<i class="icon-user"></i> Family'); ?></li>
                  <li><?php echo anchor('staffs/' . $row->staff_id . '/educations/index', '<i class="icon-book"></i> Education'); ?></li>
                  <li><?php echo anchor('staffs/' . $row->staff_id . '/work_histories/index', '<i class="icon-briefcase"></i> Work'); ?></li>
                  <li><?php echo anchor('staffs/' . $row->staff_id . '/medical_histories/index', '<i class="icon-plus"></i> Medical'); ?></li>
                  <li class="divider"></li>
                  <li><?php echo anchor('staffs/' . $row->staff_id . '/salary_components/index', '<i class="icon-list-alt"></i> Salary Components'); ?></li>
                  <li class="divider"></li>
                  <li><?php echo anchor('staffs/show/' . $row->staff_id, '<i class="icon-zoom-in"></i> Show'); ?></li> -->
                  <li><?php echo anchor('staffs/edit/' . $row->staff_id, '<i class="icon-pencil"></i> Edit'); ?></li>
                  <li><?php echo anchor('staffs/delete/' . $row->staff_id, '<i class="icon-trash"></i> Delete', array('onclick' => "return confirm('Are you sure want to delete?')")); ?></li>
                </ul>
              </div>
            </td>
          </tr>
      <?php } ?>
      <tfoot class="foot_pagi">
      	<tr>
      		<th colspan="10"><?php echo $this->pagination->create_links(); ?></th>
      	</tr>
      </tfoot>
    </table>
    <div class="clearfix"></div>
  </div>
</div>

<?php get_footer(); ?>
