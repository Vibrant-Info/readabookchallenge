<?php
//including home controller
require_once("home.php");
//include_once("Excel.php");
error_reporting(0);
require_once 'excel_reader2.php';

/**
* @category controller
* class Admin
*/
class SMS_API extends Home
{
    /**
    * load constructor
    * @access public
    * @return void
    */

    public function __construct()
    {
        parent::__construct();

         if ($this->session->userdata('logged_in') != 1) {
            redirect('home/login', 'location');
        }

        if ($this->session->userdata('user_type') != 'Admin' && $this->session->userdata('user_type') != 'Member') {
            redirect('home/login', 'location');
        }

        $this->important_feature();
        $this->periodic_check();

        $this->load->helper('form');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->upload_path = realpath(APPPATH . '../upload');
		
		$this->username = "readabookchallenge@gmail.com";
		$this->hashValue = "3a3bdd183ec7601ae380c99c4ad01445ebb1c3ea";
		$this->test = "0";
		$this->sender = "RDBOOK";
    }
	
	public function withdrawal($req_id){
		
		$where['where'] = array('wallet_request.id'=>$req_id);
        $info = $this->basic->get_data('wallet_request', $where, $select='', $join='', $limit='', $start= '', $order_by='');

        $user_id = $info[0]['user_id'];
        $paytm_phone_number = $info[0]['paytm_phone_number'];
       
		$where['where'] = array('users.id'=>$user_id);
        $users = $this->basic->get_data('users', $where, $select='', $join='', $limit='', $start= '', $order_by='');
		
		
		$message = rawurlencode("Hi ".$users[0]['first_name'].", The withdrawal request for your security deposit has been processed on paytm number ".$paytm_phone_number.". Thank you for taking the challenge!");
	
		$message = urlencode($message);
		$data = "username=".$this->username."&hash=".$this->hashValue."&message=".$message."&sender=".$this->sender."&numbers=".$users[0]['phone_number']."&test=".$test;
		$ch = curl_init('http://api.textlocal.in/send/?');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); // This is the result from the API
		curl_close($ch);
		
		echo $req_id;
	}
	
	public function afterPickedup($user_id){
		       
		$where['where'] = array('users.id'=>$user_id);
        $users = $this->basic->get_data('users', $where, $select='', $join='', $limit='', $start= '', $order_by='');
		
		
		$message = rawurlencode("Hi ".$users[0]['first_name'].", Your package of books has been successfully picked up. Thank you.");
	
		$message = urlencode($message);
		$data = "username=".$this->username."&hash=".$this->hashValue."&message=".$message."&sender=".$this->sender."&numbers=".$users[0]['phone_number']."&test=".$test;
		$ch = curl_init('http://api.textlocal.in/send/?');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); // This is the result from the API
		curl_close($ch);
		
		echo $ch;
	}
	
	public function afterDelivery($order_id){
		       
		$where['where'] = array('orders.id'=>$order_id);
        $users_id = $this->basic->get_data('orders', $where, $select='', $join='', $limit='', $start= '', $order_by='');		
		       
		$where['where'] = array('users.id'=>$users_id[0]['user_id']);
        $users = $this->basic->get_data('users', $where, $select='', $join='', $limit='', $start= '', $order_by='');
		
		
		$message = rawurlencode("Hi ".$users[0]['first_name'].", Your package of books has been successfully delivered and countdown timer has started ticking for a month. Happy Reading.");
	
		$message = urlencode($message);
		$data = "username=".$this->username."&hash=".$this->hashValue."&message=".$message."&sender=".$this->sender."&numbers=".$users[0]['phone_number']."&test=".$test;
		$ch = curl_init('http://api.textlocal.in/send/?');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); // This is the result from the API
		curl_close($ch);
		
		echo $ch;
	}
	
	public function outForDelivery($order_id){
		       
		$where['where'] = array('orders.id'=>$order_id);
        $users_id = $this->basic->get_data('orders', $where, $select='', $join='', $limit='', $start= '', $order_by='');		
		       
		$where['where'] = array('users.id'=>$users_id[0]['user_id']);
        $users = $this->basic->get_data('users', $where, $select='', $join='', $limit='', $start= '', $order_by='');
		
		$Date = $users_id[0]['created_date'];
		$newDate = date('Y-m-d', strtotime($Date. ' + 6 days'));
		$expectedDate = date('l jS \of F Y', strtotime($newDate));
		
		$message = rawurlencode("Hi ".$users[0]['first_name'].", Your order has been successfully shipped out for delivery. Expect to receive your package on or before ".$expectedDate.". Please make sure someone is available at the address.");
	
		$message = urlencode($message);
		$data = "username=".$this->username."&hash=".$this->hashValue."&message=".$message."&sender=".$this->sender."&numbers=".$users[0]['phone_number']."&test=".$test;
		$ch = curl_init('http://api.textlocal.in/send/?');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); // This is the result from the API
		curl_close($ch);
		
		echo $ch;
	}
	
	public function packageDone($order_id){
		       
		$where['where'] = array('orders.id'=>$order_id);
        $users_id = $this->basic->get_data('orders', $where, $select='', $join='', $limit='', $start= '', $order_by='');		
		       
		$where['where'] = array('users.id'=>$users_id[0]['user_id']);
        $users = $this->basic->get_data('users', $where, $select='', $join='', $limit='', $start= '', $order_by='');		
		
		$message = rawurlencode("Hi ".$users[0]['first_name'].", Your surprise package of books is packed and ready for delivery. Expect to receive your package in the next couple of days.");
	
		$message = urlencode($message);
		$data = "username=".$this->username."&hash=".$this->hashValue."&message=".$message."&sender=".$this->sender."&numbers=".$users[0]['phone_number']."&test=".$test;
		$ch = curl_init('http://api.textlocal.in/send/?');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); // This is the result from the API
		curl_close($ch);
		
		echo $ch;
	}
	
	public function onTheWay($order_id){
		       
		$where['where'] = array('orders.id'=>$order_id);
        $users_id = $this->basic->get_data('orders', $where, $select='', $join='', $limit='', $start= '', $order_by='');		
		       
		$where['where'] = array('users.id'=>$users_id[0]['user_id']);
        $users = $this->basic->get_data('users', $where, $select='', $join='', $limit='', $start= '', $order_by='');		
		
		$message = rawurlencode("Hi ".$users[0]['first_name'].", A pick will be attempted on your delivery address, kindly keep the books ready to be picked up. Thank you.");
	
		$message = urlencode($message);
		$data = "username=".$this->username."&hash=".$this->hashValue."&message=".$message."&sender=".$this->sender."&numbers=".$users[0]['phone_number']."&test=".$test;
		$ch = curl_init('http://api.textlocal.in/send/?');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); // This is the result from the API
		curl_close($ch);
		
		echo $ch;
	}
}