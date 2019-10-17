<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	// constructor
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('crud_model');
		$this->load->library('session');
		// $this->admin_login_check();
	}

	public function index()
	{
			$this->load->view('backend/login.php');
	}

   function signin()
	{
		

			$username 			= $this->input->post('username');
			$password 		= $this->input->post('password');

			$signin_result 	= $this->crud_model->signin($username, $password);
			if ($signin_result == true)
			{
				// $this->crud_model->logStat($this->session->userdata('user_id'));	

				
					redirect(base_url().'admin/dashboard');
			
					
			}
			else if ($signin_result == false){
			
					$this->session->set_flashdata('error_message','Login failed');
					redirect(base_url().'admin' , 'refresh');
				
			}
		
	
	}
	

	function dashboard()
	{
			$page_data['page_name']	=	'dashboard';
			$page_data['page_title']	=	'Dashboard';
			$this->load->view('backend/index', $page_data);
	}	
	
    function chashi_category()
	{
			$page_data['page_name']	=	'chashi_category';
			$page_data['page_title']	=	'Category';
			$this->load->view('backend/index', $page_data);
	}
	function chashi_category_create()
	{
		if (isset($_POST) && !empty($_POST))
		{
		$data['cc_name'] =	$this->input->post('name');
		$data['active'] =	$this->input->post('active');
		$data['cc_img'] = $_FILES['cat_image']['name'];
		$img=$_FILES['cat_image']['name'];
		$target = "uploads/".basename($img);
        move_uploaded_file($_FILES['cat_image']['tmp_name'], $target);
	    $this->db->insert('chashi_category', $data);
			redirect(base_url().'admin/chashi_category' , 'refresh');
		}
		$page_data['page_name']		=	'chashi_category_create';
		$page_data['page_title']	=	' Chashi Category';
		$this->load->view('backend/index', $page_data);
	}

	function chashi_vendor_delete($Vendor_id)
	{
		$this->db->delete('user',  array('user_id' => $Vendor_id));
		$this->db->delete('chashi_product',  array('user_id' => $Vendor_id));
		redirect(base_url().'admin/chashi_vendors' , 'refresh');
	}

		function chashi_product_delete($p_id)
	{
		$this->db->delete('chashi_product',  array('p_id' => $p_id));
		redirect(base_url().'admin/chashi_product_list' , 'refresh');
	}

	 function chashi_product_list()
	{

		$page_data['page_name']	=	'chashi_product_list';
		$page_data['page_title']	=	'Chashi Product List';
		$this->load->view('backend/index', $page_data);
	}
	 function chashi_products()
	{
		if (isset($_POST) && !empty($_POST))
		{

		$data['user_id'] = $this->input->post('user_id');
		$data['category_id'] = $this->input->post('category_id');
		$data['p_name'] = $this->input->post('p_name');
		// $data['active'] =	$this->input->post('active');
		$data['product_uid'] = $data['user_id'].'-'.time().'-'.mt_rand();
		$p_img1=$_FILES['p_img1']['name'];

		$target1 = "uploads/chashi_products/".basename($p_img1);
		$data['p_img1']=base_url().$target1;
		move_uploaded_file($_FILES['p_img1']['tmp_name'], $target1);

		$p_img2=$_FILES['p_img2']['name'];
		$target2 = "uploads/chashi_products/".basename($p_img2);
		$data['p_img2']=base_url().$target2;
		move_uploaded_file($_FILES['p_img2']['tmp_name'], $target2);

		$p_img3=$_FILES['p_img3']['name'];
		$target3 = "uploads/chashi_products/".basename($p_img3);
		$data['p_img3']=base_url().$target3;
		move_uploaded_file($_FILES['p_img3']['tmp_name'], $target3);

		$p_img4=$_FILES['p_img4']['name'];
		$target4 = "uploads/chashi_products/".basename($p_img4);
		$data['p_img4']=base_url().$target4;
		move_uploaded_file($_FILES['p_img4']['tmp_name'], $target4);
		$data['qty_hosted'] = $this->input->post('qty_hosted');

		$data['unit'] = $this->input->post('unit');
		$data['rate'] = $this->input->post('rate');
		$data['deliver']  = $this->input->post('delivered');


		$this->db->insert('chashi_product', $data);
		redirect(base_url().'admin/chashi_product_list' , 'refresh');
		}
		$page_data['page_name']	=	'chashi_products';
		$page_data['page_title']	=	'Chashi Products';
		$this->load->view('backend/index', $page_data);
		}



	function chashi_product_edit($p_id)
	{
		if (isset($_POST) && !empty($_POST))
		{


		$data['p_name'] = $this->input->post('p_name');
		if($_FILES['p_img1']['name']!==""){
		$p_img1=$_FILES['p_img1']['name'];

		$target1 = "uploads/chashi_products/".basename($p_img1);
		$data['p_img1']=base_url().$target1;
		move_uploaded_file($_FILES['p_img1']['tmp_name'], $target1);
		}
		if($_FILES['p_img2']['name']!==""){
		$p_img2=$_FILES['p_img2']['name'];
		$target2 = "uploads/chashi_products/".basename($p_img2);
		$data['p_img2']=base_url().$target2;
		move_uploaded_file($_FILES['p_img2']['tmp_name'], $target2);
		}
		if($_FILES['p_img3']['name']!==""){
		$p_img3=$_FILES['p_img3']['name'];
		$target3 = "uploads/chashi_products/".basename($p_img3);
		$data['p_img3']=base_url().$target3;
		move_uploaded_file($_FILES['p_img3']['tmp_name'], $target3);
		}
		if($_FILES['p_img4']['name']!==""){
		$p_img4=$_FILES['p_img4']['name'];
		$target4 = "uploads/chashi_products/".basename($p_img4);
		$data['p_img4']=base_url().$target4;
		move_uploaded_file($_FILES['p_img4']['tmp_name'], $target4);
		}

		$data['qty_hosted'] = $this->input->post('qty_hosted');

		$data['unit'] = $this->input->post('unit');
		$data['rate'] = $this->input->post('rate');
		$data['deliver']  = $this->input->post('delivered');
		$this->db->update('chashi_product', $data, array('p_id'=>$p_id));
		redirect(base_url().'admin/chashi_product_list' , 'refresh');
		}
		$page_data['p_id']		=	$p_id;
		$page_data['page_name']		=	'chashi_product_edit';
		$page_data['page_title']	=	'Chashi Product Edit';
		$this->load->view('backend/index', $page_data);
	}	

   function chashi_vendors()
	{
			$page_data['page_name']	=	'chashi_vendors';
			$page_data['page_title']	=	'Vendors';
			$this->load->view('backend/index', $page_data);
	}
	function chashi_vendor_detail($user_id)
	{

		$page_data['user_id']		=	$user_id;
		$page_data['page_name']		=	'chashi_vendor_detail';
		$page_data['page_title']	=	'Chashi Vendors Detail';
		$this->load->view('backend/index', $page_data);
	}	
	function chashi_category_edit($cat_id)
	{
		if (isset($_POST) && !empty($_POST))
		{
		$data['cc_name'] =	$this->input->post('name');
		$data['active'] =	$this->input->post('active');


		if($_FILES['cat_image']['name']!==""){
		$data['cc_img'] = $_FILES['cat_image']['name'];
		$img=$_FILES['cat_image']['name'];
		$target = "uploads/".basename($img);
        move_uploaded_file($_FILES['cat_image']['tmp_name'], $target);
         }
	    $this->db->update('chashi_category', $data, array('cc_id'=>$cat_id));
			redirect(base_url().'admin/chashi_category' , 'refresh');
		}
		$page_data['cat_id']		=	$cat_id;
		$page_data['page_name']		=	'chashi_category_edit';
		$page_data['page_title']	=	'Chashi Category Edit';
		$this->load->view('backend/index', $page_data);
	}	
	function chashi_category_delete($cat_id = '')
	{
		$this->db->delete('chashi_category',  array('cc_id' => $cat_id));
		redirect(base_url().'admin/chashi_category' , 'refresh');
	}
	
	function admin_login_check()
	{
		$user_id			=	$this->session->userdata('user_id');
		if ($user_id == "")
		{
			redirect(base_url().'admin' , 'refresh');
			//redirect(base_url().'backend/index' , 'refresh');
			//redirect(base_url().'backend/pages/dashboard' , 'refresh');			
		}
	}

	  function signout()
	{
	
		$this->session->unset_userdata('user_login_status', '');
		$this->session->unset_userdata('user_id', '');
		$this->session->sess_destroy();
		$this->session->set_flashdata('logout_notification', 'logged_out');

		redirect(base_url().'admin', 'refresh');
		
	}


	function grocery_vendor_detail($user_id)
	{
// 		if (isset($_POST) && !empty($_POST))
// 		{
// 			$data['name']			=	$this->input->post('name');
// 			$gen_cat_img            =   $_FILES['gen_cat_img']['name'];
// 			$data['thumb']			=	$gen_cat_img;
// // 			move_uploaded_file($_FILES['gen_cat_img']['tmp_name'], 'assets/global/genre_cat_thumb/' . $gen_cat_img);
// 		    move_uploaded_file($_FILES['gen_cat_img']['tmp_name'], 'assets/global/genre_cat_thumb/' . $genre_id . '.jpg');
// 			/*$data['can_guest']			=	0;
// 			$isGuest = $this->input->post('can_guest');
// 			if($isGuest != ''){
// 			    $data['can_guest'] = 1;
// 			}*/
// 			$this->db->update('genre', $data,  array('genre_id' => $genre_id));
// 			redirect(base_url().'admin/genre_list' , 'refresh');
// 		}
		$page_data['user_id']		=	$user_id;
		$page_data['page_name']		=	'grocery_vendor_detail';
		$page_data['page_title']	=	'Grocery Detail';
		$this->load->view('backend/index', $page_data);
	}	



