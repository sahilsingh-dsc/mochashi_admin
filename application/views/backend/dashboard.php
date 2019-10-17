<!DOCTYPE html>
<html>
	<head>
		<title>Mochashi | AppMeditate</title>
		<!-- all the meta tags -->
		<?php include 'metas.php'; ?>
		<!-- all the css files -->
		<?php include 'css.php'; ?>
	</head>
	<body class="">
		<div class="wrapper">
			<!-- BEGIN CONTENT -->
			<!-- SIDEBAR -->
		<!-- ========== Left Sidebar Start ========== -->
		<?php include 'menu.php'; ?>
         

			<!-- PAGE CONTAINER-->
			<div class="content-page">
				<div class="content">
						<?php include ("header.php"); ?>
					<div class="page-title">
						<i class="icon-custom-right"></i>
						<h4 class="page-title">Dashboard</h4>
					</div>
					<!-- BEGIN PlACE PAGE CONTENT HERE -->
				


<div class="row">
	
	<!-- TOTAL TV SERIES NUMBER -->
	<div class="col-md-4 col-sm-12 ">
		<div class="card widget-flat">
			<div class="card-body">
				<div class="float-right">
					<i class="mdi mdi-movie-roll widget-icon"></i>
				</div>
				<h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">25</h5>
				<h3 class="mt-3 mb-3"><?php echo $this->db->from('user')->count_all_results();?></h3>
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
					<!-- <?php
						$total_sale	=	0;
						$month			=	date("F");
						$year 			=	date("Y");
						$subscriptions	=	$this->crud_model->get_subscription_report($month, $year);
						foreach ($subscriptions as $row)
							$total_sale	+=	$row['paid_amount'];
						echo '$'.$total_sale;
						?> -->
						<?php echo $this->db->from('user')->count_all_results();?>
				</h3>
			</div>
		</div>
	</div>
</div> 
<!-- <div style="margin: 20px;"></div> -->
<div class="row">
	
</div>

					<!-- END PLACE PAGE CONTENT HERE -->
				</div>
			</div>
			<!-- END CONTENT -->
		</div>
		<!-- all the js files -->
		<?php include 'js.php'; ?>
	</body>
</html>
