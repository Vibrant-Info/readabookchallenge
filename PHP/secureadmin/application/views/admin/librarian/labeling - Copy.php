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
  <h1> <?php echo $this->lang->line("Labeling & Delivery"); ?> </h1>

</section>
<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
		<div>
			<a class="btn btn-success pull-right" id="barcode" title="Generate Catalog"><i class="fa fa-barcode"></i> Print Labeling</a>
		 </div>
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
                        <th field="order_no" fsortable="true"><?php echo $this->lang->line("Order Number"); ?></th>
                        <th field="first_name" fsortable="true"  ><?php echo $this->lang->line("First Name"); ?></th>
                        <th field="last_name" fsortable="true" ><?php echo $this->lang->line("Last Name"); ?></th>
                        <th field="email_id" fsortable="true" ><?php echo $this->lang->line("Email Id"); ?></th>
                        <th field="books_nos" fsortable="true" ><?php echo $this->lang->line("No. of Books"); ?></th>                   
                        <th field="total" ><?php echo $this->lang->line("Bill Amount"); ?></th>                    
                        <th field="phone_number" ><?php echo $this->lang->line("Phone Number"); ?></th>                    
                        <th field="ip_address" ><?php echo $this->lang->line("IP Address"); ?></th>                    
                        <th field="payment_method" ><?php echo $this->lang->line("Payment Type"); ?></th>                    
                        <th field="status"  ><?php echo $this->lang->line("Status"); ?></th> 
                        <th field="created_date" ><?php echo $this->lang->line("Created Date"); ?></th>                    
                        <th field="view" formatter='action_column'><?php echo $this->lang->line("Action"); ?></th>                    
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
       if(row.status == 'open')		
		str += "<label class='btn btn-success btn-sm'> Delivered </label>"; 
		if(row.status == 'returned')		
			str += "<input type='button' class='btn btn-success btn-sm' value='Return' onclick='returnBook(this)' data-id='"+row.id+"'>";
	
        return str;
    }   
		
	var orderId;
	
	function deliveryConfirmation(order_id){
		orderId = order_id;
		$("#confirmationPopup").modal();
	}
	function sendToDelivery(){
		$.ajax({
			url : base_url+'librarian/sendToTransit',
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
	
	$('#barcode').click(function(){
        var url = "<?php echo site_url('admin/barcode_generate');?>";
        var rows = $j("#tt").datagrid("getSelections");
		
        var info=JSON.stringify(rows); 
        if(rows == '')
        {
            alert("<?php echo $this->lang->line('you haven\'t select any book'); ?>");
            return false;
        }
        $.ajax({
            type:'POST',
            url:url,
            data:{
				'info':info,
				'types':'orders'
			},
            success:function(response){
                //$('#for_barcode_displays').html(response);
                /* docw();
                setTimeout(function(){PrintElem('#for_barcode_displays')}, 2000); */
				$('#print_barcode').hide();
				var mywindow = window.open('', '', 'height=562,width=795'); 
				mywindow.document.write('<html><head>'); 
				// mywindow.document.write('<style> table.print_slip tbody td {border:1px solid #ccc; }</style>'); 
				mywindow.document.write('</head><body >'); 
				mywindow.document.write(response); 
				mywindow.document.write('</body></html>'); 		
				mywindow.document.close(); 
				setTimeout(function(){mywindow.print()}, 1000); 
            }
        });
    });
	var return_id="";
	function returnBook(a){
		var id=$(a).data('id');
		return_id = id;
		$("#return_Popup").modal();
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
				$("#return_Popup").modal('hide');
			}
		});
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
				<form name="stockForm" method="POST" > 
					<p>Are you sure want to return the book?</p>
				</form>	
            </div> 
			<div class="modal-footer">
				<a class='btn btn-success'  onclick="conformReturn('1')">Yes</a> 
				<a class='btn btn-danger' data-dismiss="modal" onclick="conformReturn('0')"> No</a> 
			</div>
        </div>
    </div>
</div>