function grocery_category_create($user_id)
	{
		if (isset($_POST) && !empty($_POST))
		{
		$data['cat_name'] =	$this->input->post('name');
		$data['status'] =	$this->input->post('active');
		
		$img=$_FILES['cat_image']['name'];
		$target = "uploads/".basename($img);
        move_uploaded_file($_FILES['cat_image']['tmp_name'], $target);
        $data['cat_img'] = base_url()."uploads/".basename($img);
        $data['user_type'] =2;
           $data['user_id'] =$user_id;
	    $this->db->insert('category', $data);
			redirect(base_url().'admin/grocery_vendor_detail/'.$user_id , 'refresh');
		}
		$page_data['user_id']		=	$user_id;
		$page_data['page_name']		=	'grocery_category_create';
		$page_data['page_title']	=	' Grocery Category';
		$this->load->view('backend/index', $page_data);
	}
	function haat_category_create($user_id)
	{
		if (isset($_POST) && !empty($_POST))
		{
		$data['cat_name'] =	$this->input->post('name');
		$data['status'] =	$this->input->post('active');
		
		$img=$_FILES['cat_image']['name'];
		$target = "uploads/".basename($img);
        move_uploaded_file($_FILES['cat_image']['tmp_name'], $target);
        $data['cat_img'] = base_url()."uploads/".basename($img);
        $data['user_type'] =3;
           $data['user_id'] =$user_id;
	    $this->db->insert('category', $data);
			redirect(base_url().'admin/haat_vendor_detail/'.$user_id , 'refresh');
		}
		$page_data['user_id']		=	$user_id;
		$page_data['page_name']		=	'haat_category_create';
		$page_data['page_title']	=	' Haat Category';
		$this->load->view('backend/index', $page_data);
	}
	function grocery_product_create($cat_id,$user_id)
	{
		if (isset($_POST) && !empty($_POST))
		{
		$data['cat_id'] =	$cat_id;
		$data['p_name'] =	$this->input->post('p_name');
		$data['p_desc'] =	$this->input->post('desc');
		
		$img=$_FILES['p_img']['name'];
		$target = "uploads/products/".basename($img);
        move_uploaded_file($_FILES['p_img']['tmp_name'], $target);
        $data['p_img'] = base_url()."uploads/products/".basename($img);
        $data['mrp'] =	$this->input->post('mrp');
        $data['sale_price'] =	$this->input->post('sale_price');
        $data['p_qty'] =	$this->input->post('p_qty');
        $data['unit'] =	$this->input->post('unit');
        $data['is_available'] =	$this->input->post('is_available');
         $data['status'] =	$this->input->post('status');
       
	    $this->db->insert('products', $data);
		redirect(base_url().'admin/grocery_vendor_products/'.$cat_id.'/'.$user_id , 'refresh');
		}
		$page_data['user_id']		=	$user_id;
		$page_data['cat_id']		=	$cat_id;
		$page_data['page_name']		=	'grocery_product_create';
		$page_data['page_title']	=	' Grocery Product';
		$this->load->view('backend/index', $page_data);
	}
	function grocery_product_edit($p_id,$user_id)
	{
		if (isset($_POST) && !empty($_POST))
		{
		$data['p_name'] =	$this->input->post('p_name');
		$data['p_desc'] =	$this->input->post('desc');
		if($_FILES['p_img']['name']!==""){
		$img=$_FILES['p_img']['name'];
		$target = "uploads/products/".basename($img);
        move_uploaded_file($_FILES['p_img']['tmp_name'], $target);
           $data['p_img'] = base_url()."uploads/products/".basename($img);
         }
     
        $data['mrp'] =	$this->input->post('mrp');
        $data['sale_price'] =	$this->input->post('sale_price');
        $data['p_qty'] =	$this->input->post('p_qty');
        $data['unit'] =	$this->input->post('unit');
        $data['is_available'] =	$this->input->post('is_available');
         $data['status'] =	$this->input->post('status');


	
	    $this->db->update('products', $data, array('p_id'=>$p_id));
			redirect(base_url().'admin/grocery_product_edit/'.$p_id.'/'.$user_id, 'refresh');
		}
		$page_data['p_id']		=	$p_id;
		$page_data['user_id']		=	$user_id;
		$page_data['page_name']		=	'grocery_product_edit';
		$page_data['page_title']	=	'Grocery Product Edit';
		$this->load->view('backend/index', $page_data);
	}	
	function grocery_category_edit($cat_id)
	{
		if (isset($_POST) && !empty($_POST))
		{
		$data['cat_name'] =	$this->input->post('name');
		$data['status'] =	$this->input->post('active');


		if($_FILES['cat_image']['name']!==""){
	
		$img=$_FILES['cat_image']['name'];
		$target = "uploads/".basename($img);
        move_uploaded_file($_FILES['cat_image']['tmp_name'], $target);
        	 $data['cat_img'] = base_url()."uploads/".basename($img);
         }
	    $this->db->update('category', $data, array('cat_id'=>$cat_id));
			redirect(base_url().'admin/grocery_category_edit/'.$cat_id , 'refresh');
		}
		$page_data['cat_id']		=	$cat_id;
		$page_data['page_name']		=	'grocery_category_edit';
		$page_data['page_title']	=	'Grocery Category Edit';
		$this->load->view('backend/index', $page_data);
	}	
