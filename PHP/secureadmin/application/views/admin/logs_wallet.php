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
  <h1> <?php echo $this->lang->line("Wallet Logs"); ?> </h1>

</section>
<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container" style="width:100%; height:700px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin/logs_wallet_func"; ?>" 
            
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
                        <!--th field="id" checkbox="true"><?php echo $this->lang->line("ID"); ?></th-->                        
                        <th field="first_name" fsortable="true"><?php echo $this->lang->line("First Name"); ?></th>
                        <th field="last_name" fsortable="true"><?php echo $this->lang->line("Last Name"); ?></th>
                        <th field="email_id" fsortable="true"><?php echo $this->lang->line("Email Id"); ?></th>
                        <th field="phone_number" fsortable="true"><?php echo $this->lang->line("Phone Number"); ?></th>
                        <th field="wallet_amount" fsortable="true"><?php echo $this->lang->line("Amount"); ?></th>
                        <th field="actions" fsortable="true"><?php echo $this->lang->line("actions"); ?></th>
                        <th field="created_date" ><?php echo $this->lang->line("Date of Action"); ?></th>                    
                    </tr>
                </thead>
            </table>                        
         </div>
    </div>
  </div>   
</section>

</div>



