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
  <h1> <?php echo $this->lang->line("Update Book Stock"); ?> </h1>

</section>
<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
		<div class='alert alert-success text-center' id='bookstoreupdate' style='display:none;'>
			<h4 style='margin:0;'><i class='fa fa-check-circle'></i>Successfully Updated the Book Stock</h4><br/>
		</div>	
       <input type="text" id="book_id" name="book_id" placeholder="Book ID"> 
	   <input type="button" id="update" value="Update" onclick="fetch_bookid()">
	   
	   <div class="grid_container" style="width:100%; height:700px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin/list_Books"; ?>" 
            
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
                        <th field="email_id"><?php echo $this->lang->line("Email Id"); ?></th>
                        <th field="phone_number" ><?php echo $this->lang->line("Phone Number"); ?></th> 
                        <th field="title"  fsortable="true" ><?php echo $this->lang->line("Title"); ?></th>                      
                        <th field="isbn"  fsortable="true" ><?php echo $this->lang->line("ISBN"); ?></th>       
                        <th field="author" ><?php echo $this->lang->line("Author"); ?></th>                    
                        <th field="edition_year" ><?php echo $this->lang->line("Edition Year"); ?></th>    
                        <th field="publisher"  fsortable="true" ><?php echo $this->lang->line("Publisher"); ?></th>
                        <!--th field="view" formatter='action_column'><?php echo $this->lang->line("Action"); ?></th-->       
                    </tr>
                </thead>
            </table>                        
         </div>
	   
	   
    </div>
  </div>   
</section>

</div>
<script>
	function fetch_bookid(){
		var book_id=$('#book_id').val();
		//alert(book_id);
		$.ajax({
			type:'POST',
			url:'<?php echo base_url()."admin/update_bookstock_func"; ?>',
			data:{
				book_id: book_id
			},
			success:function(response){
				$('#book_id').val("");
				$('#bookstoreupdate').show();
				$('#bookstoreupdate').delay(1000).fadeOut();
				$j('#tt').datagrid('load');
			}
		});
	}
</script>


