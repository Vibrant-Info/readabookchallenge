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
  <h1> <?php echo $this->lang->line("Successful Orders"); ?> </h1>

</section>
<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
		 <form style="margin-top:20px" >
              <div class="form-group">
			  <div class="row">
				<div class="col-md-2">
					<label class="control-label" ><?php echo $this->lang->line("Total Amount :"); ?>   
					</label>
				</div>
				<div class="col-md-10">
					<label class="control-label"  id="completed_orders">	<?php echo $this->session->userdata('completed_amt'); ?>	</label>
				</div>
				<div class="col-md-2">
					<label class="control-label" ><?php echo $this->lang->line("Total Orders Count :"); ?>   
					</label>
				</div>
				<div class="col-md-10">
					<label class="control-label"  id="completed_orders_count">	<?php echo $this->session->userdata('completed_amt'); ?>	</label>
				</div>
				</div>
			</div>
				<!--<div class="form-group">
				<div class="row">
				  <div class="col-md-1">
						<label class="control-label" ><?php echo $this->lang->line("Returned :"); ?>   
					</label>
				</div>
				<div class="col-md-11">
					<label class="control-label"  id="returned_orders"><?php echo $this->session->userdata('returned_amt'); ?></label>
				</div>
				</div>-->
			</div>              
           </form>
        <div class="grid_container" style="width:100%; height:700px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."librarian/closed_list_data"; ?>" 
            
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
                        <th field="settlement_id" checkbox="true"><?php echo $this->lang->line("ID"); ?></th>                        
                        <th field="orders_nos" fsortable="true"><?php echo $this->lang->line("Order Number"); ?></th>
                        <th field="first_name" fsortable="true"  ><?php echo $this->lang->line("First Name"); ?></th>
                        <th field="last_name" fsortable="true" ><?php echo $this->lang->line("Last Name"); ?></th>
                        <th field="email_id" fsortable="true" ><?php echo $this->lang->line("Email Id"); ?></th>                 
                        <th field="total" formatter="calAmount"><?php echo $this->lang->line("Bill Amount"); ?></th>                    
                        <th field="payment_method"><?php echo $this->lang->line("Payment Type"); ?></th>                    
                        <th field="phone_number" ><?php echo $this->lang->line("Phone Number"); ?></th> 
						<th field="reason" ><?php echo $this->lang->line("Type"); ?></th>
						<th field="address" ><?php echo $this->lang->line("Address"); ?></th>
						<th field="area" ><?php echo $this->lang->line("area"); ?></th>
						<th field="city" ><?php echo $this->lang->line("city"); ?></th>
						<th field="pincode" ><?php echo $this->lang->line("pincode"); ?></th>
                        <th field="created_date" ><?php echo $this->lang->line("Created Date"); ?></th>
                    </tr>
                </thead>
            </table>                        
         </div>
		 <div id="tb" style="padding:3px">
            <form class="form-inline" style="margin-top:20px"  enctype="multipart/form-data">
                <!--<div class="form-group">
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
                </div> -->
				<div class="form-group">
                    <input id="start_date" type="date" name="start_date" class="form-control" placeholder="<?php echo $this->lang->line("Start Date"); ?>">
                </div>
				<div class="form-group">
                    <input id="end_date" type="date" name="end_date" class="form-control" placeholder="<?php echo $this->lang->line("End Date"); ?>">
                </div>
                <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line("search"); ?></button> 
				<div class="pull-right">
					<button class='btn btn-success'  id="btnExport"><?php echo $this->lang->line("export"); ?></button> 
				</div>
            </form>
        </div> 
    </div>
  </div>  
	<script type="text/javascript">
		function doSearch(event){
			event.preventDefault(); 
			$j('#tt').datagrid('load',{
			  start_date:       $j('#start_date').val(),
			  end_date:   $j('#end_date').val()
			});
		} 
		var total = 0;
		var count = 0;
		function calAmount(value,row,index){
			if(row.total != undefined ){
				total = parseInt(total) +  parseInt(row.total);
				count++;
			}
			$('#completed_orders').html('Rs. '+total);
			$('#completed_orders_count').html(count);
			
			return row.total;
		}
		
		$("#btnExport").click(function(e) { 
			var seleceted_rows = $j("#tt").datagrid("getSelections");
			
			if(seleceted_rows.length != "" && seleceted_rows.length != 0 ){
				var table = "<table><tr><th>Order Number</th><th>First Name</th><th>Last Name</th><th>Email Id</th><th>Bill Amount</th><th>Pincode</th><th>Created Date</th></tr>";
				for(var i=0; i < seleceted_rows.length; i++){
					table += "<tr><td>"+seleceted_rows[i]['orders_nos']+"</td><td>"+seleceted_rows[i]['first_name']+"</td><td>"+seleceted_rows[i]['last_name']+"</td><td>"+seleceted_rows[i]['email_id']+"</td><td>"+seleceted_rows[i]['total']+"</td><td>"+seleceted_rows[i]['pincode']+"</td><td>"+seleceted_rows[i]['created_date']+"</td></tr>"
				}
				table += "</table>";
				
				window.open('data:application/vnd.ms-excel,' + encodeURIComponent(table)); /**/
				e.preventDefault();
			}else{
				alert("Please select any of the orders!");
				e.preventDefault();
			}
		});
	</script>
</section>

</div>
