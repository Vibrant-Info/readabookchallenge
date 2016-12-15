<section class="content-header">
	<section class="content">
		<div class="box box-info custom_box">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("add"); ?> - <?php echo $this->lang->line("Category"); ?></h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			<?php   if(isset($id_exist) && !empty($id_exist)) 
				echo '<br/><div class="col-lg-6 col-lg-offset-3"><div class="alert alert-info text-center"><h4>'.$this->lang->line("sorry! there is no such member").'</h4></di></div>';
			?>
			
			<form class="form-horizontal" action="<?php echo site_url().'admin/add_category_action';?>" enctype="multipart/form-data" method="POST">
				<div class="box-body">
					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("Category Name"); ?>  * 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="category_name" value="<?php echo set_value('category_name');?>"  class="form-control" type="text" onblur="checkCategory(this.value)">		          
							<span class="red hide dub" id="cat_name">Category already exists!</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("Category Image"); ?>   *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="category_image" value="<?php echo set_value('category_image');?>"  class="form-control" type="file">	
						</div>
					</div>
				</div> <!-- /.box-body --> 
				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-12 text-center">
							<input name="submit" type="submit" class="btn btn-warning btn-lg" disabled="true" value="<?php echo $this->lang->line('save');?>"/>  
							<input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line('cancel');?>" onclick='goBack("admin/config_category")'/>  
						</div>
					</div>
				</div><!-- /.box-footer -->         
			</div><!-- /.box-info -->       
		</form>     
	</div>
</section>
</section>
<script>

function checkCategory(txt_val){
	if(txt_val != ""){
			$.ajax({
				url: "<?php echo site_url().'admin/checkCategories';?>",
				dataType: "json",
				data:{ value: txt_val},
				method:'POST',
				success: function(data) {
					if(data){					
							$('#cat_name').removeClass('hide');
							$('input[type="submit"]').prop('disabled', true);
						}else{
							$('#cat_name').addClass('hide');
							$('input[type="submit"]').prop('disabled', false);
					}
				}						
			});
		}	
}
</script>



