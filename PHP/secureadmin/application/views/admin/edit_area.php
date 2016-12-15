
<section class="content-header">
	<section class="content">
		<div class="box box-info custom_box">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-pencil"></i> <?php echo $this->lang->line("edit"); ?> - <?php echo $this->lang->line("Area"); ?></h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			<form class="form-horizontal" action="<?php echo site_url().'admin/update_area_action/'.$info['id'];?>" enctype="multipart/form-data" method="POST">
				<div class="box-body">

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("city"); ?>  *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
						 <?php
								echo "<select class='form-control' name='city' id='city' readonly>";
								foreach ($cities as $city)
								{
									if($info['city'] == $city['id'] )
										echo '<option value="'.$city['id'].'" selected>'.$city['city_name'].'</option>';
									else{
										echo '<option value="'.$city['id'].'">'.$city['city_name'].'</option>';
									}
								}
								echo "<select>";
							?>
							
						</div>
					</div> 
					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("Pincode"); ?>  *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="area" value="<?php if(set_value('area')) echo set_value('area');else {if(isset($info['area'])) echo $info['area'];}?>"  class="form-control" type="text" onblur="checkArea(this.value)">		          
							<span class="red"><?php echo form_error('area'); ?></span>
							<span class="red hide dub" id="area">Pincode already exists!</span>
						</div>
					</div> 
		             </div> <!-- /.box-body --> 
		             <div class="box-footer">
		             	<div class="form-group">
		             		<div class="col-sm-12 text-center">
		             			<input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line("save"); ?>"/>  
		             			<input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line("cancel"); ?>" onclick='goBack("admin/delivery_area",1)'/>  
		             		</div>
		             	</div>
		             </div><!-- /.box-footer -->         
		         </div><!-- /.box-info -->       
		     </form>     
		 </div>
	
		</section>
	</section>
<script>
function checkArea(txt_val){
	var city = $('#city').val();
	if(txt_val != ""){
		var id="<?php echo $info['id'];?>";
			$.ajax({
				url: "<?php echo site_url().'admin/checkAreaUpdates';?>",
				dataType: "json",
				data:{ city:city,area: txt_val,id:id},
				method:'POST',
				success: function(data) {
					if(data){
						$('input[type="submit"]').prop('disabled', true);
						
						$('#area').removeClass('hide');
					}else{
						$('input[type="submit"]').prop('disabled', false);
						$('#area').addClass('hide');
					}
					
				}						
			});
		}	
}
</script>




