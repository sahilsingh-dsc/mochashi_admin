 <?php
 ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(1);
class Home extends CI_Controller {

	// constructor
	function __construct()
	{
		parent::__construct();
		// require_once APPPATH.'third_party/src/Google_Client.php';
		// require_once APPPATH.'third_party/src/contrib/Google_Oauth2Service.php';
		$this->load->library('form_validation');
		$this->load->database();
		$this->load->model('crud_model');
		// $this->load->model('email_model');
		$this->load->library('session');
		// $this->load->helper('directory');
		$this->load->helper('text');
        // $this->countryCode = $this->get_country_code();		       
		
  //       $this->load->library('google');
		// $this->load->library('facebook');		
	}
	

	function signin($param1 = "")
	{
		// $this->login_check();
	 
		
		if (isset($_POST) && !empty($_POST))
		{
			$username 			= $this->input->post('username');
			$password 		= $this->input->post('password');
			$signin_result 	= $this->crud_model->signin($username, $password);
			if ($signin_result == true)
			{
				// $this->crud_model->logStat($this->session->userdata('user_id'));	

				
					redirect(base_url().'admin/dashboard' , 'refresh');
			
					
			}
			else if ($signin_result == false){
				if ($param1 == 'admin') {
					$this->session->set_flashdata('error_message','Login failed');
					redirect(base_url().'admin' , 'refresh');
				}else {
					redirect(base_url().'home/signin' , 'refresh');
				}
			}
		}
		if ($param1 == 'admin') {
			$this->load->view('backend/login.php');
		} 
		// else {
		// 	$page_data['page_name']		=	'signin';
		// 	$page_data['page_title']	=	'Sign in';
		// 	$this->load->view('frontend/index', $page_data);
		// }
	}
	public function share(){
	//	$this->login_check();
	// if ($this->session->userdata('user_login_status') != "1")
	// 		redirect(base_url().'home/signin' , 'refresh');
		$this->load->view('frontend/flixer/share');
	}
	

	function fblogin()
	{
		
    	$userData = array();
    	if($this->facebook->is_authenticated()){
    		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
    	//	echo "<pre>";
    	//	print_r($userProfile);
    		die();
    	}
    	else
    	{
    		$data['authUrl'] =  $this->facebook->login_url();
    	}
		
		$data['page_name']		=	'signin';
		$data['page_title']	=	'Sign in';
		$this->load->view('frontend/index', $data);
		//$this->load->view('frontend/flixer/signin',$data);
	}
	
