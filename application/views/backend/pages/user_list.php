<a href="<?php echo base_url();?>admin/user_create/" class="btn btn-primary" style="margin-bottom: 20px;">
    <i class="fa fa-plus"></i>
    Create user
</a>
<button class="btn btn-primary deleteUser" style="margin-bottom: 20px;">
    <i class="fa fa-plus"></i>
    Delete User
</button>
<button class="btn btn-primary UpgradeMembership" style="margin-bottom: 20px;">
    <i class="fa fa-plus"></i>
    Upgrade User Membership
</button>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">User List</h4>
                <p class="text-muted font-14 mb-4">
                    <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="UserChkAll"></th>
                                <th>User Email</th>
                                <th>Subscribed Package</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$users = $this->db->select('*')->from('user')->where('type',0)->order_by('user_id','DESC')->get()->result_array();
							$counter = 1;
							foreach ($users as $row):
								$plan_id	=	$this->crud_model->get_active_plan_of_user($row['user_id']);
						?>
                            <tr>
                                <td>
                                    <div class="checkbox checkbox-success">
                                        <input type="checkbox" class="Usercheckbox" id="UserChk_<?= $row['user_id'] ?>"
                                            value="<?=$row['user_id'] ?>">
                                        <label for="UserChk_<?=$row['user_id'] ?>" class=""></label>
                                    </div>
                                </td>
                                <td style="text-transform: uppercase;"><?php echo $row['email'];?> (<?=emailverify($row['email_verify_status'])?>)</td>
                                <td>
                                    <?php
								
									
									if ($plan_id != false)
									{
										$plan_name	=	$this->db->get_where('plan', array('plan_id' => $plan_id))->row()->name;
										echo ucfirst($plan_name);
									}else{
										echo "Package Expired";
									}
									?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url();?>admin/user_view/<?php echo $row['user_id'];?>"
                                        class="btn btn-primary btn-xs btn-mini">
                                        View</a>
                                    <a href="<?php echo base_url();?>admin/user_edit/<?php echo $row['user_id'];?>"
                                        class="btn btn-info btn-xs btn-mini">
                                        edit</a>
                                    <a data-id="<?php echo $row['user_id'];?>"
                                        class="btn btn-danger btn-xs btn-mini deleteSingleUser">
                                        delete</a>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="membership" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 20px;">
			    <h3>Select Plan</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:10px 15px;">
                <form role="form">
				<div class="container">
		
			<div class="membership_form">
				<?php
				$plans = $this->db->select('*')->from('plan')->where("genre","null")->order_by('display_order','asc')->get()->result_array();
				
				foreach($plans as $val){
					?>
					<div class="cstm-plan-popup-admin">
						<div>
							<h3><?=$val['name']?></h3>
							<h4>$ <?=$val['total_price']?> USD</h4>
							<a class="btn btn-subscribe subscribeNow"  data-plan="<?=$val['plan_id']?>" >SUBSCRIBE NOW</a>
						</div>
					</div>
					<?php 
				}
				?>
				<input type="text" hidden name="userId" id="SubUserIds" />
			</div>
		</div>
                   
                </form>
            </div>
        </div>

    </div>
</div>