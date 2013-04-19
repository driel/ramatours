<?php get_header(); ?>
<script type="text/javascript">
  $(document).ready(function(){
    $("#approve").iphoneStyle({
      onChange: function(e, checked){
        if(checked){
          $(e).attr("checked", "checked");
        }else{
          $(e).removeAttr("checked");
        }
      }
    });
    $(".add-module").on("click", function(e){
      e.preventDefault();
      var new_module = '<tr class="roles"><td><input type="text" name="module[]" /></td><td class="center-align"><input type="checkbox" name="add[]" class="ibtn" /></td><td class="center-align"><input type="checkbox" name="edit[]" class="ibtn" /></td><td class="center-align"><input type="checkbox" name="delete[]" class="ibtn" /></td><td class="center-align"><input type="checkbox" name="approve[]" class="ibtn" /></td><td class="center-align"><input type="checkbox" name="" class="ibtn check-all" /></td></tr>';
      $(new_module).appendTo("#modules-table");
      checkAll();
    });
    checkAll();
  });
  checkAll = function(){
    $(".check-all").on("click", function(){
      var iBtn = $(this).parents("tr.roles").children("td").children().not("input[type=text]");
      $(iBtn).each(function(){
        if($(this).hasClass("check-all")) return;
        if($(this).is(":checked")){
          $(this).removeAttr("checked");      
        }else{
          $(this).attr("checked", "checked");     
        }   
      });
    });
  }
</script>
<div class="body">
  <div class="content">
    <h2 class="rama-title">User role</h2>
    <?php echo $this->session->flashdata('message'); ?>
    <?php echo form_open($action); ?>
    <table width="100%">
      <tr>
        <td width="20%">Role name</td>
        <td>
          <div class="span3"><?php echo form_input($role_name); ?></div>
        </td>
      </tr>
      <tr>
        <td>Roled modules</td>
        <td>
          <table width="100%" id="modules-table">
          	<tr>
          		<td width="50%"><b>Module</b></td>
          		<td width="10%" class="center-align"><b>add</b></td>
          		<td width="10%" class="center-align"><b>edit</b></td>
          		<td width="10%" class="center-align"><b>delete</b></td>
          		<td width="10%" class="center-align"><b>approve</b></td>
          		<td width="10%" class="center-align"><b>All</b></td>
          	</tr>
          	<tr class="roles">
            	<td><input type="text" name="module[]" /></td>
            	<td class="center-align"><input type="checkbox" name="add[]" class="ibtn" /></td>
            	<td class="center-align"><input type="checkbox" name="edit[]" class="ibtn" /></td>
            	<td class="center-align"><input type="checkbox" name="delete[]" class="ibtn" /></td>
            	<td class="center-align"><input type="checkbox" name="approve[]" class="ibtn" /></td>
            	<td class="center-align"><input type="checkbox" class="ibtn check-all" /></td>
            </tr>
          </table>
          <a href="#" class="btn btn-info add-module">Add module</a>
        </td>
      </tr>
    </table>
    <?php echo form_submit($btn_save); ?>
    <?php echo form_close(); ?>
  </div>
</div>
<?php get_footer(); ?>
;
    });