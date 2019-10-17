<a href="<?php echo base_url();?>admin/chashi_products" class="btn btn-primary" style="margin-bottom: 20px;">
<i class="fa fa-plus"></i>
Create Chashi Products
</a>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Products List</h4>
                <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>
								#
							</th>
							<th>User</th>
							<th>Category</th>
							<th>Image</th>
                            <th>Name</th>
						<!-- 	<th>Status</th> -->
						
							<th>Operation</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$cat = $this->db->get('chashi_product')->result_array();
							$counter = 1;
							foreach ($cat as $row):

							  ?>
						<tr>
							<td style="vertical-align: middle;"><?php echo $counter++;?></td>
							<td style="vertical-align: middle;"><?php echo $this->crud_model->get_username($row['user_id']);?></td>
								<td style="vertical-align: middle;"><?php echo $this->crud_model->get_chashi_category($row['category_id']);?></td>
							<td><img src="<?php echo $row['p_img1'];?>" style="height: 70px;" /></td>
							<td style="vertical-align: middle;"><?php echo $row['p_name'];?></td>
							<!-- <td style="vertical-align: middle;"><span><?php if($row['active']==1) echo "active"; else echo "inactive";?></span></td> -->
							
							<td style="vertical-align: middle;">
								
								<a href="<?php echo base_url();?>admin/chashi_product_edit/<?php echo $row['p_id'];?>" class="btn btn-info btn-xs btn-mini">
								manage</a>
								<a href="<?php echo base_url();?>admin/chashi_product_delete/<?php echo $row['p_id'];?>" class="btn btn-danger btn-xs btn-mini" onclick="return confirm('Want to delete?')">
								delete</a>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
