<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Journal extends CI_Controller {

    private $limit = 10;

    function __construct() {
        parent::__construct();
        $this->load->helpers(array("journal","bulan"));
        $this->load->model("Journal_model","journal");
        $this->sess_username = $this->session->userdata('username');
        $this->sess_role_id = $this->session->userdata('sess_role_id');
        $this->sess_staff_id = $this->session->userdata('sess_staff_id');
        $this->session->userdata('logged_in') == true ? '' : redirect('users/sign_in');
    }

	public function index($offset = 0) {
        //filter_access(__CLASS__, "view");

		$this->session->set_flashdata('message', '');

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
	      	$data["journal"] = $this->journal->get_all("gltr_date", "DESC", $this->perpage, $this->offset);
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
        $data['link_back'] = anchor('journal/', 'Back', array('class' => 'btn btn-danger'));

        $data['act'] = "add";
        $data['gltr_id'] = "";
        $data["gltr_date"] = form_hidden("gltr_date", date("Ym"));
        $data["gltr_date_display"] = array("name"=>"gltr_date_display", "value"=>bulan_full(date("m"))." ".date("Y"), "disabled=disabled");
        $data["gltr_voucher"] = array('name' => "gltr_voucher");

        $account = new Account();
        $list_account = $account->list_drop_accno();
        $data["gltr_accno"] = form_dropdown('gltr_accno[]', $list_account, "");
        $data["gltr_keterangan"] = array('name' => "gltr_keterangan[]");
        $data["gltr_rti"] = array('name' => "gltr_rti[]");
        $data["gltr_dr"] = array('name' => "gltr_dr[]");
        $data["gltr_cr"] = array('name' => "gltr_cr[]");

        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');

		return $data;
	}

    function add() {
        //filter_access(__CLASS__, "add");
		$data = $this->_addData();

        $this->load->view('journal/form', $data);
    }

	private function _editData($id) {
        $gltr = $this->journal->get($id)->row();

	    $data["form_action"] = "journal/update";

        $data['title'] = 'Edit Entry Journal';
        $data['form_action'] = site_url('journal/save');
        $data['link_back'] = anchor('journal/', 'Back', array('class' => 'btn btn-danger'));

        $data['act'] = "edit";
        $data['gltr_id'] = $gltr->gltr_id;
        $data["gltr_date"] = form_hidden("gltr_date", $gltr->gltr_date);
        $data["gltr_date_display"] = array("name"=>"gltr_date_display", "value"=>bulan_full(substr($gltr->gltr_date,4))." ".substr($gltr->gltr_date,0,4), "disabled=disabled");
        $data["gltr_voucher"] = array("name" => "gltr_voucher", "value"=>$gltr->gltr_voucher);

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
		      array("field"=>"gltr_date", "label"=>"Date", "rules"=>"required"),
		      array("field"=>"gltr_voucher", "label"=>"Voucher", "rules"=>"required"),
		      array("field"=>"tot_debit", "label"=>"Total Debit", "rules"=>"required|matches[tot_credit]")
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
	      		$gltr_id = $this->journal->add();
	      		$this->_saveDetail($gltr_id);
		  	} else {
	      		$this->journal->update();
	      		$this->_saveDetail($this->input->post("gltr_id"));
		  	}
	      	redirect("journal/index");
	    }
    }
    
    private function _saveDetail($gltr_id){
      	$detail = $this->input->post("journal_detail");
      	if(is_array($detail)){
        	foreach($detail as $jd){
          		list($id, $account, $desc, $rti, $debit, $credit) = explode(";", $jd);
          		$acc = explode("-",$account);
          		if (($id == "undefined" || $id == "") && (($account != "null" && ($account != "undefined" || $account != "")) && (($debit != "undefined" || $debit != "") || ($credit != "undefined" || $credit != "")))) {
            		$this->db->insert("journal_detail", array("gltr_id"=>$gltr_id,"gltr_accno"=>ltrim(rtrim($acc[0])),"gltr_rti"=>$rti == "undefined"?"":$rti,"gltr_keterangan"=>$desc == "undefined"?"":$desc,"gltr_dr"=>$debit,"gltr_cr"=>$credit));
          		}
        	}
      	}
    }

    function update() {
        //filter_access(__CLASS__, "add");
  		$this->journal->update();
  		$this->_saveDetail($this->input->post("gltr_id"));
      	redirect("journal/index");
    }

    function delete($id) {
        //filter_access(__CLASS__, "delete");
        $this->journal->delete($id);

        $this->session->set_flashdata('message', 'Kurs pajak successfully deleted!');
        redirect('journal/');
    }
    
    function get_coa(){
      	$account = new Account();
      	$accounts = $account->get()->all;
      	$data = array();
      	$i = 0;
      	foreach($accounts as $x){
        	$data[$i]["glacc_no"] = $x->glacc_no;
        	$data[$i]["glacc_name"] = $x->glacc_no.' - '.$x->glacc_name;
        	$i++;
      	}
      	echo json_encode($data);
    }
    
    function get_where_account() {
      	$acc = explode(" ",urldecode($this->uri->segment(3)));
      	
      	$account = new Account();
      	$acct = $account->where("glacc_no", $acc[0])->get();
      	$accts = array("glacc_no"=>$acct->glacc_no, "glacc_name"=>$acct->glacc_name);
      	echo json_encode($accts);
    }
    
    function update_journal_detail(){
       	$id = $this->input->post("id");
       	$account = $this->input->post("account");
       	$acc = explode("-",$account);
       	$desc = $this->input->post("description");
       	$rti = $this->input->post("rti");
       	$debit = $this->input->post("debit");
       	$credit = $this->input->post("credit");

		$this->db->update("journal_detail",array("gltr_accno"=>ltrim(rtrim($acc[0])),"gltr_rti"=>$rti,"gltr_keterangan"=>$desc,"gltr_dr"=>$debit,"gltr_cr"=>$credit),array("id"=>$id));
    }
    
    function delete_journal_detail($id){
      $this->db->delete("journal_detail", array("id"=>$id));
    }

	function post() {
        $data['title'] = 'Posting Journal';
        $data['form_action'] = site_url('journal/post');
        $data['link_back'] = anchor('/', 'Back', array('class' => 'btn btn-danger'));

		// Year Period
        $years = array();
		for($i=date('Y'); $i>(date('Y')-5); $i--) {
	  		$years[$i] = $i;
	  	}

        $data['period_year'] = form_dropdown('period_year',
                        $years,
                        $this->input->post("period_year"));

		// Monthly Period
        $list_period = array();
		for ($i=1; $i<=12; $i++) {
            if ($i < 10) { $i = '0'.$i; }
            $list_period[$i] = bulan_full($i);
        }
        
        $data['period_month'] = form_dropdown('period_month',
                        $list_period,
                        $this->input->post("period_month"));
        
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Post', 'class' => 'btn btn-primary');

		if ($_POST) {
			$this->load->model("Fiscal_model","fiscal");			
        	$thf = $this->fiscal->get($this->input->post("period_year").$this->input->post("period_month"))->row();
        	if ($thf->fiskal_status == "Close") {
        		$this->session->set_flashdata('message', 'Journal has been closed for that period!');
        	} else {
        		if (posting_journal($this->input->post("period_year").$this->input->post("period_month"))) {
					redirect("/");
				}
        	}
		}

        $this->load->view('journal/post', $data);
	}

}