	public function google_login()
	{
	
		$clientId = '343893607346-0ib9duq6msvhtusg08v3u8287hlnjg1t.apps.googleusercontent.com'; //Google client ID
		$clientSecret = '3kO4qux4mNhvWsL8vR3aGG1p'; //Google client secret
		$redirectURL = base_url() .'home';
		
		//https://curl.haxx.se/docs/caextract.html

		//Call Google API
		$gClient = new Google_Client();
		$gClient->setApplicationName('Login');
		$gClient->setClientId($clientId);
		$gClient->setClientSecret($clientSecret);
		$gClient->setRedirectUri($redirectURL);
		$google_oauthV2 = new Google_Oauth2Service($gClient);
		
		if(isset($_GET['code']))
		{
			$gClient->authenticate($_GET['code']);
			$_SESSION['token'] = $gClient->getAccessToken();
			header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
		}

		if (isset($_SESSION['token'])) 
		{
			$gClient->setAccessToken($_SESSION['token']);
		}
		
		if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();
			echo "<pre>";
			print_r($userProfile);
			die;
        } 
		else 
		{
            $url = $gClient->createAuthUrl();
		    header("Location: $url");
            exit;
        }
	}

	function MyCustom404Ctrl() {
		$page_data['page_name']		=	'404';
		$page_data['page_title']	=	'404';
		$this->load->view('frontend/index', $page_data);
	}

	// Home browsing page
	public function index()
	{
		// $this->login_check();

		$params = $_SERVER['QUERY_STRING'];
		$url_q = explode('/', $params);
		$url_controller = $url_q[0];
		$url_method = $url_q[1];
		if(empty($url_controller)) {
			$page_data['page_name']		=	'landing';
			$page_data['page_title']	=	'Welcome';
                        $page_data['meta_keywords']	=	'meta keywords here ...';
			$page_data['meta_descriptions']	=	'meta descriptions here ...';
			$page_data['country_code']	=	$this->countryCode;
			$this->load->view('frontend/index', $page_data);
		} else {
			if(file_exists(APPPATH . 'controllers/' . $url_controller . '.php')) {
				if(method_exists($url_controller, $url_method)) {
					// echo 'exist';
					$page_data['page_name']		=	'landing';
					$page_data['page_title']	=	'Welcome';
					$this->load->view('frontend/index', $page_data);
				}  else {
					$this->MyCustom404Ctrl();
				}
			} else {
				$this->MyCustom404Ctrl();
			}
		}
	}
	public function save_lock_status()
	{
		$mid 			= $this->input->post('mid');
		$nextid 			= $this->input->post('nextid');
		$signup_result = $this->crud_model->save_lock_status($mid,$nextid);
		echo $signup_result;
	}
	
	
	public function about()
	{
		$page_data['about'] = $this->db->get('about')->row();
		$page_data['page_name']		=	'about_us';
		$page_data['page_title']	=	'About Us';
		$this->load->view('frontend/index', $page_data);
	}
	

	
	public function welcome()
	{
		$page_data['page_name']		=	'welcome';
		$page_data['page_title']	=	'Welcome';
		$this->load->view('frontend/flixer/welcome', $page_data);
	}
	
	public function send(){
		
		$data['name']="Dhamrnedra raikwar";
		echo site_name();
		// $email_html = 	 $this->load->view('frontend/flixer/email/verify_email',$data,TRUE);
		// send_app_mail("dharmendra.raikwar@desiredsoft.net",'-Email verification',$email_html);
	}


	function signup()
	{
	    
		$this->login_check();
		// $this->form_validation->set_rules('name','Name','required');
		// $this->form_validation->set_rules('email','Email','required');
		// $this->form_validation->set_rules('phone','Phone','required');
		// $this->v_validation->set_rules('password','Password','required');

		if (isset($_POST) && !empty($_POST))
		//if($this->form_validation()->run()==true)
		{
			$signup_result = $this->crud_model->signup_user();
			
			 $this->email_model->signup();
		
			 if ($signup_result == true){
	
				$newsemail = $this->input->post('email');
				$checkEmail = $this->crud_model->checkNewEmail($newsemail);
				if($checkEmail == false){
					
				$insertNewsLetter = $this->db->insert('newsletter',array('email'=>$newsemail));
				$site_name	=	$this->db->get_where('settings' , array('type' => 'site_name'))->row()->description;
				$adminEmail = $this->db->get_where('settings',array('type'=>'site_email'))->row()->description;
				SendEmail($newsemail,"News letter subscribed","","",'NewLatter');

            	}
		
	 
				sleep(2);
				$trial_period	=	$this->crud_model->get_settings('trial_period');
			//	$this->session->set_flashdata('signup_success','Successfully registered . Please check your registered email id , We have sent email verification link ');
		
			//	redirect(base_url().'home/signin' , 'refresh');
				if ($trial_period == 'on'){
				    if ($this->session->userdata('login_type') == 0)
				    {
				      redirect(base_url().'browse/meditation/6' , 'refresh');    
				    }
				    else
				    {
				       redirect(base_url().'home/signin' , 'refresh');
				    }
				    
				   
				}else if ($trial_period == 'off'){
						redirect(base_url().'home/signin' , 'refresh');
				}
			
			}
			else if ($signup_result == false){
				redirect(base_url().'home/signup' , 'refresh');
			}

		}
		$page_data['page_name']		=	'signup';
		$page_data['page_title']	=	'Sign up';
		$this->load->view('frontend/index', $page_data);
	
	}

 


	
	function facebook_create()
	{
		$id 			= $this->input->post('id');
		$name 			= $this->input->post('name');
		$signup_result = $this->crud_model->save_facebook_detail($id,$name);
		/* if($signup_result == 2){
			redirect(base_url().'browse/play' , 'refresh');
		}		 */
	}
	function google_create()
	{
		$id 			= $this->input->post('id');
		$name 			= $this->input->post('name');
		$email 			= $this->input->post('email');
		$signup_result = $this->crud_model->save_google_detail($id,$name,$email);
		/* if($signup_result == 2){
			redirect(base_url().'browse/play' , 'refresh');
		}		 */
	}
	function forget()
	{
		$this->login_check();
		if (isset($_POST) && !empty($_POST))
		{
			$signup_result = $this->email_model->reset_password();
			
			redirect(base_url().'home/forget' , 'refresh');
		}
		$page_data['page_name']		=	'forget';
		$page_data['page_title']	=	'Forget Password';
		$this->load->view('frontend/index', $page_data);
	}

	function signout()
	{
		$this->crud_model->logStatOut($this->session->userdata('user_id'));
		$this->session->unset_userdata('user_login_status', '');
        $this->session->unset_userdata('user_id', '');
        $this->session->unset_userdata('login_type', '');
	
		/* $this->session->set_userdata('user_login_status', '');
        $this->session->set_userdata('user_id', '');
        $this->session->set_userdata('login_type', ''); */
	
		  $this->session->sess_destroy();
		$this->session->set_flashdata('logout_notification', 'logged_out');
		if(isset($_GET['redirected_uri'])){
			redirect(base_url().'home/subscribe', 'refresh');
		}
		else{
			redirect(base_url().'home/signin', 'refresh');
		}
	}
	function login_check()
	{
		if ($this->session->userdata('user_login_status') == "1")
			redirect(base_url().'home' , 'refresh');
	}

	function subscriptionplans(){
	    $page_data['page_name']		=	'subscriptionplans';
		$page_data['page_title']	=	'Subscription Plans';
		$this->load->view('frontend/index', $page_data);
		//$this->load->view('frontend/flixer/subscriptionplans');
	}

	function donation(){
	    $page_data['page_name']		=	'donation';
		$page_data['page_title']	=	'Donation';
		$this->load->view('frontend/index', $page_data);
		//$this->load->view('frontend/flixer/subscriptionplans');
	}

	function faqs(){
		if (isset($_POST) && !empty($_POST))
		{
			if(isset($_POST['suport-contact-submit'])){
				$this->email_model->contact_send_mail();
				$this->session->set_flashdata('success_message', 'Thanks for contacting us we will contact you soon');
			}
		}
	    $page_data['page_name']		=	'support';
		$page_data['page_title']	=	'Faqs';
		$this->load->view('frontend/index', $page_data);
		//$this->load->view('frontend/flixer/support');
	}
	function subscribe($pId=null){
		if (isset($_POST) && !empty($_POST))
		{
			if(isset($_POST['login_submit'])){
				$email 			= $this->input->post('email');
				$password 		= $this->input->post('password');
				$signin_result 	= $this->crud_model->signin($email, $password);
				if ($signin_result == true)
				{
					//$page_data['is_logged_in'] = 1;
				}
				else{
					$this->session->set_flashdata('error_message', get_phrase('Login_failed'));
				}
			}
			if(isset($_POST['signup_submit'])){
				$signup_result = $this->crud_model->signup_user();
				if ($signup_result == true){
					sleep(2);
				}
				else{
					
				}
			}
		}
		if(!empty($pId)){
			$get_active_plan = $this->crud_model->get_active_plan($pId);
			$page_data['current_plan_id'] = $pId; 
		}else{
			$get_active_plan = $this->crud_model->get_active_plan();
			$page_data['current_plan_id'] = 6;
		}
		//print_r($get_active_plans);
		$page_data['is_logged_in'] = ($this->session->userdata('user_login_status') == 1)?$this->session->userdata('user_login_status'):0;
		$page_data['active_plans'] = $this->crud_model->get_active_plans();
		$page_data['active_plan'] = $get_active_plan; 
		$page_data['page_name']		=	'subscribe';
		$page_data['page_title']	=	'A Summary of your purchase';
		$this->load->view('frontend/index', $page_data);
	}
    public function login()
	{
	
		$clientId = '';
		$clientSecret = '';
		$redirectURL = base_url() .'home/login';

		//https://curl.haxx.se/docs/caextract.html

		//Call Google API
		$gClient = new Google_Client();
		

		$gClient->setApplicationName('Login');
		$gClient->setClientId($clientId);
		$gClient->setClientSecret($clientSecret);
		$gClient->setRedirectUri($redirectURL);
		$google_oauthV2 = new Google_Oauth2Service($gClient);


		if(isset($_GET['code']))
		{

			$gClient->authenticate($_GET['code']);
			$_SESSION['token'] = $gClient->getAccessToken();

			//header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
		}


		if (isset($_SESSION['token'])) 
		{
			$gClient->setAccessToken($_SESSION['token']);
		}
		
		if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();
			echo "<pre>";
			print_r($userProfile);
			die;
        } 
		else 
		{
            $url = $gClient->createAuthUrl();
		    header("Location: $url");
            exit;
        }
	}	
	function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
	function get_country_code() {

		$ip = $this->get_client_ip();

		$json   = file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip);
		$ipData = json_decode( $json, true);

		$arrVal = array(
		  'country' => $ipData['geoplugin_countryName'],
		);

		if($arrVal['country'] == 'India') {
		    $country_code = 1;
		} else {
		    $country_code = 0;
		} 
		return $country_code;
	}
	 function getToken($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }
    public function facebook_login()
	{
		$data['user'] = array();
		// Check if user is logged in
		if ($this->facebook->is_authenticated())
		{
			// User logged in, get user details
			$user = $this->facebook->request('get', '/me?fields=id,name,email');

			if (!isset($user['error']))
			{
				$queryUser = $this->db->get_where('user', array('email_id' => $user['email'], 'login_type' => 'facebook'));
				$userData = $queryUser->result();
				$uid = 0;

				echo "<pre>";
				print_r($user);
				print_r($userData);
				if (count($userData) == 0) {
					$user_id = mt_rand(100000000, 999999999);
					$ip_address = $this->input->ip_address();  
					$data = array(
						'full_name' => $user['name'],
						'email_id' => $user['email'],
						'image' => 'https://graph.facebook.com/' . $user['id'] . '/picture?type=large',
						'user_id' => $user_id,
						'ip_address' => $ip_address,
						'password' => '',
						'created_at'=> date('Y-m-d H:i:s'),
						'status' => '1',
						'login_type'=>'facebook',
						'user_type' => '1'
					);	
					$query = $this->Generalmodel->show_data_id('user','','','insert',$data);
					$iid=$this->db->insert_id();
				}

				$queryUser2 = $this->db->get_where('user', array('email_id' => $user['email'], 'login_type' => 'facebook'));
				$userData2 = $queryUser2->result();

				print_r($userData2);
				if ($uid == 0) {
					$uid = $userData2[0]->user_id;
				}
				print_r($uid);

				$session_data=array(
						'name'=>$userData2[0]->full_name,
						'email'=>$userData2[0]->email,
						'source'=>'facebook',
						'profile_pic'=>$userData2[0]->image,
						'sess_logged_in'=>1,
						'uid'=>$uid,
						'is_userlogged_in' => 1
						);

				// Add user data in session
				$this->session->set_userdata('login_type', 'facebook');
				$this->session->set_userdata('logged_in', $session_data);
				$this->session->set_userdata('is_userlogged_email',$user['email']);
				$this->session->set_userdata('is_userlogged_id',$uid);
				$this->session->set_userdata('is_vendor_id',$uid);

				redirect('profile/dashboard_vendor',$session_data);
			}
			else
			{
				redirect('profile/logout_vendor', 'refresh');
			}
		}
		else
		{
			redirect('profile/logout_vendor', 'refresh');
		}

	}
  	public function oauth2callback(){
      //redirect(base_url().'browse/home' , 'refresh');
		// $google_data=$this->google->validate();
		// die('heyya');

		$google_data = $this->google->getUserData();
	//	print_r($google_data);
		die('here we are');
	//	print_r($this->google->getUserInfo());
		die('hey');
		//echo "1"; exit();
		$queryUser = $this->db->get_where('user', array('email' => $google_data['email'], 'login_type' => 'google'));
		$userData = $queryUser->result();
		$uid = 0;
		
		if (count($userData) == 0) {
			$user_id = mt_rand(100000000, 999999999);
			$ip_address = $this->input->ip_address();  
			$data = array(
				'name' => $google_data['name'],
				'email' => $google_data['email'],
				'image' => $google_data['profile_pic'],
				'user_id' => $user_id,
				'ip_address' => $ip_address,
				'password' => '',
				'created_at'=> date('Y-m-d H:i:s')
				
			);	
			//$query = $this->Generalmodel->show_data_id('user','','','insert',$data);
			// $uid=$this->db->insert_id();
		}

		$queryUser2 = $this->db->get_where('user', array('email_id' => $google_data['email'], 'login_type' => 'google'));
		$userData2 = $queryUser2->result();

		if ($uid == 0) {
			$uid = $userData2[0]->user_id;
		}

		$session_data=array(
				'name'=>$userData2[0]->name,
				'email'=>$userData2[0]->email,
				'source'=>'google',
				'profile_pic'=>$userData2[0]->image,
				'sess_logged_in'=>1,
				'uid'=>$uid,
				'is_userlogged_in' => 1
		);
		sleep(2);
		$trial_period	=	$this->crud_model->get_settings('trial_period');

		if ($trial_period == 'on')
			// redirect(base_url().'browse/switchprofile' , 'refresh');
			redirect(base_url().'browse/meditation/6' , 'refresh');
		else if ($trial_period == 'off')
			// redirect(base_url().'browse/youraccount' , 'refresh');
			redirect(base_url().'browse/meditation/6' , 'refresh');
	}
    public function subscribeCheck(){
    	
		if (isset($_POST) && !empty($_POST))
		{
			$email 			= $this->input->post('subscribeEmail');
			$signin_result 	= $this->crud_model->checkUserForSendGift($email);
		//	echo json_encode($signin_result);
			/*if ($signin_result=='no')
			{
				echo json_encode(array('check' => 'no' ));
			}
			else {
				echo json_encode(array('check' => 'yes' ,'user_id'=>$signin_result));
			}*/
		}
		die;
    }
    public function newsletter(){
        $email = $this->input->post('news_email');
        $checkEmail = $this->crud_model->checkNewEmail($email);
        if($checkEmail){
            $this->session->set_flashdata('error_message', 'Already Subscribed to newsletter');
		//	redirect($_SERVER['REQUEST_URI'],'refresh');
		redirect(url());
		    die();
		}
		
		$insertNewsLetter = $this->db->insert('newsletter',array('email'=>$email));
		$site_name	=	$this->db->get_where('settings' , array('type' => 'site_name'))->row()->description;
        $adminEmail = $this->db->get_where('settings',array('type'=>'site_email'))->row()->description;
	
		// eLASTIC MAIL
		SendEmail($email,"News letter subscribed","","",'NewLatter');

		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
	
		$headers[] = 'From: '.$site_name.' <info@appmeditate.com>';
		$headers[] = 'Reply-To: <no-reply@appmeditate.com>';
		$headers[] = 'X-Mailer: PHP/' . phpversion();
		
		//mail($adminEmail,'New Email Subscribed',$email.' has been subscribed',implode("\r\n", $headers));
		//@mail($adminEmail,'New Email Subscribed',$email.' has been subscribed');
        //@mail('mustafa@desiredsoft.net','New Email Subscribed',$email.' has been subscribed');
		$this->session->set_flashdata('success_message', 'Successfully subscribed to newsletter');
		
	

		redirect(url());
    }
    
    
    
 function reset_audio()
	{

		$user_id=$this->session->userdata('user_id');
		$genre_id = $this->input->post('genre_id');
		
		$deleted =  $this->db->delete('user_audio',array('user_id' => $user_id,'genre_id'=>$genre_id));
		$this->db->delete('stats',array('user_id' => $user_id,'music_session_attend !='=>4));
		  // redirect(base_url().'browse/meditation/'.$genre_id.'' , 'refresh');
		   
		 if($deleted){
			echo $genre_id;
		 }else{
            echo false;
		 } 
	}   
  
    public function newsletter_subscribe(){
        $email = $this->input->post('email');
        	$apply = $this->input->post('apply');
        	if($apply==1){
        	  	$insertNewsLetter = $this->db->insert('newsletter',array('email'=>$email));
		$site_name	=	$this->db->get_where('settings' , array('type' => 'site_name'))->row()->description;
        $adminEmail = $this->db->get_where('settings',array('type'=>'site_email'))->row()->description;
	
		// eLASTIC MAIL
		SendEmail($email,"News letter subscribed","","",'NewLatter');

		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		// Additional headers
		//$headers[] = 'To: Mustafa Vohra <mustafavohra8@gmail.com>';
		$headers[] = 'From: '.$site_name.' <info@appmeditate.com>';
		$headers[] = 'Reply-To: <no-reply@appmeditate.com>';
		$headers[] = 'X-Mailer: PHP/' . phpversion();

// 		$this->session->set_flashdata('success_message', 'Successfully subscribed to newsletter');  
	echo "Successfully subscribed to newsletter";
// echo "Successfully subscribed to newsletter";
        	   //	redirect(url()); 
        	}else{
        	  	$this->db->delete('newsletter', array('email' => $email));
        	  	echo "Successfully Unsubscribed newsletter";
        	   //  $this->session->set_flashdata('success_message', 'UnSubscribed to newsletter');
        	   //	redirect(url()); 
        	}
        	
      
    }
      
}
		