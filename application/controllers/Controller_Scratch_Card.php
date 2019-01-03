<?php
require('services.php');
defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Scratch_Card extends Admin_Controller 
{
	public function __construct()
	{
		//$this->clean_session();
		
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Transaction manager';

		// load Pagination library
		$this->load->library('pagination');
		
	   // load URL helper
	   $this->load->helper('url');

		$this->load->model('model_transactions');
	}


	public function clean_session()
	{
		if (isset($_SESSION['previous'])) {		
			if ( strpos($_SERVER['PHP_SELF'], $_SESSION['previous']) == false) {
				 //session_destroy();
				 unset($_SESSION['storeValues']);
				 ### or alternatively, you can use this for specific variables:
				 ### unset($_SESSION['varname']);
			}
		 }
	}
	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
		//session_start();
		$this->clean_session();
		$this->set_current_page();

		$partner_username = $this->session->userdata('partner_username');
		$partner_id = $this->session->userdata('partner_id');
		// init params
		$params = array();
		if(!empty($_POST)){
			$error = '';
			if(empty($_POST['telcoCode'])){
				$error = 'Bạn phải chọn loại thẻ';
			}else if(empty($_POST['cardSerial'])){
				$error = 'Bạn phải nhập Serial thẻ';
			}else if(empty($_POST['cardPin'])){
				$error = 'Bạn phải nhập mã thẻ';
			}else{
				$service = new ChargingAPIServices($config);
				$json = $service->charging($_POST);
				//$input = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($response));		
				//$json = json_decode($input, true);
				
				if(!empty($json)){
					//print_r($datajson);die;
					$error = 'Kết quả gạch thẻ: <br/>';
					if(!empty($json['status'])){
						$error .= 'Status: '.$json['status'].'<br/>';
					}
					if(!empty($json['message'])){
						$error .= 'Message: '.$json['message'].'<br/>';
					}
					if(!empty($json['requestId'])){
						$error .= 'requestId: '.$json['requestId'].'<br/>';
					}           
					if(!empty($json['cardAmount'])){
						$error .= 'Mệnh giá: '.$json['cardAmount'].'<br/>';
					}
					else{
						$error .= $json;
					}
				}else{
					$error = 'Có lỗi trong quá trình thực hiện gao dịch. Mời bạn kiểu tra tham số cấu hình và enable các extendsion php cần thiết';
				}
			}
		}
		$params["error"] = $error;
         
        $this->render_template('scratch_card/index', $params);
	}

}