function haat_vendor_detail($user_id)
	{
// 		if (isset($_POST) && !empty($_POST))
// 		{
// 			$data['name']			=	$this->input->post('name');
// 			$gen_cat_img            =   $_FILES['gen_cat_img']['name'];
// 			$data['thumb']			=	$gen_cat_img;
// // 			move_uploaded_file($_FILES['gen_cat_img']['tmp_name'], 'assets/global/genre_cat_thumb/' . $gen_cat_img);
// 		    move_uploaded_file($_FILES['gen_cat_img']['tmp_name'], 'assets/global/genre_cat_thumb/' . $genre_id . '.jpg');
// 			/*$data['can_guest']			=	0;
// 			$isGuest = $this->input->post('can_guest');
// 			if($isGuest != ''){
// 			    $data['can_guest'] = 1;
// 			}*/
// 			$this->db->update('genre', $data,  array('genre_id' => $genre_id));
// 			redirect(base_url().'admin/genre_list' , 'refresh');
// 		}
		$page_data['user_id']		=	$user_id;
		$page_data['page_name']		=	'haat_vendor_detail';
		$page_data['page_title']	=	'Haat Vendors Detail';
		$this->load->view('backend/index', $page_data);
	}	
	
	
	function grocery_category_delete($cat_id = '',$user_id)
	{
		$this->db->delete('category',  array('cat_id' => $cat_id));
		redirect(base_url().'admin/grocery_vendors/'.$user_id , 'refresh');
	}
 function grocery_product_delete($p_id,$cat_id = '',$user_id)
	{
		$this->db->delete('products',  array('p_id' => $p_id));
		redirect(base_url().'admin/grocery_vendor_products/'.$cat_id.'/'.$user_id , 'refresh');
	}


 function grocery_vendors()
	{
			$page_data['page_name']	=	'grocery_vendors';
			$page_data['page_title']	=	'Vendors';
			$this->load->view('backend/index', $page_data);
	}

 function haat_vendors()
	{
			$page_data['page_name']	=	'haat_vendors';
			$page_data['page_title']	=	'Vendors';
			$this->load->view('backend/index', $page_data);
	}
	function grocery_vendor_products($cat_id,$user_id)
	{

		$page_data['user_id']		=	$user_id;
		$page_data['cat_id']		=	$cat_id;
		$page_data['page_name']		=	'grocery_products';
		$page_data['page_title']	=	'Grocery Products';
		$this->load->view('backend/index', $page_data);
	}	

		function haat_vendor_products($cat_id,$user_id)
	{
           $page_data['user_id']		=	$user_id;
		$page_data['cat_id']		=	$cat_id;
		$page_data['page_name']		=	'haat_products';
		$page_data['page_title']	=	'Haat Products';
		$this->load->view('backend/index', $page_data);
	}	
