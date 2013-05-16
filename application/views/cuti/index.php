<?php get_header(); ?>
<?php echo load_js(array(
  "plugins/ckeditor/ckeditor.js"
));?>
<script>
$(window).load(function(){
	$(".customscroll").mCustomScrollbar({
	  horizontalScroll: true
	});
});
</script>
<div class="modal hide fade" id="update_status_modal">
  <?php echo form_open("cuti/update_status"); ?>
	<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
    <h3 style="font-weight: bold">Update status cuti</h3>
	</div>
	<div class="modal-body">
      <input type="hidden" name="cuti_id" id="cuti_id" />
      <?php echo form_dropdown("status", $status); ?>
      <?php echo form_textarea($comment); ?>	
	</div>
	<div class="modal-footer">
	 <input type="submit" value="Update" class="btn btn-primary" />
	 <input type="button" value="Cancel" class="btn btn-danger" data-dismiss="modal" />
	</div>
  <?php echo form_close(); ?>
</div>
<div class="body">
    <div class="content customscroll" style="overflow:auto">
        <?php echo $this->session->flashdata('message'); ?>
        <div class="page-header">
            <div class="icon">
                <span class="ico-tag"></span>
            </div>
            <h1>Cuti
                <small>Manage cuti</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group("#", "cuti/add"); ?>
        </div>
        <div id="search_bar" class="widget-header">
            <?php search_form(array("" => "By", "asset_name" => "Name")); ?>
        </div>
        <table class="table fpTable table-hover" style="width: 1200px">
            <thead>
                <tr>
                    <th width="120"><?php echo sorter_link("staffs/index", "staff_id", $order, "Staff"); ?></th>
                    <th width="100">Branch</th>
                    <th width="100">Dept.</th>
                    <th width="100">Executed on</th>
                    <th width="100"><?php echo sorter_link("staffs/index","date_request", $order, "Requested date"); ?></th>
                    <th width="100"><?php echo sorter_link("staffs/index", "date_start", $order, "Start from"); ?>
                    <th width="100"><?php echo sorter_link("staffs/index", "date_end", $order, "To"); ?>
                    <th width="100"><?php echo sorter_link("staffs/index", "status", $order, "Status"); ?>
                    <th width="100"><?php echo sorter_link("staffs/index", "approveby_staff_id", $order, "Approve by"); ?>
                    <th width="50">Action</th>
                </tr>
            </thead>
            <?php
            foreach ($cuti->result() as $row) {
            $staff = get_staff_detail($row->staff_id);
            $branch = get_branch_detail($staff->staff_id);
            $dept = get_dept_detail($staff->staff_id);
            $approve_by = get_user_detail($row->approveby_staff_id);
            
            $detail = getDetail($row->id);
            $comment = "No Comment";
            if(count($detail)){
              $comment = strip_tags($detail->comment);;  
            }
            switch($row->status){
              case "pending":
                $status_class = "btn-info";
                break;
              case "approve":
                $status_class = "btn-primary";
                break;
              case "decline":
                $status_class = "btn-danger";
                break;
              default:
                $status_class = "btn-info";
                break;
            }
            ?>
                <tr>
                    <td><?php echo $staff ? $staff->staff_name:'-'; ?></td>
                    <td><?php echo $branch ? $branch->branch_name:'-'?></td>
                    <td><?php echo $dept ? $dept->dept_name:'-'?></td>
                    <td><?php echo $detail ? date_format(date_create($detail->comment_date), "Y-m-d"):'-'?></td>
                    <td><?php echo $row->date_request; ?></td>
                    <td><?php echo $row->date_start; ?></td>
                    <td><?php echo $row->date_end; ?></td>
                    <td>
                      <div class="btn bootstrap-tooltip <?php echo $status_class; ?>" style="width:70px;" data-title="<?php echo $comment; ?>" data-placement="top">
                        <?php echo $row->status; ?>
                      </div>
                    </td>
                    <td><?php echo $approve_by ? $approve_by->username:"-"; ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                                <i class="icon-cog"></i>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                  <a href="#update_status_modal" id="<?php echo $row->id; ?>" class="update_status" data-toggle="modal">
                                    <i class="icon-edit"></i> Update status cuti
                                  </a>                                
                                </li>
                                <li><?php echo anchor('cuti/edit/' . $row->id, '<i class="icon-pencil"></i> Edit'); ?></li>
                                <li><?php echo anchor('cuti/delete/' . $row->id, '<i class="icon-trash"></i> Delete', array('onclick' => "return confirm('Are you sure want to delete?')")); ?></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            <tfoot class="foot_pagi">
            	<tr>
            		<th colspan="10"><?php echo $this->pagination->create_links();?></th>
            	</tr>
            </tfoot>
        </table>
        <div class="clearfix"></div>
    </div>
</div>
<script type="text/javascript">
  var CKInstance;
  $("#update_status_modal").on("shown", function(){
    CKInstance = CKEDITOR.replace("comment");
  });
  $("#update_status_modal").on("hidden", function(){
    CKEDITOR.instances["comment"].destroy();  
  })
  $(".update_status").on("click", function(){
    var id = $(this).attr("id");
    $("#cuti_id").val(id);
  });
</script>
<?php get_footer(); ?>
