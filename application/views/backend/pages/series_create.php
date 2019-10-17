<div class="row">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/series_create" enctype="multipart/form-data">
	                <div class="form-group mb-3">
	                    <label for="title">Series Title</label>
	                    <input type="text" class="form-control" id = "title" name="title" required>
	                </div>
					<div class="form-group mb-3">
	                    <label for="title">Display Order No</label>
	                    <input type="text" class="form-control" id = "title" name="display_order_no"  required>
	                </div>
	                <div class="form-group mb-3">
	                    <label for="hindi_format">Audio In Hindi</label>
						<span class="help">- Upload Audio file hindi format</span>
	                    <input type="file" class="form-control" name="hindi_format" id="hindi_format" >
	                </div>
					
	                <div class="form-group mb-3">
	                    <label for="english_format">Audio In English</label>
						<span class="help">- Upload Audio file english format</span>
	                    <input type="file" class="form-control" name="english_format" id="english_format">
	                </div>
	                
	                <!-- <div class="form-group mb-3">
	                    <label for="title">Series Trailer URL</label>
	                    <input type="text" class="form-control" id = "series_trailer_url" name="series_trailer_url">
	                </div> -->

	                <div class="form-group mb-3">
	                    <label for="thumb">Thumbnail</label>
						<span class="help">- icon image of the series</span>
	                    <input type="file" class="form-control" name="thumb">
	                </div>

	                <div class="form-group mb-3">
	                    <label for="poster">Poster</label>
						<span class="help">- large banner image of the series</span>
	                    <input type="file" class="form-control" name="poster">
	                </div>

					<div class="form-group mb-3">
						<label for="description_short">Short description</label>
						<textarea class="form-control" id="description_short" name="description_short" rows="6"></textarea>
					</div>

					<div class="form-group mb-3">
						<label for="description_long">Long description</label>
						<textarea class="form-control" id="description_long" name="description_long" rows="6"></textarea>
					</div>
					<div class="form-group mb-3">
						<label for="description_long">Thankyou Quotation</label>
						<textarea class="form-control" id="thank_quote" name="thank_quote" rows="6" required></textarea>
					</div>
					<div class="form-group mb-3">
	                    <label for="poster">Thankyou Quotation Image</label>
						<!-- <span class="help">- large banner image of the series</span> -->
	                    <input type="file" class="form-control" name="thankquoto" required>
	                </div>
					<!-- <div class="form-group mb-3">
						<label for="actors">Actors</label>
						<span class="help">- select multiple actors</span>
						<select class="form-control select2" id="actors" multiple name="actors[]">
							<?php
								$actors	=	$this->db->get('actor')->result_array();
								foreach ($actors as $row2):?>
							<option value="<?php echo $row2['actor_id'];?>">
								<?php echo $row2['name'];?>
							</option>
							<?php endforeach;?>
						</select>
					</div> -->

					<div class="form-group mb-3">
						<label for="genre_id">Genre</label>
						<span class="help">- genre must be selected</span>
						<select class="form-control select2" id="genre_id" name="genre_id">
							<?php
								$genres	=	$this->crud_model->get_genres();
								foreach ($genres as $row2):?>
							<option value="<?php echo $row2['genre_id'];?>">
								<?php echo $row2['name'];?>
							</option>
							<?php endforeach;?>
						</select>
					</div>

					<!-- <div class="form-group mb-3">
						<label for="year">Publishing Year</label>
						<span class="help">- year of publishing time</span>
						<select class="form-control select2" id="year" name="year">
							<?php for ($i = date("Y"); $i > 2000 ; $i--):?>
							<option value="<?php echo $i;?>">
								<?php echo $i;?>
							</option>
							<?php endfor;?>
						</select>
					</div>

					<div class="form-group mb-3">
						<label for="rating">Rating</label>
						<span class="help">- star rating of the movie</span>
						<select class="form-control select2" id="rating" name="rating">
							<?php for ($i = 0; $i <= 5 ; $i++):?>
							<option value="<?php echo $i;?>">
								<?php echo $i;?>
							</option>
							<?php endfor;?>
						</select>
					</div> -->
					<div class="row">
						<div class="form-group col-6">
							<input type="submit" class="btn btn-success col-12" value="Create">
						</div>
						<div class="col-6">
							<a href="<?php echo base_url();?>admin/series_list" class="btn btn-secondary col-12">Go back</a>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
