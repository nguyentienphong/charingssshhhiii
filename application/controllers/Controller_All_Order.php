<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_All_Order extends Admin_Controller 
{
	public function __construct()
	{
		
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		parent::__construct();

		$this->not_logged_in();
		
		// load Pagination library
		$this->load->library('pagination');
		
	   // load URL helper
	   $this->load->helper('url');

		$this->load->model('model_all_orders');
	}

	
	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
		session_start();
		$this->set_current_page();
		//$result = $this->model_all_orders->getTransactionData();
		$partner_username = $this->session->userdata('partner_username');
		//$this->data['results'] = $result;
        // init params
        $params = array();
		$params['page_title'] = 'Order Manage';
        $limit_per_page = 50;
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	
		$fromDate = "";
		$toDate = "";

		// $partner_username = isset($_POST['partnerUsrname']) ? $_POST['partnerUsrname'] : '';
		
		$partner_id = $this->session->userdata('partner_id');
		//$partner_id = '98000';
		
		$enableSearch = false;
		
		if ($_POST) {
			$this->form_validation->set_rules('fromDate', 'fromDate', 'trim');
			$this->form_validation->set_rules('toDate', 'toDate', 'trim');
			$this->form_validation->set_rules('order_name', 'order_name', 'trim|xss_clean');
			$this->form_validation->set_rules('order_status', 'order_status', 'trim|xss_clean');
			$this->form_validation->set_rules('Provider', 'Provider', 'trim|xss_clean');
			
			if ($this->form_validation->run()) {
				$enableSearch = true;
				//log_message('error', 'form_validation success: ' . print_r($this->input->post(), true));
				$fromDate = '';
				$toDate = '';
				
				if($this->input->post('fromDate') != null && $this->input->post('fromDate') != '')
					$fromDate = date("Y-m-d", strtotime($this->input->post('fromDate')));
				
				if($this->input->post('toDate') != null && $this->input->post('toDate') != '')
					$toDate = date("Y-m-d", strtotime($this->input->post('toDate')));
				
				if($this->input->post('toDate') !== '' && $this->input->post('fromDate') !== '') {
					$day_span_to_select = $this->calculateTwoDate($this->input->post('fromDate'),$this->input->post('toDate'));
					if(30 < $day_span_to_select || $day_span_to_select < 0) {
						echo "<script>
						alert('Khoang thoi gian can check='+$day_span_to_select +' ,qua gioi han hoac khong hop le');
						</script>";
						$enableSearch = false;
					}
				}
				
				$where = array();
				if($this->input->post('order_name') != '')
					$where['order_name'] = $this->input->post('order_name');
				if($this->input->post('order_status') != '')
					$where['order_status'] = $this->input->post('order_status');
				if($this->input->post('provider_code') != '')
					$where['provider_code'] = $this->input->post('provider_code');
				
			} else {
				print_r( $this->form_validation->error_array() );
				log_message('error', 'form_validation false: ' . print_r($this->form_validation->error_array(), true));
			}
		}
		log_message('error', 'enableSearch => ' . $enableSearch);
		if($enableSearch){
			$total_records = $this->model_all_orders->get_total_summary_order($partner_id,$fromDate,$toDate,$where);
			log_message('error', 'total_records => ' . $total_records);
		}else{
			$total_records = 0;
		}
		
		$config['base_url'] = base_url() . 'paging/config';
		
        if ($total_records > 0) 
        {
            // get current page records
			
            $arrResult = $this->model_all_orders->get_current_summary_order($limit_per_page, $start_index,$partner_id,$fromDate,$toDate,$where);
			 
			
			$params["results"] = $arrResult;
			$params["totalAmount"] = $this->calculateTotalAmount($arrResult);
            $config['base_url'] = base_url() . 'Controller_All_Order/index';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
            $this->pagination->initialize($config);
             
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }
         
		$this->render_template('all_order/index', $params);
		
	}
	
	public function detail($id){
		
		$params = array();
		$params['page_title'] = 'Order Manage';
		$partner_id = $this->session->userdata('partner_id');
		
		$params['order_info'] = $this->model_all_orders->get_oder_info($id,$partner_id);
		if($params['order_info']){
			// get list order detail
			$params['list_order_detail'] = $this->model_all_orders->get_list_order_detail($id);
		} else {
			redirect('Controller_All_Order');
		}
		
		$this->render_template('all_order/detail', $params);
	}


	public function calculateTotalAmount($arrResult)
	{
		$totalAmount = 0;
		foreach($arrResult as $data)
		{
			$totalAmount += $data->total_amount;
		}
		return $totalAmount;
	}



}