<?php $this->load->view('admin/theme/message'); ?>

<?php
    if($this->session->userdata('plan_file_name')==1)
    {
        echo "<div class='alert alert-success text-center'><h4 style='margin:0;'>";
        echo "<i class='fa fa-check-circle'></i>".$this->lang->line("your data has been successfully stored into the database.")."</h4><br/></div>";
       $this->session->unset_userdata('plan_file_name');
    } 
        $add_permission    = 1;
        $edit_permission    = 1;
        $delete_permission  = 1;
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> <?php echo $this->lang->line("Signups"); ?> </h1>

</section>
<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container" style="width:100%; height:700px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin/users_list_data"; ?>" 
            
            pagination="true" 
            rownumbers="true" 
            toolbar="#tb" 
            pageSize="10" 
            pageList="[5,10,20,50,100]"  
            fit= "true" 
            fitColumns= "true" 
            nowrap= "true" 
            view= "detailview"
            idField="id"
            >
            
                <thead>
                    <tr>
                        <th field="id" checkbox="true"><?php echo $this->lang->line("ID"); ?></th>                        
                        <th field="first_name" fsortable="true"><?php echo $this->lang->line("Name"); ?></th>
                        <th field="email_id" fsortable="true"><?php echo $this->lang->line("Email ID"); ?></th>
                        <th field="phone_number" fsortable="true"><?php echo $this->lang->line("Phone Number"); ?></th>
                        <th field="type" fsortable="true" formatter='userType'><?php echo $this->lang->line("Login Type"); ?></th>
                        <th field="status" fsortable="true" formatter='status'><?php echo $this->lang->line("status"); ?></th>
                        <th field="wallet" fsortable="true"><?php echo $this->lang->line("wallet"); ?></th>
                        <th field="created_date" fsortable="true" ><?php echo $this->lang->line("created date"); ?></th>
                        <th field="view" formatter='action_column'><?php echo $this->lang->line("actions"); ?></th>                    
                    </tr>
                </thead>
            </table>                        
         </div>
		  <div id="tb" style="padding:3px">
			<form class="form-inline" style="margin-top:20px"  enctype="multipart/form-data">

                <div class="form-group">
                    <input id="search" name="search" class="form-control" size="30" placeholder="<?php echo $this->lang->line("Search by Name, Email, Phone.."); ?>">
                </div>
                <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line("search"); ?></button>  
            </form> 
			<div class="tDiv3">
			        	<a class="btn btn-primary export-anchor" href="./UserExportExcel/export" target="_self">				
				<i class="fa fa-download"></i> Export				
            </a>			
								</div>
         
        </div> 
    </div>
  </div>   
</section>


<script>    
var plan_id = 0;   
    $j(function() {
        $( ".datepicker" ).datepicker();
		$("#updateUser").on("click", function(){
			var data = new FormData($('#userUpdateForm')[0]);
			$.ajax({
				url : '<?php echo site_url().'admin/updateUser';?>',
				method: "POST",
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				dataType:'JSON',
				success:function(response){
					if(response == 0){
						$(".error").removeClass("hide");
					}else{						
						$j('#tt').datagrid('load');
						$("#userEditModal").modal('hide');
						
					}					
				}
			});
		});
    });  

    var base_url="<?php echo site_url(); ?>"
    function userType(value,row,index){
		var str = "";
		if(row.facebook_id != ""){
			str += "<img src='<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/facebook.png");?>' title='Facebook'>   ";
		}
		if(row.gplus_id != ""){
			str += "<img src='<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/google-plus.png");?>' title='GPlus'>   ";
		}
		if(row.twitter_id != ""){
			str += "<img src='<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/twitter.png");?>' title='Twitter'>   ";
		}
		var trim = str.replace(/(^,)|(,$)/g, "")
		return trim;
	}
    function action_column(value,row,index)
    {        
        var str="";
        var add_permission="<?php echo $add_permission; ?>";        
        var edit_permission="<?php echo $edit_permission; ?>";   
        var delete_permission="<?php echo $delete_permission; ?>";   
        
        
		if(edit_permission==1)
        str=str+"<a style='cursor:pointer' title='"+'<?php echo $this->lang->line("edit") ?>'+"' data-user_id="+row.id+" onclick='editUser(this)'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/edit.png");?>" alt="Edit">'+"<input type='hidden' class='editval' value='"+row.id+"'></a>";

        if(delete_permission == 1){
			if(row.status == '1'){
				str=str+"<a style='cursor:pointer' data='remove' title='"+'<?php echo $this->lang->line("Inactive") ?>'+"' onclick='deletePlan(this)'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/close.png");?>" alt="Delete">'+"<input type='hidden' value='"+row.id+"' id='plan_delete'></a>";
			}else{
				str=str+"<a style='cursor:pointer' data='activate' title='"+'<?php echo $this->lang->line("Active") ?>'+"' onclick='deletePlan(this)'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/Ok-16.png");?>" alt="activate">'+"<input type='hidden' value='"+row.id+"' id='plan_delete'></a>";
			}
			  
		}
      
        
        return str;
    } 
	function status(value,row,index){
		if(row.status == '1'){
			return "<label class='label label-success'>Active</label>";
		}
		if(row.status == '0'){
			return "<label class='label label-warning'>Inactive</label>";
		}
		
	}
	
	function deletePlan(a){
		plan_id = $(a).find('#plan_delete').val();
		var txt = $(a).attr('data');
		if(txt == 'remove'){
			$('#del_label').html('Are you sure want to Inactive this user?');
		}
		if(txt == 'activate'){
			$('#del_label').html('Are you sure want to Active this user?');
		}
		$("#deletePlan").modal();
	}
	
	function plan(e,plan){
		e.preventDefault();
		var id='';
		var plan_value='';
		var id='';
		
		if(plan == 'Delete'){
			id=plan_id;
		}
		$.ajax({
				url : base_url+'admin/delete_user',
				data:{
					'id':id,
					'type': plan
									
				},
				method:'POST',
				success:function(response){
					 $j('#tt').datagrid('load');
					 $("#deletePlan").modal('hide');
				}
			}) 
		
	}
	
	function doSearch(event){
        event.preventDefault(); 
        $j('#tt').datagrid('load',{
			search		:    $j('#search').val(),
			is_searched	:    1
        });
    }  
	
	function editUser(val){
		var user_id = $(val).find('.editval').val();		
		$("#userEditModal").modal();
		$.ajax({
			url : base_url+'admin/editUser',
			method: "POST",
			data:{
				id : user_id
			},
			dataType:'JSON',
			success:function(response){
				console.log(response)
				$("#id").val(response[0].id);
				$("#first_name").val(response[0].first_name);
				$("#last_name").val(response[0].last_name);
				$("#email_id").val(response[0].email_id);
				$("#phone_number").val(response[0].phone_number);
				$("#alt_phone_number").val(response[0].alt_phone_number);
				$("#age").val(response[0].age);
				$("#wallet").val(response[0].wallet);
				$("#addrs_id").val(response[0].addrs_id);
				$("#address").val(response[0].address);
				$("#city").val(response[0].city);
				$("#area").val(response[0].area);
				$("#landmark").val(response[0].landmark);
				$("#pincode").val(response[0].pincode);
				$("#paytm_id").val(response[0].paytm_id);
				$("#pay_phone_number").val(response[0].pay_phone_number);
				$("#pay_email_id").val(response[0].pay_email_id);
				$("#status").val(response[0].status);
				
			}
		});
		
		
	}
	
