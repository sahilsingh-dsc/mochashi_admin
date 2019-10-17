<div class="row">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/chashi_products" enctype="multipart/form-data">
					 <div class="form-group mb-3">
	                    <label for="title">User</label>

	                   <select class="form-control" name="user_id">
	                  <?php
$query= $this->db->get_where('user',array('active'=>1,'user_type'=>4));
   foreach($query->result() as $u){ ?>
    <option value="<?php echo $u->user_id ?>"><?php echo $u->fname ?></option>
<?php } 
?>
	                   </select>
	                </div>
	               <div class="form-group mb-3">
	                    <label for="title">Category</label>

	                   <select class="form-control" name="category_id">
	                  <?php
$query1= $this->db->get_where('chashi_category',array('active'=>1));
   foreach($query1->result() as $c){ ?>
    <option value="<?php echo $c->cc_id ?>"><?php echo $c->cc_name ?></option>
<?php } 
?>
	                   </select>
	                </div>
					
					 <div class="form-group mb-3">
	                    <label for="title">Product Name</label>
	                    <input type="text" class="form-control" id = "title" name="p_name" required>
	                </div>
					<div class="form-group mb-3">
	                    <label for="poster">Image1</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="p_img1" required>
	                </div>
					<div class="form-group mb-3">
	                    <label for="poster">Image2</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="p_img2" required>
	                </div>
	                <div class="form-group mb-3">
	                    <label for="poster">Image3</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="p_img3" required>
	                </div>
	                   <div class="form-group mb-3">
	                    <label for="poster">Image4</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="p_img4" required>
	                </div>
	                 <div class="form-group mb-3">
	                    <label for="title">Quantity Hosted</label>
	                    <input type="text" class="form-control" id = "title" name="qty_hosted" required>
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
	                    <label for="title">Rate</label>
	                    <input type="text" class="form-control" id = "title" name="rate" required>
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
	                  
    <option value="1">Yes </option>
     <option value="2">No</option>
   


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
