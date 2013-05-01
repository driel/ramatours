<?php get_header(); ?>
<script type="text/javascript">
$(document).ready(function(){
  	$(".proc").on("click", function(e){
		e.preventDefault();
		var data = $("form").serialize();
		var target = $(this).attr("target") == "_blank" ? "_blank":"_self";
		var to = $(this).data("to");
		window.open("<?php echo current_url(); ?>/?"+data+"&to="+to, target);
	});
});
</script>
<div class="body">
    <div class="content">
        <?php echo $this->session->flashdata('message'); ?>
        <div class="page-header">
            <div class="icon">
                <span class="ico-tag"></span>
            </div>
            <h1>Assets
                <small>Report Asset List</small>
            </h1>
        </div>
	    <form action="" method="post">
	    	<div class="span3">Branch<br />
	    	<?php echo $branch; ?></div>
	    	<div class="span3">Asset Name<br />
	    	<?php echo form_input(array('name' => 'asset_name', 'value' => $this->input->get('asset_name'), 'size' => '28'));?></div>
	    	<div class="cl"></div>
	    </form>
	    <div style="margin: 10px 0; border-bottom:1px solid #e0e0e0;"></div>
	    <a href="#" class="btn btn-info proc" target="_blank" data-to="print">Print</a>
	    <a href="#" class="btn btn-primary proc" data-to="pdf">Save PDF</a>
	    <a href="#" class="btn proc" data-to="xls">Save XLS</a>
	</div>
</div>
<?php get_footer(); ?>