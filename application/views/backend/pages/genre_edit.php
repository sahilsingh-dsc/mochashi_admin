 <?php
	$genre_detail = $this->db->get_where('genre',array('genre_id'=>$genre_id))->row();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/genre_edit/<?php echo $genre_id;?>" enctype="multipart/form-data">
					<div class="row justify-content-center">
						<div class="col-xl-8 col-lg-9 col-md-12 col-sm-12 col-12">
							<div class="form-group mb-3">
			                    <label for="name">Genre Name</label>
								<span class="help">e.g. "Action, Romantic"</span>
			                    <input type="text" class="form-control" id = "name" name="name" value="<?php echo $genre_detail->name;?>">
			                </div>
			                <div class="form-group mb-3">
			                    <label for="cat_img">Genre Thumbnail</label>
								<span class="help">e.g. "Action Thumbnail, Romantic Thumbnail"</span>
			                    <input type="file" class="form-control" id = "cat_img" name="gen_cat_img">
			                </div>
			                <!-- <div class="form-group mb-3">
			                    <input type="checkbox" id = "can_guest" name="can_guest" <?=($genre_detail->can_guest == 1)?'checked':''?>>
			                    <label for="can_guest">Can guests see</label>
			                </div> -->
							<div class="form-group">
								<input type="submit" class="btn btn-success" value="Update">
								<a href="<?php echo base_url();?>admin/genre_list" class="btn btn-secondary">Go back</a>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