function grocery_product_detail($p_id,$user_id)
	{
        $page_data['user_id']		=	$user_id;
		$page_data['p_id']		=	$p_id;
		$page_data['page_name']		=	'grocery_product_detail';
		$page_data['page_title']	=	'Grocery Product Detail';
		$this->load->view('backend/index', $page_data);
	}	
	function haat_product_detail($p_id)
	{

		$page_data['p_id']		=	$p_id;
		$page_data['page_name']		=	'haat_product_detail';
		$page_data['page_title']	=	'Haat Product Detail';
		$this->load->view('backend/index', $page_data);
	}	
	// WATCH LIST OF GENRE, MANAGE THEM

	function genre_list()
	{
		$page_data['page_name']		=	'genre_list';
		$page_data['page_title']	=	'Manage Genre';
		$this->load->view('backend/index', $page_data);
	}

	// CREATE A NEW GENRE
	function genre_create()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$data['name']			=	$this->input->post('name');
			// $data['can_guest']			=	0;
			// $isGuest = $this->input->post('can_guest');
			// if($isGuest != ''){
			//     $data['can_guest'] = 1;
			// }
			$this->db->insert('genre', $data);
			redirect(base_url().'admin/genre_list' , 'refresh');
		}
		$page_data['page_name']		=	'genre_create';
		$page_data['page_title']	=	'Create Genre';
		$this->load->view('backend/index', $page_data);
	}

	// EDIT A GENRE
	function genre_edit($genre_id = '')
	{
		if (isset($_POST) && !empty($_POST))
		{
			$data['name']			=	$this->input->post('name');
			$gen_cat_img            =   $_FILES['gen_cat_img']['name'];
			$data['thumb']			=	$gen_cat_img;
// 			move_uploaded_file($_FILES['gen_cat_img']['tmp_name'], 'assets/global/genre_cat_thumb/' . $gen_cat_img);
		    move_uploaded_file($_FILES['gen_cat_img']['tmp_name'], 'assets/global/genre_cat_thumb/' . $genre_id . '.jpg');
			/*$data['can_guest']			=	0;
			$isGuest = $this->input->post('can_guest');
			if($isGuest != ''){
			    $data['can_guest'] = 1;
			}*/
			$this->db->update('genre', $data,  array('genre_id' => $genre_id));
			redirect(base_url().'admin/genre_list' , 'refresh');
		}
		$page_data['genre_id']		=	$genre_id;
		$page_data['page_name']		=	'genre_edit';
		$page_data['page_title']	=	'Edit Genre';
		$this->load->view('backend/index', $page_data);
	}

	// DELETE A GENRE
	function genre_delete($genre_id = '')
	{
		$this->db->delete('genre',  array('genre_id' => $genre_id));
		redirect(base_url().'admin/genre_list' , 'refresh');
	}

	// WATCH LIST OF MOVIES, MANAGE THEM
	function track_list()
	{
		$page_data['page_name']		=	'movie_list';
		$page_data['page_title']	=	'Manage Music';
		$this->load->view('backend/index', $page_data);
	}

	// CREATE A NEW MOVIE
	function movie_create()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->crud_model->create_movie();
			redirect(base_url().'admin/track_list' , 'refresh');
		}
		$page_data['page_name']		=	'movie_create';
		$page_data['page_title']	=	'Create track';
		$this->load->view('backend/index', $page_data);
	}

	// EDIT A MOVIE
	function track_edit($movie_id = '')
	{

		if (isset($_POST) && !empty($_POST))
		{
			$this->crud_model->update_movie($movie_id);
			redirect(base_url().'admin/track_list' , 'refresh');
		}
		$page_data['movie_id']		=	$movie_id;
		$page_data['page_name']		=	'movie_edit';
		$page_data['page_title']	=	'Edit track';
		$this->load->view('backend/index', $page_data);
	}

	// DELETE A MOVIE
	function movie_delete($movie_id = '')
	{
		$this->db->delete('movie',  array('movie_id' => $movie_id));
		redirect(base_url().'admin/track_list' , 'refresh');
	}

	// WATCH LIST OF SERIESS, MANAGE THEM
	function series_list()
	{
		$page_data['page_name']		=	'series_list';
		$page_data['page_title']	=	'Manage Series';
		$this->load->view('backend/index', $page_data);
	}

	// CREATE A NEW SERIES
	function series_create()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->crud_model->create_series();
			redirect(base_url().'admin/series_list' , 'refresh');
		}
		$page_data['page_name']		=	'series_create';
		$page_data['page_title']	=	' Create Meditation Series';
		$this->load->view('backend/index', $page_data);
	}

	// EDIT A SERIES
	function series_edit($series_id = '')
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->crud_model->update_series($series_id);
	//		redirect(base_url().'admin/series_list/' , 'refresh');
		}
		$page_data['series_id']		=	$series_id;
		$page_data['page_name']		=	'series_edit';
		$page_data['page_title']	=	'Edit Mediation Series';
		$this->load->view('backend/index', $page_data);
	}

	// DELETE A SERIES
	function series_delete($series_id = '')
	{
		$this->db->delete('series',  array('series_id' => $series_id));
		redirect(base_url().'admin/series_list' , 'refresh');
	}

	// CREATE A NEW SEASON
	function season_create($series_id = '')
	{
		$this->db->where('series_id' , $series_id);
		$this->db->from('season');
        $number_of_season 	=	$this->db->count_all_results();

		$data['series_id']	=	$series_id;
		$data['name']		=	'Season ' . ($number_of_season + 1);
		$this->db->insert('season', $data);
		redirect(base_url().'admin/series_edit/'.$series_id , 'refresh');

	}

	// EDIT A SEASON
	function season_edit($series_id = '', $season_id = '')
	{
		if (isset($_POST) && !empty($_POST))
		{
			$data['title']			=	$this->input->post('title');
			$this->db->update('series', $data,  array('series_id' => $series_id));
			redirect(base_url().'admin/series_edit/'.$series_id , 'refresh');
		}
		$series_name				=	$this->db->get_where('series', array('series_id'=>$series_id))->row()->title;
		$season_name				=	$this->db->get_where('season', array('season_id'=>$season_id))->row()->name;
		$page_data['page_title']	=	'Manage episodes of ' . $season_name . ' : ' . $series_name;
		$page_data['season_name']	=	$this->db->get_where('season', array('season_id'=>$season_id))->row()->name;
		$page_data['series_id']		=	$series_id;
		$page_data['season_id']		=	$season_id;
		$page_data['page_name']		=	'season_edit';
		$this->load->view('backend/index', $page_data);
	}

	// DELETE A SEASON
	function season_delete($series_id = '', $season_id = '')
	{
		$this->db->delete('season',  array('season_id' => $season_id));
		redirect(base_url().'admin/series_edit/'.$series_id , 'refresh');
	}

	// CREATE A NEW EPISODE
	function episode_create($series_id = '', $season_id = '')
	{
		if (isset($_POST) && !empty($_POST))
		{
			$data['title']			=	$this->input->post('title');
			$data['url']			=	$this->input->post('url');
			$data['season_id']		=	$season_id;
			$this->db->insert('episode', $data);
			$episode_id = $this->db->insert_id();
			move_uploaded_file($_FILES['thumb']['tmp_name'], 'assets/global/episode_thumb/' . $episode_id . '.jpg');
			redirect(base_url().'admin/season_edit/'.$series_id.'/'.$season_id , 'refresh');
		}
	}

	// CREATE A NEW EPISODE
	function episode_edit($series_id = '', $season_id = '', $episode_id = '')
	{
		if (isset($_POST) && !empty($_POST))
		{
			$data['title']			=	$this->input->post('title');
			$data['url']			=	$this->input->post('url');
			$data['season_id']		=	$season_id;
			$this->db->update('episode', $data, array('episode_id'=>$episode_id));
			move_uploaded_file($_FILES['thumb']['tmp_name'], 'assets/global/episode_thumb/' . $episode_id . '.jpg');
			redirect(base_url().'admin/season_edit/'.$series_id.'/'.$season_id , 'refresh');
		}
	}

	// DELETE AN EPISODE
	function episode_delete($series_id = '', $season_id = '', $episode_id = '')
	{
		$this->db->delete('episode',  array('episode_id' => $episode_id));
		redirect(base_url().'admin/season_edit/'.$series_id.'/'.$season_id , 'refresh');
	}

	// WATCH LIST OF ACTORS, MANAGE THEM
	function banner_list()
	{
		$page_data['page_name']		=	'actor_list';
		$page_data['page_title']	=	'Manage actor';
		$this->load->view('backend/index', $page_data);
	}
	
	function tool_tip()
	{
		$page_data['page_name']		=	'tool_tip';
		$page_data['page_title']	=	'Manage tool tip';
		$this->load->view('backend/index', $page_data);
	}

	// CREATE A NEW ACTOR
	function banner_create()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->crud_model->create_actor();
			redirect(base_url().'admin/banner_list' , 'refresh');
		}
		$page_data['page_name']		=	'actor_create';
		$page_data['page_title']	=	'Create Banner';
		$this->load->view('backend/index', $page_data);
	}

	// EDIT A ACTOR
	function banner_edit($actor_id = '')
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->crud_model->update_actor($actor_id);
			redirect(base_url().'admin/banner_list' , 'refresh');
		}
		$page_data['actor_id']		=	$actor_id;
		$page_data['page_name']		=	'actor_edit';
		$page_data['page_title']	=	'Edit Banner';
		$this->load->view('backend/index', $page_data);
	}

	// DELETE A ACTOR
	function actor_delete($actor_id = '')
	{
		$this->db->delete('actor',  array('actor_id' => $actor_id));
		redirect(base_url().'admin/banner_list' , 'refresh');
	}
        
	function coupan_list()
	{
		$page_data['page_name']		=	'coupan_list';
		$page_data['page_title']	=	'Manage Coupons';
		$this->load->view('backend/index', $page_data);
	}

	function coupan_create()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->crud_model->create_coupan();
			redirect(base_url().'admin/coupan_list' , 'refresh');
		}
		$page_data['page_name']		=	'coupan_create';
		$page_data['page_title']	=	'Create Coupon';
		$this->load->view('backend/index', $page_data);
	}

	function coupan_edit($actor_id = '')
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->crud_model->update_coupan($actor_id);
			redirect(base_url().'admin/coupan_list' , 'refresh');
		}
		$page_data['actor_id']		=	$actor_id;
		$page_data['page_name']		=	'coupan_edit';
		$page_data['page_title']	=	'Edit Coupon';
		$this->load->view('backend/index', $page_data);
	}

	function coupan_delete($actor_id = '')
	{
		$this->db->delete('coupans',  array('coupan_id' => $actor_id));
		redirect(base_url().'admin/coupan_list' , 'refresh');
	}

	// WATCH LIST OF PRICING PACKAGES, MANAGE THEM
	function plan_list()
	{
		$page_data['page_name']		=	'plan_list';
		$page_data['page_title']	=	'Manage plan';
		$this->load->view('backend/index', $page_data);
	}

	// EDIT A ACTOR
	function plan_edit($plan_id = '')
	{
		if (isset($_POST) && !empty($_POST))
		{

			$data['name']			=	$this->input->post('name');
			$data['price']			=	$this->input->post('price');
			$data['total_price']	=	$this->input->post('total_price');
			$data['inr_price']		=	$this->input->post('price_inr');
			$data['status']			=	$this->input->post('status');
				$data['validity']		=	$this->input->post('validity');
			$data['plan_type']			=	$this->input->post('plan_type');
			$genre					=	$this->input->post('genres');
			$data['des'] = $this->input->post('des');
				
			$data['genre'] = json_encode($genre);

			$this->db->update('plan', $data,  array('plan_id' => $plan_id));
			redirect(base_url().'admin/plan_list' , 'refresh');
		}
		$page_data['plan_id']		=	$plan_id;
		$page_data['page_name']		=	'plan_edit';
		$page_data['page_title']	=	'Edit Membership plan';
		$this->load->view('backend/index', $page_data);
	}

	// WATCH LIST OF USERS, MANAGE THEM
	function user_list()
	{
		$page_data['page_name']		=	'user_list';
		$page_data['page_title']	=	'Manage user';
		$this->load->view('backend/index', $page_data);
	}

	// CREATE A NEW USER
	function user_create()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->crud_model->create_user();
			redirect(base_url().'admin/user_list' , 'refresh');
		}
		$page_data['page_name']		=	'user_create';
		$page_data['page_title']	=	'Create user';
		$this->load->view('backend/index', $page_data);
	}

	// EDIT A USER
	function user_edit($edit_user_id = '')
	{
		if (isset($_POST) && !empty($_POST))
		{
			$this->crud_model->update_user($edit_user_id);
			redirect(base_url().'admin/user_list' , 'refresh');
		}
		$page_data['edit_user_id']	=	$edit_user_id;
		$page_data['page_name']		=	'user_edit';
		$page_data['page_title']	=	'Edit user';
		$this->load->view('backend/index', $page_data);
	}

	// EDIT A USER
	function user_view($edit_user_id = '')
	{
		
		$page_data['edit_user_id']	=	$edit_user_id;
		$page_data['page_name']		=	'user_view';
		$page_data['page_title']	=	'View user';
		$this->load->view('backend/index', $page_data);
	}
	// DELETE A USER
	function user_delete($user_id = '')
	{
		$this->db->delete('user',  array('user_id' => $user_id));
		redirect(base_url().'admin/user_list' , 'refresh');
	}

	function user_bulk_delete()
	{
		$userData = $this->input->post();
		
		foreach($userData['userId'] as $userId){
			
		$deleted = 	$this->db->delete('user',  array('user_id' => $userId));
		}
		if($deleted){
			echo true;
		}else{
			echo false;
		}
		
		// $this->db->delete('user',  array('user_id' => $user_id));
		// redirect(base_url().'admin/user_list' , 'refresh');
	}


	public function ugrade_membership(){
		$userData = $this->input->post();
		
		$plan_id =  $userData['plan_id'];
		$user_id = $userData['user_id'];
		$user_ids = explode(",",$user_id);
		
		
		$timestamp_from		=	strtotime(date("Y-m-d H:i:s"));
		$days =	$this->db->get_where('plan', array('plan_id'=>$plan_id))->row()->validity;
		$tD= '+'.$days.'days';
		$timestamp_to		=	strtotime($tD, $timestamp_from);


		foreach($user_ids as $userId){
			$data['plan_id'] = $plan_id;
			$data['timestamp_from'] = $timestamp_from;
			$data['timestamp_to'] = $timestamp_to;

		$userData =	$this->db->get_where("subscription",array('user_id'=>$user_id));
			if($userData->num_rows()>0){
				$updated = 	$this->db->update('subscription',$data,array('user_id' => $userId));
			}else{
				$data['user_id']			=	$user_id;
				$data['paid_amount']		=	0;
				$data['payment_timestamp']	=	strtotime(date("Y-m-d H:i:s"));
			    $data['payment_method']		=	'FREE';
				$data['payment_details']	=	'';
				$data['status']				=	1;

				$updated = 	$this->db->insert('subscription',$data);
			}
		
	}
		if($updated){
			
			echo true;
			redirect(base_url().'admin/user_list' , 'refresh');
		}else{
			
			echo false;
			redirect(base_url().'admin/user_list' , 'refresh');
		}
	}

	// WATCH SUBSCRIPTION, PAYMENT REPORT
	function report($month = '', $year = '')
	{
		if ($month == '')
			$month	=	date("F");
		if ($year == '')
			$year = date("Y");

		$page_data['month']			=	$month;
		$page_data['year']			=	$year;
		$page_data['page_name']		=	'report';
		$page_data['page_title']	=	'Customer subscription & payment report';
		$this->load->view('backend/index', $page_data);
	}

	// WATCH LIST OF FAQS, MANAGE THEM
	function faq_list()
	{
		$page_data['page_name']		=	'faq_list';
		$page_data['page_title']	=	'Manage faq';
		$this->load->view('backend/index', $page_data);
	}

	// CREATE A NEW FAQ
	function faq_create()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$data['question']		=	$this->input->post('question');
			$data['answer']			=	$this->input->post('answer');
			$this->db->insert('faq', $data);
			redirect(base_url().'admin/faq_list' , 'refresh');
		}
		$page_data['page_name']		=	'faq_create';
		$page_data['page_title']	=	'Create faq';
		$this->load->view('backend/index', $page_data);
	}

	// EDIT A FAQ
	function faq_edit($faq_id = '')
	{
		if (isset($_POST) && !empty($_POST))
		{
			$data['question']		=	$this->input->post('question');
			$data['answer']			=	$this->input->post('answer');
			$this->db->update('faq', $data,  array('faq_id' => $faq_id));
			redirect(base_url().'admin/faq_list' , 'refresh');
		}
		$page_data['faq_id']		=	$faq_id;
		$page_data['page_name']		=	'faq_edit';
		$page_data['page_title']	=	'Edit faq';
		$this->load->view('backend/index', $page_data);
	}

	// DELETE A FAQ
	function faq_delete($faq_id = '')
	{
		$this->db->delete('faq',  array('faq_id' => $faq_id));
		redirect(base_url().'admin/faq_list' , 'refresh');
	}

	// EDIT SETTINGS
	function settings()
	{
		if (isset($_POST) && !empty($_POST))
		{
			// Updating website name
			$data['description']		=	$this->input->post('site_name');
			$this->db->update('settings', $data,  array('type' => 'site_name'));

			// Updating website email
			$data['description']		=	$this->input->post('site_email');
			$this->db->update('settings', $data,  array('type' => 'site_email'));

			// Updating trial period enable/disable
			$data['description']		=	$this->input->post('trial_period');
			$this->db->update('settings', $data,  array('type' => 'trial_period'));

			// Updating trial period number of days
			$data['description']		=	$this->input->post('trial_period_days');
			$this->db->update('settings', $data,  array('type' => 'trial_period_days'));

			// Updating website language settings
			$data['description']		=	$this->input->post('language');
			$this->db->update('settings', $data,  array('type' => 'language'));

			// Updating website theme settings
			$data['description']		=	$this->input->post('theme');
			$this->db->update('settings', $data,  array('type' => 'theme'));

			// Updating website paypal merchant email
			$data['description']		=	$this->input->post('paypal_merchant_email');
			$this->db->update('settings', $data,  array('type' => 'paypal_merchant_email'));

			// Updating invoice address
			$data['description']		=	$this->input->post('invoice_address');
			$this->db->update('settings', $data,  array('type' => 'invoice_address'));

			// Updating envato purchase code
			//$data['description']		=	$this->input->post('purchase_code');
			//$this->db->update('settings', $data,  array('type' => 'purchase_code'));

			// Updating Phone Number
			$data['description']		=	$this->input->post('site_phone');
			$this->db->update('settings', $data,  array('type' => 'site_phone'));

			// Updating Facebook URL
			$data['description']		=	$this->input->post('site_fb_url');
			$this->db->update('settings', $data,  array('type' => 'fb_url'));

			// Updating Twitter URL
			$data['description']		=	$this->input->post('site_twitter_url');
			$this->db->update('settings', $data,  array('type' => 'twitter_url'));

			// Updating Google+ URL
			$data['description']		=	$this->input->post('site_gp_url');
			$this->db->update('settings', $data,  array('type' => 'google_plus_url'));

			// Updating Instagram URL
			$data['description']		=	$this->input->post('site_insta_url');
			$this->db->update('settings', $data,  array('type' => 'insta_url'));

			// Updating Website URL
			$data['description']		=	$this->input->post('website_url');
			$this->db->update('settings', $data,  array('type' => 'website_url'));

			// Updating Android URL
			$data['description']		=	$this->input->post('android_url');
			$this->db->update('settings', $data,  array('type' => 'android_url'));

			// Updating IOS URL
			$data['description']		=	$this->input->post('ios_url');
			$this->db->update('settings', $data,  array('type' => 'ios_url'));
			
			//Updating About Us section
			$data['description']		=	$this->input->post('about_us');
			$this->db->update('settings', $data,  array('type' => 'about_us'));

			// Updating privacy policy
			$data['description']		=	$this->input->post('privacy_policy');
			$this->db->update('settings', $data,  array('type' => 'privacy_policy'));

			// Updating refund policy
			$data['description']		=	$this->input->post('refund_policy');
			$this->db->update('settings', $data,  array('type' => 'refund_policy'));

			// Updating stripe publishable key
			$data['description']		=	$this->input->post('stripe_publishable_key');
			$this->db->update('settings', $data,  array('type' => 'stripe_publishable_key'));

			// Updating stripe secret key
			$data['description']		=	$this->input->post('stripe_secret_key');
			$this->db->update('settings', $data,  array('type' => 'stripe_secret_key'));

			move_uploaded_file($_FILES['logo']['tmp_name'], 'assets/global/logo.png');

			redirect(base_url().'admin/settings' , 'refresh');
		}

		$page_data['site_name']				=	$this->db->get_where('settings',array('type'=>'site_name'))->row()->description;
		$page_data['site_email']			=	$this->db->get_where('settings',array('type'=>'site_email'))->row()->description;
		$page_data['trial_period']			=	$this->db->get_where('settings',array('type'=>'trial_period'))->row()->description;
		$page_data['trial_period_days']		=	$this->db->get_where('settings',array('type'=>'trial_period_days'))->row()->description;
		$page_data['theme']					=	$this->db->get_where('settings',array('type'=>'theme'))->row()->description;
		$page_data['paypal_merchant_email']	=	$this->db->get_where('settings',array('type'=>'paypal_merchant_email'))->row()->description;
		$page_data['invoice_address']		=	$this->db->get_where('settings',array('type'=>'invoice_address'))->row()->description;
		$page_data['site_phone']			=	$this->db->get_where('settings',array('type'=>'site_phone'))->row()->description;
		$page_data['site_fb_url']			=	$this->db->get_where('settings',array('type'=>'fb_url'))->row()->description;
		$page_data['site_twitter_url']		=	$this->db->get_where('settings',array('type'=>'twitter_url'))->row()->description;
		$page_data['site_gp_url']			=	$this->db->get_where('settings',array('type'=>'google_plus_url'))->row()->description;
		$page_data['site_insta_url']		=	$this->db->get_where('settings',array('type'=>'insta_url'))->row()->description;
		$page_data['website_url']			=	$this->db->get_where('settings',array('type'=>'website_url'))->row()->description;
		$page_data['android_url']			=	$this->db->get_where('settings',array('type'=>'android_url'))->row()->description;
		$page_data['ios_url']				=	$this->db->get_where('settings',array('type'=>'ios_url'))->row()->description;
		//	$page_data['purchase_code']			=	$this->db->get_where('settings',array('type'=>'purchase_code'))->row()->description;
		$page_data['privacy_policy']		=	$this->db->get_where('settings',array('type'=>'privacy_policy'))->row()->description;
		$page_data['refund_policy']			=	$this->db->get_where('settings',array('type'=>'refund_policy'))->row()->description;
		$page_data['stripe_publishable_key']=	$this->db->get_where('settings',array('type'=>'stripe_publishable_key'))->row()->description;
		$page_data['stripe_secret_key']		=	$this->db->get_where('settings',array('type'=>'stripe_secret_key'))->row()->description;
		$page_data['about_us']		=	$this->db->get_where('settings',array('type'=>'about_us'))->row()->description;

		$page_data['page_name']				=	'settings';
		$page_data['page_title']			=	'Website settings';
		$this->load->view('backend/index', $page_data);
	}

	function jplayer_edit() {
		$page_data['page_name']				=	'jplayer';
		$page_data['page_title']			=	'jPlayer settings';
		$this->load->view('backend/index', $page_data);
	}

	function jp_upload() {

		$old_hi_audio = $_POST['old_hi_audio'];
		$old_en_audio = $_POST['old_en_audio'];

		if($_FILES['jp_audio']['name'] == '') {
			$jp_audio = $old_hi_audio;	
		} else {

			$jp_audio = $_FILES['jp_audio']['name'];
		}

		if($_FILES['en_audio']['name'] == '') {
			$en_audio = $old_en_audio;
		} else {

			$en_audio = $_FILES['en_audio']['name'];
		}

		if(isset($jp_audio)) {
			$data = array(
		        'jp_audio'=> $jp_audio,
		        'en_audio'=> $en_audio
		    );

		    $this->db->update('jplayer',$data);
			move_uploaded_file($_FILES['jp_audio']['tmp_name'], 'assets/global/jplayer/' . $jp_audio);
			move_uploaded_file($_FILES['en_audio']['tmp_name'], 'assets/global/jplayer/' . $en_audio);
			redirect(base_url() . 'admin/jplayer_edit');
		}

	}

	function manage_language($param1 = '', $param2 = '', $param3 = '')
	{

		if ($param1 == 'edit_phrase') {
			$page_data['edit_profile'] = $param2;
		}
		if ($param1 == 'update_phrase') {
			$language = $param2;
			$total_phrase = $this->input->post('total_phrase');
			for ($i = 1; $i < $total_phrase; $i++) {
				//$data[$language]  =   $this->input->post('phrase').$i;
				$this->db->where('phrase_id', $i);
				$this->db->update('language', array($language => $this->input->post('phrase' . $i)));
			}
			redirect(base_url() . 'admin/manage_language/edit_phrase/' . $language, 'refresh');
		}
		if ($param1 == 'do_update') {
			$language = $this->input->post('language');
			$data[$language] = $this->input->post('phrase');
			$this->db->where('phrase_id', $param2);
			$this->db->update('language', $data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(base_url() . 'admin/manage_language/', 'refresh');
		}
		if ($param1 == 'add_phrase') {
			$data['phrase'] = $this->input->post('phrase');
			$this->db->insert('language', $data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(base_url() . 'admin/manage_language/', 'refresh');
		}
		if ($param1 == 'add_language') {
			$language = $this->input->post('language');
			$this->load->dbforge();
			$fields = array(
				$language => array(
					'type' => 'LONGTEXT',
					'null' => FALSE
				)
			);
			$this->dbforge->add_column('language', $fields);

			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(base_url() . 'admin/manage_language/', 'refresh');
		}
		if ($param1 == 'delete_language') {
			$language = $param2;
			$this->load->dbforge();
			$this->dbforge->drop_column('language', $language);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));

			redirect(base_url() . 'admin/manage_language/', 'refresh');
		}

		$page_data['page_name']				=	'manage_language';
		$page_data['page_title']			=	'Multi - language settings';
		$this->load->view('backend/index', $page_data);
	}

	function account()
	{

		$user_id	=	$this->session->userdata('user_id');
		
		if (isset($_POST) && !empty($_POST))
		{
			$task	=	$this->input->post('task');
			 if ($task == 'update_password')
			{
				$old_password_encrypted				=	$this->crud_model->get_current_user_detail()->password;
				$old_password_submitted_encrypted	=	md5($this->input->post('old_password'));
				$new_password						=	$this->input->post('new_password');
				$new_password_encrypted				=	md5($this->input->post('new_password'));

				// CORRECT OLD PASSWORD NEEDED TO CHANGE PASSWORD
				if ($old_password_encrypted 		==	$old_password_submitted_encrypted)
				{
					$this->db->update('admin', array('password'=>$new_password_encrypted), array('id'=>$user_id));
					$this->session->set_flashdata('status', 'password_changed');
				}
				redirect(base_url().'admin/account' , 'refresh');
			}
		}
		$page_data['page_name']				=	'account';
		$page_data['page_title']			=	'Manage account';
		$this->load->view('backend/index', $page_data);
	}




	function actor_wise_movie_and_series($actor_id) {
		$actor_details = $this->db->get_where('actor', array('actor_id' => $actor_id))->row_array();
		$page_data['page_name']				=	'actor_wise_movie_and_series';
		$page_data['page_title']			=	get_phrase('movies_and_TV_series_of').' "'.$actor_details['name'].'"';
		$page_data['actor_id']				=	$actor_id;
		
		$this->load->view('backend/index', $page_data);
	}
	
	function tool_tip_create()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$data['text']		=	$this->input->post('text');
				$data['order_by']		=	$this->input->post('order_by');
		
			$this->db->insert('tool_tip', $data);
			redirect(base_url().'admin/tool_tip' , 'refresh');
		}
		$page_data['page_name']		=	'tool_tip_create';
		$page_data['page_title']	=	'Create Tool tip';
		$this->load->view('backend/index', $page_data);
	}

	function about()
	{
		echo  $_FILES['about_image']['name'];
		if (isset($_POST) && !empty($_POST))
		{
			

			$data['about_title']		=	$this->input->post('about_title');
			$about_image            =   $_FILES['about_image']['name'];
			
		    $data['about_desc']		    =	$this->input->post('about_desc');
			if(!empty($about_image)){
				$data['about_image']			=	$about_image;
				move_uploaded_file($_FILES['about_image']['tmp_name'], 'assets/global/' . $about_image);
			}

			$data['vision_title']		=	$this->input->post('vision_title');
			$vision_image            =   $_FILES['vision_image']['name'];
			$data['vision_desc']		=	$this->input->post('vision_desc');
			if(!empty($vision_image)){
				$data['vision_image']			=	$vision_image;
				move_uploaded_file($_FILES['vision_image']['tmp_name'], 'assets/global/' . $vision_image);
			}
			

			$data['mission_title']		=	$this->input->post('mission_title');
			$mission_image            =   $_FILES['mission_image']['name'];
			print_r($mission_image);
			echo $mission_image;
			$data['mission_desc']		=	$this->input->post('mission_desc');
			if(!empty($mission_image)){
				$data['mission_image']			=	$mission_image;
			     move_uploaded_file($_FILES['mission_image']['tmp_name'], 'assets/global/' . $mission_image);
			}
			
			$this->db->update('about',$data , array('id'=>1));
//print_r($data);
		$page_data['page_name']		=	'about';
		$page_data['page_title']	=	'About us';


	//	$this->load->view('backend/index', $page_data);
		}
		
		$page_data['page_name']		=	'about';
		$page_data['page_title']	=	'About us';
		$this->load->view('backend/index', $page_data);
    }

	function tool_tip_edit($id = '')
	{
		if (isset($_POST) && !empty($_POST))
		{
			$data['text']		=	$this->input->post('text');
		    $data['order_by']		=	$this->input->post('order_by');
		
			$this->db->update('tool_tip', $data,  array('id' => $id));
			redirect(base_url().'admin/tool_tip' , 'refresh');
		}
		$page_data['id']		=	$id;
		$page_data['page_name']		=	'tool_tip_edit';
		$page_data['page_title']	=	'Edit Tool Tips';
		$this->load->view('backend/index', $page_data);
	}

	// DELETE A FAQ
	function tool_tips_delete($id = '')
	{
		$this->db->delete('tool_tip',  array('id' => $id));
		redirect(base_url().'admin/tool_tip' , 'refresh');
	}
	function tool_tip_image()
	{
		

	    $page_data['page_name']				=	'tool_tip_image';
		$page_data['page_title']			=	'Tool Tip Image';
		$this->load->view('backend/index', $page_data);
	}
	function update_tool_tip_image()	
	{
    
    	move_uploaded_file($_FILES['logo']['tmp_name'], 'assets/global/player-bg.jpg');

			redirect(base_url().'admin/tool_tip_image' , 'refresh');
	
	}
	function support_text()
	{
		$page_data['page_name']		=	'support_text';
		$page_data['page_title']	=	'Manage Support Text';
		$this->load->view('backend/index', $page_data);
	}
	function newsletter()
	{
		$page_data['page_name']		=	'newsletter';
		$page_data['page_title']	=	'Newsletters';
		$this->load->view('backend/index', $page_data);
	}
	function support_text_create()
	{
		if (isset($_POST) && !empty($_POST))
		{
			$data['title_text']		=	$this->input->post('title_text');
			$data['big_text']		=	$this->input->post('big_text');
			$this->db->insert('support_text', $data);
			redirect(base_url().'admin/support_text' , 'refresh');
		}
		$page_data['page_name']		=	'support_text_create';
		$page_data['page_title']	=	'Create Support Text';
		$this->load->view('backend/index', $page_data);
	}
	
	function support_text_edit($id = '')
	{
		if (isset($_POST) && !empty($_POST))
		{
			$data['text']		=	$this->input->post('text');
		    $data['big_text']		=	$this->input->post('big_text');
			$this->db->update('support_text', $data,  array('id' => $id));
			redirect(base_url().'admin/support_text' , 'refresh');
		}
		$page_data['id']		=	$id;
		$page_data['page_name']		=	'support_text_edit';
		$page_data['page_title']	=	'Edit Support Text';
		$this->load->view('backend/index', $page_data);
	}
	function support_text_delete($id = '')
	{
		$this->db->delete('support_text',  array('id' => $id));
		redirect(base_url().'admin/support_text' , 'refresh');
	}
}
