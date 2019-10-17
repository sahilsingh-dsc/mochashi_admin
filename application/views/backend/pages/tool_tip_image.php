<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/update_tool_tip_image" enctype="multipart/form-data">
					<div class="row">
						<div class="col-8">
						    <div class="form-group mb-3">
			                   	<label class="form-label">Tool Tip Image</label>
								<span class="help"></span>
								<div class="controls">
									<input type="file" name="logo" />
									<img src="<?php echo base_url();?>assets/global/player-bg.jpg" height="100" />
								</div>
			                </div>

						

							<div class="form-group">
								<input type="submit" class="btn btn-success" value="Update">
													</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>

