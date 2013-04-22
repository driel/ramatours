<?php get_header(); ?>
<div class="body">
	<div class="content">
	 <div class="page-header">
      <div class="icon">
        <span class="ico-cog"></span>
      </div>
      <h1>User
      <small>Register user</small>
      </h1>
    </div>
    <form method="post" class="form-horizontal" action="<?php echo site_url('users/save_user'); ?>" enctype="multipart/form-data">
    <table width="100%">
    	<tr>
    		<td width="20%">Staff</td>
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
    	<tr>
    		<td>Password</td>
    		<td><div class="span3"><?php echo form_password($password); ?></div></td>
    	</tr>
    	<tr>
    		<td>Avatar</td>
    		<td><input type="file" name="file" size="20"></td>
    	</tr>
    </table>
    <?php echo form_submit($btn_sign_up); ?>
    </form>
	</div>
</div>
<?php get_footer(); ?>
