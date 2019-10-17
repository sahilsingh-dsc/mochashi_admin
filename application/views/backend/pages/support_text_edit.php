<?php
	$detail = $this->db->get_where('support_text',array('id'=>$id))->row();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/support_text_edit/<?php echo $id;?>">
					<div class="row">
						<div class="col-8">
							 <div class="form-group mb-3">
			                    <label for="title_text">Title Text</label>
			                    <input type="text" class="form-control" id ="title_text" name="title_text" value="<?php echo $detail->title_text;?>">
			                </div>


							<div class="form-group mb-3">
			                    <label for="big_text">Description Text</label>
								<textarea class="form-control" id="big_text" name="big_text" rows="6"><?php echo $detail->big_text;?></textarea>
			                </div>

							<div class="form-group">
								<input type="submit" class="btn btn-success" value="Update">
								<a href="<?php echo base_url();?>admin/support_text" class="btn btn-secondary">Go back</a>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
