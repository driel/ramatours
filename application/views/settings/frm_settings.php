<?php get_header(); ?>
<?php echo load_js(array(
    "plugins/ckeditor/ckeditor.js"
)); ?>
<script type="text/javascript">
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
        	  var target = input.name;
            $('#'+target).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
</script>
<div class="body">
	<div class="content">
		<div class="page-header">
			<div class="icon">
				<span class="ico-site-map"></span>
			</div>
			<h1>
				Setting <small>Add new settings</small>
			</h1>
		</div>
		<br class="cl" />
		<?php echo $this->session->flashdata('message'); ?>
		<?php echo form_open_multipart($form_action); ?>
		<div class="data-fluid tabbable tabs-left">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">General</a>
				</li>
				<li><a href="#taxes" data-toggle="tab">Taxes variables</a>
				</li>
				<li><a href="#finance" data-toggle="tab">Finance</a>
				</li>
				<li><a href="#reservation" data-toggle="tab">Reservation</a>
				</li>
				<li><a href="#absensi" data-toggle="tab">Absensi</a>
				</li>
			</ul>
			<div class="tab-content">
				<div id="general" class="tab-pane active">
					<table width="100%">
						<tr>
							<td width="20%">Logo</td>
							<td>
								<?php if($logo ==''){ ?>
								<img src="<?php echo isset($_POST['logo']) ? assets_url('upload/' . $_POST['logo']) : '' ?>" alt="" id="logo" />
								<?php }else{ ?>
								<img src="<?php echo assets_url('upload/' . $logo); ?>" alt="" id="logo" />
								<?php } ?>
								<div class="input-append file">
									<input type="file" name="logo" onchange="readURL(this)" style="display: none;" />
									<input type="text" style="width: 208px" />
									<a href="#" class="btn">Browse</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>Login page background</td>
							<td>
							  <?php if($logo ==''){ ?>
								<img src="<?php echo isset($_POST['logo']) ? assets_url('upload/' . $_POST['logo']) : '' ?>" alt="" id="login_page_bg" style="width: 256px; height: auto"/>
								<?php }else{ ?>
								<img src="<?php echo assets_url('upload/' . $login_page_bg); ?>" alt="" id="login_page_bg" style="width: 256px; height: auto" />
								<?php } ?>
							  <div class="input-append file">
									<input type="file" name="login_page_bg" onchange="readURL(this)" style="display: none;" />
									<input type="text" style="width: 208px" />
									<a href="#" class="btn">Browse</a>
								</div>
							</td>
						</tr>
						<tr>
							<td width="20%">Company Name</td>
							<td>
								<div class="span3">
									<?php echo form_input($company_name); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td width="20%" valign="top">Address</td>
							<td>
								<div class="span3">
									<?php echo form_textarea($address); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td width="20%">Phone</td>
							<td>
								<div class="span3">
									<?php echo form_input($phone); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td width="20%">Fax</td>
							<td>
								<div class="span3">
									<?php echo form_input($fax); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td width="20%">Email</td>
							<td>
								<div class="span3">
									<?php echo form_input($email); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td width="20%">City</td>
							<td>
								<div class="span3">
									<?php echo form_input($city); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td width="20%">No NPWP</td>
							<td>
								<div class="span3">
									<?php echo form_input($no_npwp); ?>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div id="taxes" class="tab-pane">
					<table width="100%">
						<tr>
							<td width="20%">Wajib pajak</td>
							<td>
								<div class="span2">
									<?php echo form_input($hrd_wp); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td>Tunjangan Jabatan Percent</td>
							<td>
								<div class="span1 input-append">
									<?php echo form_input($hrd_tj_percent); ?>
									<span class="btn">%</span>
								</div>
							</td>
						</tr>
						<tr>
							<td>Tunjangan Jabatan Max</td>
							<td>
								<div class="span2">
									<?php echo form_input($hrd_tj_max); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td>HRD Net 1</td>
							<td>
								<div class="span2">
									<?php echo form_input($hrd_net1); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td>HRD Net 2</td>
							<td>
								<div class="span2">
									<?php echo form_input($hrd_net2); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td>HRD Net 3</td>
							<td>
								<div class="span2">
									<?php echo form_input($hrd_net3); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td>Pph Percent 1</td>
							<td>
								<div class="span1 input-append">
									<?php echo form_input($hrd_pph_percent1); ?>
									<span class="btn">%</span>
								</div>
							</td>
						</tr>
						<tr>
							<td>Pph Percent 2</td>
							<td>
								<div class="span1 input-append">
									<?php echo form_input($hrd_pph_percent2); ?>
									<span class="btn">%</span>
								</div>
							</td>
						</tr>
						<tr>
							<td>Pph Percent 3</td>
							<td>
								<div class="span1 input-append">
									<?php echo form_input($hrd_pph_percent3); ?>
									<span class="btn">%</span>
								</div>
							</td>
						</tr>
						<tr>
							<td>Pph Percent 4</td>
							<td>
								<div class="span1 input-append">
									<?php echo form_input($hrd_pph_percent4); ?>
									<span class="btn">%</span>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div id="finance" class="tab-pane">
				  <table width="100%">
				  	<tr>
				  		<td width="20%">Invoice note</td>
				  		<td>
				  		  <div class="span7" style="margin:0!important"><?php echo form_textarea($invoice_note); ?></div>
				  		</td>
				  	</tr>
				  	<tr>
				  		<td>Ticketing invoice numbering</td>
				  		<td>
				  		  <div class="one_fourth">
				  		    <span>Head office start</span><br />
				  		    <?php echo form_input($invoice_ticketing_ho_start); ?>
				  		  </div>
				  		  <div class="one_fourth">
				  		    <span>Jakarta start</span><br />
				  		    <?php echo form_input($invoice_ticketing_jkt_start); ?>
				  		  </div>
				  		  <div class="one_fourth">
				  		    <span>Jogja start</span><br />
				  		    <?php echo form_input($invoice_ticketing_jog_start); ?>
				  		  </div>
				  		  <div class="one_fourth lastcolumn">
				  		    <span>Code behind invoice</span><br />
				  		    <?php echo form_input($code_behind_invoice); ?>
				  		  </div>
				  		</td>
				  	</tr>
				  	<tr>
				  		<td>Invoice number length</td>
				  		<td>
				  		  <div class="span1">
				  		    <?php echo form_input($invoice_number_length); ?>
				  		  </div>
				  		</td>
				  	</tr>
				  </table>
				</div>
				<div id="reservation" class="tab-pane">
				  <table width="100%">
				  	<tr>
				  		<td width="20%">Tour number (RTI) start form</td>
				  		<td>
				  		  <div class="span2">
				  		    <?php echo form_input($rti_start_from); ?>
				  		  </div>
				  		</td>
				  	</tr>
				  	<tr>
				  		<td>RTI number length</td>
				  		<td>
				  		  <div class="span1">
				  		    <?php echo form_input($rti_length); ?>
				  		  </div>
				  		</td>
				  	</tr>
				  </table>
				</div>
				<div id="absensi" class="tab-pane">
				  <table width="100%">
				  	<tr>
				  		<td width="20%">Default absensi day</td>
				  		<td>
				  		  <div class="span1 input-append">
				  		    <?php echo form_input($default_absensi_day); ?><span class="btn">Hr</span>
				  		  </div>
				  		</td>
				  	</tr>
				  </table>
				</div>
			</div>
		</div>
		<?php echo form_submit($btn_save); ?>
		<?php echo form_close() ?>
	</div>
</div>
<script>
CKEDITOR.replace("invoice_note");
</script>
<?php get_footer(); ?>
