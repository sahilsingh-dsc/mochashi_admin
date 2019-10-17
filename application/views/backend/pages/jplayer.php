<?php 

$this->db->select('*');
$this->db->from('jplayer');

$query = $this->db->get();

if ( $query->num_rows() > 0 )
{
    $row = $query->row_array();
}

$old_hi_audio = $row['jp_audio'];
$old_en_audio = $row['en_audio'];

$oha = base_url() . 'assets/global/jplayer/' . $old_hi_audio;
$oea = base_url() . 'assets/global/jplayer/' . $old_en_audio;

?>


<div class="row">
	<div class="col-12">
		<form method="post" action="<?php echo base_url();?>admin/jp_upload" enctype="multipart/form-data">
			<div class="row">
				<div class="col-6">
			        <div class="card">
			            <div class="card-body">
							<div class="form-group">
								<label class="form-label">Upload Audio</label>
								<span class="help"> - Hindi Audio</span>
								<div class="controls">
									<input type="file" name="jp_audio" />
									<input type="hidden" name="old_hi_audio" value="<?= $old_hi_audio; ?>">
								</div>
							</div>
							
			            </div>
			        </div>
			    </div>

			    <div class="col-6">
			        <div class="card">
			            <div class="card-body">
							<div class="form-group">
								<label class="form-label">Audio In Hindi:</label>
								<span class="help"></span>
								<div class="controls">
									<audio controls>
								  		<source src="<?= $oha; ?>" type="audio/ogg">
								  		<source src="<?= $oha; ?>" type="audio/mpeg">
									</audio>
								</div>
							</div>
							
			            </div>
			        </div>
			    </div>

			    <div class="col-6">
			        <div class="card">
			            <div class="card-body">
							<div class="form-group">
								<label class="form-label">Upload Audio</label>
								<span class="help"> - English Audio</span>
								<div class="controls">
									<input type="file" name="en_audio" />
									<input type="hidden" name="old_en_audio" value="<?= $old_en_audio; ?>">
								</div>
							</div>
							
			            </div>
			        </div>
			    </div>

			    <div class="col-6">
			        <div class="card">
			            <div class="card-body">
							<div class="form-group">
								<label class="form-label">Audio In English:</label>
								<span class="help"></span>
								<div class="controls">
									<audio controls>
								  		<source src="<?= $oea; ?>" type="audio/ogg">
								  		<source src="<?= $oea; ?>" type="audio/mpeg">
									</audio>
								</div>
							</div>
							
			            </div>
			        </div>
			    </div>

				<div class="col-4">
					<div class="form-group">
						<input type="submit" class="btn btn-success" value="Update">
					</div>
				</div>
			</div>
		</form>
	</div>
</div>