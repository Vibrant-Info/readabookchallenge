<section class="content-header">
	<section class="content">
		<div class="box box-info custom_box">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-pencil"></i> <?php echo $this->lang->line("edit"); ?> - <?php echo $this->lang->line("Category"); ?></h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			
			<form class="form-horizontal" action="<?php echo site_url().'admin/update_category_action/'.$info['id'];?>" enctype="multipart/form-data" method="POST">
				<div class="box-body">

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("Category name"); ?>  *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="category_name" value="<?php if(set_value('category_name')) echo set_value('category_name');else {if(isset($info['category_name'])) echo $info['category_name'];}?>"  class="form-control" type="text" id="category_name" onblur="checkCategory(this.value)">		          
							<span class="red hide dub" id="cat_name">Category already exists!</span>
						</div>
					</div> 
					<div class="form-group">
						<label class="col-sm-3 control-label" for="image"> <?php echo $this->lang->line("Category Image"); ?>
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input type="file" id="category_image" name="category_image">
							<img src="<?php echo $info['category_image'];?>" style="width: 95px;height: 82px;"></img>
						</div>
						<div class='clear'></div>
					</div> 
		             </div> <!-- /.box-body --> 
		             <div class="box-footer">
		             	<div class="form-group">
		             		<div class="col-sm-12 text-center">
		             			<input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line("save"); ?>"/>  
		             			<input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line("cancel"); ?>" onclick='goBack("admin/config_category",1)'/>  
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
				data:{ value: txt_val,type:'update',id:'<?php echo $info['id'];?>'},
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




