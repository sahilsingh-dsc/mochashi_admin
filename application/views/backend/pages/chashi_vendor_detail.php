 <?php
	$vendor_details = $this->db->get_where('user',array('user_id'=>$user_id))->row();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
	<!-- 			<form method="post" action="<?php echo base_url();?>admin/genre_edit/<?php echo $genre_id;?>" enctype="multipart/form-data"> -->
					<div class="row justify-content-center">
						<div class="col-xl-8 col-lg-9 col-md-12 col-sm-12 col-12">
							<div class="form-group mb-3">
			                    <label for="name" style="font-weight: bold;">Name</label>
								<span class="help">  <?php echo $vendor_details->fname;?></span>
			                  <!--   <input type="text" class="form-control" id = "name" name="name" value="<?php echo $genre_detail->name;?>"> -->
			                </div>
			                <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">Email</label>
								<span class="help">  <?php echo $vendor_details->email;?></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			                 <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">Mobile</label>
								<span class="help">  <?php echo $vendor_details->mobile;?></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			                <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">Shop Name</label>
								<span class="help">  <?php echo $vendor_details->shop_name;?></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			                <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">Address</label>
								<span class="help">  <?php echo $vendor_details->address;?></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			                 <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">State</label>
								<span class="help">  <?php echo $this->crud_model->get_state($vendor_details->state);?></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			                   <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">City</label>
								<span class="help">  <?php echo $this->crud_model->get_city($vendor_details->city);?></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			                 <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">Pincode</label>
								<span class="help">  <?php echo $vendor_details->pincode;?></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			                  <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">status</label>
			                   <?php if($vendor_details->active==1){
                                   $status="active";

			                   }else{
			                   	$status="Inactive";
			                   }?>
								<span class="help">  <?php echo $status;?></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			                <!-- <div class="form-group mb-3">
			                    <input type="checkbox" id = "can_guest" name="can_guest" <?=($genre_detail->can_guest == 1)?'checked':''?>>
			                    <label for="can_guest">Can guests see</label>
			                </div> -->
							<div class="form-group">
								<!-- <input type="submit" class="btn btn-success" value="Update"> -->
								<a href="<?php echo base_url();?>admin/chashi_vendors" class="btn btn-secondary">Go back</a>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"> Products</h4>
                <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>#</th>
							<th>Category</th>
							<th>Product</th>
							<th>Img</th>
								<th>Quantity hosted</th>
								<th>Rate</th>
						
                           
                         <!-- 
						    <th>Operation</th> -->
						</tr>
					</thead>
					<tbody>
						<?php
							$cat = $this->db->get_where('chashi_product',array('user_id'=>$user_id))->result_array();
							$counter = 1;
							foreach ($cat as $row):

							  ?>
						<tr>
							<td style="vertical-align: middle;"><?php echo $counter++;?></td>
							<td style="vertical-align: middle;"><?php echo $this->crud_model->get_chashi_category($row['category_id']);?></td>
							<td style="vertical-align: middle;"><?php echo $row['p_name'];?></td>
								
							<td><img src="<?php echo $row['p_img1'];?>" style="height: 70px;" /></td>
								<td style="vertical-align: middle;"><?php echo $row['qty_hosted'];?> <?php echo $row['unit'];?></td>
									<td style="vertical-align: middle;">Rs <?php echo $row['rate'];?> / <?php echo $row['unit'];?></td>
							<!-- <td style="vertical-align: middle;"><span><?php if($row['active']==1) echo "active"; else echo "inactive";?></span></td> -->
							
							<td style="vertical-align: middle;">
								
							<!-- 	<a href="<?php echo base_url();?>admin/chashi_product_edit/<?php echo $row['p_id'];?>" class="btn btn-info btn-xs btn-mini">
								manage</a> -->
							<!-- 	<a href="<?php echo base_url();?>admin/chashi_product_delete/<?php echo $row['p_id'];?>" class="btn btn-danger btn-xs btn-mini" onclick="return confirm('Want to delete?')">
								delete</a> -->
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
