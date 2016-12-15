<?php 
	$CI =& get_instance();
	$CI->load->library('session');	
	
	if($CI->session->flashdata('delete_success_message')==1)
	echo "<div class='alert alert-success text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> Your data has been successfully deleted from the database. </h4></div>";
	
	if($CI->session->flashdata('delete_error_message')==1)
	echo "<div class='alert alert-success text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> Your data has been failed to delete from the database. </h4></div>";

	 if($CI->session->userdata('category_success')==1)
    {
       echo "<div class='alert alert-success text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> Your data has been successfully stored in the database. </h4></div>";
	   
       $CI->session->unset_userdata('category_success');
    } 
	if($CI->session->userdata('category_error')==1)
    {
       echo "<div class='alert alert-success text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> Your data has not been stored in the database. </h4></div>";
	   
       $CI->session->unset_userdata('category_error');
    } 
	
?>