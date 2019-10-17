<div class="row">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/grocery_product_create/<?php echo $cat_id ?>/<?php echo $user_id ?>" enctype="multipart/form-data">
					
					
					 <div class="form-group mb-3">
	                    <label for="title">Product Name</label>
	                    <input type="text" class="form-control" id = "title" name="p_name" required>
	                </div>
	                 <div class="form-group mb-3">
	                    <label for="title">Product Description</label>
	                    <textarea  class="form-control"  name="desc"></textarea>
	                </div>
					<div class="form-group mb-3">
	                    <label for="poster">Image1</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="p_img" required>
	                </div>
					
	                 <div class="form-group mb-3">
	                    <label for="title">Mrp</label>
	                    <input type="text" class="form-control" id = "title" name="mrp" required>
	                </div>
	                 <div class="form-group mb-3">
	                    <label for="title">Selling Price</label>
	                    <input type="text" class="form-control" id = "title" name="sale_price" required>
	                </div>
	                  <div class="form-group mb-3">
	                    <label for="title">Quantity</label>
	                    <input type="text" class="form-control" id = "title" name="p_qty" required>
	                </div>
					<div class="form-group mb-3">
					<label for="title">Unit</label>

						<select class="form-control" name="unit">

						<option value="kg">kg </option>
						<option value="g">g </option>
						<option value="L">L</option>
						<option value="ml">ml</option>
						<option value="packet">packet</option>
						</select>
					</div>

	                  <div class="form-group mb-3">
	                    <label for="title">Is Available</label>

	                   <select class="form-control" name="is_available">
	                  
                    <option value="1">Yes </option>
                   <option value="0">No </option>
   
                     </select>
	                </div>
	                  <div class="form-group mb-3">
	                    <label for="title">Status</label>

	                   <select class="form-control" name="status">
	                  
                    <option value="1">Active </option>
                   <option value="0">Inactive </option>
   
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
