<?php
	$actor_detail = $this->db->get_where('actor',array('actor_id'=>$actor_id))->row();

	$banner_img = base_url() . 'assets/global/actor/' . $actor_detail->actor_id . '.jpg';
?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/banner_edit/<?php echo $actor_id;?>">
					<div class="row">
						<div class="col-12">
							<div class="form-group mb-3">
			                    <label for="name">Banner Title</label>
								<span class="help">e.g. "Leonardo di Caprio"</span>
			                    <input type="text" class="form-control" id = "name" name="name" value="<?php echo $actor_detail->name;?>">
			                </div>
							<div class="form-group mb-3">
			                    <label for="thumb">Banner Image</label>
			                    <input type="file" class="form-control" name="thumb">
			                    <input type="hidden" name="old_banner" value="<?= $banner_img; ?>">
			                </div>
							<div class="form-group mb-3">
			                    <label for="name">Short Description</label>
			                    <textarea rows="6" class="form-control" name="short_desc"><?php echo $actor_detail->short_desc;?></textarea>
			                </div>
			                 <div class="form-group mb-3">
			                    <label for="name">Long Description</label>
			                    <textarea rows="6" class="form-control" name="long_desc"><?php echo $actor_detail->long_desc;?></textarea>
			                </div>
							<div class="form-group">
								<input type="submit" class="btn btn-success" value="Update">
								<a href="<?php echo base_url();?>admin/banner_list" class="btn btn-secondary">Go back</a>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
				<div class="row">
					<div class="col-12">
						<div class="form-group mb-3">
		                    <label for="name">Banner Thumbnail</label>
		                    <br>
							<img src="<?= $banner_img; ?>" alt="Banner Image" style="width:100%;">
		                </div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
