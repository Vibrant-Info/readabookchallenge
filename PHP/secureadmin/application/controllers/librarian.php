<?php
//including home controller
require_once("home.php");
require_once("sendSMS.php");
error_reporting(0);
require_once 'excel_reader2.php';

/**
* @category controller
* class Admin
*/
class librarian extends Home
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

        

        $this->important_feature();
        $this->periodic_check();

        $this->load->helper('form');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->upload_path = realpath(APPPATH . '../upload');
    }
	//////////////////////////////////////////////  ASSIGNING SECTION ////////////////////////////////////
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function assigning(){		
		$data['body']='admin/librarian/assigning.php';
        $data['page_title'] = 'Assigning Book';
        $this->_viewcontroller($data);
	}
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function assigning_list_data(){		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        // setting variables for pagination
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'orders.id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $order_by_str = $sort." ".$order;

       
        $offset = ($page-1)*$rows;
        $result = array();
		
		$order_no = trim($this->input->post('order_no', true));
        $first_name = trim($this->input->post('first_name', true));
        $last_name = trim($this->input->post('last_name', true));
        $phone_number = trim($this->input->post("phone_number", true));
        $email_id = trim($this->input->post('email_id', true));
        $ip_address = trim($this->input->post('ip_address', true));
        $payment_method = trim($this->input->post('payment_method', true));
		
		// creating a blank where_simple array
        $where_simple = array();

        // trimming data
        if ($order_no) {
            $where_simple['orders.order_no like '] = "%".$order_no."%";
        }
        if ($first_name) {
            $where_simple['users.first_name like '] = "%".$first_name."%";
        }
        if ($last_name) {
            $where_simple['users.last_name like '] = "%".$last_name."%";
        }
        if ($phone_number) {
            $where_simple['users.phone_number as alias_user_phone like '] = "%".$phone_number."%";
        }
        if ($email_id) {
            $where_simple['users.email_id like '] = "%".$email_id."%";
        }
        if ($ip_address) {
            $where_simple['orders.ip_address like '] = "%".$ip_address."%";
        }
        if ($payment_method) {
            $where_simple['orders.payment_method like '] = "%".$payment_method."%";
        }
		
		$where_simple['orders.status'] = "selection";
        $where = array('where' => $where_simple);
		$join = array('users' => 'users.id = orders.user_id, left outer');
		$select['orders'] = 'orders.*';
		$select['users'] = 'users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id, (SELECT count(order_items.order_id) from order_items WHERE  orders.id = order_items.order_id) as order_count';
        $offset = ($page-1)*$rows;
        $result = array();
		//echo $where_simple;
        $table = "orders";
        $info = $this->basic->get_data($table, $where, $select, $join, $limit = $rows, $start = $offset, $order_by = $order_by_str);
		
		for($p=0;$p<count($info); $p++){
			$books_id_query = "SELECT order_id, GROUP_CONCAT(book_id) as books_ids FROM order_items where order_id = '".$info[$p]['id']."' GROUP BY order_id";
			$books_ids = $this->basic->execute_query($books_id_query);
			$info[$p]['books_ids'] = $books_ids[0]['books_ids'];
		}
		
        $total_rows_array = $this->basic->count_row($table, $where, $count = "id");
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($info, $total_result);
		
		/* 
		$query= "SELECT orders.*, users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id,  (SELECT count(order_items.order_id) from order_items WHERE  orders.id = order_items.order_id) as order_count FROM orders LEFT OUTER JOIN users ON users.id = orders.user_id WHERE orders.status = 'selection'";
		//$query= "SELECT id,plan,CASE WHEN status = '1' THEN 'Active' ELSE 'In active' END as 'status' FROM plans";
        
		$info = $this->basic->execute_query($query);
		$total_result = count($info);

        echo convert_to_grid_data($info, $total_result); */
	}
	
	
	/**
    * For Get Books
    * @access public
    * @return void
    */
	public function getBooks(){
		$order_id = $_POST['orderId'];  
		$dupRemove = "";
		$response = "<form id='selectForm' name='selectForm'><table class='table table-hover'><tr><th></th><th>Book Name</th><th>Vendor Name</th><th>Stock</th><th>Select</th></tr>";
		
		$query = "SELECT `user_id` FROM orders WHERE `id` = '".$order_id."'";		
		$user_id = $this->basic->execute_query($query);
		
		//$wishlist_query = "SELECT book_info.vendor,book_info.title,book_info.id, book_info.number_of_books FROM `users_wishlists` LEFT OUTER JOIN `book_info` ON users_wishlists.book_info_id = book_info.id WHERE user_id = '".$user_id[0]['user_id']."'";
		$wishlist_query = "SELECT book_info.vendor,book_info.title,book_info.id, book_info.number_of_books FROM `wishlist` LEFT OUTER JOIN `book_info` ON wishlist.title = book_info.title WHERE user_id = '".$user_id[0]['user_id']."' AND book_info.title <> ''";
		$wishlist = $this->basic->execute_query($wishlist_query);
		if(count($wishlist) > 0){
			for($i=0;$i < count($wishlist);$i++ ){
				$dupRemove .= $wishlist[$i]['id'] .",";
				if($wishlist[$i]['number_of_books'] == 0)
					$sts = "disabled";
				else
					$sts = "";
				
				$response .= "<tr>";
				$response .= "<td><img src='".base_url('assets/images/w.png')."'> </td>";
				$response .= "<td>".$wishlist[$i]['title']."</td>";
				$response .= "<td>".$wishlist[$i]['vendor']."</td>";
				$response .= "<td>".$wishlist[$i]['number_of_books']."</td>";
				$response .= "<td><input type='checkbox' value='".$wishlist[$i]['id']."' ".$sts." name='book_id_checked' ></td>";
				$response .= "</tr>";
			}
		}
		$dupRemove = rtrim($dupRemove, ',');
		$dupRemove = ltrim($dupRemove, ',');
		if($dupRemove != '')
			$where = "AND book_info.id NOT IN  (".$dupRemove.")";
		else
			$where = "AND 1=1";
		
		$category_query = "SELECT book_info.vendor,book_info.title,book_info.id, book_info.number_of_books FROM `users_genre` LEFT OUTER JOIN `book_info` ON users_genre.category_id IN (book_info.category_id) WHERE user_id = '".$user_id[0]['user_id']."' AND  book_info.title <> '' ".$where."";
		
		$category_books = $this->basic->execute_query($category_query);
		if(count($category_books) > 0){
			for($i=0;$i < count($category_books);$i++ ){
				$dupRemove .= ",".$category_books[$i]['id'];
				if($category_books[$i]['number_of_books'] == 0)
					$sts = "disabled";
				else
					$sts = "";
				
				$response .= "<tr>";
				$response .= "<td><img src='".base_url('assets/images/i.png')."'> </td>";
				$response .= "<td>".$category_books[$i]['title']."</td>";
				$response .= "<td>".$category_books[$i]['vendor']."</td>";
				$response .= "<td>".$category_books[$i]['number_of_books']."</td>";
				$response .= "<td><input type='checkbox' value='".$category_books[$i]['id']."' ".$sts." name='book_id_checked'></td>";
				$response .= "</tr>";
			}
		}
		
		 $dupRemove = rtrim($dupRemove, ',');
		 $dupRemove = ltrim($dupRemove, ',');
		if($dupRemove != '')
			$where = " AND book_info.id NOT IN  (".$dupRemove.")";
		else
			$where = "AND 1=1";
		
		$dislike_query = "SELECT book_info.vendor,book_info.title,book_info.id, book_info.number_of_books FROM `book_info` WHERE book_info.title <> '' ".$where."";		
		$dislike_books = $this->basic->execute_query($dislike_query);
		if(count($dislike_books) > 0){
			for($i=0;$i < count($dislike_books);$i++ ){
				if($dislike_books[$i]['number_of_books'] == 0)
					$sts = "disabled";
				else
					$sts = "";
				
				$response .= "<tr>";
				$response .= "<td><img src='".base_url('assets/images/d.png')."'> </td>";
				$response .= "<td>".$dislike_books[$i]['title']."</td>";
				$response .= "<td>".$dislike_books[$i]['vendor']."</td>";
				$response .= "<td>".$dislike_books[$i]['number_of_books']."</td>";
				$response .= "<td><input type='checkbox' value='".$dislike_books[$i]['id']."' ".$sts." name='book_id_checked'></td>";
				$response .= "</tr>";
			}
		} /**/
		
		$response .= "</table></form>";
		echo $response;
	}
	
	/**
    * For Edit Books
    * @access public
    * @return void
    */
	public function editBooks(){
		$order_id = $_POST['orderId'];  
		$dupRemove = "";
		$response = "<form id='selectForm' name='selectForm'><table class='table table-hover'><tr><th></th><th>Book Name</th><th>Vendor Name</th><th>Stock</th><th>Select</th></tr>";
		
		$query = "SELECT `user_id` FROM orders WHERE `id` = '".$order_id."'";		
		$user_id = $this->basic->execute_query($query);
		
		//$wishlist_query = "SELECT book_info.vendor,book_info.title,book_info.id, book_info.number_of_books FROM `users_wishlists` LEFT OUTER JOIN `book_info` ON users_wishlists.book_info_id = book_info.id WHERE user_id = '".$user_id[0]['user_id']."'";
		$wishlist_query = "SELECT book_info.vendor,book_info.title,book_info.id, book_info.number_of_books FROM `wishlist` LEFT OUTER JOIN `book_info` ON wishlist.title = book_info.title WHERE user_id = '".$user_id[0]['user_id']."' AND book_info.title <> ''";
		$wishlist = $this->basic->execute_query($wishlist_query);
		
		if(count($wishlist) > 0){			
			for($i=0;$i < count($wishlist);$i++ ){
				$order_items_query = "SELECT `book_id` FROM `order_items` WHERE `order_id` = '".$order_id."'";
				$order_items = $this->basic->execute_query($order_items_query);
				$checked="";
				
				foreach($order_items as $wish_id){
					if(in_array($wishlist[$i]['id'],$wish_id)){
						$checked = 'checked';
					}
				}
				//for($j=0;$j < count($order_items);$j++ ){
					$dupRemove .= $wishlist[$i]['id'] .",";
					if($wishlist[$i]['number_of_books'] == 0)
						$sts = "disabled";
					else
						$sts = "";
					
					$response .= "<tr>";
					$response .= "<td><img src='".base_url('assets/images/w.png')."'> </td>";
					$response .= "<td>".$wishlist[$i]['title']."</td>";
					$response .= "<td>".$wishlist[$i]['vendor']."</td>";
					$response .= "<td>".$wishlist[$i]['number_of_books']."</td>";
					$response .= "<td><input type='checkbox' value='".$wishlist[$i]['id']."' ".$sts." name='book_id_checked' ".$checked." ></td>";
					$response .= "</tr>";
				//}
			}
		}
		$dupRemove = rtrim($dupRemove, ',');
		$dupRemove = ltrim($dupRemove, ',');
	
		if($dupRemove != '')
			$where = "AND book_info.id NOT IN  (".$dupRemove.")";
		else
			$where = "";
		
		$category_query = "SELECT book_info.vendor,book_info.title,book_info.id, book_info.number_of_books FROM `users_genre` LEFT OUTER JOIN `book_info` ON users_genre.category_id IN (book_info.category_id) WHERE user_id = '".$user_id[0]['user_id']."' AND book_info.title <> '' ".$where."";
		
		$category_books = $this->basic->execute_query($category_query);
		
		if(count($category_books) > 0){
			for($i=0;$i < count($category_books);$i++ ){
				$order_items_query = "SELECT `book_id` FROM `order_items` WHERE `order_id` = '".$order_id."'";
				$order_items = $this->basic->execute_query($order_items_query);
				$checked="";
				foreach($order_items as $wish_id){
					if(in_array($category_books[$i]['id'],$wish_id)){
						$checked = 'checked';
					}
				}
				$dupRemove .= ",".$category_books[$i]['id'];
				if($category_books[$i]['number_of_books'] == 0)
					$sts = "disabled";
				else
					$sts = "";
				
				$response .= "<tr>";
				$response .= "<td><img src='".base_url('assets/images/i.png')."'> </td>";
				$response .= "<td>".$category_books[$i]['title']."</td>";
				$response .= "<td>".$category_books[$i]['vendor']."</td>";
				$response .= "<td>".$category_books[$i]['number_of_books']."</td>";
				$response .= "<td><input type='checkbox' value='".$category_books[$i]['id']."' ".$sts." name='book_id_checked' ".$checked."></td>";
				$response .= "</tr>";
			}
		
		}
		
		$dupRemove = rtrim($dupRemove, ',');
		$dupRemove = ltrim($dupRemove, ',');
		if($dupRemove != '')
			$where = "AND book_info.id NOT IN  (".$dupRemove.")";
		else
			$where = "";
		
		$dislike_query = "SELECT book_info.vendor,book_info.title,book_info.id, book_info.number_of_books FROM `book_info` WHERE book_info.title <> '' ".$where."";		
		$dislike_books = $this->basic->execute_query($dislike_query);
		if(count($dislike_books) > 0){
			for($i=0;$i < count($dislike_books);$i++ ){
				$order_items_query = "SELECT `book_id` FROM `order_items` WHERE `order_id` = '".$order_id."'";
				$order_items = $this->basic->execute_query($order_items_query);
				$checked="";
				foreach($order_items as $wish_id){
					if(in_array($dislike_books[$i]['id'],$wish_id)){
						$checked = 'checked';
					}
				}
				if($dislike_books[$i]['number_of_books'] == 0)
					$sts = "disabled";
				else
					$sts = "";
				
				$response .= "<tr>";
				$response .= "<td><img src='".base_url('assets/images/d.png')."'> </td>";
				$response .= "<td>".$dislike_books[$i]['title']."</td>";
				$response .= "<td>".$dislike_books[$i]['vendor']."</td>";
				$response .= "<td>".$dislike_books[$i]['number_of_books']."</td>";
				$response .= "<td><input type='checkbox' value='".$dislike_books[$i]['id']."' ".$sts." name='book_id_checked' ".$checked."></td>";
				$response .= "</tr>";
					
			}
			
		}
		
		$response .= "</table></form>";
		echo $response;
	}
	
	public function OrderBooks(){
		$books_id = $_REQUEST['booksID'];
		$order_id = $_REQUEST['orderId'];
		
		$explode = explode(',', $books_id);
		
		$where = array( "order_id" => $order_id );
		$dasda =  $this->basic->delete_data('order_items',$where);
		
		for($i=0;$i<count($explode); $i++){
			$data = array(
				'order_id'=>$order_id,
				'book_id'=>$explode[$i]
			);
			$this->basic->insert_data('order_items', $data);
		}
		$this->assigning_list_data();
	}
	
	public function sendToPackage(){
		$order_id = $_REQUEST['orderId'];
		$books_id = $_REQUEST['booksID'];
		$explode = explode(',', $books_id);
		
		$where = array('id' => $order_id);
        $data = array('status' => 'packaging');
        $this->basic->update_data('orders', $where, $data);
		
		$sendSMS = new SMS_API();
		$sendSMS->packageDone($order_id);
		
		for($i=0;$i<count($explode); $i++){
			$query= "UPDATE book_info SET number_of_books = number_of_books-1 WHERE id='".$explode[$i]."'";
			$info = $this->basic->execute_complex_query($query);
		}
		$this->assigning_list_data();
	}
	
	
	public function bulkStatuschange(){
		$info=$this->input->post('info', true);
		$status=$this->input->post('status', true);
		
		$info=json_decode($info, true);
		
		if($status == 'packaging'){
			foreach ($info as $inform) {
				
				$books_id = $inform['books_ids'];
				$order_id = $inform['id'];
				
				$explode = explode(',', $books_id);
				
				$where = array('id' => $order_id);
				$data = array('status' => 'packaging');
				$this->basic->update_data('orders', $where, $data);				
				
		
				for($i=0;$i<count($explode); $i++){
					$query= "UPDATE book_info SET number_of_books = number_of_books-1 WHERE id='".$explode[$i]."'";
					$info = $this->basic->execute_complex_query($query);
				}
			}
		}else if($status == "labeling"){
			foreach ($info as $inform) {				
				$order_id = $inform['id'];
				
				$where = array('id' => $order_id);
				$data = array('status' => 'labeling');
				$this->basic->update_data('orders', $where, $data);
				
				$sendSMS = new SMS_API();
				$sendSMS->packageDone($order_id);				
			}
		}else if($status == "on transits"){
			foreach ($info as $inform) {				
				$order_id = $inform['id'];
				
				$where = array('id' => $order_id);
				$data = array('status' => 'on transits');
				$this->basic->update_data('orders', $where, $data);
				
				$sendSMS = new SMS_API();
				$sendSMS->outForDelivery($order_id);
			}
		}
	}
	////////////////////////////////////  PACKAGING SECTION ////////////////////////////////////
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function packaging(){		
		$data['body']='admin/librarian/packaging.php';
        $data['page_title'] = 'Packaging Book';
        $this->_viewcontroller($data);
	}
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function packaging_list_data(){		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        // setting variables for pagination
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'orders.id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $order_by_str = $sort." ".$order;

       
        $offset = ($page-1)*$rows;
        $result = array();
		
		$order_no = trim($this->input->post('order_no', true));
        $first_name = trim($this->input->post('first_name', true));
        $last_name = trim($this->input->post('last_name', true));
        $phone_number = trim($this->input->post("phone_number", true));
        $email_id = trim($this->input->post('email_id', true));
        $ip_address = trim($this->input->post('ip_address', true));
        $payment_method = trim($this->input->post('payment_method', true));
		
		// creating a blank where_simple array
        $where_simple = array();

        // trimming data
        if ($order_no) {
            $where_simple['orders.order_no like '] = "%".$order_no."%";
        }
        if ($first_name) {
            $where_simple['users.first_name like '] = "%".$first_name."%";
        }
        if ($last_name) {
            $where_simple['users.last_name like '] = "%".$last_name."%";
        }
        if ($phone_number) {
            $where_simple['users.phone_number as alias_user_phone like '] = "%".$phone_number."%";
        }
        if ($email_id) {
            $where_simple['users.email_id like '] = "%".$email_id."%";
        }
        if ($ip_address) {
            $where_simple['orders.ip_address like '] = "%".$ip_address."%";
        }
        if ($payment_method) {
            $where_simple['orders.payment_method like '] = "%".$payment_method."%";
        }
		
		$where_simple['orders.status'] = "packaging";
        $where = array('where' => $where_simple);
		$join = array('users' => 'users.id = orders.user_id, left outer');
		$select['orders'] = 'orders.*';
		$select['users'] = 'users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id';
        $offset = ($page-1)*$rows;
        $result = array();
		//echo $where_simple;
        $table = "orders";
        $info = $this->basic->get_data($table, $where, $select, $join, $limit = $rows, $start = $offset, $order_by = $order_by_str);
		
		for($p=0;$p<count($info); $p++){
			$books_id_query = "SELECT order_id, GROUP_CONCAT(book_id) as books_ids FROM order_items where order_id = '".$info[$p]['id']."' GROUP BY order_id";
			$books_ids = $this->basic->execute_query($books_id_query);
			$info[$p]['books_ids'] = $books_ids[0]['books_ids'];
		}
        $total_rows_array = $this->basic->count_row($table, $where, $count = "id");
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($info, $total_result);
		
		/* $query= "SELECT orders.*, users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id FROM orders LEFT OUTER JOIN users ON users.id = orders.user_id WHERE orders.status = 'packaging'";
		//$query= "SELECT id,plan,CASE WHEN status = '1' THEN 'Active' ELSE 'In active' END as 'status' FROM plans";
        
		$info = $this->basic->execute_query($query);
		$total_result = count($info);

        echo convert_to_grid_data($info, $total_result); */
	}	
	
	/**
    * For Get Ordered Books
    * @access public
    * @return void
    */
	public function getOrderedBooks(){
		$order_id = $_POST['orderId'];  
		$dupRemove = "";
		$response = "<form id='selectForm' name='selectForm'><table class='table table-hover'><tr><th>Book ID</th><th>Book Name</th><th>Vendor Name</th><th>Stock</th></tr>";
		
		$query = "SELECT `user_id` FROM orders WHERE `id` = '".$order_id."'";		
		$user_id = $this->basic->execute_query($query);
		
		$wishlist_query = "SELECT order_items.book_id, book_info.vendor,book_info.title,book_info.id, book_info.number_of_books FROM `order_items`,`book_info` WHERE order_items.order_id = '".$order_id."' AND order_items.book_id = book_info.id";
		$wishlist = $this->basic->execute_query($wishlist_query);
		if(count($wishlist) > 0){
			for($i=0;$i < count($wishlist);$i++ ){
				$response .= "<tr>";
				$response .= "<td>".$wishlist[$i]['id']."</td>";
				$response .= "<td>".$wishlist[$i]['title']."</td>";
				$response .= "<td>".$wishlist[$i]['vendor']."</td>";
				$response .= "<td>".$wishlist[$i]['number_of_books']."</td>";
				$response .= "</tr>";
			}
		}
		$response .= "</table></form>";
		echo $response;
	}
	
	public function sendToLabel(){
		$order_id = $_REQUEST['orderId'];
		
		$where = array('id' => $order_id);
        $data = array('status' => 'labeling');
        $this->basic->update_data('orders', $where, $data);
		
		$sendSMS = new SMS_API();
		$sendSMS->packageDone($order_id);
		
		$this->packaging_list_data();
	}
	////////////////////////////////////  LABELING SECTION ////////////////////////////////////
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function labeling(){		
		$data['body']='admin/librarian/labeling.php';
        $data['page_title'] = 'Labeling Book & Delivery';
        $this->_viewcontroller($data);
	}
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function labeling_list_data(){		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        // setting variables for pagination
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'orders.id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $order_by_str = $sort." ".$order;

       
        $offset = ($page-1)*$rows;
        $result = array();
		
		$order_no = trim($this->input->post('order_no', true));
        $first_name = trim($this->input->post('first_name', true));
        $last_name = trim($this->input->post('last_name', true));
        $phone_number = trim($this->input->post("phone_number", true));
        $email_id = trim($this->input->post('email_id', true));
        $ip_address = trim($this->input->post('ip_address', true));
        $payment_method = trim($this->input->post('payment_method', true));
		
		// creating a blank where_simple array
        $where_simple = array();

        // trimming data
        if ($order_no) {
            $where_simple['orders.order_no like '] = "%".$order_no."%";
        }
        if ($first_name) {
            $where_simple['users.first_name like '] = "%".$first_name."%";
        }
        if ($last_name) {
            $where_simple['users.last_name like '] = "%".$last_name."%";
        }
        if ($phone_number) {
            $where_simple['users.phone_number as alias_user_phone like '] = "%".$phone_number."%";
        }
        if ($email_id) {
            $where_simple['users.email_id like '] = "%".$email_id."%";
        }
        if ($ip_address) {
            $where_simple['orders.ip_address like '] = "%".$ip_address."%";
        }
        if ($payment_method) {
            $where_simple['orders.payment_method like '] = "%".$payment_method."%";
        }
		
		$where_simple['orders.status'] = "labeling";
        $where = array('where' => $where_simple);
		$join = array('users' => 'users.id = orders.user_id, left outer');
		$select['orders'] = 'orders.*';
		$select['users'] = 'users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id';
        $offset = ($page-1)*$rows;
        $result = array();
		//echo $where_simple;
        $table = "orders";
        $info = $this->basic->get_data($table, $where, $select, $join, $limit = $rows, $start = $offset, $order_by = $order_by_str);
		for($p=0;$p<count($info); $p++){
			$books_id_query = "SELECT order_id, GROUP_CONCAT(book_id) as books_ids FROM order_items where order_id = '".$info[$p]['id']."' GROUP BY order_id";
			$books_ids = $this->basic->execute_query($books_id_query);
			$info[$p]['books_ids'] = $books_ids[0]['books_ids'];
		}
        $total_rows_array = $this->basic->count_row($table, $where, $count = "id");
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($info, $total_result);
		
		/* $query= "SELECT orders.*, users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id FROM orders LEFT OUTER JOIN users ON users.id = orders.user_id WHERE orders.status = 'labeling'";
		//$query= "SELECT id,plan,CASE WHEN status = '1' THEN 'Active' ELSE 'In active' END as 'status' FROM plans";
        
		$info = $this->basic->execute_query($query);
		$total_result = count($info);

        echo convert_to_grid_data($info, $total_result); */
	}	
	
	
	public function sendToDelivery(){
		/** KOORIEE API **/
		
		$order_id = $_REQUEST['orderId'];
		
		$where = array('id' => $order_id);
        $data = array('status' => 'labeling');
        $this->basic->update_data('orders', $where, $data);
		$this->labeling_list_data();
	}
	////////////////////////////////////  Transit SECTION ////////////////////////////////////
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function transits(){		
		$data['body']='admin/librarian/transit.php';
        $data['page_title'] = 'Transit Book & Delivery';
        $this->_viewcontroller($data);
	}
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function transits_list_data(){		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        // setting variables for pagination
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'orders.id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $order_by_str = $sort." ".$order;

       
        $offset = ($page-1)*$rows;
        $result = array();
		
		$order_no = trim($this->input->post('order_no', true));
        $first_name = trim($this->input->post('first_name', true));
        $last_name = trim($this->input->post('last_name', true));
        $phone_number = trim($this->input->post("phone_number", true));
        $email_id = trim($this->input->post('email_id', true));
        $ip_address = trim($this->input->post('ip_address', true));
        $payment_method = trim($this->input->post('payment_method', true));
        $shipping_address = trim($this->input->post('shipping_address', true));
        $pincode = trim($this->input->post('pincode', true));
        $area = trim($this->input->post('area', true));
		
		// creating a blank where_simple array
        $where_simple = " AND 1=1 ";

        // trimming data
        if ($order_no) {
			  $where_simple .=" AND orders.order_no like '%".$order_no."%'";
          
        }
        if ($first_name) {
			 $where_simple .=" AND users.first_name like  '%".$first_name."%'";
          
        }
        if ($last_name) {
			$where_simple .=" AND users.last_name like '%".$last_name."%'";
        }
        if ($phone_number) {
			$where_simple .=" AND users.phone_number as alias_user_phone like   '%".$phone_number."%'";
        }
        if ($email_id) {
			$where_simple .=" AND users.first_name like  '%".$email_id."%'";
        }
        if ($ip_address) {
			$where_simple .=" AND orders.ip_address like  '%".$ip_address."%'";
        }
        if ($payment_method) {
			$where_simple .=" AND orders.payment_method like '%".$payment_method."%'";
        } 
		if ($shipping_address) {
			$where_simple .=" AND orders_address.address like '%".$shipping_address."%'";
        }  if ($pincode) {
			$where_simple .=" AND orders_address.pincode like '%".$pincode."%'";
        }  if ($area) {
			$where_simple .=" AND orders_address.area like '%".$area."%'";
        }
		/*$where_simple['orders.status <>'] = "labeling";
		  $where = array('where' => $where_simple);
		$join = array('users' => 'users.id = orders.user_id, left outer');
		$select['orders'] = 'orders.*';
		$select['users'] = 'users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id';
        $offset = ($page-1)*$rows;
        $result = array();
   
	   $table = "orders";
        $info = $this->basic->get_data($table, $where, $select, $join, $limit = $rows, $start = $offset, $order_by = $order_by_str);

        $total_rows_array = $this->basic->count_row($table, $where, $count = "id");
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($info, $total_result); */
		
		$query= "SELECT orders.*, orders_address.address,orders_address.area,orders_address.pincode, users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id FROM orders LEFT OUTER JOIN users ON users.id = orders.user_id LEFT OUTER JOIN orders_address ON orders.id = orders_address.order_id WHERE orders.status IN ('on transits') ".$where_simple." ";
		//$query= "SELECT id,plan,CASE WHEN status = '1' THEN 'Active' ELSE 'In active' END as 'status' FROM plans";
        
		$info = $this->basic->execute_query($query);
		for($p=0;$p<count($info); $p++){
			$books_id_query = "SELECT order_id, GROUP_CONCAT(book_id) as books_ids FROM order_items where order_id = '".$info[$p]['id']."' GROUP BY order_id";
			$books_ids = $this->basic->execute_query($books_id_query);
			$info[$p]['books_ids'] = $books_ids[0]['books_ids'];
		}
		$total_result = count($info);

        echo convert_to_grid_data($info, $total_result); 
	}	
	public function returnBook(){
		$order_id = $_REQUEST['orderId'];		
		$status = $_REQUEST['status'];
		$up_status = '';
		
		if($status == '1'){
			$up_status = 'on transits';
			$where = array('id' => $order_id);
			$data = array('status' => $up_status);
			$this->basic->update_data('orders', $where, $data);
		}
		if($status == '0'){
			$up_status = 'returned';
			$where = array('id' => $order_id);
			$data = array('status' => $up_status);
			$this->basic->update_data('orders', $where, $data);
		}
		if($status == '4'){
			$up_status = 'labeling';
			$where = array('id' => $order_id);
			$data = array('status' => $up_status);
			$this->basic->update_data('orders', $where, $data);
		}
		
		if($status == '10'){
			$up_status = 'pickup';
			$sendSMS = new SMS_API();
			$sendSMS->onTheWay($order_id);
		}
		
		if($status == '3'){
			
			$date = strtotime("+30 day");
			$due_date = date('Y-m-d h:i:s', $date);
			$delivery_date = date('Y-m-d h:i:s');			
			$data = array('status' => $up_status,'due_date'=>$due_date,'delivery_date'=>$delivery_date);
			
			$previous_close_query = "SELECT id FROM orders WHERE (status = 'open' OR status = 'due') AND user_id = (SELECT orders.user_id FROM orders WHERE orders.id = '".$order_id."' )";
			$previous_close = $this->basic->execute_query($previous_close_query);
			
			if( count($previous_close) > 0){
				$pre_where = array('id' => $previous_close[0]['id']);
				$pre_data = array('status' => 'closed');
				$updated = $this->basic->update_data('orders', $pre_where, $pre_data);
				if($updated){
					$input_paymet = array(
						'order_ids' => $previous_close[0]['id'].",".$order_id,
						'reason' => 'Picked up & Delivery'
					);
					$this->basic->insert_data('payment_settlement', $input_paymet);
					
					$sendSMS = new SMS_API();
					$sendSMS->afterDelivery($order_id);
				}
			}else{
				$input_paymet = array(
					'order_ids' => $order_id,
					'reason' => 'Delivery'
				);
				$this->basic->insert_data('payment_settlement', $input_paymet);
				
				$sendSMS = new SMS_API();
				$sendSMS->afterDelivery($order_id);
			}
			$up_status = 'open';
			$where = array('id' => $order_id);
			$data = array('status' => $up_status);
			$this->basic->update_data('orders', $where, $data);
		}
		
		if($status == '2'){
			
			$up_status = 'closed';
			$where = array('id' => $order_id);
			$data = array('status' => $up_status);
			$this->basic->update_data('orders', $where, $data);
			
			$query = " SELECT (SELECT orders.user_id FROM orders WHERE orders.id = '".$order_id."' ) as user_id,(SELECT orders.genres FROM orders WHERE orders.id = '".$order_id."' ) as genres, book_info.isbn,book_info.title,book_info.author,book_info.category_id,book_info.edition,book_info.cover FROM order_items LEFT OUTER JOIN book_info ON order_items.book_id = book_info.id WHERE order_items.order_id = '".$order_id."'";        
			$info = $this->basic->execute_query($query);
				foreach($info as $datas){
						$query_lib = " SELECT * FROM library WHERE user_id = '".$info[0]['user_id']."' AND isbn = '".$datas['isbn']."'";        
						$get_lib = $this->basic->execute_query($query_lib);
						if(count($get_lib) == 0){
								$input_library = array(
									'user_id' => $info[0]['user_id'],
									'isbn' => $datas['isbn'],
									'genre' => $datas['category_id'],
									'title' => $datas['title'],
									'author' => $datas['author'],
									'edition' => $datas['edition'],
									'cover_image' => $datas['cover']
								);
						
						$this->basic->insert_data('library', $input_library);
						}
				}
				$input_paymet = array(
					'order_ids' => $order_id,
					'reason' => 'Picked Up'
				);
				$this->basic->insert_data('payment_settlement', $input_paymet);
				
				$sendSMS = new SMS_API();
				$sendSMS->afterPickedup($info[0]['user_id']);
				
		}
		
	}
	
	
	//////////////////////////////////////////////  CLOSED ORDER SECTION ////////////////////////////////////
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function closeOrders(){		
		$data['body']='admin/librarian/closeOrders.php';
        $data['page_title'] = 'Closed Orders';
		
		$query= "SELECT SUM(total) as 'closed' FROM `orders` WHERE status='closed'";        
		$info = $this->basic->execute_query($query);
		$closed_amt = $info[0]['closed']; 
		
		$query_return= "SELECT SUM(total) as 'returned' FROM `orders` WHERE status='returned'";        
		$info_return = $this->basic->execute_query($query_return);
		$return_amt = $info_return[0]['returned'];
		
	
		  $this->session->set_userdata('completed_amt', $closed_amt);
		  $this->session->set_userdata('returned_amt', $return_amt);

        $this->_viewcontroller($data);
	}
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function closed_list_data(){		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        // setting variables for pagination
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'orders.id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $order_by_str = $sort." ".$order;

       
        $offset = ($page-1)*$rows;
        $result = array();
		
		/* $order_no = trim($this->input->post('order_no', true));
        $first_name = trim($this->input->post('first_name', true));
        $last_name = trim($this->input->post('last_name', true));
        $phone_number = trim($this->input->post("phone_number", true));
        $email_id = trim($this->input->post('email_id', true)); 
        $ip_address = trim($this->input->post('ip_address', true));
        $payment_method = trim($this->input->post('payment_method', true));*/
		
		// creating a blank where_simple array
        

        // trimming data
        /* if ($order_no) {
            $where_simple['orders.order_no like '] = "%".$order_no."%";
        }
        if ($first_name) {
            $where_simple['users.first_name like '] = "%".$first_name."%";
        }
        if ($last_name) {
            $where_simple['users.last_name like '] = "%".$last_name."%";
        }
        if ($phone_number) {
            $where_simple['users.phone_number as alias_user_phone like '] = "%".$phone_number."%";
        }
        if ($email_id) {
            $where_simple['users.email_id like '] = "%".$email_id."%";
        }
        if ($ip_address) {
            $where_simple['orders.ip_address like '] = "%".$ip_address."%";
        }
        if ($payment_method) {
            $where_simple['orders.payment_method like '] = "%".$payment_method."%";
        }
		
		$where_simple['orders.status'] = "closed";
        $where = array('where' => $where_simple);
		$join = array('users' => 'users.id = orders.user_id, left outer');
		$select['orders'] = 'orders.*';
		$select['users'] = 'users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id , (SELECT count(order_items.order_id) from order_items WHERE  orders.id = order_items.order_id) as order_count';
        $offset = ($page-1)*$rows;
        $result = array();
		//echo $where_simple;
        $table = "orders";
        $info = $this->basic->get_data($table, $where, $select, $join, $limit = $rows, $start = $offset, $order_by = $order_by_str);
		
		for($p=0;$p<count($info); $p++){
			$books_id_query = "SELECT order_id, GROUP_CONCAT(book_id) as books_ids FROM order_items where order_id = '".$info[$p]['id']."' GROUP BY order_id";
			$books_ids = $this->basic->execute_query($books_id_query);
			$info[$p]['books_ids'] = $books_ids[0]['books_ids'];
		}
		
        $total_rows_array = $this->basic->count_row($table, $where, $count = "id");
        $total_result = $total_rows_array[0]['total_rows'];

        //echo convert_to_grid_data($info, $total_result); */
		
		$start_date = trim($this->input->post('start_date', true));
        $end_date = trim($this->input->post('end_date', true));
		
		$where_simple = "";
		if ($start_date != '') {
            $where_simple .= "AND Date_Format(created_date,'%Y-%m-%d') >= '".$start_date."'";
        }

        if ($end_date != '') {
            $where_simple .= "AND Date_Format(created_date,'%Y-%m-%d') <= '".$end_date."'";
        }
		
		$order_number_query = "SELECT `order_ids`, created_date, id, reason FROM payment_settlement WHERE 1=1 ".$where_simple." ORDER BY id DESC";
		$order_number = $this->basic->execute_query($order_number_query);
		$total_orders = array();
		$order_idss = "";
		for( $i = 0; $i < count($order_number); $i++){
			$order_arrays = explode(',', $order_number[$i]['order_ids']);
			//print_r($order_arrays);
			for($j=0; $j < count($order_arrays); $j++){
				$order_ids_query = "SELECT order_no FROM orders where id = '".$order_arrays[$j]."' ";
				$order_ids = $this->basic->execute_query($order_ids_query);
				$order_idss .= $order_ids[0]['order_no'] . ",";
			}
			$order_idss = rtrim($order_idss, ',');
			
			$orders_address_query = "SELECT orders.id, orders.total, orders.shipping_mode, orders.payment_method, orders.user_id, users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id, orders_address.address, orders_address.city, orders_address.area, orders_address.pincode FROM orders LEFT OUTER JOIN users ON users.id = orders.user_id LEFT OUTER JOIN orders_address ON orders_address.order_id = orders.id WHERE orders.id = '".$order_arrays[0]."'";
			$orders_address = $this->basic->execute_query($orders_address_query);
			
			$total_orders[$i]['orders_nos'] = $order_idss;
			$total_orders[$i]['id'] = $orders_address[0]['id'];
			$total_orders[$i]['first_name'] = $orders_address[0]['first_name'];
			$total_orders[$i]['total'] = $orders_address[0]['total'];
			$total_orders[$i]['shipping_mode'] = $orders_address[0]['shipping_mode'];
			$total_orders[$i]['payment_method'] = $orders_address[0]['payment_method'];
			$total_orders[$i]['last_name'] = $orders_address[0]['last_name'];
			$total_orders[$i]['phone_number'] = $orders_address[0]['alias_user_phone'];
			$total_orders[$i]['email_id'] = $orders_address[0]['email_id'];
			$total_orders[$i]['address'] = $orders_address[0]['address'];
			$total_orders[$i]['city'] = $orders_address[0]['city'];
			$total_orders[$i]['area'] = $orders_address[0]['area'];
			$total_orders[$i]['pincode'] = $orders_address[0]['pincode'];
			$total_orders[$i]['created_date'] = $order_number[$i]['created_date'];
			$total_orders[$i]['settlement_id'] = $order_number[$i]['id'];
			$total_orders[$i]['reason'] = $order_number[$i]['reason'];
			
			$order_idss = "";
		}
		echo convert_to_grid_data($total_orders, count($total_orders));
		/* $query= "SELECT orders.*, users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id, (SELECT count(order_items.order_id) from order_items WHERE  orders.id = order_items.order_id) as order_count FROM orders LEFT OUTER JOIN users ON users.id = orders.user_id WHERE orders.status = 'closed'";
		//$query= "SELECT id,plan,CASE WHEN status = '1' THEN 'Active' ELSE 'In active' END as 'status' FROM plans";
        
		$info = $this->basic->execute_query($query);
		$total_result = count($info);

        echo convert_to_grid_data($info, $total_result); */
	}
	
	public function sendToClose(){
		$order_id = $_REQUEST['orderId'];
		
		$where = array('id' => $order_id);
        $data = array('status' => 'closed');
		$id = $this->basic->update_data('orders', $where, $data);
		if($id){
			$query = " SELECT (SELECT orders.user_id FROM orders WHERE orders.id = '".$order_id."' ) as user_id,(SELECT orders.genres FROM orders WHERE orders.id = '".$order_id."' ) as genres, book_info.isbn,book_info.title,book_info.author,book_info.category_id,book_info.edition,book_info.cover FROM order_items LEFT OUTER JOIN book_info ON order_items.book_id = book_info.id WHERE order_items.order_id = '".$order_id."'";        
			$info = $this->basic->execute_query($query);
				foreach($info as $datas){
						$query_lib = " SELECT * FROM library WHERE user_id = '".$info[0]['user_id']."' AND isbn = '".$datas['isbn']."'";        
						$get_lib = $this->basic->execute_query($query_lib);
						if(count($get_lib) == 0){
								$input_library = array(
									'user_id' => $info[0]['user_id'],
									'isbn' => $datas['isbn'],
									'genre' => $datas['category_id'],
									'title' => $datas['title'],
									'author' => $datas['author'],
									'edition' => $datas['edition'],
									'cover_image' => $datas['cover']
								);
						
						$this->basic->insert_data('library', $input_library);
						}
					
				
			}
		}
	  $this->closed_list_data();
	}
	//////////////////////////////////////////////  OPEN ORDER SECTION ////////////////////////////////////
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function openOrders(){		
		$data['body']='admin/librarian/openOrders.php';
        $data['page_title'] = 'Closed Orders';
        $this->_viewcontroller($data);
	}
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function open_list_data(){		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        // setting variables for pagination
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'orders.id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $order_by_str = $sort." ".$order;

       
        $offset = ($page-1)*$rows;
        $result = array();
		
		$order_no = trim($this->input->post('order_no', true));
        $first_name = trim($this->input->post('first_name', true));
        $last_name = trim($this->input->post('last_name', true));
        $phone_number = trim($this->input->post("phone_number", true));
        $email_id = trim($this->input->post('email_id', true));
        $ip_address = trim($this->input->post('ip_address', true));
        $payment_method = trim($this->input->post('payment_method', true));
		
		// creating a blank where_simple array
        $where_simple = array();

        // trimming data
        if ($order_no) {
            $where_simple['orders.order_no like '] = "%".$order_no."%";
        }
        if ($first_name) {
            $where_simple['users.first_name like '] = "%".$first_name."%";
        }
        if ($last_name) {
            $where_simple['users.last_name like '] = "%".$last_name."%";
        }
        if ($phone_number) {
            $where_simple['users.phone_number as alias_user_phone like '] = "%".$phone_number."%";
        }
        if ($email_id) {
            $where_simple['users.email_id like '] = "%".$email_id."%";
        }
        if ($ip_address) {
            $where_simple['orders.ip_address like '] = "%".$ip_address."%";
        }
        if ($payment_method) {
            $where_simple['orders.payment_method like '] = "%".$payment_method."%";
        }
		
		/* $where_simple['orders.status'] = "orders.status = 'open' OR orders.status = 'on transits' OR orders.status = 'pickup'";
		$where_simple['orders.status'] = "on transits";
		$where_simple['orders.status'] = "open"; */
		
        /*$where = array('where' => $where_simple);
		$join = array('users' => 'users.id = orders.user_id, left outer');
		$select['orders'] = 'orders.*';
		$select['users'] = 'users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id , (SELECT count(order_items.order_id) from order_items WHERE  orders.id = order_items.order_id) as order_count';
        $offset = ($page-1)*$rows;
        $result = array();
		//echo $where_simple;
        $table = "orders";
        $info = $this->basic->get_data($table, $where, $select, $join, $limit = $rows, $start = $offset, $order_by = $order_by_str);

        $total_rows_array = $this->basic->count_row($table, $where, $count = "id");
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($info, $total_result); */
		
		 $query= "SELECT orders.*, users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id,  (SELECT count(order_items.order_id) from order_items WHERE  orders.id = order_items.order_id) as order_count FROM orders LEFT OUTER JOIN users ON users.id = orders.user_id WHERE orders.status = 'open' OR orders.status = 'on transits' OR orders.status = 'pickup'";
        
		$info = $this->basic->execute_query($query);
		
		for($p=0;$p<count($info); $p++){
			$books_id_query = "SELECT order_id, GROUP_CONCAT(book_id) as books_ids FROM order_items where order_id = '".$info[$p]['id']."' GROUP BY order_id";
			$books_ids = $this->basic->execute_query($books_id_query);
			$info[$p]['books_ids'] = $books_ids[0]['books_ids'];
		}
		
		$total_result = count($info);

        echo convert_to_grid_data($info, $total_result);
	}
	
	public function sendToTransit(){
		$order_id = $_REQUEST['orderId'];
		
		$where = array('id' => $order_id);
        $data = array('status' => 'on transits');
        $this->basic->update_data('orders', $where, $data);
		
		$sendSMS = new SMS_API();
		$sendSMS->outForDelivery($order_id);
		
		$this->open_list_data();
	}
	
	//////////////////////////////////////////////  DUE ORDER SECTION ////////////////////////////////////
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function dueOrders(){		
		$data['body']='admin/librarian/dueOrders.php';
        $data['page_title'] = 'Closed Orders';
        $this->_viewcontroller($data);
	}
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function due_list_data(){		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        // setting variables for pagination
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'plan';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $order_by_str = $sort." ".$order;

       
        $offset = ($page-1)*$rows;
        $result = array();
		
		$query= "SELECT orders.*, users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id,  (SELECT count(order_items.order_id) from order_items WHERE  orders.id = order_items.order_id) as order_count FROM orders LEFT OUTER JOIN users ON users.id = orders.user_id WHERE orders.status = 'due' OR orders.status = 'auto'";
        
		$info = $this->basic->execute_query($query);
		$total_result = count($info);

        echo convert_to_grid_data($info, $total_result);
	}
	
	/* public function sendToDue(){
		$order_id = $_REQUEST['orderId'];
		
		$date = strtotime("+7 day");
		$due_date = date('Y-m-d h:i:s', $date);
		$where = array('id' => $order_id);
        $data = array('status' => 'due', 'due_date' => $due_date);
        $this->basic->update_data('orders', $where, $data);
		$this->due_list_data();
	} */
	
	public function sendToAuto(){
		$order_id = $_REQUEST['orderId'];
		
		if( $order_id != NULL || $order_id != ''){
			// OLD ORDER DATA MOVE TO CLOSED
			$where = array('id' => $order_id);
			$data = array('status' => 'closed');
			$this->basic->update_data('orders', $where, $data);
			
			/* // CREATE NEW ORDER WITH OLD ORDER ID WITH STATUS AUTO*/
			$query = "SELECT * FROM orders WHERE id ='".$order_id."'";
			$data = $this->basic->execute_query($query);
			
			$users_name_query = "SELECT `first_name`,`last_name`, `wallet` FROM `users` WHERE `id` = '".$data[0]['user_id']."'";
			$users_name = $this->basic->execute_query($users_name_query);
			
			$new_order_ids = $this->basic->count_row('orders');
			$count_orders = $new_order_ids[0]['total_rows'] + 1;
			
			if(count($users_name[0])== 3){
				$letter1 = strtoupper (substr($users_name[0]['first_name'], 0, 1));
				$letter2 = strtoupper (substr($users_name[0]['last_name'], 0, 1));
				$new_order_id = $letter1.$letter2."-".$count_orders;
			}else{
				$letter1 = strtoupper (substr($users_name[0]['first_name'], 0, 2));
				$new_order_id = $letter1."-".$count_orders;
			}
			$date = strtotime("+1 month");
			$due_date = date('Y-m-d h:i:s', $date);
			
			$input_new_order = array(
				'order_no' => $new_order_id,
				'user_id' => $data[0]['user_id'],
				'books_nos' => $data[0]['books_nos'],
				'genres' => $data[0]['genres'],
				'price' => $data[0]['price'],
				'delivery_charges' => $data[0]['delivery_charges'],
				'pickup_charges' => $data[0]['pickup_charges'],
				'total' => $data[0]['total'],
				'phone_number' => $data[0]['phone_number'],
				'ip_address' => $data[0]['ip_address'],
				'transaction_id' => $data[0]['transaction_id'],
				'coupon' => $data[0]['coupon'],
				'coupon_amount' => $data[0]['coupon_amount'],
				'payment_type' => 'wallet',
				'delivery_date' => $data[0]['delivery_date'],
				'due_date' => $due_date,
				'status' => 'auto',
				'created_date' => $data[0]['created_date']
			);
			
			$this->basic->insert_data('orders', $input_new_order);
			$insert_id = $this->db->insert_id();
			
			if($insert_id){
				$amount = $users_name[0]['wallet'] - $data[0]['price'];
				$where = array('id' => $data[0]['user_id']);
				$wallet = array('wallet' => $amount);
				$update_wallet = $this->basic->update_data('users', $where, $wallet);
				
				$logs = array(
					'user_id' => $data[0]['user_id'],
					'actions' => 'Auto renewal Dedection by system'
				);
				$this->basic->insert_data('logs_wallet', $logs);
				$this->due_list_data();
			}
			/* $date = strtotime("+1 month");
			$due_date = date('Y-m-d h:i:s', $date);
			$where = array('id' => $insert_id);
			$data = array('status' => 'auto', 'due_date' => $due_date);
			$this->basic->update_data('orders', $where, $data);  */
		}
	}
	public function summary_amt(){		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
             
		$query= "SELECT COUNT(id) as 'assigning' FROM `orders` WHERE status='selection'";        
		$info = $this->basic->execute_query($query);
		$assigning = $info[0]['assigning']; 
		
		$query_return= "SELECT COUNT(id) as 'packaging' FROM `orders` WHERE status='packaging'";        
		$info_return = $this->basic->execute_query($query_return);
		$packaging = $info_return[0]['packaging'];
		
		$query_return= "SELECT COUNT(id) as 'labeling' FROM `orders` WHERE status='labeling'";        
		$info_return = $this->basic->execute_query($query_return);
		$labeling = $info_return[0]['labeling'];
		
		$query_return= "SELECT COUNT(id) as 'transit' FROM `orders` WHERE status='on transits'";        
		$info_return = $this->basic->execute_query($query_return);
		$transit = $info_return[0]['transit'];
		
		$query_return= "SELECT COUNT(id) as 'pickup' FROM `orders` WHERE status='pickup'";        
		$info_return = $this->basic->execute_query($query_return);
		$pickup = $info_return[0]['pickup'];
		
		$query_return= "SELECT COUNT(id) as 'open' FROM `orders` WHERE status='open'";        
		$info_return = $this->basic->execute_query($query_return);
		$open = $info_return[0]['open'];
		
		$query_return= "SELECT COUNT(id) as 'closed' FROM `orders` WHERE status='closed'";        
		$info_return = $this->basic->execute_query($query_return);
		$closed = $info_return[0]['closed'];
		
		$amt = array(
			'assigning'=>$assigning,
			'packaging'=>$packaging,
			'labeling'=>$labeling,
			'transit'=>$transit,
			'pickup'=>$pickup,
			'open'=>$open,
			'closed'=>$closed
		);
		echo json_encode($amt);
			
	}
	////////////////////////////////////  Summary SECTION ////////////////////////////////////
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function summary(){		
		$data['body']='admin/librarian/summary.php';
        $data['page_title'] = 'Order Summary';
        $this->_viewcontroller($data);
	}
	
		/**
    * For List Books
    * @access public
    * @return void
    */
	public function summary_data(){		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        // setting variables for pagination
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'orders.id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $order_by_str = $sort." ".$order;

       
        $offset = ($page-1)*$rows;
        $result = array();
		
		$order_no = trim($this->input->post('order_no', true));
        $first_name = trim($this->input->post('first_name', true));
        $last_name = trim($this->input->post('last_name', true));
        $phone_number = trim($this->input->post("phone_number", true));
        $email_id = trim($this->input->post('email_id', true));
        $ip_address = trim($this->input->post('ip_address', true));
        $payment_method = trim($this->input->post('payment_method', true));
        $status = trim($this->input->post('status', true));
		
		// creating a blank where_simple array
        $where_simple = " 1=1 ";

        // trimming data
        if ($order_no) {
			  $where_simple .=" AND orders.order_no like '%".$order_no."%'";
          
        }
        if ($first_name) {
			 $where_simple .=" AND users.first_name like  '%".$first_name."%'";
          
        }
        if ($last_name) {
			$where_simple .=" AND users.last_name like '%".$last_name."%'";
        }
        if ($phone_number) {
			$where_simple .=" AND users.phone_number as alias_user_phone like   '%".$phone_number."%'";
        }
        if ($email_id) {
			$where_simple .=" AND users.first_name like  '%".$email_id."%'";
        }
        if ($ip_address) {
			$where_simple .=" AND orders.ip_address like  '%".$ip_address."%'";
        }
        if ($payment_method) {
			$where_simple .=" AND orders.payment_method like '%".$payment_method."%'";
        } if ($status) {
			if($status == "process")
				$where_simple .=" AND orders.status IN ('selection', 'packaging','labeling')";
			else if($status == "transit")
				$where_simple .=" AND orders.status IN ('in transits', 'pickup')";
			else if($status == "reading")
				$where_simple .=" AND orders.status IN ('open', 'due')";
			else if($status == "done")
				$where_simple .=" AND orders.status IN ('closed')";
			else if($status == "cancelled")
				$where_simple .=" AND orders.status IN ('cancelled')";
			 
        }
		
		
		/*$where_simple['orders.status <>'] = "labeling";
		  $where = array('where' => $where_simple);
		$join = array('users' => 'users.id = orders.user_id, left outer');
		$select['orders'] = 'orders.*';
		$select['users'] = 'users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id';
        $offset = ($page-1)*$rows;
        $result = array();
   
	   $table = "orders";
        $info = $this->basic->get_data($table, $where, $select, $join, $limit = $rows, $start = $offset, $order_by = $order_by_str);

        $total_rows_array = $this->basic->count_row($table, $where, $count = "id");
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($info, $total_result); */
		
		$query= "SELECT orders.*, users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id FROM orders LEFT OUTER JOIN users ON users.id = orders.user_id WHERE ".$where_simple." ";
		//$query= "SELECT id,plan,CASE WHEN status = '1' THEN 'Active' ELSE 'In active' END as 'status' FROM plans";
        
		$info = $this->basic->execute_query($query);
		$total_result = count($info);

        echo convert_to_grid_data($info, $total_result); 
	}	
		////////////////////////////////////  Pick up SECTION ////////////////////////////////////
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function pickups(){		
		$data['body']='admin/librarian/pickups.php';
        $data['page_title'] = 'Pick ups';
        $this->_viewcontroller($data);
	}
	
	/**
    * For List Books
    * @access public
    * @return void
    */
	public function pickup_data(){		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        // setting variables for pagination
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'orders.id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $order_by_str = $sort." ".$order;

       
        $offset = ($page-1)*$rows;
        $result = array();
		
		$order_no = trim($this->input->post('order_no', true));
        $first_name = trim($this->input->post('first_name', true));
        $last_name = trim($this->input->post('last_name', true));
        $phone_number = trim($this->input->post("phone_number", true));
        $email_id = trim($this->input->post('email_id', true));
        $ip_address = trim($this->input->post('ip_address', true));
        $payment_method = trim($this->input->post('payment_method', true));
        $shipping_address = trim($this->input->post('shipping_address', true));
        $pincode = trim($this->input->post('pincode', true));
        $area = trim($this->input->post('area', true));
		
		// creating a blank where_simple array
        $where_simple = " AND 1=1 ";

        // trimming data
        if ($order_no) {
			  $where_simple .=" AND orders.order_no like '%".$order_no."%'";
          
        }
        if ($first_name) {
			 $where_simple .=" AND users.first_name like  '%".$first_name."%'";
          
        }
        if ($last_name) {
			$where_simple .=" AND users.last_name like '%".$last_name."%'";
        }
        if ($phone_number) {
			$where_simple .=" AND users.phone_number as alias_user_phone like   '%".$phone_number."%'";
        }
        if ($email_id) {
			$where_simple .=" AND users.first_name like  '%".$email_id."%'";
        }
        if ($ip_address) {
			$where_simple .=" AND orders.ip_address like  '%".$ip_address."%'";
        }
        if ($payment_method) {
			$where_simple .=" AND orders.payment_method like '%".$payment_method."%'";
        } 
		if ($shipping_address) {
			$where_simple .=" AND orders_address.address like '%".$shipping_address."%'";
        }  if ($pincode) {
			$where_simple .=" AND orders_address.pincode like '%".$pincode."%'";
        }  if ($area) {
			$where_simple .=" AND orders_address.area like '%".$area."%'";
        }
		/*$where_simple['orders.status <>'] = "labeling";
		  $where = array('where' => $where_simple);
		$join = array('users' => 'users.id = orders.user_id, left outer');
		$select['orders'] = 'orders.*';
		$select['users'] = 'users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id';
        $offset = ($page-1)*$rows;
        $result = array();
   
	   $table = "orders";
        $info = $this->basic->get_data($table, $where, $select, $join, $limit = $rows, $start = $offset, $order_by = $order_by_str);

        $total_rows_array = $this->basic->count_row($table, $where, $count = "id");
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($info, $total_result); */
		
		$query= "SELECT orders.*, orders_address.address,orders_address.area,orders_address.pincode, users.id as alias_user_id, users.first_name, users.last_name, users.phone_number as alias_user_phone, users.email_id FROM orders LEFT OUTER JOIN users ON users.id = orders.user_id LEFT OUTER JOIN orders_address ON orders.id = orders_address.order_id WHERE orders.status IN ('pickup') ".$where_simple." ";
		//$query= "SELECT id,plan,CASE WHEN status = '1' THEN 'Active' ELSE 'In active' END as 'status' FROM plans";
        
		$info = $this->basic->execute_query($query);
		$total_result = count($info);

        echo convert_to_grid_data($info, $total_result); 
	}	
	
	//////////// PICKUP SECTION /////
	public function sendToPickup(){
		$order_id = $_REQUEST['orderId'];
		
		$where = array('id' => $order_id);
        $data = array('status' => 'pickup');
		$id = $this->basic->update_data('orders', $where, $data);
		echo 1;
	}
	
}