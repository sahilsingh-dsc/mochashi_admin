<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/tool_tip_create">
					<div class="row">
						<div class="col-8">
						    <div class="form-group mb-3">
			                    <label for="question">order</label>
			                    <input type="number" class="form-control" id ="order_by" name="order_by">
			                </div>

							<div class="form-group mb-3">
			                    <label for="answer">Text</label>
								<textarea class="form-control" id="text" name="text" rows="6"></textarea>
			                </div>

							<div class="form-group">
								<input type="submit" class="btn btn-success" value="Create">
								<a href="<?php echo base_url();?>admin/tool_tip" class="btn btn-secondary">Go back</a>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
