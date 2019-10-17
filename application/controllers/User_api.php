<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class User_api extends REST_Controller {
    public function __construct() {
        parent::__construct();
        //$this->load->helper('envoy_helper');
        $this->load->model('crud_model');
        // $this->load->model('email_model');
    }
  
   
    public function states_get(){
       
     
        $states = $this->db->get_where('states', array('country_id'=>101));
 
        $states_data=array();
        if($states->num_rows()>0){
        $sdata = $states->result();
        foreach($sdata as $b){

        $states_data[]=array(
        'id'=>$b->id,
        'name'=>$b->name,
        );
        }}
      

       
        $result['states'] = $states_data;
      
        $response = array("status"=>"200","message"=>"Successfully Fetched","result"=>$result);
        echo json_encode($response);
        } 
  
  public function cities_post(){
       
        $state_id = $this->input->post('state_id');
        $cities = $this->db->get_where('cities', array('state_id'=>$state_id));
 
        $cities_data=array();
        if($cities->num_rows()>0){
        $cdata = $cities->result();
        foreach($cdata as $c){

        $cities_data[]=array(
        'id'=>$c->id,
        'name'=>$c->name,
        );
        }}

       
        $result['cities'] = $cities_data;
      
        $response = array("status"=>"200","message"=>"Successfully Fetched","result"=>$result);
        echo json_encode($response);
        } 


  public function chashi_category_post(){
       
     
        $chashi_cat = $this->db->get_where('chashi_category', array('active'=>1));
 
        $cat_data=array();
        if($chashi_cat->num_rows()>0){
        $cdata = $chashi_cat->result();
        foreach($cdata as $b){
         
        $cat_data[]=array(
        'cat_id'=>$b->cc_id,
        'cat_name'=>$b->cc_name,
        'cat_img'=>base_url().'uploads/'.$b->cc_img,
        );
        }}
      

       
        $result['category'] = $cat_data;
      
        $response = array("status"=>"200","message"=>"Successfully Fetched","result"=>$result);
        echo json_encode($response);
        } 

public function chashi_vendor_post(){
       
        $cat_id= $this->input->post('category_id');
        $vendor = $this->db->get_where('chashi_product', array('category_id'=>$cat_id,'active'=>1));
 
        $vendor_data=array();
        if($vendor->num_rows()>0){
        $vdata = $vendor->result();
        foreach($vdata as $v){

        $user = $this->db->get_where('user', array('user_id'=>$v->user_id,'active'=>1));
        $udata = $user->row();
         if($v->qty_avl==0){
            $sold=1;
        }else{
         $sold=0;

        }
        $vendor_data[]=array(
        'product_id'=>$v->p_id,
        'vendor_id'=>$v->user_id,
        'vendor_name'=>$udata->shop_name,
        'product_name'=>$v->p_name,
        'vendor_img'=>$udata->img,
        'qty_avl'=>$v->qty_avl,
        'unit'=>$v->unit,
        'rate'=>$v->rate,
         'is_sold'=>$sold
        );
        }}
      

       
        $result['vendor'] = $vendor_data;
      
        $response = array("status"=>"200","message"=>"Successfully Fetched","result"=>$result);
        echo json_encode($response);
        } 

public function vendor_details_post(){
       
        $p_id= $this->input->post('product_id');
        $vendor = $this->db->get_where('chashi_product', array('p_id'=>$p_id));
 
        $vendor_data=array();
        if($vendor->num_rows()>0){
        $vdata = $vendor->row();
         $user = $this->db->get_where('user', array('user_id'=>$vdata->user_id));
        $udata = $user->row();
        if($vdata->qty_avl==0){
            $sold=1;
        }else{
         $sold=0;

        }
         
        $vendor_data[]=array(
        'product_id'=>$vdata->p_id,
        'vendor_id'=>$vdata->user_id,
        'vendor_name'=>$udata->fname,
        'product_name'=>$vdata->p_name,
        'product_img1'=>$vdata->p_img1,
        'product_img2'=>$vdata->p_img2,
        'product_img3'=>$vdata->p_img3,
        'product_img4'=>$vdata->p_img4,
        'qty_avl'=>$vdata->qty_avl,
        'unit'=>$vdata->unit,
        'rate'=>$vdata->rate,
         'is_sold'=>$sold,
          'is_deliver'=>$vdata->deliver,
          'date'=>strtotime($vdata->date),
        );
        }
      

       
        $result['vendor_details'] = $vendor_data;
      
        $response = array("status"=>"200","message"=>"Successfully Fetched","result"=>$result);
        echo json_encode($response);
        } 



    public function user_signup_post(){
        $data['user_type'] = $this->input->post('user_type');
        $data['fname'] = $this->input->post('name');
        $data['email']      = $this->input->post('email');
        $data['mobile']   = $this->input->post('mobile');
        $data['shop_name']   = $this->input->post('shop_name');
        $data['img'] = $this->input->post('img');

        $data['address']   = $this->input->post('address');
        $data['state']   = $this->input->post('state');
        $data['city']   = $this->input->post('city');
        $data['pincode']   = $this->input->post('pincode');
        $data['password']   = md5($this->input->post('password'));
        $data['active']=1;
     
       
        $this->db->where('email' , $data['email']);
        $this->db->where('active' ,1);
        $this->db->from('user');
        $total_number_of_matching_user = $this->db->count_all_results();
        // validate if duplicate email exists
        if ($total_number_of_matching_user == 0) {
        $this->db->insert('user' , $data);
        $user_id    =   $this->db->insert_id();
        $device_key =  $this->input->post('device_key');
        $device_type =  $this->input->post('device_type');
        $token_data = array(
        'u_id'=>$user_id,
        'device_key'=>$device_key,
        'device_type'=>$device_type
        );
        $data['user_id']=$user_id;
        
        $this->db->insert('user_device_tokens', $token_data);

        // create a free subscription for premium package for 30 days
        $response = array('status' => "200", 'message' => 'Successfully registered','result'=>$data);
        }
        else {
        $response = array('status' => "404", 'message' => 'Email already Exists');
        }
        echo json_encode($response);
        }


public function user_signin_post(){
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $device_key =  $this->input->post('device_key');
        $device_type =  $this->input->post('device_type');
        $query = $this->db->query("SELECT * FROM `user` WHERE `email`='$email' AND password='$password'");// AND 
        $total_number_of_matching_user = $this->db->count_all_results();
        // validate if duplicate email exists
        if ($query->num_rows() > 0) {
        $login_data = $query->row();
        $login_id = $login_data->user_id;
        $query2 =   $this->db->query("SELECT `device_key`, `device_type` FROM `user_device_tokens` WHERE `u_id`='$login_id' AND `device_key`='$device_key'");
        $token_data = $query2->row_array();
        if (empty($token_data['device_key'])) {
        $user_data = array(
        'u_id'=>$login_id,
        'device_key'=> $device_key,
        'device_type'=>$device_type
        );
        $this->db->insert('user_device_tokens', $user_data);
        }

        $response = array('status' => "200", 'message' => 'Successfully Login','result'=>$login_data);

        }

        else {
        $response = array('status' => "404", 'message' => 'Invalid email and password');
        }
        echo json_encode($response);
        }

    public function logout_post()
    {
        $device_key =  $this->input->post('device_key');
       
        $this->db->where('device_key', $device_key);
        $query= $this->db->delete('user_device_tokens');
     
        //$query = $this->db->query("Delete FROM `user_device_tokens` WHERE `device_key`='$data'");
        if ($query) {
            $response = array('status' => "200", 'message' => 'Successfully Logout');
        //$query2 =   $this->db->query("SELECT `device_key`, `device_type` FROM `user_device_tokens` WHERE `u_id`='$login_id'");
         //$token_data = $query2->row_array()
          // $this->db->insert('user_device_tokens',$user_data);
        } else {
            $response = array('status' => "404", 'message' => 'Something Went Wrong');
        }
    }

     public function fetch_shops_post(){
       
        $type = $this->input->post('type');
   
        $shops = $this->db->get_where('user', array('user_type'=>$type));
 
        $shops_data=array();
        if($shops->num_rows()>0){
        $sdata = $shops->result();
        foreach($sdata as $s){
         $city=$this->crud_model->get_city($s->city);
          $state=$this->crud_model->get_state($s->state);
        $shops_data[]=array(
        'shop_id'=>$s->user_id,
        'shop_name'=>$s->shop_name,
        'shop_img'=>$s->img,
        'city'=>$city,
        'state'=>$state,
        'address'=>$s->address

        );
        }}

       
        $result['shops'] = $shops_data;
      
        $response = array("status"=>"200","message"=>"Successfully Fetched","result"=>$result);
        echo json_encode($response);
        } 

  public function fetch_category_post(){
       
        $shop_id = $this->input->post('shop_id');
   
        $category = $this->db->get_where('category', array('user_id'=>$shop_id,'status'=>1));
 
        $category_data=array();
        if($category->num_rows()>0){
        $sdata = $category->result();
        foreach($sdata as $s){
      
        $category_data[]=array(
        'cat_id'=>$s->cat_id,
        'cat_name'=>$s->cat_name,
        'cat_img'=>$s->cat_img,
       
        );
        }}

       
        $result['category'] = $category_data;
      
        $response = array("status"=>"200","message"=>"Successfully Fetched","result"=>$result);
        echo json_encode($response);
        } 


public function fetch_products_post(){
       
        $cat_id = $this->input->post('cat_id');
   
        $products = $this->db->get_where('products', array('cat_id'=>$cat_id,'status'=>1));
 
        $products_data=array();
        if($products->num_rows()>0){
        $sdata = $products->result();
        foreach($sdata as $s){
      
        $products_data[]=array(
        'p_id'=>$s->p_id,
        'p_name'=>$s->p_name,
        'p_desc'=>$s->p_desc,
        'p_img'=>$s->p_img,
        'mrp'=>$s->mrp,
        'sale_price'=>$s->sale_price,
        'p_qty'=>$s->p_qty,
        'unit'=>$s->unit,
        'available'=>$s->is_available,

        );
        }}

       
        $result['products'] = $products_data;
      
        $response = array("status"=>"200","message"=>"Successfully Fetched","result"=>$result);
        echo json_encode($response);
        } 


public function place_order_post(){
       

        $data['user_id'] = $this->input->post('user_id');
        $data['vendor_id'] = $this->input->post('vendor_id');
        $data['total_price']      = $this->input->post('total_price');
        $data['shipping_address']   = $this->input->post('shipping_address');
        $data['shipping_charge']   = $this->input->post('shipping_charge');
        $data['tax']   = $this->input->post('tax');
        $data['unique_id'] = time() . mt_rand() . $data['user_id'];
        $insert_order=$this->db->insert('orders' , $data);
       if($insert_order){
            $order_id    =   $this->db->insert_id();
            $data1['product_id'] = $this->input->post('product_id');
            $data1['product_qty'] = $this->input->post('product_qty');
            $data1['product_price'] = $this->input->post('product_price');
         
            $qty = str_replace(array('[',']'),'',$data1['product_qty']);
            $qty1=explode(',',$qty);
            $p_id = str_replace(array('[',']'),'',$data1['product_id']);
            $p_id1=explode(',',$p_id);
            $price= str_replace(array('[',']'),'',$data1['product_price']);
            $price1=explode(',',$price);
         foreach($p_id1 as $key => $value) 
          {
            $product_item=array(
            'unique_id'=>$data['unique_id'],
            'product_id'=>$p_id1[$key],
            'order_id'=>$order_id,
            'product_qty'=>$qty1[$key],
            'product_price'=>$price1[$key],
            'total_product_price'=>$price1[$key] * $qty1[$key]
            );
                 $insert=$this->db->insert('order_items' , $product_item);
         }
           $response = array("status"=>"200","message"=>"Successfully placed ordered");
        
       }
       else{
          $response = array("status"=>"404","message"=>"Order not Placed! try again");

       }
      
       
        echo json_encode($response);
        } 

public function add_product_post(){
       

        $data['user_id'] = $this->input->post('user_id');
        $data['category_id'] = $this->input->post('category_id');
        $data['p_name'] = $this->input->post('p_name');
     
         $data['p_img1'] = $this->input->post('p_img1');
            $data['p_img2'] = $this->input->post('p_img2');
        $data['p_img3'] = $this->input->post('p_img3');
        $data['p_img4'] = $this->input->post('p_img4');
        $data['qty_hosted'] = $this->input->post('qty_hosted');
      
        $data['unit'] = $this->input->post('unit');
        $data['rate'] = $this->input->post('rate');
        $data['deliver']      = $this->input->post('deliver');
       
        $data['product_uid'] = $data['user_id'].'-'.time().'-'.mt_rand();
        $insert=$this->db->insert('chashi_product' , $data);
       if($insert){
           
       
       $response = array("status"=>"200","message"=>"Product Successfully inserted");
        
       }
       else{
          $response = array("status"=>"404","message"=>"Order not Placed! try again");

       }
      
       
        echo json_encode($response);
        } 

    public function chashi_vendor_product_post(){
       
        $user_id= $this->input->post('vendor_id');
        $vendor = $this->db->get_where('chashi_product', array('user_id'=>$user_id,'active'=>1));
 
        $vendor_data=array();
        if($vendor->num_rows()>0){
        $vdata = $vendor->result();
        foreach($vdata as $v){

        // $user = $this->db->get_where('user', array('user_id'=>$v->user_id,'active'=>1));
        // $udata = $user->row();
         if($v->qty_avl==0){
            $sold=1;
        }else{
         $sold=0;

        }
        $vendor_data[]=array(
        'product_id'=>$v->p_id,
        'category_id'=>$v->category_id,
        'product_name'=>$v->p_name,
        'p_img1'=>$v->p_img1,
        'p_img2'=>$v->p_img2,
        'p_img3'=>$v->p_img3,
        'p_img4'=>$v->p_img4,
        'qty_hosted'=>$v->qty_hosted,
        'qty_booked'=>$v->qty_booked,
        'qty_avl'=>$v->qty_avl,
        'unit'=>$v->unit,
        'rate'=>$v->rate,
        'is_sold'=>$sold,
        'is_deliver'=>$v->deliver,
        'date'=>strtotime($v->date)
        );
      
}}
       
        $result['vendor_products'] = $vendor_data;
      
        $response = array("status"=>"200","message"=>"Successfully Fetched","result"=>$result);
        echo json_encode($response);
        } 

public function delete_chashi_product_post(){
       
        $p_id = $this->input->post('p_id');
   
        $this -> db -> where('p_id', $p_id);
        $delete=$this -> db -> delete('chashi_product');
 
       if($delete){
      
        $response = array("status"=>"200","message"=>"Successfully Deleted");
       }else{
  
           $response = array("status"=>"404","message"=>"Something Went wrong");
        }
        echo json_encode($response);
        } 


// public function user_login_post(){
//         $data['mobile'] = $this->input->post('phone');
       
//         $otp =  rand(1000, 9999);
//         $this->db->select("*");
//         $this->db->from('user');
//         $this->db->where('mobile' , $data['mobile']);
//         $this->db->where('status' ,1);
//         $query  =  $this->db->get();

//         $log_data= $query->row();
//         $total_number_of_matching_user = $this->db->count_all_results();
    
//         if ($total_number_of_matching_user == 0) {
//          $response = array('status' => "404", 'message' => 'Mobile number not registered');

//         }
//         else {
     
//         $send_data = array(
//         'id'=> $log_data->id,
//         'otp'=>$otp
//         );
//         $response = array('status' => "200", 'message' => 'Otp sent Successfully','result'=>$send_data);
//         }
//         echo json_encode($response);
//         }

}
