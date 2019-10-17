<!-- <a href="<?php echo base_url();?>admin/coupan_create/" class="btn btn-primary" style="margin-bottom: 20px;">
<i class="fa fa-plus"></i>
Create Coupons
</a> -->

<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Haat Products</h4>
                <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>#</th>
						    <th>Name</th>
                            <th>Image</th>
                             <th>Price</th>
                             <th>Status</th>
						    <th>Operation</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$products = $this->db->get_where('products',  array('cat_id' => $cat_id))->result_array();
							$counter = 1;
							foreach ($products as $row): ?>
						<tr id="<?php echo $row['p_id'];?>">
							<td style="vertical-align: middle;"><?php echo $counter++;?></td>
							<td style="vertical-align: middle;">
								<a href="javascript:;" style="color: #6c757d;"><?php echo ucfirst($row['p_name']);?></a>
							</td>
							<td style="vertical-align: middle;">
								<img src="<?php echo $row['p_img'];?>" style="height: 60px;" />
							</td>
							<td style="vertical-align: middle;">
								<?php if( $row['mrp']==$row['sale_price']){?>
&#x20b9;<?php echo $row['mrp'];
								}else{?>
							<strike>&#x20b9;<?php echo $row['mrp'];?></strike> &#x20b9;<?php echo $row['sale_price'];
					}?>
							</td>
							<?php if($row['status']==1){
                                   $statuss="active";


			                   }else{
			                   	$statuss="Inactive";
			                   }?>
								<td style="vertical-align: middle;">
								<?php echo $statuss;?>
							</td>
							
				     <td style="vertical-align: middle;">
					 <a href="<?php echo base_url();?>admin/haat_product_detail/<?php echo $row['p_id'];?>" class="btn btn-info btn-xs btn-mini"><i class="dripicons-box"></i></a>
						<!-- <a href="<?php echo base_url();?>admin/chashi_vendor_delete/<?php echo $row['user_id'];?>" class="btn btn-danger btn-xs btn-mini deleteSingleUser">Delete</a> -->
						<a class="btn btn-danger btn-xs btn-mini remove"><i class="dripicons-trash"></i></a>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
