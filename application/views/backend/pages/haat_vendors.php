<!-- <a href="<?php echo base_url();?>admin/coupan_create/" class="btn btn-primary" style="margin-bottom: 20px;">
<i class="fa fa-plus"></i>
Create Coupons
</a> -->

<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Vendor List</h4>
                <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
                            <th>Mobile</th>
                             <th>Shop Name</th>
						    <th>Operation</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$user = $this->db->get_where('user',  array('user_type' => 3))->result_array();
							$counter = 1;
							foreach ($user as $row): ?>
						<tr id="<?php echo $row['user_id'];?>">
							<td style="vertical-align: middle;"><?php echo $counter++;?></td>
							<td style="vertical-align: middle;">
								<a href="javascript:;" style="color: #6c757d;"><?php echo ucfirst($row['fname']);?></a>
							</td>
							<td style="vertical-align: middle;">
								<?php echo $row['email'];?>
							</td>
							<td style="vertical-align: middle;">
								<?php echo $row['mobile'];?>
							</td>
								<td style="vertical-align: middle;">
								<?php echo $row['shop_name'];?>
							</td>
							<td style="vertical-align: middle;">
					 <a href="<?php echo base_url();?>admin/haat_vendor_detail/<?php echo $row['user_id'];?>" class="btn btn-info btn-xs btn-mini"><i class="dripicons-preview"></i></a>
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
