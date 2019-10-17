


<div class="row">

	<!-- TOTAL TV SERIES NUMBER -->
	<div class="col-md-4 col-sm-12 ">
		<div class="card widget-flat">
			<div class="card-body">
				<div class="float-right">
					<i class="mdi mdi-movie-roll widget-icon"></i>
				</div>
				<h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Customers</h5>
				<h3 class="mt-3 mb-3"><?php echo $this->db->where('user_type',1)->from('user')->count_all_results();?></h3>
			</div>
		</div>
	</div>
	
	<!-- TOTAL USER NUMBER -->
	<div class="col-md-4 col-sm-12 ">
		<div class="card widget-flat">
			<div class="card-body">
				<div class="float-right">
					<i class="mdi mdi-account-multiple-check widget-icon"></i>
				</div>
				<h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Chashi Category</h5>
				<h3 class="mt-3 mb-3"><?php echo $this->db->from('chashi_category')->count_all_results();?></h3>
			</div>
		</div>
	</div>
	<!-- TOTAL ACTIVE SUBSCRIPTION -->
	<div class="col-md-4 col-sm-12 ">
		<div class="card widget-flat">
			<div class="card-body">
				<div class="float-right">
					<i class="mdi mdi-wallet-membership widget-icon"></i>
				</div>
				<h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">products</h5>
				<h3 class="mt-3 mb-3">
					<?php echo $this->db->from('chashi_product')->count_all_results();?>
				</h3>
			</div>
		</div>
	</div>
	<!-- REVENUE THIS MONTH -->
	<div class="col-md-4 col-sm-12 ">
		<div class="card widget-flat">
			<div class="card-body">
				<div class="float-right">
					<i class="mdi mdi-square-inc-cash widget-icon"></i>
				</div>
				<h5 class="text-muted font-weight-normal mt-0" title="Number of vendors">vendors</h5>
				<h3 class="mt-3 mb-3">
				
						<?php echo $this->db->from('user')->count_all_results();?>
				</h3>
			</div>
		</div>
	</div>
</div> 
<!-- <div style="margin: 20px;"></div> -->
<div class="row">
	
</div>
