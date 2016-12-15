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
  <h1> <?php echo $this->lang->line("Currently Reading"); ?> </h1>

</section>
<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container" style="width:100%; height:700px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."librarian/open_list_data"; ?>" 
            
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
						<th field="books_ids" ><?php echo $this->lang->line("Selected Books IDs"); ?></th>
                        <th field="first_name" fsortable="true"  ><?php echo $this->lang->line("First Name"); ?></th>
                        <th field="last_name" fsortable="true" ><?php echo $this->lang->line("Last Name"); ?></th>
                        <th field="email_id" fsortable="true" ><?php echo $this->lang->line("Email Id"); ?></th>
                        <th field="books_nos" fsortable="true" ><?php echo $this->lang->line("No. of Books"); ?></th>
                        <th field="total" ><?php echo $this->lang->line("Bill Amount"); ?></th>                    
                        <th field="phone_number" ><?php echo $this->lang->line("Phone Number"); ?></th>               
                        <th field="payment_method" ><?php echo $this->lang->line("Payment Type"); ?></th>   
						<th field="shipping_mode" ><?php echo $this->lang->line("Shipping Mode"); ?></th>
                        <th field="status" ><?php echo $this->lang->line("Status"); ?></th>                   
                        <th field="delivery_date" ><?php echo $this->lang->line("Delivered Time"); ?></th>                 
                        <th field="requested_date" ><?php echo $this->lang->line("requested pickup time"); ?></th>                
                        <!--<th field="due_date" ><?php echo $this->lang->line("due time"); ?></th>-->
                        <th field="action" formatter='countDown' align="center"><?php echo $this->lang->line("Count Down"); ?></th>                
                        <th field="created_date" ><?php echo $this->lang->line("Created date"); ?></th>                
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
		 <div class="datagrid-cell"></div>
    </div>
  </div>  
<script type="text/javascript">
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
	function countDown(value,row,index){
		var date1 = new Date();
		var date2 = new Date(row.due_date);
		var timeDiff = date2.getTime() - date1.getTime();
		
		//if(timeDiff > 0){
			if(row.status == "open"){			
				var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
				return diffDays + " Days remaining";
			}
			if(row.status == "pickup"){
				//return str = "<a href='#' onclick='changeStatus("+row.id+")'><i class='fa fa-flag'></i></a>"
			}
		//} else{
			/*$.ajax({
				url : "<?php echo base_url().'librarian/sendToDue'; ?>",
				data:{
					'orderId': row.id								
				},
				method:'POST',
				success:function(response){
					//$j('#tt').datagrid('load');
				}
			});
		} */
	}
	/* 
	function changeStatus(id){
		var conf = confirm("Are you sure to change Status to 'On Transit'? ");
		if(conf){
			$.ajax({
				url : "<?php echo base_url().'librarian/sendToTransit'; ?>",
				data:{
					'orderId': id								
				},
				method:'POST',
				success:function(response){
					$j('#tt').datagrid('load');
				}
			});
		}
	} */
</script>
</section>

</div>
