<section class="content-header">
	<section class="content">
		<div class="box box-info custom_box">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-pencil"></i> <?php echo $this->lang->line("edit"); ?> - <?php echo $this->lang->line("book"); ?></h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			
			<form class="form-horizontal" action="<?php echo site_url().'admin/update_vendor_action/'.$info['id'];?>" enctype="multipart/form-data" method="POST" onsubmit="return checkData()">
				<div class="box-body">
					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("name"); ?>  *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="name" value="<?php if(set_value('name')) echo set_value('name');else {if(isset($info['name'])) echo $info['name'];}?>"  class="form-control" type="text" id="uname">		          
							<span class="red hide dub" id="name">Please enter vendor name!</span>
						</div>
					</div> 

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("email"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="email" id="email"  value="<?php if(set_value('email')) echo set_value('email');else {if(isset($info['email'])) echo $info['email'];}?>"  class="form-control" type="text">		          
							<span class="red hide" id="mailregex"></span>
							<span class="red hide" id="mailexist"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("phone"); ?>  *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="phone" value="<?php if(set_value('phone')) echo set_value('phone');else{if(isset($info['phone'])) echo $info['phone'];}?>"  class="form-control" type="text"  onblur="checkMobile('phone',this.value);" id="phonenum" >		          
							<span class="red hide" id="phoneregex"></span>
							<span class="red hide" id="phoneexist"></span>
						</div>
					</div> 

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("address"); ?>  
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<textarea name="address"  class="form-control" ><?php if(set_value('address')) echo set_value('address');else{if(isset($info['address'])) echo $info['address'];}
							?></textarea>          
							<span class="red"><?php echo form_error('address'); ?></span>
						</div>
					</div>		

		             </div> <!-- /.box-body --> 
		             <div class="box-footer">
		             	<div class="form-group">
		             		<div class="col-sm-12 text-center">
		             			<input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line("save"); ?>"/>  
		             			<input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line("cancel"); ?>" onclick='goBack("admin/vendor_list",1)'/>  
		             		</div>
		             	</div>
		             </div><!-- /.box-footer -->         
		         </div><!-- /.box-info -->       
		     </form>     
		 </div>
	
		</section>
	</section>
<script>

//var mailid = 1;
var phonenum = 1;
function checkMail(txt,txt_val){
	if(txt_val != ""){
			$.ajax({
				url: "<?php echo site_url().'admin/checkVendorUpdates';?>",
				dataType: "json",
				data:{ type:txt,value: txt_val,id:'<?php echo $info['id'];?>'},
				method:'POST',
				success: function(data) {
					if(data){
							$('#mailregex').addClass('hide');
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
				url: "<?php echo site_url().'admin/checkVendorUpdates';?>",
				dataType: "json",
				data:{ type:txt,value: txt_val,id:'<?php echo $info['id'];?>'},
				method:'POST',
				success: function(data) {
					if(data){
							$('#phoneexist').removeClass('hide');
							$('#phoneexist').html('Phone number already exist');
							phonenum = 0;
						}
					else{
							$('#phoneregex').addClass('hide');
							$('#phoneexist').addClass('hide');
							$('#phoneexist').html('');
							phonenum = 1;
					}
				}						
			});
			
		}	
		
}
/* function checkData(){
	var uname = $('#uname').val();
	var mail = $('#email').val();
	var mobile = $('#phonenum').val();
	if(uname == ''){
		$('#name').removeClass('hide');
	}else{
		$('#name').addClass('hide');
	}
	if(uname!=''&&regexmail(mail)&&regexmobile(mobile)&&phonenum==1&&mailid==1){
		return true;
	}else{
		return false;
	}
}
 */
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




