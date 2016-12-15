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
  <h1> <?php echo $this->lang->line("Delivery & Pickup and Delivery"); ?> </h1>

</section>
<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
					
        <div class="grid_container" style="width:100%; height:700px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."librarian/transits_list_data"; ?>" 
            
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
                        <th field="total" ><?php echo $this->lang->line("Bill Amount"); ?></th>                    
                        <th field="address" ><?php echo $this->lang->line("Shipping address"); ?></th>                    
                        <th field="area" ><?php echo $this->lang->line("Area"); ?></th>                   
                        <th field="pincode" ><?php echo $this->lang->line("Pincode"); ?></th>                    
                        <th field="phone_number" ><?php echo $this->lang->line("Phone Number"); ?></th>               
                        <th field="payment_method" ><?php echo $this->lang->line("Payment Type"); ?></th>   
						<!--<th field="shipping_mode" ><?php echo $this->lang->line("Shipping Mode"); ?></th>-->
                        <th field="status"  ><?php echo $this->lang->line("Status"); ?></th> 
                        <th field="created_date" ><?php echo $this->lang->line("Created Date"); ?></th>            
                        <th field="cancel" formatter='cancel_column'><?php echo $this->lang->line("Cancel Order"); ?></th>            
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
                    <input id="payment_method" name="payment_method" class="form-control" size="15" placeholder="<?php echo $this->lang->line("Payment Method"); ?>">
                </div> <div class="form-group">
                    <input id="shipping_address" name="shipping_address" class="form-control" size="15" placeholder="<?php echo $this->lang->line("Shipping address"); ?>">
                </div> <div class="form-group">
                    <input id="area" name="area" class="form-control" size="15" placeholder="<?php echo $this->lang->line("Area"); ?>">
                </div> <div class="form-group">
                    <input id="pincode" name="pincode" class="form-control" size="15" placeholder="<?php echo $this->lang->line("pincode"); ?>">
                </div> 
                <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line("search"); ?></button> 
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
          payment_method:   $j('#payment_method').val(),
          shipping_address:   $j('#shipping_address').val(),
          area:   $j('#area').val(),
          pincode:   $j('#pincode').val()
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
		if(row.status == 'on transits')	{
			str += "<input type='button' class='btn btn-success btn-sm' value='Delivered ' onclick='conformReturn(this,3)' data-id='"+row.id+"'>&nbsp";
			str += "<input type='button' class='btn btn-danger btn-sm' value='Not Done' onclick='conformReturn(this, 4)' data-id='"+row.id+"'>";
		
		}	
		
        return str;
    }   
		
	var orderId;
	
	
	var return_id="";
	function returnBook(a){
		
		var rvalue = $(a).attr('value');
		if(rvalue == 'Return'){
			$("#return_Popup").modal();
		}else if(rvalue == 'Pick up'){
			$("#pickup_popup").modal();
		}else if(rvalue == 'Transits'){
			$("#transit_popup").modal();
		}
		
	}

    $("#import_book_btn").click(function(){
        $("#text_upload_modal").modal();
        });
		var book_id = 0;

		function addStock(a){
			book_id = $(a).find('.bkid').val();
			 $("#stockmodal").modal();
		}
		function conformReturn(a,th){
			var conf = confirm("Are you sure change the status?");
			
			if(conf){
				var id=$(a).data('id');
				return_id = id;
				$.ajax({
					url : base_url+'librarian/returnBook',
					data:{
						'orderId': 	return_id,
						'status' :th
					},
					method:'POST',
					success:function(response){
						$j('#tt').datagrid('load');
					}
				});
			}
		}

		function cancel_column(value,row,index){
			return "<input type='button' class='btn btn-warning btn-sm' value='Cancel Order' onclick='conformReturn(this, 0)' data-id='"+row.id+"'>";
		}
    

</script>
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
					<p>Are you sure to submit to Koorie?</p>
				</form>	
            </div> 
			<div class="modal-footer">
				<a class='btn btn-danger' data-dismiss="modal" > No</a> 
				<a class='btn btn-success' onclick="sendToDelivery()"> Done</a> 
			</div>
        </div>
    </div>
</div>
<!-- Start Modal For return book. -->
<div id="return_Popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#215;</span>
                </button>
                <h4 id="new_search_details_title" class="modal-title">Confirmation</h4>
            </div><br/>
            <div class="modal-body">
				<a class='btn btn-success' data-dismiss="modal" onclick="conformReturn('1')">Resend</a> 
				<a class='btn btn-danger' data-dismiss="modal" onclick="conformReturn('0')"> Cancel order</a> 
            </div> 
			<div class="modal-footer">
				
			</div>
        </div>
    </div>
</div>
<!-- Start Modal For Pick up book. -->
<div id="pickup_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#215;</span>
                </button>
                <h4 id="new_search_details_title" class="modal-title">Pick up confirmation</h4>
            </div><br/>
            <div class="modal-body">
				<a class='btn btn-success' data-dismiss="modal" onclick="conformReturn('2')">Pickup</a> 
				<a class='btn btn-danger' data-dismiss="modal"> Cancel</a> 
            </div> 
			<div class="modal-footer">
				
			</div>
        </div>
    </div>
</div><!-- Start Modal For Transit book. -->
<div id="transit_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#215;</span>
                </button>
                <h4 id="new_search_details_title" class="modal-title">Transit up confirmation</h4>
            </div><br/>
            <div class="modal-body">
				<a class='btn btn-success' data-dismiss="modal" onclick="conformReturn('3')">Delivered</a> 
				<a class='btn btn-danger' data-dismiss="modal" onclick="conformReturn('4')"> Returned</a> 
            </div> 
			<div class="modal-footer">
				
			</div>
        </div>
    </div>
</div>
