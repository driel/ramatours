<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fiscal extends CI_Controller {

    private $limit = 10;

    function __construct() {
        parent::__construct();
        $this->load->model("Fiscal_model","fiscal");
        $this->load->helper("bulan");
        $this->sess_username = $this->session->userdata('username');
        $this->sess_role_id = $this->session->userdata('sess_role_id');
        $this->sess_staff_id = $this->session->userdata('sess_staff_id');
        $this->session->userdata('logged_in') == true ? '' : redirect('users/sign_in');
    }

	public function index($offset = 0) {
        //filter_access(__CLASS__, "view");

	    $tp = $this->input->get("to_page");
	    if(strlen($tp)){
	      	$this->session->set_userdata(array("to_page"=>$tp));
	    }
	    $this->perpage = ($this->session->userdata("to_page") > 0 ? $this->session->userdata("to_page"):10);
	    // order by
	    $order_by = $this->input->get("order_by");
	    $order = $this->input->get("order");
	    $q = $this->input->get("q");
	    $by = $this->input->get("search_by");
	    $this->offset = $this->uri->segment(3);
	    if(strlen($q)){
	      	if(strlen($by)){
	        	$data["fiscal"] = $this->fiscal->get_all($order_by, strtoupper($order), $this->perpage, $this->offset);
	      	}
	    }else{
	      	$data["fiscal"] = $this->fiscal->get_all("fiskal_date", "ASC", $this->perpage, $this->offset);
	      	$config = init_paginate(base_url("fiscal/index"), $this->fiscal->get_all()->num_rows(), $this->perpage);
	      	$config["suffix"] = '?'.http_build_query($_GET, '', "&");
	      	$this->pagination->initialize($config);
	    }
	    // toggle order ASC DESC
	    $data["order"] = ($order == "asc" ? "desc":"asc");

    	$this->load->view('fiscal/index', $data);
    }

	private function _addData() {
        $data['title'] = 'Add Fiscal';
        $data['form_action'] = site_url('fiscal/save');
        $data['link_back'] = anchor('fiscal/', 'Back', array('class' => 'btn btn-danger'));

        $data['act'] = "add";
        $data['id'] = "";

		// Year Period
        $years = array();
		for($i=date('Y'); $i>(date('Y')-5); $i--) {
	  		$years[$i] = $i;
	  	}

        $data['period_year'] = form_dropdown('period_year',
                        $years,
                        '');

		// Monthly Period
        $list_period = array();
		for ($i=1; $i<=12; $i++) {
            if ($i < 10) { $i = '0'.$i; }
            $list_period[$i] = bulan_full($i);
        }
        
        $data['period_month'] = form_dropdown('period_month',
                        $list_period,
                        '');
        
        $data["fiskal_status"] = form_checkbox(array('name'=>'fiskal_status', 'id'=>'fiskal_status'));
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');

		return $data;
	}

    function add() {
        //filter_access(__CLASS__, "add");
		$data = $this->_addData();

        $this->load->view('fiscal/form', $data);
    }

	private function _editData($fiscal_date) {
        $data['title'] = 'Add Fiscal';
        $data['form_action'] = site_url('fiscal/save');
        $data['link_back'] = anchor('fiscal/', 'Back', array('class' => 'btn btn-danger'));

		$fiscal = $this->fiscal->get($fiscal_date)->row();

        $data['act'] = "edit";
        $data['id'] = $fiscal->fiskal_date;

		// Year Period
        $years = array();
		for($i=date('Y'); $i>(date('Y')-5); $i--) {
	  		$years[$i] = $i;
	  	}

        $data['period_year'] = form_dropdown('period_year',
                        $years,
                        substr($fiscal->fiskal_date,0,4),"disabled=disabled");

		// Monthly Period
        $list_period = array();
		for ($i=1; $i<=12; $i++) {
            if ($i < 10) { $i = '0'.$i; }
            $list_period[$i] = bulan_full($i);
        }
        
        $data['period_month'] = form_dropdown('period_month',
                        $list_period,
                        substr($fiscal->fiskal_date,4),"disabled=disabled");
        
        $status_selected = $fiscal->fiskal_status == 'Open' ? TRUE:FALSE;
        $data["fiskal_status"] = form_checkbox(array('name'=>'fiskal_status', 'id'=>'fiskal_status', 'checked'=>$status_selected));
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');

		return $data;
	}

    function edit($fiskal_date) {
        //filter_access(__CLASS__, "add");
		$data = $this->_editData($fiskal_date);

        $this->load->view('fiscal/form', $data);
    }

    function save() {
        //filter_access(__CLASS__, "add");
	    $this->form_validation->set_rules(array(
		      array("field"=>"period_month", "label"=>"Period Month", "rules"=>"required"),
		      array("field"=>"period_year", "label"=>"Period Year", "rules"=>"required")
	    ));

	    $this->form_validation->set_message("required", "%s cannot be blank");
	    if($this->form_validation->run() === false){
	      	if ($this->input->post("act") == "add") {
		  		$data = $this->_addData();
		  	} else {
		  		$data = $this->_editData();
		  	}
	      	$this->load->view("fiscal/form", $data);
	    }else{
	      	if ($this->input->post("act") == "add") {
	      		$this->fiscal->add();
		  	} else {
	      		$this->fiscal->update();
		  	}
	      	redirect("fiscal/index");
	    }
    }

    function delete($id) {
        //filter_access(__CLASS__, "delete");
        $this->fiscal->delete($id);

        $this->session->set_flashdata('message', 'Fiscal successfully deleted!');
        redirect('fiscal/');
    }

}