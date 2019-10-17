<div class="row">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/grocery_category_create/<?php echo $user_id ?>" enctype="multipart/form-data">
	                <div class="form-group mb-3">
	                    <label for="title">Name</label>
	                    <input type="text" class="form-control" id = "title" name="name" required>
	                </div>
					
					
					<div class="form-group mb-3">
	                    <label for="poster">Image</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="cat_image" required>
	                </div>
	                <div class="form-group mb-3">
	                    <label for="title">Status</label>

	                   <select class="form-control" name="active">
	                  
    <option value="1">Active </option>
     <option value="0">Inactive</option>
   


	                   </select>
	                </div>
					
					<div class="row">
						<div class="form-group col-6">
							<input type="submit" class="btn btn-success col-12" value="Create">
						</div>
						<div class="col-6">
							<a href="<?php echo base_url();?>admin/grocery_vendor_detail/<?php echo $user_id?>" class="btn btn-secondary col-12">Go back</a>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