</script>
<!-- Start Modal For plan add. -->

<!-- End Modal For plan add. -->
<!-- Start Modal For plan edit. -->
<div id="deletePlan" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#215;</span>
                </button>
                <h4 id="new_search_details_title" class="modal-title">Conformation</h4>
            </div><br/>
            <div class="modal-body">
				<label class="control-label" id="del_label" ></label>
            </div>
			<div class="modal-footer">
				<a class='btn btn-info' onclick="plan(event,'Delete')">Yes</a> 
				<a class="btn btn-default" data-dismiss="modal">Cancel</a> 
			</div>
			<div class="clearfix"></div>
        </div>
    </div>
</div>

<!-- End Modal For plan add. -->
<!-- Modal -->
<div id="userEditModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">User Edit</h4>
      </div>
      <div class="modal-body">
		<form name="userUpdateForm" id="userUpdateForm" enctype="multipart/form-data">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<h3>Personal Details</h3>
			</div>
		</div>
        <div class="row">
			<p class="text-center hide error" style="color:red">Email ID already exists!</p>
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>First Name:</label>
					<input type="text" class="form-control" name="first_name" id="first_name"/>
					<input type="hidden" class="form-control" name="id" id="id"/>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Last Name:</label>
					<input type="text" class="form-control" name="last_name" id="last_name"/>
				</div>
			</div>			
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Contact Number:</label>
					<input type="text" class="form-control" name="phone_number" id="phone_number"/>
				</div>
			</div>	
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Alternative Contact Number:</label>
					<input type="text" class="form-control" name="alt_phone_number" id="alt_phone_number"/>
				</div>
			</div>			
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Email Address:</label>
					<input type="text" class="form-control" name="email_id" id="email_id"/>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Wallet:</label>
					<input type="text" class="form-control" name="wallet" id="wallet"/>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Age:</label>
					<input type="text" class="form-control" name="age" id="age"/>
				</div>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<h3>Shipping Details</h3>
			</div>
		</div>
        <div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="form-group">
					<label>Address:</label>
					<input type="text" name="address" class="form-control" id="address"/>
					<input type="hidden" name="addrs_id" class="form-control" id="addrs_id"/>
				</div>
			</div>			
		</div>	
        <div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>City:</label>
					<input type="text" class="form-control" name="city" id="city"/>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Area:</label>
					<input type="text" class="form-control" name="area" id="area"/>
				</div>
			</div>			
		</div>		
        <div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Landmark:</label>
					<input type="text" class="form-control" name="landmark" id="landmark"/>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Pincode:</label>
					<input type="text" class="form-control" name="pincode" id="pincode"/>
				</div>		
			</div>			
		</div>	
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<h3>Paytm Details</h3>
			</div>
		</div>
        <div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Contact Number:</label>
					<input type="hidden" class="form-control" name="paytm_id" id="paytm_id"/>
					<input type="text" class="form-control" name="pay_phone_number" id="pay_phone_number"/>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Email Address:</label>
					<input type="text" class="form-control" name="pay_email_id" id="pay_email_id"/>
				</div>
			</div>			
		</div>
        <div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Status:</label>
					<select class="form-control" id="status" name="status">
						<option value="0">Inactive</option>
						<option value="1">Active</option>
					</select>
				</div>
			</div>	
		</div>
        <div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="text-right">
					<input type="button" class="btn btn-lg" Value="Save" id="updateUser" name="updateUser"/>
				</div>
			</div>			
		</div>	
		<form>
      </div>
    </div>

  </div>
</div>






