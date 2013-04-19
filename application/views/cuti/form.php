<?php get_header(); ?>
<?php echo load_js(array(
  "plugins/ckeditor/ckeditor.js"
));?>
<script type="text/javascript">
    $(document).ready(function(){
      $("#staff").autocomplete({
        source: function(request, response){
          console.log(request)
          var url = "<?php echo site_url('absensi/get_staff')?>/"+request.term;
          $.getJSON(url, function(data){
            var list = [];
            $.each(data, function(i, v){
              var li = {
                value: v.staff_name,
                staff_id: v.staff_id
              }
              list.push(li);
            });
            response(list);
          });
        },
        select: function(event, ui){
          $("#staff_id").val(ui.item.staff_id);
        }
      });
      /*$("#status_dd").on("change", function(){
        if($(this).val()!="pending"){
          $("#cuti_comment").show();
        }else{
          $("#cuti_comment").hide();
        }
      });*/
    });
</script>
<div class="body">
    <div class="content">
        <h2 class="rama-title">Form Cuti</h2>
        <?php echo validation_errors(); ?>
        <?php echo $this->session->flashdata('message'); ?>
        <?php echo form_open($form_action) . form_hidden('id', $id); ?>
        <input type="hidden" name="staff_id" id="staff_id" value="<?php echo $staff_id; ?>" />
        <table width="100%">
          <tr>
              <td width="20%">Staff</td>
              <td><div class="span3"><?php echo form_input($staff_name); ?></div></td>
          </tr>
          <tr>
              <td width="20%">Approve by</td>
              <td><div class="span3">
                <?php echo form_dropdown("approveby_staff_id", $approveby_staff_id, $approve_staff_id, "id='staff_dd'"); ?>
              </div></td>
          </tr>
          <tr>
              <td>Tanggal pengajuan</td>
              <td><div class="span2"><?php echo form_input($date_request); ?></div></td>
          </tr>
          <tr>
            <td>Mulai cuti</td>
            <td><div class="span2"><?php echo form_input($date_start); ?></div></td>
          </tr>
          <tr>
            <td>Akhir cuti</td>
            <td><div class="span2"><?php echo form_input($date_end); ?></div></td>
          </tr>
          <tr>
            <td>Status</td>
            <td><div class="span1"><?php echo form_dropdown("status", $status, $status_selected, 'id="status_dd"'); ?></div></td>
          </tr>
          <tr id="cuti_comment">
            <td>Comment</td>
            <td><div class="span6"><?php echo form_textarea(array(
              "name"=>"comment",
              "id"=>"comment",
              "style"=>"width:100%;",
              "value"=>$comment
            )); ?></div></td>
          </tr>
        </table>
        <input type="submit" name="save" class="btn btn-primary" />
        <a href="<?php echo site_url('cuti/index'); ?>" class="btn btn-danger">Back</a>
        <?php echo form_close() ?>
    </div>
</div>
<script type="text/javascript">
  CKEDITOR.replace("comment");
</script>
<?php get_footer(); ?>
