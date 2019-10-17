<?php
	$cat = $this->db->get_where('chashi_category',array('cc_id'=>$cat_id))->row();
?>
<div class="row">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/chashi_category_edit/<?php echo $cat->cc_id; ?>" enctype="multipart/form-data">
	                <div class="form-group mb-3">
	                    <label for="title">Name</label>
	                    <input type="text" class="form-control" id = "title" name="name" value="<?php echo $cat->cc_name; ?>" required >
	                </div>
					
					
					<div class="form-group mb-3">
	                    <label for="poster">Image</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="cat_image">
	                </div>
	                <img src="<?php echo base_url();?>uploads/<?php echo $cat->cc_img;?>" height="100">
	                <div class="form-group mb-3">
	                    <label for="title">Status</label>

	                   <select class="form-control" name="active">
	                  
    <option value="1" <?php if($cat->active==1) echo "selected";?>>Active </option>
     <option value="0"  <?php if($cat->active==0) echo "selected";?>>Inactive</option>
   


	                   </select>
	                </div>
					
					<div class="row">
						<div class="form-group col-6">
							<input type="submit" class="btn btn-success col-12" value="Update">
						</div>
						<div class="col-6">
							<a href="<?php echo base_url();?>admin/chashi_category" class="btn btn-secondary col-12">Go back</a>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
