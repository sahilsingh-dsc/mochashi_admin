<?php
	$coupan_detail = $this->db->get_where('coupans',array('coupan_id'=>$actor_id))->row();

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/coupan_edit/<?php echo $actor_id;?>">
					<div class="row">
						<div class="col-12">
							<div class="form-group mb-3">
			                    <label for="name">Coupon Title</label>
								<span class="help">e.g. "Leonardo di Caprio"</span>
			                    <input type="text" class="form-control" id = "name" name="name" value="<?php echo $coupan_detail->title;?>">
			                </div>
							<div class="form-group mb-3">
			                    <label for="name">Coupon Code</label>
								<span class="help">e.g. "AM01234"</span>
			                    <input type="text" class="form-control" id = "coupon_code" name="coupon_code" value="<?php echo $coupan_detail->coupon_code;?>">
			                </div>
							<div class="form-group mb-3">
			                    <label for="name">Coupon Use Time</label>
								<span class="help">e.g. "1 time or 4 times"</span>
			                    <input type="text" class="form-control" id = "use_time" name="use_time" value="<?php echo $coupan_detail->use_time;?>">
			                </div>

			                <div class="form-group mb-3">
			                    <label for="name">Coupon Start Date</label>
			                    <input type="date" class="form-control" id = "start_date" name="start_date" value="<?php echo $coupan_detail->start_date;?>">
			                </div>

			                <div class="form-group mb-3">
			                    <label for="name">Coupon End Date</label>
			                    <input type="date" class="form-control" id = "end_date" name="end_date" value="<?php echo $coupan_detail->end_date;?>">
			                </div>
                             <div class="form-group mb-3">
			                    <label for="name">Discount type</label>
							
			                    <select class="form-control" name="discount_type">
			                    	<option value="1" <?php if($coupan_detail->discount_type == 1) { echo 'selected'; } ?>>Flat</option>
			                    	<option value="2" <?php if($coupan_detail->discount_type == 2) { echo 'selected'; } ?>>Percentage</option>
			                    </select>
			                </div>
			                	<div class="form-group mb-3">
			                    <label for="name">Discount</label>
							 <input type="text" class="form-control" id = "discount" name="discount" value="<?php echo $coupan_detail->discount;?>" >
			                </div>
			                <div class="form-group mb-3">
			                    <label for="name">Coupon Status</label>
			                    <span class="help">e.g. "Active / Inactive"</span>
			                    <select class="form-control" name="status">
			                    	<option value="1" <?php if($coupan_detail->status == 1) { echo 'selected'; } ?>>Active</option>
			                    	<option value="0" <?php if($coupan_detail->status == 0) { echo 'selected'; } ?>>Inactive</option>
			                    </select>
			                </div>
			                <div class="form-group">
								<input type="submit" class="btn btn-success" value="Update Coupan">
								<a href="<?php echo base_url();?>admin/coupan_list" class="btn btn-secondary">Go back</a>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
