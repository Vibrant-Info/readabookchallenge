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
  <h1> <?php echo $this->lang->line("Packaging"); ?> </h1>

</section>
<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container" style="width:100%; height:700px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."librarian/packaging_list_data"; ?>" 
            
            pagination="true" 
            rownumbers="true" 
            toolbar="#tb" 
            pageSize="50" 
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
                        <th field="view" formatter='action_column'><?php echo $this->lang->line("Action"); ?></th>      						
                        <th field="order_no" fsortable="true"><?php echo $this->lang->line("Order Number"); ?></th>  
						<th field="books_ids" ><?php echo $this->lang->line("Selected Books IDs"); ?></th> 
                        <th field="first_name" fsortable="true"  ><?php echo $this->lang->line("First Name"); ?></th>
                        <th field="last_name" fsortable="true" ><?php echo $this->lang->line("Last Name"); ?></th>
                        <th field="email_id" fsortable="true" ><?php echo $this->lang->line("Email Id"); ?></th>
                        <th field="books_nos" fsortable="true" ><?php echo $this->lang->line("No. of Books"); ?></th>
                        <th field="delivery_time" ><?php echo $this->lang->line("Delivery Time"); ?></th>                    
                        <th field="total" ><?php echo $this->lang->line("Bill Amount"); ?></th>                    
                        <th field="phone_number" ><?php echo $this->lang->line("Phone Number"); ?></th>                
                        <th field="payment_method" ><?php echo $this->lang->line("Payment Type"); ?></th>  
						<th field="shipping_mode" ><?php echo $this->lang->line("Shipping Mode"); ?></th>
                        <th field="status" ><?php echo $this->lang->line("Status"); ?></th> 
						<th field="created_date" ><?php echo $this->lang->line("Created Date"); ?></th>                
                    </tr>
                </thead>
            </table>                        
         </div>
		 <div id="tb" style="padding:3px">
            <form class="form-inline" style="margin-top:20px"  enctype="multipart/form-data">
                <div class="form-group">
                    <input id="order_no" name="order_no" class="form-control" size="15" placeholder="<?php echo $this->lang->line("Order Number"); ?>">
                </div>
                <div class="form-group">
                    <input id="first_name" name="first_name" class="form-control" size="15" placeholder="<?php echo $this->lang->line("First Name"); ?>">
                </div>
                <div class="form-group">
                    <input id="last_name" name="last_name" class="form-control" size="15" placeholder="<?php echo $this->lang->line("Last Name"); ?>">
                </div>
                <div class="form-group">
                    <input id="phone_number" name="phone_number" class="form-control" size="15" placeholder="<?php echo $this->lang->line("Email ID"); ?>">
                </div> 
                <div class="form-group">
                    <input id="email_id" name="email_id" class="form-control" size="15" placeholder="<?php echo $this->lang->line("Phone Number"); ?>">
                </div> 
                <div class="form-group">
                    <input id="ip_address" name="ip_address" class="form-control" size="15" placeholder="<?php echo $this->lang->line("Ip Address"); ?>">
                </div> 
                <div class="form-group">
                    <input id="payment_method" name="payment_method" class="form-control" size="15" placeholder="<?php echo $this->lang->line("Payment Method"); ?>">
                </div> 
                <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line("search"); ?></button> 
				
				<div class="pull-right">
					<input type="button" class="btn btn-success" value="Bulk Request Labeling" id="bulkChange" />
				</div>
            </form>
        </div>
    </div>
  </div>   
</section>

