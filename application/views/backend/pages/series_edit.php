<?php
	$series_detail = $this->db->get_where('series',array('series_id'=>$series_id))->row();

	$hi_audio = $series_detail->hi_audio;
	$en_audio = $series_detail->en_audio;

	if(file_exists('assets/global/series_thumb/' . $series_detail->series_id . '.jpg')) {
		$thumb_img = base_url() . 'assets/global/series_thumb/' . $series_detail->series_id . '.jpg';
	} else {
		$thumb_img = base_url() . 'assets/global/placeholder.jpg';
	}

	if(file_exists('assets/global/series_poster/' . $series_detail->series_id . '.jpg')) {
		$poster_img = base_url() . 'assets/global/series_poster/' . $series_detail->series_id . '.jpg';
	} else {
		$poster_img = base_url() . 'assets/global/placeholder.jpg';
	}

	if(!empty($series_detail->share_img)){
		$share_img = base_url() . 'assets/global/quotes/' .$series_detail->share_img;
	}
?>
			<form method="post" action="<?php echo base_url();?>admin/series_edit/<?php echo $series_id;?>" enctype="multipart/form-data">
<div class="row">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-body">
	                <div class="form-group mb-3">
	                    <label for="title">Series Title</label>
	                    <input type="text" class="form-control" id = "title" name="title" value="<?php echo $series_detail->title;?>">
	                </div>
					
					<div class="form-group mb-3">
	                    <label for="title">Display Order No</label>
	                    <input type="text" class="form-control" id = "title" name="display_order_no" value="<?php echo $series_detail->display_order_no;?>" required>
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
	                    <label for="title">Tv Series Trailer URL</label>
	                    <input type="text" class="form-control" id = "title" name="series_trailer_url" value="<?php echo $series_detail->trailer_url;?>">
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
						<textarea class="form-control" id="description_short" name="description_short" rows="6"><?php echo $series_detail->description_short;?></textarea>
					</div>

					<div class="form-group mb-3">
						<label for="description_long">Long description</label>
						<textarea class="form-control" id="description_long" name="description_long" rows="6"><?php echo $series_detail->description_long;?></textarea>
					</div>
					<div class="form-group mb-3">
						<label for="description_long">Thankyou Quotation</label>
						<textarea class="form-control" id="thank_quote" name="thank_quote" rows="6"><?php echo $series_detail->thank_quote;?></textarea>
					</div>
					<div class="form-group mb-3">
	                    <label for="thumb">Thankyou Quotation Image</label>
					    <input type="file" class="form-control" name="thankquoto">
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
									$actors	=	$series_detail->actors;
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
								<?php if ( $series_detail->genre_id == $row2['genre_id']) echo 'selected';?>
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
								<?php if ( $series_detail->year == $i) echo 'selected';?>
								value="<?php echo $i;?>">
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
							<option
								<?php if ( $series_detail->rating == $i) echo 'selected';?>
								value="<?php echo $i;?>">
								<?php echo $i;?>
							</option>
							<?php endfor;?>
						</select>
					</div> -->
					<div class="row">
						<div class="form-group col-6">
							<input type="submit" class="btn btn-success col-12" value="Update Tv Series">
						</div>
						<div class="col-6">
							<a href="<?php echo base_url();?>admin/series_list" class="btn btn-secondary col-12">Go back</a>
						</div>
					</div>
				
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
							$hindi_format = base_url('assets/global/series/hindi_format/') . $hi_audio;
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
							<?php $eng_format = base_url('assets/global/series/english_format/') . $en_audio; ?>
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
						<img src="<?= $thumb_img; ?>" class="thumb-img" style="width: 100%;">
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
						<img src="<?= $poster_img; ?>" class="poster-img" style="width: 100%;">
					</div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="form-group">
						<label class="form-label">Quotes:</label>
						<span class="help">- Thankyou Quotes</span>
						<img src="<?= $share_img; ?>" class="poster-img" style="width: 100%;">
						<input type="hidden" name="old_quotes" value="<?= $series_detail->share_img; ?>">
					</div>
				</div>
			</div>
		</div>
				
</div>
</form>
	<!-- <div class="col-md-6 col-12">
		<div class="card">
            <div class="card-body">
                <h4 class="header-title">Seasons & episodes</h4>
				<a href="<?php echo base_url();?>admin/season_create/<?php echo $series_id;?>"
					class="btn btn-primary pull-right" style="margin-bottom: 20px;">
				<i class="fa fa-plus"></i>
				Create season
				</a>

				<table class="table table-hover table-centered mb-0" width="100%">
					<tbody>
						<?php
							$seasons	=	$this->crud_model->get_seasons_of_series($series_id);
							foreach ($seasons as $row):
							?>
						<tr>
							<td>
								<i class="fa fa-dot-circle-o"></i>
								<?php echo $row['name'];?>
							</td>
							<td>
								<?php
									$episodes	=	$this->crud_model->get_episodes_of_season($row['season_id']);
									echo count($episodes);
									?>
								episodes
							</td>
							<td>
								<a href="<?php echo base_url();?>admin/season_edit/<?php echo $series_id.'/'.$row['season_id'];?>"
									class="btn btn-info btn-xs btn-mini">
								manage episodes</a>
								<a href="<?php echo base_url();?>admin/season_delete/<?php echo $series_id.'/'.$row['season_id'];?>"
									class="btn btn-danger btn-xs btn-mini" onclick="return confirm('Want to delete?')">
								delete</a>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
                </table>
            </div>
        </div>
	</div>
</div> -->
