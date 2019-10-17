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
								<a href="<?php echo base_url();?>admin/haat_vendors" class="btn btn-secondary">Go back</a>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
<a href="<?php echo base_url();?>admin/haat_category_create/<?php echo $user_id?>" class="btn btn-primary" style="margin-bottom: 20px;">
<i class="fa fa-plus"></i>
Create Haat Category
</a>
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"> Category</h4>
                <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>#</th>
							<th>Category</th>
							<th>Img</th>
                            <th>Status</th>
                         
						    <th>Operation</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$user = $this->db->get_where('category',  array('user_id' => $user_id))->result_array();
							$counter = 1;
							foreach ($user as $row): ?>
						<tr id="<?php echo $row['cat_id'];?>">
							<td style="vertical-align: middle;"><?php echo $counter++;?></td>
							<td style="vertical-align: middle;">
								<a href="javascript:;" style="color: #6c757d;"><?php echo ucfirst($row['cat_name']);?></a>
							</td>
							<td style="vertical-align: middle;">
								<img src="<?php echo $row['cat_img'];?>" style="height: 60px;" />
								
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
					 <a href="<?php echo base_url();?>admin/haat_vendor_products/<?php echo $row['cat_id'];?>/<?php echo $row['user_id'];?>" class="btn btn-info btn-xs btn-mini"><i class="dripicons-plus"></i></a>

					
							<a href="<?php echo base_url();?>admin/haat_category_edit/<?php echo $row['cat_id'];?>" class="btn btn-success btn-xs btn-mini">
								manage</a>
						<!-- <a href="<?php echo base_url();?>admin/chashi_vendor_delete/<?php echo $row['user_id'];?>" class="btn btn-danger btn-xs btn-mini deleteSingleUser">Delete</a> -->
						
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
