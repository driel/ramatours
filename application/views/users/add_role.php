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
      var new_module = '<tr class="roles"><td><input type="text" name="module[]" /></td><td class="center-align"><input type="checkbox" name="add" class="ibtn" /></td><td class="center-align"><input type="checkbox" name="edit" class="ibtn"/></td><td class="center-align"><input type="checkbox" name="delete" class="ibtn" /></td><td class="center-align"><input type="checkbox" name="approve" class="ibtn" /></td><td class="center-align"><input type="checkbox" class="ibtn check-all" /></td></tr>';
      $(new_module).appendTo("#modules-table");
      checkAll();
    });
    checkAll();
    $("form").on("submit", function(e){
      var form = this;
      e.preventDefault();
      $(".roles").each(function(){
        var _module = '';
        $(this).children("td").each(function(){
          if($(this).children().is("input[type=text]")){
            _module = $(this).children().val();      
          }else{
            if(_module.length > 0){ // check if module name is not empty, if so then don't do anything
              var attr = $(this).children().attr("name");
              if(typeof attr != "undefined"){ // skip unnamed checkbox, eg. check-all checkbox
                _module = _module.replace(/\s/g, "_");
                $(this).children().attr("name", attr+"_"+_module);               
              }        
            }          
          }
        });      
      });
      form.submit();  
    });
  });
  checkAll = function(){
    $(".check-all").on("click", function(){
      var iBtn = $(this).parents("tr.roles").children("td").children().not("input[type=text]");
      $(iBtn).each(function(){
        if($(this).hasClass("check-all")) return;
        if(!$(".check-all").is(":checked")){
          $(this).removeAttr("checked");
          $(this).val("0")  
        }else{
          $(this).attr("checked", "checked");  
          $(this).val("1")   
        }
        // remove check-all if one of ibtn is unchecked
        $(this).on("click", function(){
          if(!$(this).is(":checked")){
            $(this).parents("tr.roles").children("td").children(".check-all").removeAttr("checked");
            //$(".check-all").removeAttr("checked");
            $(this).val("0");      
          }else{
            $(this).val("1");  
          }
        });
      });
    });
  }
</script>
<div class="body">
  <div class="content">
    <h2 class="rama-title">User role</h2>
    <?php if(validation_errors()) echo error_box(validation_errors()); ?>
    <?php echo form_open($action); ?>
    <table width="100%">
      <tr>
        <td width="20%">Role name</td>
        <td>
          <div class="span3">
          <?php echo form_hidden("role_id", $role_id); ?>
          <?php echo form_input($role_name); ?>
          </div>
        </td>
      </tr>
      <tr>
        <td>Roled modules</td>
        <td>
          <table width="100%" id="modules-table">
          	<tr>
          		<td width="40%"><b>Module</b></td>
          		<td width="10%" class="center-align"><b>view</b></td>
          		<td width="10%" class="center-align"><b>add</b></td>
          		<td width="10%" class="center-align"><b>edit</b></td>
          		<td width="10%" class="center-align"><b>delete</b></td>
          		<td width="10%" class="center-align"><b>approve</b></td>
          		<td width="10%" class="center-align"><b>All</b></td>
          	</tr>
          	<?php
          	  $_super = 0;
              foreach($modules->result() as $module){
                $roled = get_roled($role_id, $module->id);
                ?>
                <tr class="roles">
                  <td>
                  <input type="text" name="module[]" value="<?php echo str_replace("_", " ", $module->name); ?>" readonly /></td>
                  <?php echo form_hidden(str_replace(" ", "_", $module->name), $module->id); ?>
                  <?php if($roled->num_rows() > 0){ foreach($roled->result() as $roled){ $_super = $roled->roled_super; ?>
                  <td class="center-align"><input type="checkbox" name="view" class="ibtn"<?php echo $roled->roled_view == "1" ? ' checked':''; ?> /></td>
                	<td class="center-align"><input type="checkbox" name="add" class="ibtn"<?php echo $roled->roled_add == "1" ? ' checked':''; ?> /></td>
                	<td class="center-align"><input type="checkbox" name="edit" class="ibtn"<?php echo $roled->roled_edit == "1" ? ' checked':''; ?> /></td>
                	<td class="center-align"><input type="checkbox" name="delete" class="ibtn"<?php echo $roled->roled_delete == "1" ? ' checked':''; ?> /></td>
                	<td class="center-align"><input type="checkbox" name="approve" class="ibtn"<?php echo $roled->roled_approve == "1" ? ' checked':''; ?> /></td>
                	<td class="center-align"><input type="checkbox" class="ibtn check-all" /></td>
                	<?php }}else{ ?>
                	<td class="center-align"><input type="checkbox" name="view" class="ibtn" /></td>
                	<td class="center-align"><input type="checkbox" name="add" class="ibtn" /></td>
                	<td class="center-align"><input type="checkbox" name="edit" class="ibtn" /></td>
                	<td class="center-align"><input type="checkbox" name="delete" class="ibtn" /></td>
                	<td class="center-align"><input type="checkbox" name="approve" class="ibtn" /></td>
                	<td class="center-align"><input type="checkbox" class="ibtn check-all" /></td>
                	<?php } ?>            
                </tr>
                <?php
              }          	
          	?>
          	<tr class="roles">
            	<td><input type="text" name="module[]" /></td>
            	<td class="center-align"><input type="checkbox" name="view" class="ibtn" /></td>
            	<td class="center-align"><input type="checkbox" name="add" class="ibtn" /></td>
            	<td class="center-align"><input type="checkbox" name="edit" class="ibtn" /></td>
            	<td class="center-align"><input type="checkbox" name="delete" class="ibtn" /></td>
            	<td class="center-align"><input type="checkbox" name="approve" class="ibtn" /></td>
            	<td class="center-align"><input type="checkbox" class="ibtn check-all" /></td>
            </tr>
            <tr>
            	<td><input type="checkbox" name="super" class="ibtn"<?php echo $_super == "1" ? ' checked':''; ?>  /> <a href="#" class="bootstrap-tooltip" data-placement="top" data-title="Warning, this permission can see salary tab. use it on 'President' only"><b>Super</b></a></td>
            </tr>
          </table>
          <a href="#" class="btn btn-info add-module">Add module</a>
        </td>
      </tr>
    </table>
    <?php echo form_submit($btn_save)." ".$link_back ?>
    <?php echo form_close(); ?>
  </div>
</div>
<?php get_footer(); ?>