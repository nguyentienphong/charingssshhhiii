<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_transaction extends Admin_Controller 
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
		if(!$this->IsNullOrEmptyString($partner_username))
		{
			$requestId = "";
			$fromDate = "";
			$toDate = "";
			$serial = "";
			$pin = "";
			$finalStatus = "";
			
			if (!isset($_SESSION['HasSearched'])) {
				$_SESSION['HasSearched'] = 0;
			}
			# start of page:
			if (isset($_POST['submit'])) {
				$_SESSION['HasSearched'] = 0;
			}
			# when you execute code for displaying search results
			# check first if the session has been set:
			if ($_SESSION['HasSearched'] == 0) {
				# proceed with search code
				# then set it to 1 since a search has been performed just now
				$_SESSION['HasSearched'] = 1;
	
				//$partner_username = isset($_POST['partnerUsrname']) ? $_POST['partnerUsrname'] : '';
				$requestId =  isset($_POST['requestId']) ? $_POST['requestId'] : '';
				$fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : '';
				$toDate = isset($_POST['toDate']) ? $_POST['toDate'] : '';
				$serial = isset($_POST['serial']) ? $_POST['serial'] : '';
				$pin = isset($_POST['pin']) ? $_POST['pin'] : '';
				$finalStatus = isset($_POST['slFinalStatus']) ? $_POST['slFinalStatus'] : '';
	
				$_arrSearchValues = array($partner_username, $requestId, $fromDate,$toDate,$serial,$pin,$finalStatus);
				$_SESSION['storeValues'] = $_arrSearchValues;
			} else {
				# this means a search had been previously made.
				# based on your requirement, no results should be displayed
				# since the assumption would be that a new search would be put in place
	
				# code to display fresh page with search form goes here
				# reset the session variable's value
				//$_SESSION['HasSearched'] = 0;
				$partner_username = $_SESSION['storeValues'][0];
				$requestId =  $_SESSION['storeValues'][1];
				$fromDate = $_SESSION['storeValues'][2];
				$toDate = $_SESSION['storeValues'][3];
				$serial = $_SESSION['storeValues'][4];
				$pin = $_SESSION['storeValues'][5];
				$finalStatus = $_SESSION['storeValues'][6];
			}
			//$partner_username = $this->session->userdata('partner_username');
			//$this->data['results'] = $result;
			
			$limit_per_page = 50;
			
			$start_index =  (int)($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			
		
			$total_records = $this->model_transactions->countTransactionData($partner_username,$requestId,$serial,$pin, $fromDate, $toDate,$finalStatus);
			$config['base_url'] = base_url() . 'paging/config';
			
			if ($total_records > 0) 
			{
				// get current page records
				$params["results"] = $this->model_transactions->selectTransactionPaging($limit_per_page, $start_index,$partner_username,$requestId,$serial,$pin,$fromDate, $toDate,$finalStatus);
				 
				$config['base_url'] = base_url() . 'Controller_transaction/index';
				$config['total_rows'] = $total_records;
				$config['per_page'] = $limit_per_page;
				$config["uri_segment"] = 3;
				 
				$this->pagination->initialize($config);
				 
				// build paging links
				$params["links"] = $this->pagination->create_links();
			}
		}
		
         
        $this->render_template('transactions/index', $params);
	}

}