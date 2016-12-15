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
  <h1> <?php echo $this->lang->line("Summary"); ?> </h1>

</section>
<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
		
		 <form style="margin-top:20px" >
				<p>
					<label class="control-label" ><?php echo $this->lang->line("Assigning :"); ?>   
					</label> <label class="control-label"  id="assigning_orders">	</label>&nbsp;&nbsp;&nbsp;
					<label class="control-label" ><?php echo $this->lang->line("Packaging :"); ?>   
					</label> <label class="control-label"  id="packaging_orders">	</label>&nbsp;&nbsp;&nbsp;
					<label class="control-label" ><?php echo $this->lang->line("Labeling :"); ?>   
					</label> <label class="control-label"  id="labeling_orders">	</label>&nbsp;&nbsp;&nbsp;
					<label class="control-label" ><?php echo $this->lang->line("In Transit :"); ?>   
					</label> <label class="control-label"  id="transit_orders">	</label>&nbsp;&nbsp;&nbsp;
					<label class="control-label" ><?php echo $this->lang->line("Pickup :"); ?>   
					</label> <label class="control-label"  id="pickup_orders">	</label>&nbsp;&nbsp;&nbsp;
					<label class="control-label" ><?php echo $this->lang->line("Currently Reading :"); ?>   
					</label> <label class="control-label"  id="open_orders">	</label>&nbsp;&nbsp;&nbsp;
					<label class="control-label" ><?php echo $this->lang->line("Closed Orders:"); ?>   
					</label> <label class="control-label"  id="closed_orders">	</label>
				</p>
           </form>
			
        <div class="grid_container" style="width:100%; height:700px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."librarian/summary_data"; ?>" 
            
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
                        <th field="order_no" fsortable="true"><?php echo $this->lang->line("Order Number"); ?></th>
                        <th field="first_name" fsortable="true"  ><?php echo $this->lang->line("First Name"); ?></th>
                        <th field="last_name" fsortable="true" ><?php echo $this->lang->line("Last Name"); ?></th>
                        <th field="email_id" fsortable="true" ><?php echo $this->lang->line("Email Id"); ?></th>
                        <th field="books_nos" fsortable="true" ><?php echo $this->lang->line("No. of Books"); ?></th>                   
                        <th field="total" ><?php echo $this->lang->line("Bill Amount"); ?></th>                    
                        <th field="phone_number" ><?php echo $this->lang->line("Phone Number"); ?></th>               
                        <th field="payment_method" ><?php echo $this->lang->line("Payment Type"); ?></th>   
						<th field="shipping_mode" ><?php echo $this->lang->line("Shipping Mode"); ?></th>       						
                        <th field="status"  ><?php echo $this->lang->line("Status"); ?></th> 
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
                    <input id="phone_number" name="phone_number" class="form-control" size="15" placeholder="<?php echo $this->lang->line("Email ID"); ?>">
                </div> 
                <div class="form-group">
                    <input id="email_id" name="email_id" class="form-control" size="15" placeholder="<?php echo $this->lang->line("Phone Number"); ?>">
                </div> 
               
                <div class="form-group">
                    <input id="payment_method" name="payment_method" class="form-control" size="15" placeholder="<?php echo $this->lang->line("Payment Method"); ?>">
                </div> 
				<div class="form-group">
					<select id="status" name="status" class="form-control"  >
						<option value=""><?php echo $this->lang->line("All Orders"); ?></option>
						<option value="process"><?php echo $this->lang->line("In Process"); ?></option>
						<option value="transit"><?php echo $this->lang->line("In Transit"); ?></option>
						<option value="reading"><?php echo $this->lang->line("Currently Reading"); ?></option>
						<option value="done"><?php echo $this->lang->line("Done Reading"); ?></option>
						<option value="cancelled"><?php echo $this->lang->line("Cancelled"); ?></option>
					
					</select>
                  
                </div> 
                <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line("search"); ?></button> 
				<div class="pull-right">
					<button class='btn btn-success'  id="btnExport"><?php echo $this->lang->line("export"); ?></button> 
				</div>
            </form>
        </div>        
    </div>
  </div>   
</section>

</div>
<script> 
getSummary();
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
          status:   $j('#status').val()
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
       if(row.status == 'open')		
		str += "<label class='btn btn-success btn-sm'> Delivered </label>"; 
		if(row.status == 'returned')		
			str += "<input type='button' class='btn btn-success btn-sm' value='Return' onclick='returnBook(this)' data-id='"+row.id+"'>";
		if(row.status == 'pickup')		
			str += "<input type='button' class='btn btn-success btn-sm' value='Pick up' onclick='returnBook(this)' data-id='"+row.id+"'>";
		if(row.status == 'on transits')		
			str += "<input type='button' class='btn btn-success btn-sm' value='Transits' onclick='returnBook(this)' data-id='"+row.id+"'>";
	
        return str;
    }   
		
	var orderId;
	
	
	var return_id="";
	function returnBook(a){
		var id=$(a).data('id');
		return_id = id;
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
		function conformReturn(a){
			$.ajax({
			url : base_url+'librarian/returnBook',
			data:{
				'orderId': 	return_id,
				'status' :a
			},
			method:'POST',
			success:function(response){
				$j('#tt').datagrid('load');
			}
		});
		}
	function getSummary(){
			$.ajax({
			url : './summary_amt',
			method:'POST',
			success:function(response){
				var data  = JSON.parse(response);
				$('#assigning_orders').html(data.assigning);
				$('#packaging_orders').html(data.packaging);
				$('#labeling_orders').html(data.labeling);
				$('#transit_orders').html(data.transit);
				$('#pickup_orders').html(data.pickup);
				$('#open_orders').html(data.open);
				$('#closed_orders').html(data.closed);
			}
		});
	}
	
    $("#btnExport").click(function(e) { 
			var seleceted_rows = $j("#tt").datagrid("getSelections");
			console.log(seleceted_rows);
			console.log(seleceted_rows.length);
			if(seleceted_rows.length != "" && seleceted_rows.length != 0 ){
				var table = "<table><tr><th>Order Number</th><th>First Name</th><th>Last Name</th><th>Email Id</th><th>Number of Books</th><th>Bill Amount</th><th>Phone Number</th><th>Payment Type</th><th>Shipping Type</th><th>Status</th><th>Created Date</th></tr>";
				for(var i=0; i < seleceted_rows.length; i++){
					table += "<tr><td>"+seleceted_rows[i]['order_no']+"</td><td>"+seleceted_rows[i]['first_name']+"</td><td>"+seleceted_rows[i]['last_name']+"</td><td>"+seleceted_rows[i]['email_id']+"</td><td>"+seleceted_rows[i]['books_nos']+"</td><td>"+seleceted_rows[i]['total']+"</td><td>"+seleceted_rows[i]['phone_number']+"</td><td>"+seleceted_rows[i]['payment_method']+"</td><td>"+seleceted_rows[i]['shipping_mode']+"</td><td>"+seleceted_rows[i]['status']+"</td><td>"+seleceted_rows[i]['created_date']+"</td></tr>"
				}
				table += "</table>";
				window.open('data:application/vnd.ms-excel,' + encodeURIComponent(table)); /**/
				e.preventDefault();
			}else{
				alert("Please select any of the Books!");
				e.preventDefault();
			}
		});

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
