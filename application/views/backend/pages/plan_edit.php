<?php
	$plan_detail = $this->db->get_where('plan',array('plan_id'=>$plan_id))->row();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
				<form method="post" action="<?php echo base_url();?>admin/plan_edit/<?php echo $plan_id;?>">
					<div class="row">
						<div class="col-8">
							<!--PACKAGE NAME -->
							<div class="form-group mb-3">
			                    <label for="name">Package Name</label>
			                    <input type="text" class="form-control" id = "name" name="name" value="<?php echo $plan_detail->name;?>">
			                </div>

							<!--PACKAGE PRICE -->
							<div class="form-group mb-3">
			                    <label for="price">Package Price US</label>
			                    <input type="text" class="form-control" id = "price" name="price" value="<?php echo $plan_detail->price;?>">
			                </div>
			                <!--PACKAGE TOTAL PRICE-->
							<div class="form-group mb-3">
			                    <label for="price">Package total Price US</label>
			                    <input type="text" class="form-control" id = "total_price" name="total_price" value="<?php echo $plan_detail->total_price;?>">
			                </div>

			                <!--PACKAGE PRICE -->
							<div class="form-group mb-3">
			                    <label for="price">Package Price INR</label>
			                    <input type="text" class="form-control" id = "price_inr" name="price_inr" value="<?php echo $plan_detail->inr_price;?>">
			                </div>
			                	<div class="form-group mb-3">
			                    <label for="price">Plan type</label>
								<span class="help">e.g. "monthly / Yearly"</span>
								<select class="form-control select2" name="plan_type" style="width:150px;">
									<option value="1" <?php if ( $plan_detail->plan_type == 1) echo 'selected';?>>Monthly</option>
									<option value="2" <?php if ( $plan_detail->plan_type == 2) echo 'selected';?>>Yearly</option>
								</select>
			                </div>
			                
			                	<div class="form-group mb-3">
			                    <label for="price">validity(in days)</label>
			                    	<span class="help">e.g. "1 month = 30 days"</span>
			                    <input type="text" class="form-control" id = "validity" name="validity" value="<?php echo $plan_detail->validity;?>">
			                </div>

			                <?php /* FOR BASIC PLAN */ 
			                if($plan_detail->plan_id == 1) { ?>
				                <div class="form-group mb-3">
									<label for="actors">Genres</label>
									<span class="help">- select multiple Genre</span>

									<?php 
									$this->db->select('genre');
									$this->db->from('plan');
									$this->db->where('plan_id', 1);
									$query = $this->db->get();
									if ( $query->num_rows() > 0 ) {
									    $row1 = $query->row_array();
									} ?>

									<select class="form-control select2" id="actors" multiple name="genres[]">
										<?php $genres	=	$this->db->get('genre')->result_array();
											$count = 0;
											$all_gen = count($genres);
											foreach ($genres as $row2):
												$a = json_decode($row1['genre']); 
												
													for( $i=0; $i<$all_gen; $i++ ) {
														if( $row2['genre_id'] == $a[$i] ) { 
															$selectedId = $row2['genre_id'];
															?>
															<option
																
																value="<?php echo $row2['genre_id'];?>" <?php echo 'selected'; ?>>
																<?php echo $row2['name'];?>
															</option>
														<?php }
													} ?>
													<option 
														<?php
														$genres	=	$series_detail->genres;
														if ($genres != '')
														{
															$actor_array	=	json_decode($genres);
															// if (in_array($row2['genre_id'], $actor_array))
															// 	echo 'selected1';
														} ?> value="<?php echo $row2['genre_id'];?>">
														<?php if($row2['genre_id'] != $selectedId ) { echo $row2['name']; }?>
													</option>
											<?php $count++;
										endforeach;?>
									</select>
								</div>

							<?php } ?>

<!--description-->
<div class="form-group mb-3">
			                    <label for="answer">Description</label>
								<textarea class="form-control" id="answer" name="des" rows="6"><?php echo $plan_detail->des;?></textarea>
			                </div>


							<!-- PACKAGE STATUS -->
							<div class="form-group mb-3">
			                    <label for="price">Status</label>
								<span class="help">Inactive packages won't show to customer during purchase.</span>
								<select class="form-control select2" name="status" style="width:150px;">
									<option value="0" <?php if ( $plan_detail->status == 0) echo 'selected';?>>Inactive</option>
									<option value="1" <?php if ( $plan_detail->status == 1) echo 'selected';?>>Active</option>
								</select>
			                </div>

							<div class="form-group">
								<input type="submit" class="btn btn-success" value="Update">
								<a href="<?php echo base_url();?>admin/plan_list" class="btn btn-secondary">Go back</a>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
