<?php
    if(isset($_GET['msg']))
    {
        echo "<div class='alert alert-success text-center'><h4 style='margin:0;'>";
        echo "<i class='fa fa-check-circle'></i>".$this->lang->line("your data has been successfully stored into the database.")."</h4></div><br/>";
    } 
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<style>
.skin-blue .content-header {
    min-height: 800px;
}
</style>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>  <!---->
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<section class="content-header">
	<section class="content">
		<?php 

session_start();
?>
		<div class="box box-info custom_box">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("add"); ?> - <?php echo $this->lang->line("book"); ?></h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			<?php
			if(empty($this->session->userdata['vendor'])){?>
			<div class="box-body">
				<div class="form-group">
					<label class="col-sm-3 control-label" ><?php echo $this->lang->line("vendor"); ?>   *
					</label>
					<div class="col-sm-9 col-md-6 col-lg-6 form-inline">
						<?php
							echo "<select class='form-control' id='sess_vendor'><option></option>";
							foreach ($info3 as $vendor_list)
							{
								echo '<option value="'.$vendor_list['name'].'-'.$vendor_list['unique_id'].'">'.$vendor_list['name'].'-'.$vendor_list['unique_id'].'</option>';
							}
							echo "<select>";
						?>
						<input type="button" class="btn btn-sm btn-success" value="Add" onclick="addSession()"/>
					</div>
				</div>
			</div>
			<?php } ?>
			<?php if(!empty($this->session->userdata['vendor'])){?>
			<form class="form-horizontal" action="<?php echo site_url().'admin/add_book_action';?>" id="bookForm" enctype="multipart/form-data" method="POST" >
				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-12 text-center">
							<input name="add_form" type="button" id="add_form" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line('save');?>"/>  
							<input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line('cancel');?>" onclick='goBack("admin/book_list")'/>  
						</div>
					</div>
				</div>
				<div class="box-body">
					
					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("vendor"); ?>   *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input value="<?php echo $this->session->userdata['vendor'];?>"   class="form-control" type="text" disabled><br/>
							<input type="button" class="btn btn-sm btn-danger" value="Change Vendor" onclick="removeSession()">
							<input name="vendor" value="<?php echo $this->session->userdata['vendor'];?>"  id="vendor" class="form-control" type="hidden">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("ISBN"); ?>  *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="isbn" value="<?php echo set_value('isbn');?>"  class="form-control" id="isbn" type="text" onchange="getBooks(event)" autofocus="on">
							<span class="red"><?php echo form_error('isbn'); ?></span>
							<span class="red hide dub">ISBN number already exists!</span>
						</div>
					</div>


					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("title"); ?>   *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="title" value="<?php echo set_value('title');?>"  class="form-control" type="text" id="title">		          
							<span class="red"><?php echo form_error('title'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("subtitle"); ?>  
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="subtitle" value="<?php echo set_value('subtitle');?>"  class="form-control" type="text" id="subtitle">		          
							<span class="red"><?php echo form_error('subtitle'); ?></span>
						</div>
					</div> 

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("author"); ?>  *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="author" value="<?php echo set_value('author');?>"  class="form-control" type="text" id="author">		               
							<span class="red"><?php echo form_error('author'); ?></span>
						</div>
					</div>	

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("edition"); ?>
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="edition" value="<?php echo set_value('edition');?>"  class="form-control" type="text" id="edition">		          
							<span class="red"><?php echo form_error('edition'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("edition year"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="edition_year" value="<?php echo set_value('edition_year');?>"  class="form-control" type="date" id="edition_year">		          
							<span class="red"><?php echo form_error('edition_year'); ?></span>
						</div>
					</div> 

					<!--<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("number of copies"); ?>   *
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input type="number" min="1" name="number_of_books" value="<?php if(form_error('number_of_books')) echo set_value('number_of_books'); else echo 1;?>"  class="form-control" id="number_of_books" >		          
							<span class="red"><?php echo form_error('number_of_books'); ?></span>
						</div>
					</div>-->

					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo $this->lang->line("cover image"); ?> </label>
						<div class="col-sm-9 col-md-6 col-lg-6 manual_img">
							<input id="photo" name="photo" class="form-control" type="file"  value="<?php echo set_value('photo'); ?>">
							<span class="blue"><?php echo $this->lang->line("max dimension"); ?>  : 1200 X 2000</span><br/>
							<span class="blue"><?php echo $this->lang->line("max size"); ?> : 1024KB <?php echo $this->lang->line("allowed format");?> : jpg,png</span><br/>
							<!-- <span class="red"><?php $error=$this->session->flashdata('photo_error'); echo $error['error']; ?></span> -->
							<span class="red"><?php echo $this->session->userdata('photo_error'); $this->session->unset_userdata('photo_error'); ?></span>
						</div>
						<div class="col-sm-9 col-md-6 col-lg-6 google hide">
							<img src="" id="google_img_src">
							<input type="hidden" name="google_img" id="google_img" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("Genre"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6 manual_img">		    
							<?php 
							foreach ($info2 as $cat)
							{
								echo '<input name="cat[]" type="checkbox" value="'.$cat["id"].'"/> '.$cat["category_name"].'<br/>';
							}
							?>       		             		             		 	          
							<span class="red"><?php echo form_error('cat'); ?></span>
						</div>	
						<div class="col-sm-9 col-md-6 col-lg-6 google hide">		    
							<input type="text" name="google_category" id="google_category" class="form-control" >
						</div>		             
					</div> 


					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("physical form"); ?>  
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<?php	$all_physical_form['']="";
							echo form_dropdown('physical_form',$all_physical_form,'','class="form-control" id="physical_form"');  ?>			          
							<span class="red"><?php echo form_error('all_physical_form'); ?></span>
						</div>
					</div> 
										

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("publisher"); ?>  
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="publisher" value="<?php echo set_value('publisher');?>"  class="form-control" type="text" id="publisher">		          
							<span class="red"><?php echo form_error('publisher'); ?></span>
						</div>
					</div> 



					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("series"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="series" value="<?php echo set_value('series');?>"  class="form-control" type="text" id="series">		          
							<span class="red"><?php echo form_error('series'); ?></span>
						</div>
					</div> 

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("size"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<?php	$size_all['']="";
							echo form_dropdown('size1',$size_all,'','class="form-control" id="size1"');  ?>			          
							<span class="red"><?php echo form_error('size1'); ?></span>
						</div>
					</div>  

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("price"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="price" value="<?php echo set_value('price');?>"  class="form-control" type="text" id="price">		          
							<span class="red"><?php echo form_error('price'); ?></span>
						</div>
					</div> 

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("call no"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="call_no" value="<?php echo set_value('call_no');?>"  class="form-control" type="text" id="call_no">		          
							<span class="red"><?php echo form_error('call_no'); ?></span>
						</div>
					</div> 

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("location"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="location" value="<?php echo set_value('location');?>"  class="form-control" type="text" id="location">		          
							<span class="red"><?php echo form_error('location'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("clue page"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="clue_page" value="<?php echo set_value('clue_page');?>"  class="form-control" type="text" id="clue_page">		          
							<span class="red"><?php echo form_error('clue_page'); ?></span>
						</div>
					</div>


				

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("editor"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="editor" value="<?php echo set_value('editor');?>"  class="form-control" type="text" id="editor">		          
							<span class="red"><?php echo form_error('editor'); ?></span>
						</div>
					</div>
					

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("publication"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="publishing_year" value="<?php echo set_value('publishing_year');?>"  class="form-control" type="date" id="publishing_year">		          
							<span class="red"><?php echo form_error('publishing_year'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("publication place"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="publication_place" value="<?php echo set_value('publication_place');?>"  class="form-control" type="text" id="publication_place">		          
							<span class="red"><?php echo form_error('publication_place'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("total pages"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="number_of_pages" value="<?php echo set_value('number_of_pages');?>"  class="form-control" type="text" id="number_of_pages">		          
							<span class="red"><?php echo form_error('number_of_pages'); ?></span>
						</div>
					</div>

					

					<!-- <div class="form-group">
						<label class="col-sm-3 control-label" >Dues
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="dues" value="<?php echo set_value('dues');?>"  class="form-control" type="text">		          
							<span class="red"><?php echo form_error('dues'); ?></span>
						</div>
					</div>  -->

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("source of book"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<?php	$all_source_details['']="";
							echo form_dropdown('source_details',$all_source_details,set_value('source_details'),'class="form-control" id="source_details"');  ?>			          
							<span class="red"><?php echo form_error('source_details'); ?></span>
						</div>
					</div> 

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("notes"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="notes" value="<?php echo set_value('notes');?>"  class="form-control" type="text">		          
							<span class="red"><?php echo form_error('notes'); ?></span>
						</div>
					</div>


					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo $this->lang->line("pdf / epub version- if available"); ?> </label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input id="pdf" name="pdf" class="form-control" type="file"  value="<?php echo set_value('pdf'); ?>">
							<span class="red"><?php echo $this->session->userdata('pdf_error'); $this->session->unset_userdata('pdf_error'); ?></span>
						</div>
					</div> 

					<div class="form-group">
						<label class="col-sm-3 control-label" >
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<span><?php echo $this->lang->line("OR"); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" ><?php echo $this->lang->line("pdf / epub link- if available"); ?> 
						</label>
						<div class="col-sm-9 col-md-6 col-lg-6">
							<input name="link" value="<?php echo set_value('link');?>"  class="form-control" type="text">		          
							<span class="red"><?php echo form_error('link'); ?></span>
						</div>
					</div>


				</div> <!-- /.box-body --> 
				<!-- /.box-footer -->         
			</div><!-- /.box-info -->       
		</form> 
			<?php } ?>
	</div>
	<script>
		$(function() {
			$( "#vendor" ).autocomplete({
				source: function(request, response){
					$.ajax({
						url: "<?php echo site_url().'admin/getVendors';?>",
						dataType: "json",
						data:{ term: request.term },
						success: function(data) {
							response( $.map( data, function(item) {
								return { label: item.name, value: item.name };
							}));
							$("#ui-id-1 li").on('click',function(){
								$('#vendor').val($(this).text());
							});
						}						
					});
				},
				minLength:2
			});
		
			$("#add_form").on('click', function(e){
				
				var checkedGenre = $('[name="cat[]"]:checked').length;
				if( $("#google_category").val() != "" || checkedGenre > 0 ){
					$("#bookForm").submit();
				}else{
					alert("Please enter Genre!");
					$("#google_category").css('border', '1px solid red');
				}
					
			});
		});
		
		function check(val){
			if(val != ""){
				$.ajax({
					url: "<?php echo site_url().'admin/checkISBN';?>",
					dataType: "json",
					data:{ value:  val},
					success: function(data) {
						if(data){
							$(".dub").removeClass("hide");
							$('input[type="button"]').prop('disabled', true);
						}else{
							$(".dub").addClass("hide");
							$('input[type="button"]').prop('disabled', false);
						}
					}						
				});
			}
		}
			function getBooks(e){
				e.preventDefault();
				var word = $("#isbn").val();
				$.get("https://www.googleapis.com/books/v1/volumes?q=isbn:"+word+"&maxResults=40", function(data, status){
					if(data.totalItems > 0){
						$(".found").addClass("hide");
						handleResponse(data);
					}else{
						$.ajax({
							url: "<?php echo site_url().'admin/getBooksAPI';?>",
							dataType: "json",
							data:{ data: word },
							success: function(data) {
								if( data.title != null && data.title != '' ){
									$(".form-horizontal").removeClass("hide");
									$(".google").removeClass("hide");
									$(".manual_img").addClass("hide");
									$("#google_img_src").removeClass("hide");
									
									$(".found").addClass("hide");
									$("#isbn").val($("#isbn").val());
									$("#title").val(data.title);
									$("#google_img_src").attr("src",data.img);
									$("#google_img").val(data.img);
									$("#author").val(data.author);
									$("#publishing_year").val(data.publication);
									$("#edition_year").val(data.publication);
									$("#google_category").val(data.category);
								}else{
									$(".found").removeClass("hide");
								}
							}						
						});
						$(".found").removeClass("hide");
					}
				});
				return false;
			}
		function handleResponse(response) {
			$(".form-horizontal").removeClass("hide");
			$(".google").removeClass("hide");
			$(".manual_img").addClass("hide");
			
			$("#google_img_src").removeClass("hide");
			for (var i = 0; i < response.items.length; i++) {
				var item = response.items[i];
				var authors = item.volumeInfo.authors;
				var auth = "";
				
				$("#isbn").val($("#isbn").val());
				$("#title").val(item.volumeInfo.title);
				$("#subtitle").val(item.volumeInfo.subtitle);
				$("#google_img_src").attr("src",item.volumeInfo.imageLinks.smallThumbnail);
				$("#google_img").val(item.volumeInfo.imageLinks.smallThumbnail);
				
				for(var j=0;j< authors.length; j++){
					auth += authors[j] + ", ";
				}
				
				$("#author").val(auth);
				$("#publisher").val(item.volumeInfo.publisher);
				$("#publishing_year").val(item.volumeInfo.publishedDate);
				$("#edition_year").val(item.volumeInfo.publishedDate);
				$("#number_of_pages").val(item.volumeInfo.pageCount);
				$("#google_category").val(item.volumeInfo.categories[0]);
				
				break;
			}
		}
		
		function addSession(){
			var sess_vendor = $("#sess_vendor").val();
			if(sess_vendor != ""){
				$.ajax({
					url: "<?php echo site_url().'admin/createVendorSession';?>",
					dataType: "json",
					data:{ value:  sess_vendor},
					success: function(data) {
						if(data){
							location.reload();
						}
					}						
				});
			}
		}
		
		function removeSession(){
			$.ajax({
				url: "<?php echo site_url().'admin/removeVendorSession';?>",
				dataType: "json",
				success: function(data) {
					if(data){
						location.reload();
					}
				}						
			});
		}
	</script>
</section>
</section>


