<div id="plan_view">
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
  <h1> <?php echo $this->lang->line("Plans"); ?> </h1>

</section>
<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container" style="width:100%; height:700px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin/plan_list_data"; ?>" 
            
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
                        <th field="plan" fsortable="true"><?php echo $this->lang->line("plans"); ?></th>
                        <th field="status" fsortable="true" formatter="status" ><?php echo $this->lang->line("status"); ?></th>
                        <th field="view" formatter='action_column'><?php echo $this->lang->line("actions"); ?></th>                    
                    </tr>
                </thead>
            </table>                        
         </div>
		  <div id="tb" style="padding:3px">
       
			<a class="btn btn-warning"  title="<?php echo $this->lang->line("add"); ?> - <?php echo $this->lang->line("Plan"); ?>" data-toggle="modal" data-target="#add_plan">
			
			<i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("add"); ?>
			</a>  
         
        </div> 
    </div>
  </div>   
</section>

</div>
<script>    
var plan_id = 0;   
    $j(function() {
        $( ".datepicker" ).datepicker();
    });  

    var base_url="<?php echo site_url(); ?>"
    
    function action_column(value,row,index)
    {        
        var str="";
        var add_permission="<?php echo $add_permission; ?>";        
        var edit_permission="<?php echo $edit_permission; ?>";   
        var delete_permission="<?php echo $delete_permission; ?>";   
        
        
		if(edit_permission==1)
        str=str+"&nbsp;&nbsp;&nbsp;&nbsp;<a style='cursor:pointer' title='"+'<?php echo $this->lang->line("edit") ?>'+"' onclick='editPlan(this)'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/edit.png");?>" alt="Edit">'+"<input type='hidden' value='"+row.id+"' data='"+row.plan+"' id='plan_edit'></a>";

        if(delete_permission == 1){
			if(row.status == '1'){
				str=str+"&nbsp;&nbsp;&nbsp;&nbsp;<a style='cursor:pointer' data='remove' title='"+'<?php echo $this->lang->line("Remove the Plan") ?>'+"' onclick='deletePlan(this)'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/close.png");?>" alt="Delete">'+"<input type='hidden' value='"+row.id+"' id='plan_delete'></a>";
			}else{
				str=str+"&nbsp;&nbsp;&nbsp;&nbsp;<a style='cursor:pointer' data='activate' title='"+'<?php echo $this->lang->line("Activate the plan") ?>'+"' onclick='deletePlan(this)'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/Ok-16.png");?>" alt="activate">'+"<input type='hidden' value='"+row.id+"' id='plan_delete'></a>";
			}
			  
		}
      
        
        return str;
    } 
	function status(value,row,index){
		if(row.status == '1'){
			return "<label class='label label-success'>Active</label>";
		}
		if(row.status == '0'){
			return "<label class='label label-warning'>In Active</label>";
		}
		
	}
	function plan(e,plan){
		e.preventDefault();
		var id='';
		var plan_value='';
		var id='';
		if(plan == 'Add')
			var plan_value = $('#plan').val();
		if(plan == 'Update'){
			var plan_value = $('#plan_val').val();
			id=plan_id;
		}
		if(plan == 'Delete'){
			id=plan_id;
		}
		$.ajax({
				url : base_url+'admin/add_plans',
				data:{
					'plan_value' : plan_value,
					'id':id,
					'type': plan
									
				},
				method:'POST',
				success:function(response){
					if(response == 'success'){
						if(plan == 'Delete'){
							$('#deletePlan').modal('hide');
						}
						if(plan == 'Update'){
							$('#editPlan').modal('hide');
						}
						$j('#tt').datagrid('load');
					}
				}
			}) 
		
	}
	
	function editPlan(a){
		plan_id = $(a).find('#plan_edit').val();
		plan_name = $(a).find('#plan_edit').attr('data');
		$('#plan_val').val(plan_name);
		$("#editPlan").modal();
	}
	function deletePlan(a){
		plan_id = $(a).find('#plan_delete').val();
		var txt = $(a).attr('data');
		if(txt == 'remove'){
			$('#del_label').html('Are you sure want to remove this plan?');
		}
		if(txt == 'activate'){
			$('#del_label').html('Are you sure want to Activete this plan?');
		}
		$("#deletePlan").modal();
	}
</script>
<!-- Start Modal For plan add. -->
<div id="add_plan" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#215;</span>
                </button>
                <h4 id="new_search_details_title" class="modal-title"><i class="fa fa-cloud-upload"></i> Add Plan</h4>
            </div><br/>
            <div class="modal-body">
                     <form name="stockForm" method="POST" >            
                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="col-sm-3 control-label" ><?php echo $this->lang->line("Add Plan"); ?> 
							</label>
							<div class="col-sm-9 col-md-6 col-lg-6">
								<input type="text" name="plan" id="plan" class="form-control" placeholder="Add Plan"/>
							</div>
						</div><br/><br/><br/>
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="col-sm-3 control-label" >			</label>
							<div class="col-sm-9 col-md-6 col-lg-6">
								 <a class='btn btn-success' onclick="plan(event,'Add')"><i class="fa fa-upload"></i> Add</a> 
							</div>
						</div>    
					</form>						
             
				<br/>
                <br/>
                <br/>
                <br/>
            </div>   
        </div>
    </div>
</div>

<!-- End Modal For plan add. -->
<!-- Start Modal For plan edit. -->
<div id="editPlan" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#215;</span>
                </button>
                <h4 id="new_search_details_title" class="modal-title"><i class="fa fa-cloud-upload"></i> Edit Plan</h4>
            </div><br/>
            <div class="modal-body">
                     <form name="stockForm" method="POST" >            
                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="col-sm-3 control-label" ><?php echo $this->lang->line("Edit Plan"); ?> 
							</label>
							<div class="col-sm-9 col-md-6 col-lg-6">
								<input type="text" name="plan_val" id="plan_val" class="form-control"/>
							</div>
						</div><br/><br/><br/>
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="col-sm-3 control-label" >			</label>
							<div class="col-sm-9 col-md-6 col-lg-6">
								 <a class='btn btn-success' onclick="plan(event,'Update')"><i class="fa fa-upload"></i> Update</a> 
							</div>
						</div>    
					</form>						
             
				<br/>
                <br/>
                <br/>
                <br/>
            </div>   
        </div>
    </div>
</div>

<!-- End Modal For plan add. -->
<!-- Start Modal For plan edit. -->
<div id="deletePlan" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#215;</span>
                </button>
                <h4 id="new_search_details_title" class="modal-title"><i class="fa fa-cloud-upload"></i> Delete Conformation</h4>
            </div><br/>
            <div class="modal-body">
                     <form name="stockForm" method="POST" >            
                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="control-label" id="del_label" ></label>
							
						</div><br/><br/><br/>
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="col-sm-3 control-label" >			</label>
							<div class="col-sm-9 col-md-6 col-lg-6">
								 <a class='btn btn-info' onclick="plan(event,'Delete')">Yes</a> 
								 <a class="btn btn-default" data-dismiss="modal">Cancel</a> 
							</div>
						</div>    
					</form>						
             
				<br/>
                <br/>
                <br/>
                <br/>
            </div>   
        </div>
    </div>
</div>

<!-- End Modal For plan add. -->




