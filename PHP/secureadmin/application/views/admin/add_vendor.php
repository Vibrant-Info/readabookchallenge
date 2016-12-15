<section class="content-header">
	<section class="content">
		<div class="box box-info custom_box">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("add"); ?> - <?php echo $this->lang->line("vendor"); ?></h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			<?php   if(isset($id_exist) && !empty($id_exist)) 
				echo '<br/><div class="col-lg-6 col-lg-offset-3"><div class="alert alert-info text-center"><h4>'.$this->lang->line("sorry! there is no such member").'</h4></di></div>';
			?>
			<form class="form-horizontal" action="<?php echo site_url().'admin/add_vendor_action';?>" enctype="multipart/form-data" method="POST" onsubmit="return checkData()">
				<div class="box-body">


					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("Name"); ?>   *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="name" id="uname" value="<?php echo set_value('name');?>"  class="form-control" type="text" >	
							<span class="red hide dub" id="name">Please enter vendor name!</span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("email"); ?>  
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="email" id="email"  value="<?php echo set_value('email');?>"  class="form-control" type="text" >		          
							<span class="red hide" id="mailregex"></span>
							<span class="red hide" id="mailexist"></span>
						</div>
					</div> 

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("phone"); ?>  *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="phone" value="<?php echo set_value('phone');?>" id="phonenum" class="form-control" type="text" onblur="checkMobile('phone',this.value);">		               
							<span class="red hide" id="phoneregex"></span>
							<span class="red hide" id="phoneexist"></span>
						</div>
					</div>	

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("Address"); ?>   
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<textarea name="address" value="<?php echo set_value('address');?>"  class="form-control" ></textarea>		          
							<span class="red"><?php echo form_error('address'); ?></span>
						</div>
					</div>

				</div> <!-- /.box-body --> 
				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-12 text-center">
							<input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line('save');?>"/>  
							<input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line('cancel');?>" onclick='goBack("admin/vendor_list")'/>  
						</div>
					</div>
				</div><!-- /.box-footer -->         
			</div><!-- /.box-info -->       
		</form>     
	</div>
</section>
</section>
<script>
//var mailid = 0;
var phonenum = 0;
function checkMail(txt,txt_val){
	if(txt_val != ""){
			$.ajax({
				url: "<?php echo site_url().'admin/checkVendors';?>",
				dataType: "json",
				data:{ type:txt,value: txt_val},
				method:'POST',
				success: function(data) {
					if(data){
							$('#mailexist').removeClass('hide');
							$('#mailexist').html('Mail id already exist');
							mailid = 0;
						}
					else{
							$('#mailexist').addClass('hide');
							$('#mailexist').html('');
							mailid = 1;
					}
				}						
			});
		}	
}
function checkMobile(txt,txt_val){
	if(txt_val != ""){
			$.ajax({
				url: "<?php echo site_url().'admin/checkVendors';?>",
				dataType: "json",
				data:{ type:txt,value: txt_val},
				method:'POST',
				success: function(data) {
					if(data){
							$('#phoneregex').addClass('hide');
							$('#phoneexist').removeClass('hide');
							$('#phoneexist').html('Phone number already exist');
							phonenum = 0;
						}
					else{
							$('#phoneexist').addClass('hide');
							$('#phoneexist').html('');
							phonenum = 1;
					}
				}						
			});
		}	
}
function checkData(){
	var uname = $('#uname').val();
	var mail = $('#email').val();
	var mobile = $('#phonenum').val();
	var mailid = true;
	if(uname == ''){
		$('#name').removeClass('hide');
	}else{
		$('#name').addClass('hide');
	}
	if(mail == ''){
		mailid = true;
	}else{
		mailid = regexmail(mail);
	}
	if(uname!=''&&mailid&&regexmobile(mobile)&&phonenum==1){
		return true;
	}else{
		return false;
	}
}
function regexmail(mail){
	 var mail_regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	 if(mail_regex.test(mail)){
		 $('#mailregex').addClass('hide');
		 $('#mailregex').html('');
		 return true;
	 }else{
		 $('#mailregex').removeClass('hide');
		  $('#mailregex').html('Please enter valid email id');
		 return false;
	 }
		 
}
function regexmobile(mobile){
	 var mobile_regex = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
	 if(mobile_regex.test(mobile)){
		 $('#phoneregex').addClass('hide');
		  $('#phoneregex').html('');
		 return true;
	 }else{
		  $('#phoneregex').removeClass('hide');
		   $('#phoneregex').html('Please enter valid phone number');
		 return false;
	 }
	
}
</script>



