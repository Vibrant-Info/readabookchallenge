<?php $this->load->view('admin/theme/message'); ?>

<?php
    if($this->session->userdata('vendor_file_name')==1)
    {
        echo "<div class='alert alert-success text-center'><h4 style='margin:0;'>";
        echo "<i class='fa fa-check-circle'></i>".$this->lang->line("your data has been successfully stored into the database.")."</h4><br/>";
       $this->session->unset_userdata('vendor_file_name');
    } 
        $add_permission    = 1;
        $edit_permission    = 1;
        $delete_permission  = 1;
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> <?php echo $this->lang->line("Vendors"); ?> </h1>

</section>
<div id="div_for_print_book_ids" style="display:none;"><?php if(isset($vendor_ids)) echo $vendor_ids; ?></div>

<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container" style="width:100%; height:700px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin/vendor_list_data"; ?>" 
            
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
                        <th field="unique_id" fsortable="true"><?php echo $this->lang->line("unique id"); ?></th>                        
                        <th field="name" fsortable="true"><?php echo $this->lang->line("name"); ?></th>                        
                        <th field="email"  sortable="true" ><?php echo $this->lang->line("email"); ?></th>
                        <th field="phone" sortable="true" ><?php echo $this->lang->line("phone"); ?></th>
                        <th field="address" sortable="true" ><?php echo $this->lang->line("address"); ?> </th>
                        <th field="view" formatter='action_column'><?php echo $this->lang->line("actions"); ?></th>                    
                    </tr>
                </thead>
            </table>                        
         </div>
  
       <div id="tb" style="padding:3px">
       
			<a class="btn btn-warning"  title="<?php echo $this->lang->line("add"); ?> - <?php echo $this->lang->line("Vendor"); ?>" href="<?php echo site_url('admin/add_vendor');?>">
			<i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("add"); ?>
			</a>  
            <form class="form-inline" style="margin-top:20px"  enctype="multipart/form-data">

                <div class="form-group">
                    <input id="unique_id" name="unique_id" class="form-control" size="15" placeholder="<?php echo $this->lang->line("unique id"); ?>">
                </div>

                <div class="form-group">
                    <input id="name" name="name" class="form-control" size="15" placeholder="<?php echo $this->lang->line("vendor name"); ?>">
                </div>  

                <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line("search"); ?></button>     

                      
            </form> 

        </div>        
    </div>
  </div>   
</section>


<script>       
    $j(function() {
        $( ".datepicker" ).datepicker();
    });  

    var base_url="<?php echo site_url(); ?>"
    
    function action_column(value,row,index)
    {               
       
        var add_url=base_url+'admin/createVendorSession';
        var edit_url=base_url+'admin/update_vendor/'+row.id;
        var delete_url=base_url+'admin/delete_vendor_action/'+row.id;
        
        var str="";
        var add_permission="<?php echo $add_permission; ?>";        
        var edit_permission="<?php echo $edit_permission; ?>";   
        var delete_permission="<?php echo $delete_permission; ?>";   
        
             
         if(add_permission==1){
			 str=str+"&nbsp;&nbsp;&nbsp;&nbsp;<a style='cursor:pointer' title='"+'<?php echo $this->lang->line("Add Book") ?>'+"' onclick='addBook(this)'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/add_book1.png");?>" alt="Add Book">'+"<input type='hidden' value='"+row.name+"-"+row.unique_id+"' class='bkname'></a>";
		 }
			
 
		if(edit_permission==1)
        str=str+"&nbsp;&nbsp;&nbsp;&nbsp;<a style='cursor:pointer' title='"+'<?php echo $this->lang->line("edit") ?>'+"' href='"+edit_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/edit.png");?>" alt="Edit">'+"</a>";

        if(delete_permission == 1)
        str=str+"&nbsp;&nbsp;&nbsp;&nbsp;<a style='cursor:pointer' title='"+'<?php echo $this->lang->line("delete") ?>'+"' href='#' onclick='deleteVendor("+row.id+")'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/close.png");?>" alt="Delete">'+"</a>";
        
        return str;
    }  

     
    function doSearch(event)
    {
        event.preventDefault(); 
        $j('#tt').datagrid('load',{
          unique_id:          $j('#unique_id').val(),
          name:             $j('#name').val(),
          is_searched:      1
        });


    }  
	function addBook(a){
		var names = $(a).find('.bkname').val();
		$.ajax({
			url : base_url+'admin/createVendorSession',
			data:{
				value : names
			},
			dataType:'JSON',
			success:function(response){
				location.href=base_url+'admin/add_book';
			}
		}) 
	}
	var strsss = "";
	function number_books(value,row,index){
		$.ajax({
			url : base_url+'admin/numberOfBooks?name='+row.name,
			dataType:'JSON',
			success:function(response){
				strsss = response;
				console.log(strsss)
			}
		});
		return strsss;
		/* setTimeout(function(){
			alert(strsss)
		},1000) */
		
	}
	
	function number_orders(value,row,index){
		/* $.ajax({
			url : base_url+'admin/numberOfBooks',
			data:{
				name : row.name
			},
			dataType:'JSON',
			success:function(response){
				//location.href=base_url+'admin/add_book';
			}
		})  */
	}
	
	function deleteVendor(id){
		var conf = confirm("Are you to delete the vendor?");
		if(conf){
			window.location.href = base_url+'admin/delete_vendor_action/'+id;
		}
	}
</script>



