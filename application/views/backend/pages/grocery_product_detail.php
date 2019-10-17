 <?php
	$product = $this->db->get_where('products',array('p_id'=>$p_id))->row();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
	<!-- 			<form method="post" action="<?php echo base_url();?>admin/genre_edit/<?php echo $genre_id;?>" enctype="multipart/form-data"> -->
					<div class="row justify-content-center">
						<div class="col-xl-8 col-lg-9 col-md-12 col-sm-12 col-12">
							<div class="form-group mb-3">
			                    <label for="name" style="font-weight: bold;">Product: </label>
								<span class="help">  <?php echo $product->p_name;?></span>
			                  <!--   <input type="text" class="form-control" id = "name" name="name" value="<?php echo $genre_detail->name;?>"> -->
			                </div>
			                <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">Mrp :</label>
								<span class="help">  Rs <?php echo  $product->mrp;?></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			                 <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">Sale price :</label>
								<span class="help"> Rs <?php echo  $product->sale_price;?></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			                <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">Product Quantity :</label>
								<span class="help">  <?php echo $product->p_qty;?> <?php echo $product->unit;?></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			              
			                 <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">Available :</label>
								<span class="help">  <?php if($product->is_available==1){
									echo "Yes"; 
								}else {
									echo "No"; 	
								}?></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			                  
			                  <div class="form-group mb-3">
			                   <label for="name" style="font-weight: bold;">Image :</label>
								<span class="help"> <img src="<?php echo $product->p_img;?>" style="height: 100px;" /></span>
			                 <!--    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img"> -->
			                </div>
			                <!-- <div class="form-group mb-3">
			                    <input type="checkbox" id = "can_guest" name="can_guest" <?=($genre_detail->can_guest == 1)?'checked':''?>>
			                    <label for="can_guest">Can guests see</label>
			                </div> -->
							<div class="form-group">
								<!-- <input type="submit" class="btn btn-success" value="Update"> -->
					<a href="<?php echo base_url();?>admin/grocery_vendor_products/<?php echo $product->cat_id; ?>/<?php echo $user_id; ?>" class="btn btn-secondary">Go back</a>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>