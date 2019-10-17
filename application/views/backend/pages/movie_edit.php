<?php
	$movie_detail = $this->db->get_where('movie',array('movie_id'=>$movie_id))->row();

	$hi_audio = $movie_detail->hi_audio;
	$en_audio = $movie_detail->en_audio;

	if(file_exists('assets/global/movie_thumb/' . $movie_detail->movie_id . '.jpg')) {
		$thumb_img = base_url() . 'assets/global/movie_thumb/' . $movie_detail->movie_id . '.jpg';
	} else {
		$thumb_img = base_url() . 'assets/global/placeholder.jpg';
	}

	if(file_exists('assets/global/movie_poster/' . $movie_detail->movie_id . '.jpg')) {
		$poster_img = base_url() . 'assets/global/movie_poster/' . $movie_detail->movie_id . '.jpg';
	} else {
		$poster_img = base_url() . 'assets/global/placeholder.jpg';
	}

?>
<style>
.thumb-img {
    max-width: 100px;
    display: block;
}
.poster-img {
	max-width: 100%;
	width: 100%;
}
</style>
<form method="post" action="<?php echo base_url();?>admin/track_edit/<?php echo $movie_id;?>" enctype="multipart/form-data">
	<div class="row">
	    <div class="col-md-6 col-12">
	        <div class="card">
	            <div class="card-body">
					<div class="form-group mb-3">
	                    <label for="simpleinput1">Track Title</label>
	                    <input type="text" class="form-control" id = "simpleinput1" name="title" value="<?php echo $movie_detail->title;?>">
	                </div>
	                <div class="form-group mb-3">
	                    <label for="hindi_format">Audio In Hindi</label>
						<span class="help">- Upload Audio file hindi format</span>
	                    <input type="file" class="form-control" name="hindi_format" id="hindi_format">
	                </div>
	                <div class="form-group mb-3">
	                    <label for="english_format">Audio In English</label>
						<span class="help">- Upload Audio file english format</span>
	                    <input type="file" class="form-control" name="english_format" id="english_format">
	                </div>
					<!-- <div class="form-group mb-3">
	                    <label for="url">Movie Trailer Url</label>
						<span class="help">- youtube or any hosted video</span>
	                    <input type="text" class="form-control" name="trailer_url" id="trailer_url" value="<?php echo $movie_detail->trailer_url;?>">
	                </div> -->
					<!-- <div class="form-group mb-3">
	                    <label for="url">Video Url</label>
						<span class="help">- youtube or any hosted video</span>
	                    <input type="text" class="form-control" name="url" id="url" value="<?php echo $movie_detail->url;?>">
	                </div> -->

					<div class="form-group mb-3">
	                    <label for="">Thumbnail</label>
						<span class="help">- icon image of the track</span>
	                    <input type="file" class="form-control" name="thumb">
	                    <!-- <img src="<?= $thumb_img; ?>" style="width: 50px;"> -->
	                </div>

					<div class="form-group mb-3">
	                    <label for="">Poster</label>
						<span class="help">- large banner image of the track</span>
	                    <input type="file" class="form-control" name="poster">
	                    <!-- <img src="<?= $poster_img; ?>" style="width: 150px;"> -->
	                </div>

					<div class="form-group mb-3">
						<label for="description_long">Long description</label>
						<textarea class="form-control" id="description_long" name="description_long" rows="6"><?php echo $movie_detail->description_long;?></textarea>
					</div>

					<div class="form-group mb-3">
						<label for="description_short">Short description</label>
						<textarea class="form-control" id="description_short" name="description_short" rows="6"><?php echo $movie_detail->description_short;?></textarea>
					</div>
						<div class="form-group mb-3">
						<label for="description_welcome">Welcome message</label>
						<textarea class="form-control" id="description_welcome" name="description_welcome" rows="6"><?php echo $movie_detail->description_welcome;?></textarea>
					</div>
						<div class="form-group mb-3">
						<label for="description_thank_you">Thank you message</label>
						<textarea class="form-control" id="description_thank_you" name="description_thank_you" rows="6"><?php echo $movie_detail->description_thank_you;?></textarea>
					</div>
					

					<!-- <div class="form-group mb-3">
						<label for="actors">Actors</label>
						<span class="help">- select multiple actors</span>
						<select class="form-control select2" id="actors" multiple name="actors[]">
							<?php
								$actors	=	$this->db->get('actor')->result_array();
								foreach ($actors as $row2):?>
							<option
								<?php
									$actors	=	$movie_detail->actors;
									if ($actors != '')
									{
										$actor_array	=	json_decode($actors);
										if (in_array($row2['actor_id'], $actor_array))
											echo 'selected';
									}
									?>
								value="<?php echo $row2['actor_id'];?>">
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
							<option
								<?php if ( $movie_detail->genre_id == $row2['genre_id']) echo 'selected';?>
								value="<?php echo $row2['genre_id'];?>">
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
							<option
								<?php if ( $movie_detail->year == $i) echo 'selected';?>
								value="<?php echo $i;?>">
								<?php echo $i;?>
							</option>
							<?php endfor;?>
						</select>
					</div> -->

					<!-- <div class="form-group mb-3">
						<label for="rating">Rating</label>
						<span class="help">- star rating of the movie</span>
						<select class="form-control select2" id="rating" name="rating">
							<?php for ($i = 0; $i <= 5 ; $i++):?>
							<option
								<?php if ( $movie_detail->rating == $i) echo 'selected';?>
								value="<?php echo $i;?>">
								<?php echo $i;?>
							</option>
							<?php endfor;?>
						</select>
					</div> -->

					<!-- <div class="form-group mb-3">
						<label for="featured">Featured</label>
						<span class="help">- featured movie will be shown in home page</span>
						<select class="form-control select2" id="featured" name="featured">
							<option value="0" <?php if ( $movie_detail->featured == 0) echo 'selected';?>>No</option>
							<option value="1" <?php if ( $movie_detail->featured == 1) echo 'selected';?>>Yes</option>
						</select>
					</div> -->
	            </div>
	        </div>
	    </div>
			<div class="col-md-6 col-12">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<label class="form-label">Audio in Hindi:</label>
								<p>
									<?php 
									$hindi_format = base_url('assets/global/movies/hindi_format/') . $hi_audio;
									?>
									<input type="hidden" name="old_hi_audio" value="<?= $hi_audio; ?>">
									<audio controls>
										<source src="<?= $hindi_format;  ?>" type="audio/ogg">
										<source src="<?= $hindi_format;  ?>" type="audio/mpeg">
									</audio>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<label class="form-label">Audio in English:</label>
								<p>
									<?php $eng_format = base_url('assets/global/movies/english_format/') . $en_audio; ?>
									<input type="hidden" name="old_en_audio" value="<?= $en_audio; ?>">
									<audio controls>
										<source src="<?= $eng_format; ?>" type="audio/ogg">
										<source src="<?= $eng_format; ?>" type="audio/mpeg">
									</audio>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<label class="form-label">Thumbnail:</label>
								<span class="help">- icon image of the track</span>
								<img src="<?= $thumb_img; ?>" class="thumb-img">
							</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<label class="form-label">Poster:</label>
								<span class="help">- large banner image of the track</span>
								<img src="<?= $poster_img; ?>" class="poster-img">
							</div>
						</div>
					</div>
				</div>
				
		</div>
		<hr>

		</div>

		<div class="row">
			<div class="form-group col-md-3 col-6">
				<input type="submit" class="btn btn-success col-12" value="Update Track">
			</div>
			<div class="col-md-3 col-6">
				<a href="<?php echo base_url();?>admin/track_list" class="btn btn-secondary col-12">Go back</a>
			</div>
		</div>
	</div>
</form>
