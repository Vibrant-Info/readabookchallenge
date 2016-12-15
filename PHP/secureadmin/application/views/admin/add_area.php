<section class="content-header">
	<section class="content">
		<div class="box box-info custom_box">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("add"); ?> - <?php echo $this->lang->line("Area"); ?></h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			<?php   if(isset($id_exist) && !empty($id_exist)) 
				echo '<br/><div class="col-lg-6 col-lg-offset-3"><div class="alert alert-info text-center"><h4>'.$this->lang->line("sorry! there is no such member").'</h4></div></div>';
			?>
			<form class="form-horizontal" action="<?php echo site_url().'admin/add_area_action';?>" enctype="multipart/form-data" method="POST">
				<div class="box-body">

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("City"); ?>  * 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6 form-inline">
								
							  <?php
								echo "<select class='form-control' name='city' id='city'>";
								foreach ($cities as $city)
								{
									echo '<option value="'.$city['id'].'">'.$city['city_name'].'</option>';
								}
								echo "<select>";
							?>
								
							</div>
					</div>


					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("Pincode"); ?>   *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="area" value="<?php echo set_value('area');?>"  class="form-control" type="text" onblur="checkArea(this.value)">		          
							<span class="red"><?php echo form_error('name'); ?></span>
							<span class="red hide dub" id="area">Pincode already exists!</span>
						</div>
					</div>

					

				</div> <!-- /.box-body --> 
				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-12 text-center">
							<input name="submit" type="submit" class="btn btn-warning btn-lg" disabled="true" value="<?php echo $this->lang->line('save');?>"/>  
							<input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line('cancel');?>" onclick='goBack("admin/delivery_area")'/>  
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
			$.ajax({
				url: "<?php echo site_url().'admin/checkArea';?>",
				dataType: "json",
				data:{ city:city,area: txt_val},
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



