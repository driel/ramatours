<?php get_header(); ?>
<div class="body">
	<div class="content">
	<?php if(strlen(validation_errors()) > 0) echo error_box(validation_errors()); ?>
	<?php if(strlen($this->session->flashdata("error")) > 0) echo error_box($this->session->flashdata("error")); ?>
	 <div class="page-header">
      <div class="icon">
        <span class="ico-cog"></span>
      </div>
      <h1>User
      <small>Register user</small>
      </h1>
    </div>
    <form method="post" class="form-horizontal" action="<?php echo $form_action; ?>" enctype="multipart/form-data">
    <div class="span6">
    	<table width="100%">
    		<tr>
    			<td width="30%">Staff</td>
    			<td><?php echo $staff_id;?></td>
    		</tr>
    		<tr>
    			<td>Role</td>
    			<td><?php echo $role_id;?></td>
    		</tr>
    		<tr>
    			<td>Username</td>
    			<td><div class="span3"><?php echo form_input($username); ?></div></td>
    		</tr>
    		<?php if($edit): ?>
    		<tr>
    			<td>New password</td>
    			<td><div class="span3"><?php echo form_password(array("name"=>"new_pass", "placeholder"=>"new password")); ?></div></td>
    		</tr>
    		<tr>
    			<td>New password (retype)</td>
    			<td><div class="span3"><?php echo form_password(array("name"=>"new_pass_retype", "placeholder"=>"new password (retype)")); ?></div></td>
    		</tr>
    		<tr>
    			<td>Current password</td>
    			<td><div class="span3"><?php echo form_password($password); ?></div></td>
    		</tr>
    		<?php else: ?>
    		<tr>
    			<td>Password</td>
    			<td><div class="span3"><?php echo form_password($password); ?></div></td>
    		</tr>
    		<?php endif; ?>
    	</table>
    </div>
    <div class="span4">
      <div id="preview">
        <img src="<?php echo strlen($avatar) > 0 ? assets_url("upload/".$avatar):assets_url("images/default-avatar.png"); ?>" id="image" />
      </div>
      <div class="input-append file">
        <input type="file" name="file" style="display: none;">
        <input type="text" style="width:200px" />
        <a href="#" class="btn">Browse</a>
      </div>
    </div>
    <br class="cl" />
    <?php echo form_submit($btn_sign_up); ?>
    </form>
	</div>
</div>
<?php get_footer(); ?>
