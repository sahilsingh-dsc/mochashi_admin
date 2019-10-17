<?php
	$product = $this->db->get_where('chashi_product',array('p_id'=>$p_id))->row();
?>

<div class="row">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/chashi_product_edit/<?php echo $p_id; ?>" enctype="multipart/form-data">
					
	              
					 <div class="form-group mb-3">
	                    <label for="title">Product Name</label>
	                    <input type="text" class="form-control" id = "title" value="<?php echo $product->p_name;?>" name="p_name" required>
	                </div>
					<div class="form-group mb-3">
	                    <label for="poster">Image1</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="p_img1">
	                </div>
	                 <img src="<?php echo $product->p_img1;?>" height="100">
					<div class="form-group mb-3">
	                    <label for="poster">Image2</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="p_img2">
	                  
	                </div>
	                   <img src="<?php echo $product->p_img2;?>" height="100">
	                <div class="form-group mb-3">
	                    <label for="poster">Image3</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="p_img3">
	                </div>
	                <img src="<?php echo $product->p_img3;?>" height="100">
	                   <div class="form-group mb-3">
	                    <label for="poster">Image4</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="p_img4">
	                </div>
	                     <img src="<?php echo $product->p_img4;?>" height="100">
	                 <div class="form-group mb-3">
	                    <label for="title">Quantity Hosted</label>
	                    <input type="text" class="form-control" id = "title"  value="<?php echo $product->qty_hosted;?>" name="qty_hosted" required>
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
	                    <label for="title">Rate</label>
	                    <input type="text" class="form-control" id = "title" name="rate" value="<?php echo $product->rate;?>" required>
	                </div>
	                <!--  <div class="form-group mb-3">
	                    <label for="title">Status</label>

	                   <select class="form-control" name="active">
	                  
    <option value="1">Active </option>
     <option value="0">Inactive</option>
   


	                   </select>
	                </div> -->
	                 <div class="form-group mb-3">
	                    <label for="title">Deliverable</label>

	                   <select class="form-control" name="delivered">
	                  
    <option value="1"  <?php if($product->deliver=="1") echo "selected";?>>Yes </option>
     <option value="2"   <?php if($product->deliver=="2") echo "selected";?>>No</option>
   


	                   </select>
	                </div>
					<div class="row">
						<div class="form-group col-6">
							<input type="submit" class="btn btn-success col-12" value="Create">
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
