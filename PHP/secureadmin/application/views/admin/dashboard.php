<section class="content-header">
   <section class="content">
   	<div class="row">
			<div class="col-xs-12">

				<div class="row">
					<div class="text-center"><h2 style="font-weight:900;"><?php echo $this->lang->line('Order status');?></h2></div>
					<div id="div_for_circle_chart"></div>
				</div>

				<!-- total report section -->
				<div class="row">
					<div class="text-center"><h2 style="font-weight:900;"><?php echo $this->lang->line('overall report');?></h2></div>

					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

						<div class="small-box bg-blue">
							<div class="inner">
								<h3><?php echo $num_of_book; ?></h3>
								<p><?php echo $this->lang->line('total number of books');?></p>
							</div>
							<div class="icon">
								<i class="fa fa-book"></i>
							</div>
							<a href="<?php echo base_url()."admin/book_list"; ?>" class="small-box-footer">
								<?php echo $this->lang->line('more information');?> <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

						<div class="small-box bg-yellow">
							<div class="inner">
								<h3><?php echo $num_issue_book; ?></h3>
								<p><?php echo $this->lang->line('total number of issued books');?></p>
							</div>
							<div class="icon">
								<i class="fa fa-book"></i><i class="fa fa-mail-forward"></i>
							</div>
							<a href="<?php echo base_url()."admin/update_bookstock"; ?>" class="small-box-footer">
								<?php echo $this->lang->line('more information');?> <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

						<div class="small-box bg-yellow">
							<div class="inner">
								<h3><?php echo $num_of_users; ?></h3>
								<p><?php echo $this->lang->line('total number of signups');?></p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a href="<?php echo base_url()."admin/site_users"; ?>" class="small-box-footer">
								<?php echo $this->lang->line('more information');?> <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div>

				
				</div>
				

				<!-- end of total report section 


				<div class="row">
					<div class="text-center"><h2 style="font-weight:900;"><?php echo $this->lang->line('issued and returned report for last 12 months');?></h2></div>
					<div id='div_for_bar'></div>
				</div>
-->
				
				
				
				
				<?php
				
  						// $bar=array("0"=>array("y"=>2014,"a"=>100,"b"=>50),"1"=>array("y"=>2015,"a"=>100,"b"=>50));
				$bar = $chart_bar;
				$circle_bir = array(
					'0' => array(
						'label'=>$this->lang->line('returned'),
						'value'=>$returned[0]['returned']
						),
					'1' =>array(
						'label'=>$this->lang->line('Successful Order'),
						'value'=>$total_issued[0]['total_issued']
						
						),
						'2' =>array(
						'label'=>$this->lang->line('Currently Reading'),
						'value'=>$open[0]['open']						
						),
						'3' =>array(
						'label'=>$this->lang->line('Cancelled orders'),
						'value'=>$cancelled[0]['cancelled']						
						),
						'4' =>array(
						'label'=>$this->lang->line('In Process'),
						'value'=>$in_process[0]['in_process']						
						)
					
					);
				
				 ?>
				
				
				

			</div>
		</div>
   </section>
</section>


<script>
var total_issued_dis="<?php echo $this->lang->line('number total returned'); ?>";
var total_retuned_dis="<?php echo $this->lang->line('number total issued'); ?>";
/* Morris.Bar({
  element: 'div_for_bar',
  data: <?php echo json_encode($bar); ?>,
  xkey: 'year',
  ykeys: ['total_issue', 'total_return'],
  labels: [total_issued_dis, total_retuned_dis]
}); */

Morris.Donut({
  element: 'div_for_circle_chart',
  data: <?php echo json_encode($circle_bir); ?>
});
</script>






