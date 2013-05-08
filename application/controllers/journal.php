<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Journal extends CI_Controller {

    private $limit = 10;

    function __construct() {
        parent::__construct();
        $this->load->model("Journal_model","journal");
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
	        	$data["journal"] = $this->journal->list_where($q);
	      	}else{
	        	$data["journal"] = $this->journal->get_all($order_by, strtoupper($order), $this->perpage, $this->offset);
	      	}
	    }else{
	      	$data["journal"] = $this->journal->get_all("gltr_date", "ASC", $this->perpage, $this->offset);
	      	$config = init_paginate(base_url("fiscal/index"), $this->journal->get_all()->num_rows(), $this->perpage);
	      	$config["suffix"] = '?'.http_build_query($_GET, '', "&");
	      	$this->pagination->initialize($config);
	    }
	    // toggle order ASC DESC
	    $data["order"] = ($order == "asc" ? "desc":"asc");

    	$this->load->view('journal/index', $data);
    }

	private function _addData() {
        $data['title'] = 'Add Entry Journal';
        $data['form_action'] = site_url('journal/save');
        $data['link_back'] = anchor('fiscal/', 'Back', array('class' => 'btn btn-danger'));

        $data['act'] = "add";
        $data['kurs_id'] = "";
        $data["kurs_date"] = array("name"=>"kurs_date", "class"=>"datepicker");
        
        $data["kurs_us_rp"] = array('name' => 'kurs_us_rp');
        $data["kurs_yen_rp"] = array("name"=>"kurs_yen_rp");

        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');

		return $data;
	}

    function add() {
        //filter_access(__CLASS__, "add");
		$data = $this->_addData();

        $this->load->view('journal/form', $data);
    }

	private function _editData($id) {
        $kurs = $this->fiscal->get($id)->row();

	    $data["form_action"] = "journal/update";

        $data['title'] = 'Edit Entry Journal';
        $data['form_action'] = site_url('journal/save');
        $data['link_back'] = anchor('journal/', 'Back', array('class' => 'btn btn-danger'));

        $data['act'] = "edit";
        $data['kurs_id'] = $kurs->kurs_id;
        $data["kurs_date"] = array("name"=>"kurs_date", "class"=>"datepicker", "value"=>$kurs->kurs_date);

        $data["kurs_us_rp"] = array("name" => "kurs_us_rp", "value"=>$kurs->kurs_us_rp);
        $data["kurs_yen_rp"] = array("name"=>"kurs_yen_rp", "value"=>$kurs->kurs_yen_rp);

        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');

		return $data;
	}

    function edit($id) {
        //filter_access(__CLASS__, "edit");
		$data = $this->_editData($id);

        $this->load->view('journal/form', $data);
    }

    function save() {
        //filter_access(__CLASS__, "add");
	    $this->form_validation->set_rules(array(
		      array("field"=>"kurs_date", "label"=>"Kurs Date", "rules"=>"required"),
		      array("field"=>"kurs_us_rp", "label"=>"Kurs Dollar", "rules"=>"required"),
		      array("field"=>"kurs_yen_rp", "label"=>"Kurs Yen", "rules"=>"required")
	    ));

	    $this->form_validation->set_message("required", "%s cannot be blank");
	    if($this->form_validation->run() === false){
	      	if ($this->input->post("act") == "add") {
		  		$data = $this->_addData();
		  	} else {
		  		$data = $this->_editData();
		  	}
	      	$this->load->view("journal/form", $data);
	    }else{
	      	if ($this->input->post("act") == "add") {
	      		$this->fiscal->add();
		  	} else {
	      		$this->fiscal->update();
		  	}
	      	redirect("journal/index");
	    }
    }

    function delete($id) {
        //filter_access(__CLASS__, "delete");
        $this->fiscal->delete($id);

        $this->session->set_flashdata('message', 'Kurs pajak successfully deleted!');
        redirect('journal/');
    }

}