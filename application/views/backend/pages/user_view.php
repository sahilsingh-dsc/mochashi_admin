<?php
	$user_detail = $this->db->get_where('user',array('user_id'=>$edit_user_id))->row();
	$profile_pic = $user_detail->profile_pic; 
 
     $log_usr_id = $edit_user_id;


// $this->db->select('*');
// $this->db->from('stats');
// $this->db->where('user_id', $log_usr_id);
// $query = $this->db->get();
// $total_rec = $query->num_rows();
// if ( $query->num_rows() > 0 ) {
//     $row = $query->result_array();

//     //debug($row);
// }
// $music_session_complete = array();
// for($i=0; $i<$total_rec; $i++) {
//     $music_data = $row[$i]['music_session_attend'];
//     if(!empty($music_data)) {
//         $music_attend[] = $row[$i]['music_session_attend'];
//     }

//     $med_data = $row[$i]['med_session_attend'];
    
//     if(!empty($med_data)) {
//         $med_attend[] = $row[$i]['med_session_attend'];
//     }
//     $mSC = $row[$i]['music_session_complete'];
//     if(!empty($mSC)){
//         $music_session_complete[] = $mSC;
//     }
// }
//  $lastTimeMeditated = $row[count($row)-1]['last_time_med'];

// $q = $this->db->query("SELECT login_session FROM stats WHERE med_session_attend != '' AND user_id=" . $log_usr_id . ' ORDER BY stat_id DESC LIMIT 1');
// $res = $q->row_array();
// $last_med_time = date('d-m-Y', strtotime($res['login_session']));


/* GET LOGIN SESSION TIME SPEND */
$cur_date = date('Y-m-d');
$q1 = $this->db->query("SELECT login_time, logout_time FROM login_stats WHERE logout_time != '' AND log_date<= '$cur_date' AND user_id=" . $log_usr_id . ' ORDER BY log_stat_id DESC LIMIT 1');
$res1 = $q1->row_array();

$log_time = explode(' ', $res1['login_time']);
$log_out_time = explode(' ', $res1['logout_time']);

function calculate_time( $parm, $parm1 ) {
    $t1= $parm;
    $t2= $parm1;
    $a1 = explode(":",$t1);
    $a2 = explode(":",$t2);
    $time1 = (($a1[0]*60*60)+($a1[1]*60));
    $time2 = (($a2[0]*60*60)+($a2[1]*60));
    $diff = abs($time1-$time2);
    $hours = floor($diff/(60*60));
    $mins = floor(($diff-($hours*60*60))/(60));
    $secs = floor(($diff-(($hours*60*60)+($mins*60))));

    $result['hours'] = $hours; 
    $result['min'] = $mins; 
    $result['sec'] = $secs; 
    
    return $result;
}
 

 $current_plan_id            =  $this->db->get_where('subscription',array('user_id'=>$log_usr_id))->row('plan_id');// $this->crud_model->get_current_plan_id();
 $current_plan_name          =   $this->db->get_where('plan', array('plan_id'=> $current_plan_id))->row()->name;
 $current_plan_screens       =   $this->db->get_where('plan', array('plan_id'=> $current_plan_id))->row()->screens;
 $current_subscription_upto_timestamp =  $this->db->get_where('subscription', array('plan_id'=> $current_plan_id, 'user_id' => $log_usr_id))->row()->timestamp_to;
 $current_subscription_start_timestamp =  $this->db->get_where('subscription', array('plan_id'=> $current_plan_id, 'user_id' => $log_usr_id))->row()->timestamp_from;

?>


<style type="text/css">

	.text-right{
		text-align: right;
	}

.admin-user-pic .img-tr {
	width: 100px;
	margin-left: auto;
	overflow: hidden;
}
.admin-user-pic img{
  width: 100%;
}
.cstm-user-detail thead tr {
	background-color: #2c5364;
	color: #fff;
}
.cstm-user-detail tbody td {
	background-color: #fff;
}
.cstm-user-detail h2 {
	color: #2c5364;
	font-weight: 500;
}

.row.cstm-name-pic {
	padding-bottom: 25px;
}
.row.cstm-name-pic .user-name {
	color: #2c5364;
	font-size: 20px;
}
.row.cstm-name-pic h5 {
	color: #2c5364;
	font-size: 18px;
	font-weight: 500;
}


</style>

<div class="row">
    <div class="col-12">
    	
    	<div class="cstm-user-detail">
    		<h2>Personal Detail</h2>
    		<div class="row cstm-name-pic">
    			<div class="col-9 col-sm-9">
    			<h4 class="user-name"><?=ucfirst($user_detail->name)?></h4>
    			<h5><i class="mdi mdi-email-open-outline"></i> <?=$user_detail->email?></h5>
    			<h5><i class="mdi mdi-cellphone"></i> <?=$user_detail->phone?></h5>
    			</div>
    			<div class="col-3 col-sm-3">
    			<div class="admin-user-pic">
    				<div class="img-tr">
						<?php if(!empty($profile_pic)){ ?>
				
							<img src="<?=base_url()?>/uploads/<?=$profile_pic?>">
				<?php		}else{
echo '<img src="/assets/global/profile-img.jpg">';
						}?>
    				
    				</div>
    			</div>
    			</div>
    		</div>
<!--     		<div class="table-responsive">
    		<table class="table table-bordered">
    			<tbody>
    				<tr>
    					<td><b>Email</b></td>
    					<td>dharmendraraikwar@gmail.com</td>
    				</tr>
    				<tr>
    					<td></b>Phone Number</b></td>
    					<td>+91 9893652654</td>
    				</tr>
    			</tbody>
    		</table>
    		</div> -->

             <h2>Package Detail</h2>
    		<div class="table-responsive">
    		<table class="table table-bordered">
    			<thead>
    				<tr>
    					<th>Package Name</th>
    					<th>Activate Date</th>
    					<th>Effective Date</th>
    					<!-- <th>Coupen Code Used</th> -->
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<td> <?php echo $current_plan_id!=''? $current_plan_name . " (" . $current_plan_screens . " screens)":''; ?></td>
    					<td><?php echo date('d M, Y', $current_subscription_start_timestamp);?></td>
    					<td><?php echo date('d M, Y', $current_subscription_upto_timestamp);?></td>
    					<!-- <td>DHAR00012</td> -->
    				</tr>
    			</tbody>
    		</table>
    		</div>


    		<h2>Stats</h2>
    		<div class="table-responsive">
    		<table class="table table-bordered">
    			<thead>
    				<tr>
    					<th>Last time meditated</th>
    					<th>Total Time Meditated</th>
    					<th>Login Session</th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<td><?php  if(!empty($user_detail->last_time_med)){
                                            echo date('d, F Y h:ia',strtotime($user_detail->last_time_med));
                                        }?></td>
    					<td><?php echo $user_detail->music_session_complete;  ?></td>
    					<td>
							<?php
									$login_session = calculate_time($log_time[0], $log_out_time[0]);
									$hour = $login_session['hours'];
									$min = $login_session['min'];
									$sec = $login_session['sec'];
									if(!empty($hour)) {
											echo $hour . ' Hours, ' . $min . ' min';
									} else {
											echo $min . ' Minutes';
									} ?>
							</td>
    				</tr>
    			</tbody>
    		</table>
    		</div>
    	</div>

    </div>
</div>
