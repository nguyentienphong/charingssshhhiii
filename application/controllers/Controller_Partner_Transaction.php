<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Partner_Transaction extends Admin_Controller 
{
	public function __construct()
	{
		
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Total partner manager';

		// load Pagination library
		$this->load->library('pagination');
		
	   // load URL helper
	   $this->load->helper('url');

		$this->load->model('model_transactions');
	}

	
	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
		session_start();
		$this->set_current_page();
		//$result = $this->model_transactions->getTransactionData();
		$partner_username = $this->session->userdata('partner_username');
		//$this->data['results'] = $result;
        // init params
        $params = array();
        $limit_per_page = 50;
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	
		$fromDate = "";
		$toDate = "";

		// $partner_username = isset($_POST['partnerUsrname']) ? $_POST['partnerUsrname'] : '';
	
		$fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : '';
		$toDate = isset($_POST['toDate']) ? $_POST['toDate'] : '';
		
		$day_span_to_select = $this->calculateTwoDate($fromDate,$toDate);
		$enableSearch = true;
		if(30 < $day_span_to_select ||$day_span_to_select<0)
		{
			echo "<script>
			alert('Khoang thoi gian can check='+$day_span_to_select +' ,qua gioi han hoac khong hop le');
			</script>";
			$enableSearch = false;
		}

		if($enableSearch)
		{
			$total_records = $this->model_transactions->get_total_summary_rec($partner_username,$fromDate,$toDate);
		}else{
			$total_records = 0;
		}
		$config['base_url'] = base_url() . 'paging/config';
		
        if ($total_records > 0) 
        {
            // get current page records
            $arrResult = $this->model_transactions->get_current_summary_rep($limit_per_page, $start_index,$partner_username,$fromDate,$toDate);
			 
			
			$params["results"] = $arrResult;
			$params["totalAmount"] = $this->calculateTotalAmount($arrResult);
            $config['base_url'] = base_url() . 'Controller_Partner_Transaction/index';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
            $this->pagination->initialize($config);
             
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }
         
		$this->render_template('total_transactions/index', $params);
		
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

	/*
	* It checks if it gets the brand id and retreives
	* the brand information from the brand model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchBrandDataById($id)
	{
		if($id) {
			$data = $this->model_brands->getBrandData($id);
			echo json_encode($data);
		}

		return false;
	}

	/*
	* Its checks the brand form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{

		if(!in_array('createBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('brand_name', 'Item name', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('brand_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_brands->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the brand information';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);

	}

	/*
	* Its checks the brand form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id)
	{
		if(!in_array('updateBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_brand_name', 'Item name', 'trim|required');
			$this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'name' => $this->input->post('edit_brand_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_brands->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the brand information';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}

		echo json_encode($response);
	}

	/*
	* It removes the brand information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('deleteBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$brand_id = $this->input->post('brand_id');
		$response = array();
		if($brand_id) {
			$delete = $this->model_brands->remove($brand_id);

			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the brand information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

}