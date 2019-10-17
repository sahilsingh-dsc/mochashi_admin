<?php
	$product = $this->db->get_where('products',array('p_id'=>$p_id))->row();
?>

<div class="row">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/grocery_product_edit/<?php echo $p_id ?>/<?php echo $user_id ?>" enctype="multipart/form-data">
					
					
					 <div class="form-group mb-3">
	                    <label for="title">Product Name</label>
	        <input type="text" class="form-control" id = "title" name="p_name" value="<?php echo $product->p_name?>" required>
	                </div>
	                 <div class="form-group mb-3">
	                    <label for="title">Product Description</label>
	                    <textarea  class="form-control"  name="desc"><?php echo $product->p_desc?></textarea>
	                </div>
					<div class="form-group mb-3">
	                    <label for="poster">Image</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="p_img" >
	                </div>
					<img src="<?php echo $product->p_img;?>" height="100">
	                 <div class="form-group mb-3">
	                    <label for="title">Mrp</label>
	                    <input type="text" class="form-control" id = "title" name="mrp" required value="<?php echo $product->mrp?>">
	                </div>
	                 <div class="form-group mb-3">
	                    <label for="title">Selling Price</label>
	                    <input type="text" class="form-control" id = "title" name="sale_price" value="<?php echo $product->sale_price?>" required>
	                </div>
	                  <div class="form-group mb-3">
	                    <label for="title">Quantity</label>
	                    <input type="text" class="form-control" id = "title" name="p_qty"  value="<?php echo $product->p_qty?>" required>
	                </div>
					<div class="form-group mb-3">
					<label for="title">Unit</label>

						<select class="form-control" name="unit">

						 <option value="kg" <?php if($product->unit=="kg"){ echo "selected";}?>>kg </option>
     <option value="g" <?php if($product->unit=="g"){ echo "selected"; }?>>g </option>
     <option value="L" <?php if($product->unit=="L"){ echo "selected"; }?>>L</option>
        <option value="ml" <?php if($product->unit=="ml"){ echo "selected"; }?>>ml</option>
             <option value="packet"  <?php if($product->unit=="packet") { echo "selected"; }?>>packet</option>
						</select>
					</div>

	                  <div class="form-group mb-3">
	                    <label for="title">Is Available</label>

	                   <select class="form-control" name="is_available">
	                  
                   <option value="1" <?php if($product->status==1) echo "selected";?>>Yes </option>
     <option value="0"  <?php if($product->status==0) echo "selected";?>>No</option>
   
                     </select>
	                </div>
	                  <div class="form-group mb-3">
	                    <label for="title">Status</label>

	                   <select class="form-control" name="status">
	                  
                  <option value="1" <?php if($product->status==1) echo "selected";?>>Active </option>
     <option value="0"  <?php if($product->status==0) echo "selected";?>>Inactive</option>
   
                     </select>
	                </div>
	                
					<div class="row">
						<div class="form-group col-6">
							<input type="submit" class="btn btn-success col-12" value="Update">
						</div>
						<!-- <div class="col-6">
							<a href="<?php echo base_url();?>admin/chashi_category" class="btn btn-secondary col-12">Go back</a>
						</div> -->
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
