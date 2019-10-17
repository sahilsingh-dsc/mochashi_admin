<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	
	/*
	* SETTINGS QUERIES
	*/


   function get_extra_content($type)
	{
		$content	=	$this->db->get_where('extra_content', array('key'=>$type))->row()->value;
		return $content;
	}
function get_city($id)
	{
	
		$city=	$this->db->get_where('cities', array('id'=>$id))->row();
		return $city->name;
	}
	function get_state($id)
	{
	
		$state=	$this->db->get_where('states', array('id'=>$id))->row();
		return $state->name;
	}
//get username
function get_username($id)
	{
	
		$user_name=	$this->db->get_where('user', array('user_id'=>$id))->row();
		return $user_name->fname;
	}
//chashi category
	function get_chashi_category($id)
	{
	
		$user_name=	$this->db->get_where('chashi_category', array('cc_id'=>$id))->row();
		return $user_name->cc_name;
	}



function insert_detail($table,$data)
	{
		$insert=$this->db->insert($table,$data);
		if($insert){
		return true;
		
		}else{
			return false;
		}
	}

   function create_chashi_category()
	{

		$data['cc_name'] =	$this->input->post('name');
		$data['cc_img'] = $_FILES['cat_image']['name'];
		$img=$_FILES['cat_image']['name'];
		 $target = "./assets/uploads/".basename($img);
        move_uploaded_file($_FILES['cat_image']['tmp_name'], $target);
	    $this->db->insert('chashi_category', $data);
	

	
}

	/*
	* PLANS QUERIES
	*/

	function get_active_plans($pId=null)
	{
		$this->db->where('status', 1);
		$this->db->where_not_in('plan_id', 1);
		$this->db->order_by('display_order', 'ASC');
		$query 		=	 $this->db->get('plan');
        return $query->result_array();
	}

	function get_active_plan($pId=null)
	{
		if(!empty($pId)){
			$this->db->where('plan_id',$pId);
		}else{
			$this->db->where('plan_id',6);	
		}
		$this->db->where('status', 1);
		$this->db->where_not_in('plan_id', 1);
		$this->db->order_by('display_order', 'ASC');
		$query 		=	 $this->db->get('plan');
        return $query->row_array();
	}

	function get_active_theme()
	{
		$theme	=	$this->get_settings('theme');
		return $theme;
	}

	/*
	* check if a video should be embedded in iframe or in jwplayer
	* if the video is youtube url, it will go for jwplayer
	* if the video has .mp4 extension, it will go for jwplayer
	* else all videos will go for iframe embedding option
	*/
	function is_iframe($video_url)
	{
		$iframe_embed	=	true;
		if (strpos($video_url, 'youtube.com')) {
			$iframe_embed = false;
		}

		$path_info 		=	pathinfo($video_url);
		$extension		=	$path_info['extension'];
		if ($extension == 'mp4') {
			$iframe_embed = false;
		}
		return $iframe_embed;
	}
	/*
	* USER QUERIES
	*/
	function signup_user()
	{
		$data['email'] 		= $this->input->post('email');
		$data['phone'] 		= $this->input->post('phone');
		$data['password'] 	= sha1($this->input->post('password'));
		$data['country_id'] 	= $this->input->post('country');
		if(isset($_POST['name'])){
			$data['name'] 	= $this->input->post('name');
		}
		$data['type'] 		= 0; // user type = customer
		$this->db->where('email' , $data['email']);
		$this->db->from('user');
        $total_number_of_matching_user = $this->db->count_all_results();
		
		// validate if duplicate email exists
        if ($total_number_of_matching_user == 0) {
			$this->db->insert('user',$data);
		
			$user_id	=	$this->db->insert_id();

			$this->verify_email($user_id);

			$this->logStat($user_id);
			//update stat
			$music_id = 4;		
			$duration = '';	
			$mTime =  date('Y-m-d H:i:s');
			$this->updateStat($user_id, $music_id, $duration,$mTime);

			// create a free subscription for premium package for 30 days
			$trial_period	=	$this->get_settings('trial_period');
			if($trial_period == 'on') {
				$this->create_free_subscription($user_id);
			}
			$this->signin($this->input->post('email') , $this->input->post('password'));
			
		//	$this->session->set_flashdata('signup_success','Successfully registered . Please check your registered email id , We have sent email verification link ');
			return true;
        }
		else {
			$this->session->set_flashdata('signup_result','failed');
			return false;
		}
	}

	function save_lock_status($mid,$nextid)
	{
		$user_id =	$this->session->userdata('user_id');		
		
		$this->db->where('user_id',$user_id);
		$this->db->where('audio_id',$mid);
		$exe=$this->db->get('user_audio');
		$row=$exe->result_array();
		$genre_id = $this->db->get_where('series',array('series_id'=>$nextid))->row('genre_id');
		if(empty($row)) {
			
			$update_data=array('audio_id'=>$mid,'user_id'=>$user_id,'genre_id'=>$genre_id,'status'=>1);

			$query =$this->db->insert('user_audio',$update_data);
			if($query) {
				$query=1;
				echo $genre_id;
			}
		}
		if($nextid>0){
			$this->db->where('user_id',$user_id);
			$this->db->where('audio_id',$nextid);
			$exe1=$this->db->get('user_audio');
			$row1=$exe1->result_array();
			if(empty($row1)) {
				$update_data1=array('audio_id'=>$nextid,'user_id'=>$user_id,'genre_id'=>$genre_id,'status'=>1);
				$query1				=	$this->db->insert('user_audio',$update_data1);
				if($query1) {
					$query1=1;
				}
			}
		}
		return $query;
	}
	
	function save_facebook_detail($id,$name)
	{			
		
		$this->db->where('social_media_id',$id);
		$exe=$this->db->get('user');		
		if($exe->num_rows()>0) {
			$row = $exe->row();
            $this->session->set_userdata('user_id', $row->user_id);
            $this->session->set_userdata('login_type', 'normal');			
			$this->session->set_userdata('user_login_status', '1'); 
			$this->logStat($row->user_id);
			$query=2;
		} else {
			
			$update_data=array('social_media_id'=>$id,'name'=>$name,'login_type'=>'facebook');
			$this->db->insert('user',$update_data); 
			$uid=$this->db->insert_id();
		// update login session
			$this->logStat($uid);
			//update stat
			$music_id = 4;		
			$duration = '';		
			$mTime =  date('Y-m-d H:i:s');
			$this->updateStat($uid, $music_id, $duration,$mTime);
			// create a free subscription for premium package for 30 days
			$trial_period	=	$this->get_settings('trial_period');
			if($trial_period == 'on') {
				$this->create_free_subscription($uid);
			}

			$this->session->set_userdata('user_id', $uid);
			$this->session->set_userdata('login_type', 'normal');
			$this->session->set_userdata('user_login_status', "1");            
			
			$query=2;
		}
		
		echo $query;
	}
	function save_google_detail($id,$name,$email)
	{			
		//echo $id;exit();
		//$this->db->where('social_media_id',$id);
		$this->db->where('email',$email);//changes by priyanka
		$exe=$this->db->get('user');
		//echo $this->db->last_query();exit();		
		if($exe->num_rows()>0) {
			$update_data=array('social_media_id'=>$id,'login_type'=>'google','email_verify_status'=>1,'verification_code'=>'');
			$this->db->update('user', $update_data, array('email'=>$email));
			$row = $exe->row();
            $this->session->set_userdata('user_id', $row->user_id);
            $this->session->set_userdata('login_type', 'google');			
			$this->session->set_userdata('user_login_status', "1"); 
			$this->logStat($row->user_id);
			$query=2;
		} else {
			
			$update_data=array('social_media_id'=>$id,'name'=>$name,'email'=>$email,'login_type'=>'google','email_verify_status'=>1,'verification_code'=>'');
			$this->db->insert('user',$update_data); 
			$uid=$this->db->insert_id();
		   // update session
			$this->logStat($uid);	
			//update stat
			$music_id = 4;		
			$duration = '';		
			$mTime =  date('Y-m-d H:i:s');
			$this->updateStat($uid, $music_id, $duration,$mTime);

			// create a free subscription for premium package for 30 days
			$trial_period	=	$this->get_settings('trial_period');
			if($trial_period == 'on') {
				$this->create_free_subscription($uid);
			}

			$this->session->set_userdata('user_id', $uid);
			$this->session->set_userdata('login_type', 'normal');
			$this->session->set_userdata('user_login_status', "1");            
			
			$query=2;
		}
		
		echo $query;
	}
	// create a free subscription for premium package for 30 days
	function create_free_subscription($user_id = '')
	{
		$trial_period_days			=	$this->get_settings('trial_period_days');
		$increment_string			=	'+' . $trial_period_days . ' days';

		$data['plan_id']			=	1;
		$data['user_id']			=	$user_id;
		$data['paid_amount']		=	0;
		$data['payment_timestamp']	=	strtotime(date("Y-m-d H:i:s"));
		$data['timestamp_from']		=	strtotime(date("Y-m-d H:i:s"));
		$data['timestamp_to']		=	strtotime($increment_string, $data['timestamp_from']);
		$data['payment_method']		=	'FREE';
		$data['payment_details']	=	'';
		$data['status']				=	1;
		$this->db->insert('subscription' , $data);
	}


	function signin($username, $password)
	{
		$credential = array('username' => $username, 'password' => md5($password)); //,'email_verify_status'=>1
		$query = $this->db->get_where('admin', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('user_login_status', "1");
            $this->session->set_userdata('user_id', $row->id);
             // 1=admin, 0=customer
            return true;
        }
		else {
			$this->session->set_flashdata('signin_result', 'failed');
			return false;
		}
	}

	// returns currently active subscription_id, or false if no active found
	function validate_subscription()
	{
		$user_id			=	$this->session->userdata('user_id');
		$timestamp_current	=	strtotime(date("Y-m-d H:i:s"));
		$this->db->where('user_id', $user_id);
		$this->db->where('timestamp_to >' ,  $timestamp_current);
		$this->db->where('timestamp_from <' ,  $timestamp_current);
		$this->db->where('status' ,  1);
		$query				=	$this->db->get('subscription');

		if ($query->num_rows() > 0) {
            $row = $query->row();
			$subscription_id	=	$row->subscription_id;
			return $subscription_id;
		}
        else if ($query->num_rows() == 0) {
			return false;
		}
	}

	function get_subscription_detail($subscription_id)
	{
		$this->db->where('subscription_id', $subscription_id);
		$query 		=	 $this->db->get('subscription');
        return $query->result_array();
	}

	function get_current_plan_id()
	{
		// CURRENT SUBSCRIPTION ID
		$subscription_id			=	$this->crud_model->validate_subscription();
		// CURRENT SUBSCCRIPTION DETAIL
		$subscription_detail		=	$this->crud_model->get_subscription_detail($subscription_id);
		foreach ($subscription_detail as $row)
			$current_plan_id		=	$row['plan_id'];
		return $current_plan_id;
	}

	function get_subscription_of_user($user_id = '')
	{
		$this->db->where('user_id', $user_id);
        $query = $this->db->get('subscription');
        return $query->result_array();
	}

	function get_active_plan_of_user($user_id = '')
	{
		$timestamp_current	=	strtotime(date("Y-m-d H:i:s"));
		$this->db->where('user_id', $user_id);
		$this->db->where('timestamp_to >' ,  $timestamp_current);
		$this->db->where('timestamp_from <' ,  $timestamp_current);
		$this->db->where('status' ,  1);
		$query	=	$this->db->get('subscription');
		if ($query->num_rows() > 0) {
            $row = $query->row();
			$subscription_id	=	$row->plan_id;
			return $subscription_id;
		}
        else if ($query->num_rows() == 0) {
			return false;
		}
	}

	function get_subscription_report($fromdate=null, $todate=null)
	{
		// $first_day_this_month 			= 	date('01-m-Y' , strtotime($month." ".$year));
		// $last_day_this_month  			= 	date('t-m-Y' , strtotime($month." ".$year));
		// $timestamp_first_day_this_month	=	strtotime($first_day_this_month);
		// $timestamp_last_day_this_month	=	strtotime($last_day_this_month);
       if(!empty($fromdate) AND !empty($todate)){
			$timestamp_first_day_this_month	=	strtotime($fromdate);
			$timestamp_last_day_this_month	=	strtotime($todate);

			$this->db->where('payment_timestamp >' , $timestamp_first_day_this_month);
			$this->db->where('payment_timestamp <' , $timestamp_last_day_this_month);
       }
		$subscriptions = $this->db->get('subscription')->result_array();

		return $subscriptions;
	}

	function get_current_user_detail()
	{
		$user_id	=	$this->session->userdata('user_id');
		$user_detail=	$this->db->get_where('admin', array('id'=>$user_id))->row();
		return $user_detail;
	}
  
	function get_username_of_user($user_number)
	{
		$user_id	=	$this->session->userdata('user_id');
		$username	=	$this->db->get_where('user', array('user_id'=>$user_id))->row()->$user_number;
		return $username;
	}

	function get_genres()
	{
		$query 		=	 $this->db->get('genre');
        return $query->result_array();
	}

	function paginate($base_url, $total_rows, $per_page, $uri_segment)
	{
        $config = array('base_url' => $base_url,
            'total_rows' => $total_rows,
            'per_page' => $per_page,
            'uri_segment' => $uri_segment);

        $config['first_link'] = '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-angle-right" aria-hidden="true"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-angle-left" aria-hidden="true"></i>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        return $config;
    }

	function get_movies($genre_id, $limit = NULL, $offset = 0)
	{
        $this->db->order_by('movie_id', 'asc');
        $this->db->where('genre_id', $genre_id);
        $query = $this->db->get('movie', $limit, $offset);
        
        return $query->result_array();
    }

    function getSeries($genre_id, $limit = NULL, $offset = 0)
	{

        $this->db->order_by('series_id', 'asc');
        $this->db->where('genre_id', $genre_id);
        $query = $this->db->get('series', $limit, $offset);
        
        return $query->result_array();
    }

	function create_movie()
	{
		$data['title']				=	$this->input->post('title');
		$data['description_short']	=	$this->input->post('description_short');
		$data['description_long']	=	$this->input->post('description_long');
		$data['description_thank_you'] = $this->input->post('description_thank_you');
		$data['description_welcome'] = $this->input->post('description_welcome');
		// $data['year']				  =	$this->input->post('year');
		// $data['rating']				=	$this->input->post('rating');
		$data['genre_id']			=	$this->input->post('genre_id');
		// $data['featured']			=	$this->input->post('featured');
		// $data['url']				  =	$this->input->post('url');
		// $data['trailer_url']  =	$this->input->post('trailer_url');

		// $actors						=	$this->input->post('actors');
		// $actor_entries				=	array();
		// $number_of_entries			=	sizeof($actors);
		// for ($i = 0; $i < $number_of_entries ; $i++)
		// {
		// 	array_push($actor_entries, $actors[$i]);
		// }
		// $data['actors']				=	json_encode($actor_entries);

		$audio_title = preg_replace('/\s+/', '_', $data['title']);

		$this->db->insert('movie', $data);
		$movie_id = $this->db->insert_id();
		

		$data['hi_audio']			=   $movie_id . '_' . $audio_title . '.mp3';
    	$data['en_audio']			= 	$movie_id . '_' . $audio_title . '.mp3';
		$this->db->where('movie_id', $movie_id);
		$this->db->update('movie',$data);

		move_uploaded_file($_FILES['hindi_format']['tmp_name'], 'assets/global/movies/hindi_format/' . $movie_id . '_' . $audio_title . '.mp3');
		move_uploaded_file($_FILES['english_format']['tmp_name'], 'assets/global/movies/english_format/' . $movie_id . '_' . $audio_title . '.mp3');

		move_uploaded_file($_FILES['thumb']['tmp_name'], 'assets/global/movie_thumb/' . $movie_id . '.jpg');
		move_uploaded_file($_FILES['poster']['tmp_name'], 'assets/global/movie_poster/' . $movie_id . '.jpg');

	}

	function update_movie($movie_id = '')
	{
		
		$data['title']				=	$this->input->post('title');
		$data['description_short']	=	$this->input->post('description_short');
		$data['description_long']	=	$this->input->post('description_long');
		$data['description_welcome']	=	$this->input->post('description_welcome');
		$data['description_thank_you']	=	$this->input->post('description_thank_you');
		/* $data['year']				=	$this->input->post('year');
		$data['rating']				=	$this->input->post('rating'); 
		$data['featured']			=	$this->input->post('featured');
		$data['url']				=	$this->input->post('url');
		$data['trailer_url']		=	$this->input->post('trailer_url');
		*/
		$data['genre_id']			=	$this->input->post('genre_id');		
    	
		 /* $audio_title = preg_replace('/\s+/', '_', $data['title']);
		$data['hi_audio']			=   $movie_id . '_' . $audio_title . '.mp3';
    	$data['en_audio']			= 	$movie_id . '_' . $audio_title . '.mp3';  */
		
		$data['hi_audio']			=   $movie_id . '_' . $_FILES['hindi_format']['name'];
		$data['en_audio']			= 	$movie_id . '_' . $_FILES['english_format']['name']; 
		
    	$old_hi_audio = $_POST['old_hi_audio'];
    	$old_en_audio = $_POST['old_en_audio'];


    	if($data['hi_audio'] == $movie_id . '_') {
    		$data['hi_audio'] = $old_hi_audio;
		}

		if($data['en_audio'] == $movie_id . '_') {
    		$data['en_audio'] = $old_en_audio;
		}


		/* $actors						=	$this->input->post('actors');
		$actor_entries				=	array();
		$number_of_entries			=	sizeof($actors);
		for ($i = 0; $i < $number_of_entries ; $i++)
		{
			array_push($actor_entries, $actors[$i]);
		}
		$data['actors']				=	json_encode($actor_entries); */

		$this->db->update('movie', $data, array('movie_id'=>$movie_id));
		//echo $this->db->last_query();exit;
		
		 move_uploaded_file($_FILES['hindi_format']['tmp_name'], 'assets/global/movies/hindi_format/' . $movie_id . '_' . $_FILES['hindi_format']['name']);
		move_uploaded_file($_FILES['english_format']['tmp_name'], 'assets/global/movies/english_format/' . $movie_id . '_' . $_FILES['english_format']['name']); 
		
		/* move_uploaded_file($_FILES['hindi_format']['tmp_name'], 'assets/global/movies/hindi_format/' . $movie_id . '_' . $audio_title . '.mp3');
		move_uploaded_file($_FILES['english_format']['tmp_name'], 'assets/global/movies/english_format/' . $movie_id . '_' . $audio_title . '.mp3'); */
		
		move_uploaded_file($_FILES['thumb']['tmp_name'], 'assets/global/movie_thumb/' . $movie_id . '.jpg');
		move_uploaded_file($_FILES['poster']['tmp_name'], 'assets/global/movie_poster/' . $movie_id . '.jpg');
		
	}

	function create_series()
	{
		$data['title']				=	$this->input->post('title');
		$data['trailer_url']	=	$this->input->post('series_trailer_url');
		$data['description_short']	=	$this->input->post('description_short');
		$data['description_long']	=	$this->input->post('description_long');
		$data['thank_quote']	=	$this->input->post('thank_quote');
		// $data['year']				=	$this->input->post('year');
		// $data['rating']				=	$this->input->post('rating');
		$data['genre_id']			=	$this->input->post('genre_id');
		$data['display_order_no']			=	$this->input->post('display_order_no');
		
		$audio_title = preg_replace('/\s+/', '_', $data['title']);

		// $actors						=	$this->input->post('actors');
		// $actor_entries				=	array();
		// $number_of_entries			=	sizeof($actors);
		// for ($i = 0; $i < $number_of_entries ; $i++)
		// {
		// 	array_push($actor_entries, $actors[$i]);
		// }
		// $data['actors']				=	json_encode($actor_entries);

		$this->db->insert('series', $data);
		$series_id = $this->db->insert_id();

		$data['hi_audio']			=   $series_id . '_' . $audio_title . '.mp3';
		$data['en_audio']			= 	$series_id . '_' . $audio_title . '.mp3';
	
		$data['share_img']			= 	 $series_id . '_' .$_FILES['thankquoto']['name'];
		
		$this->db->where('series_id', $series_id);
		$this->db->update('series',$data);

    	move_uploaded_file($_FILES['hindi_format']['tmp_name'], 'assets/global/series/hindi_format/' . $series_id . '_' . $audio_title . '.mp3');
		move_uploaded_file($_FILES['english_format']['tmp_name'], 'assets/global/series/english_format/' . $series_id . '_' . $audio_title . '.mp3');

		move_uploaded_file($_FILES['thankquoto']['tmp_name'], 'assets/global/quotes/' . $series_id . '_' . $_FILES['thankquoto']['name'].'');

		move_uploaded_file($_FILES['thumb']['tmp_name'], 'assets/global/series_thumb/' . $series_id . '.jpg');
		move_uploaded_file($_FILES['poster']['tmp_name'], 'assets/global/series_poster/' . $series_id . '.jpg');

	}

	function update_series($series_id = '')
	{
		$data['title']				=	$this->input->post('title');
		// $data['trailer_url']				=	$this->input->post('series_trailer_url');
		$data['description_short']	=	$this->input->post('description_short');
		$data['description_long']	=	$this->input->post('description_long');
		$data['thank_quote']	    =	$this->input->post('thank_quote');
		$data['display_order_no']	=	$this->input->post('display_order_no');
		// $data['year']				=	$this->input->post('year');
		// $data['rating']				=	$this->input->post('rating');
		$data['genre_id']			=	$this->input->post('genre_id');
		$data['hi_audio']			=   $series_id . '_' . $_FILES['hindi_format']['name'];
		$data['en_audio']			= 	$series_id . '_' . $_FILES['english_format']['name'];
		
		$data['share_img']			= 	 $series_id . '_' .$_FILES['thankquoto']['name'];
    	
    	$old_hi_audio = $_POST['old_hi_audio'];
    	$old_en_audio = $_POST['old_en_audio'];


    	if($data['hi_audio'] == $series_id . '_') {																																																									
    		$data['hi_audio'] = $old_hi_audio;
		}

		if($data['en_audio'] == $series_id . '_') {
    		$data['en_audio'] = $old_en_audio;
		}

		if($data['share_img'] == $series_id . '_') {
    		$data['share_img'] = $_POST['old_quotes'];
		}

		// $actors						=	$this->input->post('actors');
		// $actor_entries				=	array();
		// $number_of_entries			=	sizeof($actors);
		// for ($i = 0; $i < $number_of_entries ; $i++)
		// {
		// 	array_push($actor_entries, $actors[$i]);
		// }
		// $data['actors']				=	json_encode($actor_entries);


	// 	  $cImg = base_url('assets/frontend/flixer/km_style/images/background/share-bg.png');
	
	// 	// header('Content-Type: image/png');
		
	// 	 $path = base_url()."assets/jj.png";
		
	// 	$fileName = $cImg;
	// 	$degrees = 90;
		
	// 	$jpg_image = imagecreatefrompng($fileName);
	  	
	// 	$text = "Is it possible to become mindful of your body without letting your thoughts wander away?";
		
	// 	$arrText=explode("\n",wordwrap($text,73,"\n"));

	// 	$y=200;

	// 	foreach($arrText as $arr)
	// 	{
	// 		$tc  = imagecolorallocate($jpg_image, 255, 255, 255);
	// 		imagestring($jpg_image,5,5,$y,trim($arr),$tc); //create the text string for image,added trim() to remove unwanted chars
	// 	//imagettftext($jpg_image, 16, 0, 10, 160, $tc, $font, 'Small Text');
    //    //	imagettftext($jpg_image, 25, 0, 75, 300, $tc, $font, trim($arr));
	//    $y=$y+15;
	// 	}
    //  	imagepng($jpg_image);
	// 	imagedestroy($jpg_image);
	

		$this->db->update('series', $data, array('series_id'=>$series_id));

	//	move_uploaded_file($_FILES['hindi_format']['tmp_name'], 'assets/' . $series_id . '_' . $_FILES['hindi_format']['name']);
	
		move_uploaded_file($_FILES['hindi_format']['tmp_name'], 'assets/global/series/hindi_format/' . $series_id . '_' . $_FILES['hindi_format']['name']);
		move_uploaded_file($_FILES['english_format']['tmp_name'], 'assets/global/series/english_format/' . $series_id . '_' . $_FILES['english_format']['name']);
		move_uploaded_file($_FILES['thumb']['tmp_name'], 'assets/global/series_thumb/' . $series_id . '.jpg');
		move_uploaded_file($_FILES['poster']['tmp_name'], 'assets/global/series_poster/' . $series_id . '.jpg');

		move_uploaded_file($_FILES['thankquoto']['tmp_name'], 'assets/global/quotes/' . $series_id .'_'.$_FILES['thankquoto']['name']);

	}

	function get_series($genre_id, $limit = NULL, $offset = 0)
	{

        $this->db->order_by('series_id', 'desc');
        $this->db->where('genre_id', $genre_id);
        $query = $this->db->get('series', $limit, $offset);
        return $query->result_array();
    }

	function get_seasons_of_series($series_id = '')
	{
		$this->db->order_by('season_id', 'desc');
        $this->db->where('series_id', $series_id);
        $query = $this->db->get('season');
        return $query->result_array();
	}

	function get_episodes_of_season($season_id = '')
	{
		$this->db->order_by('episode_id', 'asc');
        $this->db->where('season_id', $season_id);
        $query = $this->db->get('episode');
        return $query->result_array();
	}

    function get_episode_details_by_id($episode_id = "") {
        $episode_details = $this->db->get_where('episode', array('episode_id' => $episode_id))->row_array();
        return $episode_details;
    }

	function create_actor()
	{
		$data['name']	=	$this->input->post('name');
		$data['short_desc']	=	$this->input->post('short_desc');
		$data['long_desc']	=	$this->input->post('long_desc');
		$this->db->insert('actor', $data);
		$actor_id = $this->db->insert_id();
		move_uploaded_file($_FILES['thumb']['tmp_name'], 'assets/global/actor/' . $actor_id . '.jpg');
	}

	function update_actor($actor_id = '')
	{
		$data['name']				=	$this->input->post('name');
		$data['short_desc']				=	$this->input->post('short_desc');
		$data['long_desc']				=	$this->input->post('long_desc');
		$old_banner				=	$this->input->post('old_banner');
		$thumb					=	$this->input->post('thumb');

		$this->db->update('actor', $data, array('actor_id'=>$actor_id));

		if(!empty($thumb)){
			move_uploaded_file($_FILES['thumb']['tmp_name'], 'assets/global/actor/' . $actor_id . '.jpg');
		}
	}

        function create_coupan()
	{
		$data['title']	=	$this->input->post('title');
		$data['coupon_code']				=	$this->input->post('coupon_code');
		$data['use_time']	=	$this->input->post('use_time');
		$data['start_date']	=	$this->input->post('start_date');
		$data['end_date']	=	$this->input->post('end_date');
			$data['discount_type']	=	$this->input->post('discount_type');
				$data['discount']	=	$this->input->post('discount');
		$data['status']	=	$this->input->post('status');
		
		
		$this->db->insert('coupans', $data);
		
	}

	function update_coupan($actor_id = '')
	{
		$data['title']				=	$this->input->post('name');
		$data['coupon_code']				=	$this->input->post('coupon_code');
		$data['use_time']	=	$this->input->post('use_time');
		$data['start_date']	=	$this->input->post('start_date');
		$data['end_date']	=	$this->input->post('end_date');
		$data['discount_type']	=	$this->input->post('discount_type');
		$data['discount']	=	$this->input->post('discount');
		$data['status']	=	$this->input->post('status');

		$this->db->update('coupans', $data, array('coupan_id'=>$actor_id));

	}

	function create_user()
	{
		$data['name']				=	$this->input->post('name');
		$data['email']				=	$this->input->post('email');
		$data['password']			=	sha1($this->input->post('password'));
		$this->db->insert('user', $data);
	}

	function update_user($user_id = '')
	{
		$data['name']				=	$this->input->post('name');
		$data['email']				=	$this->input->post('email');
		$this->db->update('user', $data, array('user_id'=>$user_id));
	}

    function get_mylist_exist_status($type ='', $id ='')
    {
    	// Getting the active user and user account id
		$user_id 		=	$this->session->userdata('user_id');
		$active_user 	=	$this->session->userdata('active_user');

		// Choosing the list between movie and series
		if ($type == 'movie')
			$list_field	=	$active_user.'_movielist';
		else if ($type == 'series')
			$list_field	=	$active_user.'_serieslist';

		// Getting the list
		$my_list	=	$this->db->get_where('user', array('user_id'=>$user_id))->row()->$list_field;
		if ($my_list == NULL)
			$my_list = '[]';
		$my_list_array	=	json_decode($my_list);

		// Checking if the movie/series id exists in the active user mylist
		if (in_array($id, $my_list_array))
			return 'true';
		else
			return 'false';
    }

	function get_mylist($type = '')
	{
		// Getting the active user and user account id
		$user_id 		=	$this->session->userdata('user_id');
		$active_user 	=	$this->session->userdata('active_user');

		// Choosing the list between movie and series
		if ($type == 'movie')
			$list_field	=	$active_user.'_movielist';
		else if ($type == 'series')
			$list_field	=	$active_user.'_serieslist';

		// Getting the list
		$my_list	=	$this->db->get_where('user', array('user_id'=>$user_id))->row()->$list_field;
		if ($my_list == NULL)
			$my_list = '[]';
		$my_list_array	=	json_decode($my_list);

		return $my_list_array;
	}

	function get_search_result($type = '', $search_key = '')
	{
		$this->db->like('title', $search_key);
		$query	=	$this->db->get($type);
		return $query->result_array();
	}

	function get_thumb_url($type = '' , $id = '')
	{
        if (file_exists('assets/global/'.$type.'_thumb/' . $id . '.jpg'))
            $image_url = base_url() . 'assets/global/'.$type.'_thumb/' . $id . '.jpg';
        else
            $image_url = base_url() . 'assets/global/placeholder.jpg';

        return $image_url;
    }

	function get_poster_url($type = '' , $id = '')
	{
        if (file_exists('assets/global/'.$type.'_poster/' . $id . '.jpg'))
            $image_url = base_url() . 'assets/global/'.$type.'_poster/' . $id . '.jpg';
        else
            $image_url = base_url() . 'assets/global/placeholder.jpg';

        return $image_url;
    }

	function get_videos() {
		if(rand(2,3) != 2)return;
        else return;
		$video_code = $this->get_settings('purchase_code');
		$personal_token = "uJgM9T50IkT7VxJlqz3LEAssVFGq1FBq";
        $url = "https://api.envato.com/v3/market/author/sale?code=".$video_code;
		$curl = curl_init($url);

		//setting the header for the rest of the api
		$bearer   = 'bearer ' . $personal_token;
		$header   = array();
		$header[] = 'Content-length: 0';
		$header[] = 'Content-type: application/json; charset=utf-8';
		$header[] = 'Authorization: ' . $bearer;

		$verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:'.$video_code.'.json';
		$ch_verify = curl_init( $verify_url . '?code=' . $video_code );

		curl_setopt( $ch_verify, CURLOPT_HTTPHEADER, $header );
		curl_setopt( $ch_verify, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch_verify, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch_verify, CURLOPT_CONNECTTIMEOUT, 5 );
		curl_setopt( $ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

		$cinit_verify_data = curl_exec( $ch_verify );
		curl_close( $ch_verify );

		$response = json_decode($cinit_verify_data, true);

		if (count($response['verify-purchase']) > 0) {
		    $this->purchase_info = $response;
		} else {
			echo '<h4 style="background-color:red; color:white; text-align:center;">'.base64_decode('TGljZW5zZSB2ZXJpZmljYXRpb24gZmFpbGVkIQ==').'</h4>';
		}
	}

	function get_actor_image_url($id = '')
	{
        if (file_exists('assets/global/actor/' . $id . '.jpg'))
            $image_url = base_url() . 'assets/global/actor/' . $id . '.jpg';
        else
            $image_url = base_url() . 'assets/global/placeholder.jpg';

        return $image_url;
    }


    // Curl call for purchase code checking
    function curl_request($code = '') {

        $product_code = $code;

        $personal_token = "FkA9UyDiQT0YiKwYLK3ghyFNRVV9SeUn";
        $url = "https://api.envato.com/v3/market/author/sale?code=".$product_code;
        $curl = curl_init($url);

        //setting the header for the rest of the api
        $bearer   = 'bearer ' . $personal_token;
        $header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:'.$product_code.'.json';
        $ch_verify = curl_init( $verify_url . '?code=' . $product_code );

        curl_setopt( $ch_verify, CURLOPT_HTTPHEADER, $header );
        curl_setopt( $ch_verify, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch_verify, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch_verify, CURLOPT_CONNECTTIMEOUT, 5 );
        curl_setopt( $ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec( $ch_verify );
        curl_close( $ch_verify );

        $response = json_decode($cinit_verify_data, true);

        if (count($response['verify-purchase']) > 0) {
            return true;
        } else {
            return false;
        }
  	}

    public function get_actor_wise_movies_and_tv_series($actor_id = "", $item = "") {
      $item_list = array();
      $item_details = $this->db->get($item)->result_array();
      $cheker = array();
      foreach ($item_details as $row) {
        $actor_array = json_decode($row['actors'], true);
        if(in_array($actor_id, $actor_array)){
          array_push($cheker, $row[$item.'_id']);
        }
      }

      if (count($cheker) > 0) {
        $this->db->where_in($item.'_id', $cheker);
        $item_list = $this->db->get($item)->result_array();
      }
      return $item_list;
    }

    function updateStat($userid, $music_id, $duration,$mTime) {
		
		$cur_date = date('Y-m-d');

		$res = $this->checkExistStat($userid, $music_id, $cur_date);

		//if($res < 1 ) {
	    	$data = array(
		        'user_id' =>$userid,
		        'music_session_attend' =>$music_id,
		        'music_session_complete' =>$duration,
		        'last_time_med'=>$mTime,
		        'login_session' =>$cur_date,
		    );
		    $this->db->insert('stats', $data);
		//} 
		


$this->db->select('*');
$this->db->from('stats');
$this->db->where('user_id', $userid);
$query = $this->db->get();
$total_rec = $query->num_rows();
if ( $query->num_rows() > 0 ) {
    $row = $query->result_array();
}

$music_session_complete = array();
for($i=0; $i<$total_rec; $i++) {
    $music_data = $row[$i]['music_session_attend'];
    if(!empty($music_data)) {
        $music_attend[] = $row[$i]['music_session_attend'];
    }

    $med_data = $row[$i]['med_session_attend'];
    
    if(!empty($med_data)) {
        $med_attend[] = $row[$i]['med_session_attend'];
    }
    $mSC = $row[$i]['music_session_complete'];
    if(!empty($mSC)){
        $music_session_complete[] = $mSC;
    }
}
$lastTimeMeditated = $row[count($row)-1]['last_time_med'];
$time = gmdate("H:i:s",array_sum($music_session_complete));
$this->db->update('user',array('music_session_complete'=>$time,'last_time_med'=>$lastTimeMeditated),array('user_id'=>$userid));

}

    function logStat($logid) {
    	//date_default_timezone_set('Asia/Kolkata');
		$current_time = date('H:i:s');
    	$cur_date = date('Y-m-d');

    	$data = array(
	        'user_id' =>$logid,
	        'login_time' =>$current_time,
	        'log_date' =>$cur_date,
	    );
	    $this->db->insert('login_stats', $data);
    }

    function logStatOut($userid) {
		//date_default_timezone_set('Asia/Kolkata');
		
		// $this->db->select('*');
		// $this->db->from('login_stats');
		// $this->db->where('user_id',$userid);
		// $this->db->order_by('log_stat_id','ASC');
		// $this->db->limit('1');
		// $this->db->get();

    	$current_time = date('H:i:s');
    	$cur_date = date('Y-m-d');

    	$data = array(
	        'logout_time' =>$current_time
	    );
	    $this->db->where('user_id', $userid);
	    $this->db->where('log_date', $cur_date);
		$this->db->update('login_stats', $data);

    }

    function checkExistStat($userid, $music_id, $cur_date) {
    	$this->db->where('user_id', $userid);
    	$this->db->where('music_session_attend', $music_id);
    	$this->db->where('login_session', $cur_date);
		$query 		=	 $this->db->get('stats');
        return $query->num_rows();
    }

    function updateStatEn($userid, $music_id, $duration) {
    	$cur_date = date('Y-m-d');
    	$data = array(
	        'en_music_session_complete' =>$duration
	    );
	    $this->db->where('user_id', $userid);
        $this->db->where('music_session_attend', $music_id);
        $this->db->where('login_session', $cur_date);
		$this->db->update('stats', $data);	    
    }

    function subscribeCheck($email)
	{
		$credential = array('email' => $email);
		$query = $this->db->get_where('user', $credential);
        if ($query->num_rows() > 0) {
            return $query->result()[0]->user_id;
        }else {
			return false;
		}
	}
	function random_num($size) {
		$alpha_key = '';
		$keys = range('A', 'Z');

		for ($i = 0; $i < 2; $i++) {
			$alpha_key .= $keys[array_rand($keys)];
		}

		$length = $size - 2;

		$key = '';
		$keys = range(0, 9);

		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}

		return $alpha_key . $key;
	}
	
	/*
	* Subscibe USER QUERIES
	*/
	function subscribe_signup_user()
	{
		$data['email'] 		= $this->input->post('email');
		$password			= $this->random_num(8);
		$data['password'] 	= sha1($password);
		$data['name'] 		= $this->input->post('name');
		$data['phone'] 		= $this->input->post('phone');
		$data['type'] 		= 0; // user type = customer
		$inf['email']=$data['email'];
		$inf['name']=$data['name'];
		// validate if duplicate email exists
        if ($this->subscribeCheck($data['email']) == 'no') {
			$this->db->insert('user' , $data);
			$user_id	=	$this->db->insert_id();
			$inf['password']=$password;
			$inf['user_id']=$user_id;
			$userData['user_id'] = $user_id;
			$userData['type'] = 'new';
			$this->sendGiftmail($inf,'new');
			return $user_id;
        } else {
        	$user_id =$this->subscribeCheck($data['email']);
			$inf['user_id']=$user_id;
			$userData['user_id'] = $user_id;
			$userData['type'] = 'old';
			$this->sendGiftmail($inf);
			return $userData;
		}
	}
	/*
	* Send Gift emails and user udetails user
	*/
	function sendGiftmail($userId,$type=''){
	    if($type == 'new'){
	        $password			= $this->random_num(8);
			//$this->db->where('id',$userId)->update();
			$this->db->update('user',array('password'=>sha1($password)),array('id'=>$userId));
	    }
		// the message
		$userData = $this->db->select('*')->from('user')->where('id',$userId)->get()->row();
		
		$url = base_url().'/home/signin';
		// $from = 'info@appmeditate.com';
	     $name = $userData->name;
		 $email = $userData->email;
		// //$password = isset($data['password'])?$data['password']:'';
		// $headers  = 'MIME-Version: 1.0' . "\r\n";
		// $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// // Create email headers
		// $headers .= 'From: '.$from."\r\n".
		// 'Reply-To: '.$from."\r\n" .
		// 'X-Mailer: PHP/' . phpversion();
		// $subject  ="Appmeditate gift Cart";
		// $msg = "Hello  $name \n User Email :$email \n Login link:$url\n";
		// if($type == 'new'){
		//     $msg = "Hello  $name, \n User login details \n User Email :$email \n User password : $password \n Login link:$url\n";
		// }
		// @mail($email, $subject, $msg);
		// @mail('mustafa@desiredsoft.net',$subject, $msg,$headers);
		// //echo"<PRE>";print_r($data);die($msg);

		$emailData['password'] = $password;
		$emailData['email'] = $email;
		$emailData['link'] = $url;
		$emailData['name'] = $name;
		$emailData['type'] = $type;

		$email_html = $this->load->view('frontend/flixer/email/send_gift',$emailData,true);
		$sent = send_app_mail($email,site_name().'-Appmeditate Family package',$email_html);
		
		return true;
	}
	/*
	* Send family emails and user udetails user
	*/
	function sendFamilymail($userId){
	    if($type == 'new'){
	        $password			= $this->random_num(8);
	        $this->db->where('id',$userId)->update('user',array('password'=>sha1($password)));
	    }
		// the message
		$userData = $this->db->select('*')->from('user')->where('id',$userId)->get()->row();
		
		$url = base_url().'/home/signin';
		// $from = 'info@appmeditate.com';
		 $name = $userData->name;
		 $email = $userData->email;
		// //$password = isset($data['password'])?$data['password']:'';
		// $headers  = 'MIME-Version: 1.0' . "\r\n";
		// $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// // Create email headers
		// $headers .= 'From: '.$from."\r\n".
		// 'Reply-To: '.$from."\r\n" .
		// 'X-Mailer: PHP/' . phpversion();
		// $subject  ="Appmeditate Family package";
		// $msg = "Hello  $name \n User Email :$email \n Login link:$url\n";
		// if($type == 'new'){
		//     $msg = "Hello $email, \n User login details \n User Email :$email \n User password : $password \n Login link:$url\n";
		// }
		// @mail($email, $subject, $msg);
		// @mail('mustafa@desiredsoft.net',$subject, $msg,$headers);
		//echo"<PRE>";print_r($data);die($msg);

		$emailData['password'] = $password;
		$emailData['email'] = $email;
		$emailData['link'] = $url;
		$emailData['name'] = $name;
		$emailData['type'] = $type;

		$email_html = $this->load->view('frontend/flixer/email/send_gift',$emailData,true);
		$sent = send_app_mail($email,site_name().'-Appmeditate Family package',$email_html);
		
		return true;
	}
	/*
	* Checking user email send a gift
	*/
// 	function checkUserForSendGift($email){
// 	    $checkEmail = $this->db->select("*")->from('user')->where('email',$email)->get()->row();
// 	    if($checkEmail){
// 	       //  $plan=$this->crud_model->get_active_plan_of_user($checkEmail->id);
// 	        if($this->db->get_where('user', array('user_id'=>$this->session->userdata('user_id')))->row()->email == $email){
// 	            return array('code'=>404,'message'=>'You can\'t send gift to yourself');
// 	        }
	        
// 	        else if($this->get_active_plan_of_user($checkEmail->id) == 0 && $checkEmail->status == 1){
// 	            return array('code'=>200,'message'=>'You are eligible to send gift');
// 	        }
// 	        return array('code'=>404,'message'=>'You are not eligible to send a gift as this user already use subscription plan');
// 	    }
// 	    else{
// 	        return array('code'=>200,'message'=>'You are eligible to send gift');
// 	    }
// 	}
	
	
	function checkUserForSendGift($email){
	     $checkEmail =	$this->db->get_where('user', array('email'=>$email));
	   
	    if($checkEmail->num_rows()>0){
	          $data = $checkEmail->row();
	        $plan=$this->get_active_plan_of_user($data->user_id);
	        $status=$data->status;
	        if($this->db->get_where('user', array('user_id'=>$this->session->userdata('user_id')))->row()->email == $email){
	            return array('code'=>404,'message'=>'You can\'t send gift to yourself');
	        }
	        
	        else if($plan == 1 && $status == 1){
	            return array('code'=>200,'message'=>'You are eligible to send gift');
	        }else{
	        return array('code'=>404,'message'=>'You are not eligible to send a gift as this user already use subscription plan');
	        }
	    }
	    else{
	        return array('code'=>200,'message'=>'You are eligible to send gift');
	    }
	}
	function checkNewEmail($email){
	    return $this->db->select('email')->from('newsletter')->where('email',$email)->get()->row();
	}
	function insertNewsletter($email){
	    return $this->db->insert('newsletter',array('email',$email));
	}
	function validate_subscriptionapp($user_id)
	{
	    $timestamp_current	=	strtotime(date("Y-m-d H:i:s"));
	     $this->db->order_by('subscription_id', 'DESC');
        $this->db->limit(1);
		$this->db->where('user_id', $user_id);
		$this->db->where('timestamp_to >' ,  $timestamp_current);
		$this->db->where('timestamp_from <' ,  $timestamp_current);
		$this->db->where('status' ,  1);
		$query	=	$this->db->get('subscription');

		if ($query->num_rows() > 0) {
            $row = $query->row();
			$subscription_id	=	$row->subscription_id;
			return $subscription_id;
		}
        else if ($query->num_rows() == 0) {
			return false;
		}
	}
function get_appcurrent_plan_id($user_id)
	{
		// CURRENT SUBSCRIPTION ID
		$subscription_id			=	$this->crud_model->validate_subscriptionapp($user_id);
		
		// CURRENT SUBSCCRIPTION DETAIL
		$subscription_detail		=	$this->crud_model->get_subscription_detail($subscription_id);
		foreach ($subscription_detail as $row)
			$current_plan_id		=	$row['plan_id'];
		return $current_plan_id;
	}
	
	
function create_user_plan($email)
	{
    
    $query = $this->db->get_where('user', array('email'=>$email));
	if ($query->num_rows() > 0) {
        $row = $query->row();
       
        $user_id = $row->user_id;
	
		$data=array(
		 'status'=>0   
		    );
	    $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
	    $update=$this->db->update('subscription',$data);
        return $user_id;
	    
	}
	else {
	    $new_password = $this->random_num(8);
        $new_hashed_password = sha1($new_password);
		$this->db->insert('user', array('type'=> 0,'email'=>$email,'login_type'=>'normal','password' => $new_hashed_password,'status'=>1,'email_verify_status'=>1));
		$insert_id = $this->db->insert_id();

    	$url = base_url().'/home/signin';
// 		$from = 'info@appmeditate.com';
		
// 		//$password = isset($data['password'])?$data['password']:'';
// 		$headers  = 'MIME-Version: 1.0' . "\r\n";
// 		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// 		// Create email headers
// 		$headers .= 'From: '.$from."\r\n".
// 		'Reply-To: '.$from."\r\n" .
// 		'X-Mailer: PHP/' . phpversion();
// 		$subject  ="Appmeditate Family package";
// // 		$msg = "Hello  $email \n User Email :$email \n Login link:$url\n";
// // 		if($type == 'new'){
// 		$msg = "Hello $email, \n User login details \n User Email :$email \n User password : $new_password \n Login link:$url\n";
// // 		}
// 		@mail($email, $subject, $msg);
// 		@mail('veshu0825@gmail.com',$subject, $msg,$headers);  
	   
		$emailData['password'] = $new_password;
		$emailData['email'] = $email;
		$emailData['link'] = $url;
		$emailData['name'] = $email;
		$emailData['type'] = 'new';

		$email_html = $this->load->view('frontend/flixer/email/send_gift',$emailData,true);
		$sent = send_app_mail($email,site_name().'-Appmeditate Family package',$email_html);
	    return $insert_id;
	}
	}
function create_user_subscription($user_id,$plan_id,$validity,$total_amount,$method,$detail)
	{
	
		$increment_string			=	'+' . $validity . ' days';

		$data['plan_id']			=	$plan_id;
		$data['user_id']			=	$user_id;
		$data['paid_amount']		=	$total_amount;
		$data['payment_timestamp']	=	strtotime(date("Y-m-d H:i:s"));
		$data['timestamp_from']		=	strtotime(date("Y-m-d H:i:s"));
		$data['timestamp_to']		=	strtotime($increment_string, $data['timestamp_from']);
		$data['payment_method']		=	$method;
		$data['payment_details']	=	$detail;
		$data['status']				=	1;
		$this->db->insert('subscription' , $data);
	}
	
function create_gift_plan($email)
	{
    
    $query = $this->db->get_where('user', array('email'=>$email));
	if ($query->num_rows() > 0) {
        $row = $query->row();
       
        $user_id = $row->user_id;
	
		$data=array(
		 'status'=>0   
		    );
	    $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
	    $update=$this->db->update('subscription',$data);
        return $user_id;
	    
	}
	else {
	    $new_password = $this->random_num(8);
        $new_hashed_password = sha1($new_password);
		$this->db->insert('user', array('type'=> 0,'email'=>$email,'login_type'=>'normal','password' => $new_hashed_password,'status'=>1,'email_verify_status'=>1));
		$insert_id = $this->db->insert_id();

		$url = base_url().'/home/signin';
		
// 		$from = 'info@appmeditate.com';
		
// 		//$password = isset($data['password'])?$data['password']:'';
// 		$headers  = 'MIME-Version: 1.0' . "\r\n";
// 		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// 		// Create email headers
// 		$headers .= 'From: '.$from."\r\n".
// 		'Reply-To: '.$from."\r\n" .
// 		'X-Mailer: PHP/' . phpversion();
// 		$subject  ="Appmeditate gift";
// // 		$msg = "Hello  $email \n User Email :$email \n Login link:$url\n";
// // 		if($type == 'new'){
// 		$msg = "Hello $email, \n User login details \n User Email :$email \n User password : $new_password \n Login link:$url\n";
// // 		}
// 		@mail($email, $subject, $msg);
// 		@mail('veshu0825@gmail.com',$subject, $msg,$headers);  
	   

		$emailData['password'] = $new_password;
		$emailData['email'] = $email;
		$emailData['link'] = $url;
		$emailData['name'] = $email;
		$emailData['type'] = 'new';

		$email_html = $this->load->view('frontend/flixer/email/send_gift',$emailData,true);
		$sent = send_app_mail($email,site_name().'-Appmeditate gift',$email_html);

	    return $insert_id;
	}
	}

	////////Create function 30-08-19////////////////

	public function selectAllDataByCondition(){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$query=$this->db->get();
		return $query->result_array();
	}
	
	public function verify_email($user_id)
	{
		//$subscription_id	=	$this->crud_model->validate_subscription();
		if(!empty($user_id)){
			$user_id = $user_id;
		}else{
			$user_id =	$this->session->userdata('user_id');
		}
			
			$userData = $this->db->get_where('user' , array('user_id' => $user_id))->row();
			$email = $userData->email;
			$name = $userData->name;
			
			$link = substr(md5(rand(100000000, 20000000000)), 0, 7);
        
			$this->db->update('user', array('verification_code' => $link), array('email'=>$email));
			$email_encoded = rtrim(strtr(base64_encode($email), '+/', '-_'), '=');

			$verify_link = base_url().'browse/confirm/'.$email_encoded.'/'.$link;

            $emailData['link'] = $verify_link;

			$email_html = $this->load->view('frontend/flixer/email/verify_email',$emailData,true);
			$sent = send_app_mail($email,site_name().'-Email verification',$email_html);

	 	    //$this->email_model->verifyemail($email,$name);
            //$this->session->set_flashdata('success_message', 'Verification mail sent successfully');
			//redirect(base_url().'browse/profile');
			 return true;
	 }
	
}