</div>
<script> 
	function doSearch(event){
        event.preventDefault(); 
        $j('#tt').datagrid('load',{
          order_no:         $j('#order_no').val(),
          first_name:       $j('#first_name').val(),
          last_name:        $j('#last_name').val(),
          phone_number:     $j('#phone_number').val(),           
          email_id:     	$j('#email_id').val(),
          ip_address:       $j('#ip_address').val(),
          payment_method:   $j('#payment_method').val()
        });
    } 
	
	var plan_id = 0;   
    $j(function() {
        $( ".datepicker" ).datepicker();
    });  

    var base_url="<?php echo site_url(); ?>"
    var number_of_books = 0;
    function action_column(value,row,index)
    {    
        var str="";
        var add_permission="<?php echo $add_permission; ?>";        
        var edit_permission="<?php echo $edit_permission; ?>";   
        var delete_permission="<?php echo $delete_permission; ?>";   
        
		number_of_books = row.books_nos;
		
		str += "<input type='button' class='btn btn-info btn-sm' value='Books' onclick='books("+row.id+")' >";
		str += "&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' class='btn btn-success btn-sm' value='Move to Labeling' onclick='labelConfirmation("+row.id+")' >";
		
        //str=str+"&nbsp;&nbsp;&nbsp;&nbsp;<a style='cursor:pointer' title='"+'<?php echo $this->lang->line("edit") ?>'+"' onclick='editPlan(this)'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/edit.png");?>" alt="Edit">'+"<input type='hidden' value='"+row.id+"' data='"+row.plan+"' id='plan_edit'></a>";
		
        /* if(delete_permission == 1){
			if(row.status == '1'){
				str=str+"&nbsp;&nbsp;&nbsp;&nbsp;<a style='cursor:pointer' data='remove' title='"+'<?php echo $this->lang->line("Remove the Plan") ?>'+"' onclick='deletePlan(this)'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/close.png");?>" alt="Delete">'+"<input type='hidden' value='"+row.id+"' id='plan_delete'></a>";
			}else{
				str=str+"&nbsp;&nbsp;&nbsp;&nbsp;<a style='cursor:pointer' data='activate' title='"+'<?php echo $this->lang->line("Activate the plan") ?>'+"' onclick='deletePlan(this)'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/Ok-16.png");?>" alt="activate">'+"<input type='hidden' value='"+row.id+"' id='plan_delete'></a>";
			}
			  
		} */
      
        
        return str;
    } 
	
	var orderId;
	function books(order_id){
		orderId = order_id;
		$("#books").modal();
		
		$.ajax({
			url : base_url+'librarian/getOrderedBooks',
			data:{
				'orderId': orderId
								
			},
			method:'POST',
			success:function(response){
				$("#sectionPlace").html(response);
			}
		});
	}
	
	function labelConfirmation(order_id){
		orderId = order_id;
		$("#confirmationPopup").modal();
	}
	function sendToLabel(){
		$.ajax({
			url : base_url+'librarian/sendToLabel',
			data:{
				'orderId': orderId								
			},
			method:'POST',
			success:function(response){
				$j('#tt').datagrid('load');
				$("#confirmationPopup").modal('hide');
			}
		});
	}
	
	$('#bulkChange').click(function(){
        var rows = $j("#tt").datagrid("getSelections");
        var info=JSON.stringify(rows);
        if(rows == '')
        {
            alert("<?php echo $this->lang->line('you haven\'t select any orders'); ?>");
            return false;
        }
		var conf = confirm("Are you sure to change Bulk status?");
		if(conf){
			$.ajax({
				url : base_url+'librarian/bulkStatuschange',
				data:{
					'info': info,
					'status' : 'labeling'
				},
				method:'POST',
				success:function(response){
					$j('#tt').datagrid('load');
					//$("#confirmationPopup").modal('hide');
				}
			});
		}
    });
</script>
<div id="books" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#215;</span>
                </button>
                <h4 id="new_search_details_title" class="modal-title"><i class="fa fa-cloud-upload"></i>Selected Books</h4>
            </div><br/>
            <div class="modal-body">
				<form name="stockForm" method="POST" > 
					<div id="sectionPlace"></div>
				</form>	
            </div> 
			<div class="modal-footer">
				<a class='btn btn-success' data-dismiss="modal"> Done</a> 
			</div>
        </div>
    </div>
</div>

<!-- Start Modal For plan add. -->
<div id="confirmationPopup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#215;</span>
                </button>
                <h4 id="new_search_details_title" class="modal-title">Confirmation</h4>
            </div><br/>
            <div class="modal-body">
				<form name="stockForm" method="POST" > 
					<p>Are you sure to move this order to Labeling?</p>
				</form>	
            </div> 
			<div class="modal-footer">
				<a class='btn btn-danger' data-dismiss="modal" > No</a> 
				<a class='btn btn-success' onclick="sendToLabel()"> Done</a> 
			</div>
        </div>
    </div>
</div>
