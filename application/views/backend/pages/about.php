<?php
	$about = $this->db->get('about')->row();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/about/<?php echo $faq_id;?>" enctype="multipart/form-data">
					<div class="row">
						<div class="col-12">
							<div class="form-group mb-3">
			                    <label for="question">About Title</label>
			                    <input type="text" class="form-control" id = "" name="about_title" value="<?php echo $about->about_title;?>" required>
			                </div>
                            <div class="form-group mb-3">
			                    <label for="question">About Image</label>
                                <img src="<?=base_url()?>assets/global/<?=$about->about_image?>" style="width:200px;height:auto">
			                    <input type="file" class="form-control" id = "" name="about_image" value="<?php echo $about->about_image;?>">
			                </div>
							<div class="form-group mb-3">
			                    <label for="answer">About Desc</label>
								<textarea class="form-control" id="" name="about_desc" rows="6" required><?php echo $about->about_desc;?></textarea>
			                </div>


                            <div class="form-group mb-3">
			                    <label for="question">Vision Title</label>
			                    <input type="text" class="form-control" id = "" name="vision_title" value="<?php echo $about->vision_title;?>" required>
			                </div>
                            <div class="form-group mb-3">
			                    <label for="question">Vision Image</label>
                                <img src="<?=base_url()?>assets/global/<?=$about->vision_image?>" style="width:200px;height:auto">
			                    <input type="file" class="form-control" id = "" name="vision_image" value="<?php echo $about->vision_image;?>">
			                </div>
							<div class="form-group mb-3">
			                    <label for="answer">Vision Desc</label>
								<textarea class="form-control" id="" name="vision_desc" rows="6" required><?php echo $about->vision_desc;?></textarea>
			                </div>

                            <div class="form-group mb-3">
			                    <label for="question">Mission Title</label>
			                    <input type="text" class="form-control" id = "" name="mission_title" value="<?php echo $about->mission_title;?>" required>
			                </div>
                            <div class="form-group mb-3">
			                    <label for="question">Mission Image</label>
                                <img src="<?=base_url()?>assets/global/<?=$about->mission_image?>" style="width:200px;height:auto">
			                    <input type="file" class="form-control" id = "" name="mission_image" value="<?php echo $about->mission_image;?>">
			                </div>
							<div class="form-group mb-3">
			                    <label for="answer">Mission Desc</label>
								<textarea class="form-control" id="" name="mission_desc" rows="6" required><?php echo $about->mission_desc;?></textarea>
			                </div>

							<div class="form-group">
								<input type="submit" class="btn btn-success" value="Update">
								<a href="<?php echo base_url();?>admin/faq_list" class="btn btn-secondary">Go back</a>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
