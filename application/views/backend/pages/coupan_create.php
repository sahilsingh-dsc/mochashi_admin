<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-9 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/coupan_create" enctype="multipart/form-data">
					<div class="row justify-content-center">
						<div class="col-12">
							<div class="form-group mb-3">
			                    <label for="name">Title</label>
								<span class="help">e.g. "Leonardo di Caprio"</span>
			                    <input type="text" class="form-control" id = "title" name="title">
			                </div>
							<div class="form-group mb-3">
			                    <label for="name">Coupon Code</label>
								<span class="help">e.g. "AM01234"</span>
			                    <input type="text" class="form-control" id = "coupon_code" name="coupon_code">
			                </div>
			                <div class="form-group mb-3">
			                    <label for="name">Coupon Use Time</label>
								<span class="help">e.g. "1 time or 4 times"</span>
			                    <input type="text" class="form-control" id = "use_time" name="use_time">
			                </div>

			                <div class="form-group mb-3">
			                    <label for="name">Coupon Start Date</label>
			                    <input type="date" class="form-control" id = "start_date" name="start_date">
			                </div>

			                <div class="form-group mb-3">
			                    <label for="name">Coupon End Date</label>
			                    <input type="date" class="form-control" id = "end_date" name="end_date">
			                </div>
			                <div class="form-group mb-3">
			                    <label for="name">Discount type</label>
							
			                    <select class="form-control" name="discount_type">
			                    	<option value="1">Flat</option>
			                    	<option value="2">Percentage</option>
			                    </select>
			                </div>
			                	<div class="form-group mb-3">
			                    <label for="name">Discount</label>
							 <input type="text" class="form-control" id = "discount" name="discount">
			                </div>

			                <div class="form-group mb-3">
			                    <label for="name">Coupon Status</label>
			                    <span class="help">e.g. "Active / Inactive"</span>
			                    <select class="form-control" name="status">
			                    	<option value="1">Active</option>
			                    	<option value="0">Inactive</option>
			                    </select>
			                </div>
							
							<div class="form-group">
								<input type="submit" class="btn btn-success" value="Create">
								<a href="<?php echo base_url();?>admin/coupan_list" class="btn btn-secondary">Go back</a>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
