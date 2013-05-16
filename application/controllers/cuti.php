<?php
class Cuti extends CI_Controller{
  private $perpage = 50;
  function __construct(){
    parent::__construct();
    $this->load->model("Cuti_model", "cuti");
    $this->load->helper("staff");
    $this->load->helper("cuti");
    $this->load->helper("branch");
    $this->load->helper("dept");
  }
  
  function index(){
    filter_access("Cuti Transaction", "view");
    // view to page
    $tp = $this->input->get("to_page");
    if(strlen($tp)){
      $this->session->set_userdata(array("to_page"=>$tp));
    }
    $this->perpage = $this->session->userdata("to_page") > 0 ? $this->session->userdata("to_page"):50;
    // order by
    $order_by = $this->input->get("order_by");
    $order = $this->input->get("order");
    $q = $this->input->get("q");
    $by = $this->input->get("search_by");
    $this->offset = $this->uri->segment(3);
    if(strlen($q)){
      if(strlen($by)){
        $data["cuti"] = $this->cuti->search($by, $q);
      }else{
        $data["cuti"] = $this->cuti->get_all($order_by, strtoupper($order), $this->perpage, $this->offset);
      }
    }else{
      $data["cuti"] = $this->cuti->get_all($order_by, strtoupper($order), $this->perpage, $this->offset);
      $config = init_paginate(base_url("staffs/index"), $this->cuti->get_all()->num_rows(), $this->perpage);
      $config["suffix"] = '?'.http_build_query($_GET, '', "&");
      $this->pagination->initialize($config);
    }
    // toggle order ASC DESC
    $data["order"] = ($order == "asc" ? "desc":"asc");
    
    $this->load->view("cuti/index", $data);
  }
  
  private function _newData(){
    $data["form_action"] = "cuti/create";
    $data["id"] = null;
    $data["staff_id"] = null;
    $data["approve_staff_id"] = null;
    $data["status_selected"] = null;
    $data["comment"] = null;
    $data["staff_name"] = array("name"=>"staff_name", "id"=>"staff");
    $data["approveby_staff_id"] = getApproval("Cuti_Transaction");
    $data["date_request"] = array("name"=>"date_request", "class"=>"datepicker");
    $data["date_start"] = array("name"=>"date_start", "class"=>"datepicker");
    $data["date_end"] = array("name"=>"date_end", "class"=>"datepicker");
    $data["status"] = array("pending"=>"Pending", "approve"=>"Approve", "decline"=>"Decline");
    return $data;
  }
  
  private function _editData($id){
    $cuti = $this->cuti->get($id)->row();
    $staff = get_staff_detail($cuti->staff_id);
    $detail = $this->cuti->getDetail($cuti->id)->row();
    $data["form_action"] = "cuti/update";
    $data["id"] = $cuti->id;
    $data["staff_id"] = $cuti->staff_id;
    $data["staff_name"] = array("name"=>"staff_name", "id"=>"staff", "value"=>$staff->staff_name);
    $data["approveby_staff_id"] = getApproval("Cuti_Transaction");
    $data["approve_staff_id"] = $cuti->approveby_staff_id;
    $data["date_request"] = array("name"=>"date_request", "class"=>"datepicker", "value"=>$cuti->date_request);
    $data["date_start"] = array("name"=>"date_start", "class"=>"datepicker", "value"=>$cuti->date_start);
    $data["date_end"] = array("name"=>"date_end", "class"=>"datepicker", "value"=>$cuti->date_end);
    $data["status"] = array("pending"=>"Pending", "approve"=>"Approve", "decline"=>"Decline");
    $data["status_selected"] = $cuti->status;
    $data["comment"] = $detail->comment;
    return $data;
  }
  
  function add(){
    filter_access("Cuti Transaction", "add");
    $data = $this->_newData();
    $this->load->view("cuti/form", $data);
  }
  
  function edit($id){
    filter_access("Cuti Transaction", "edit");
    $data = $this->_editData($id);
    $this->load->view("cuti/form", $data);
  }
  
  function update_status(){
    filter_access("Cuti Transaction", "view");
    $this->cuti->update_status();
    redirect("cuti/index");
  }
  
  function create(){
    filter_access("Cuti Transaction", "save");
    $this->form_validation->set_rules(array(
      array("field"=>"staff_name", "label"=>"Staff name", "rules"=>"required"),
      array("field"=>"approveby_staff_id", "label"=>"Approve by", "rules"=>"required")
    ));
    if($this->form_validation->run()===false){
      $data = $this->_newData();
      $this->load->view("cuti/form", $data);
    }else{
      $this->cuti->add();
      redirect("cuti/index");
    }
  }
  
  function update(){
    filter_access("Cuti Transaction", "edit");
    $this->form_validation->set_rules(array(
      array("field"=>"staff_name", "label"=>"Staff name", "rules"=>"required"),
      array("field"=>"approveby_staff_id", "label"=>"Approve by", "rules"=>"required")
    ));
    if($this->form_validation->run()===false){
      $data = $this->_editData();
      $this->load->view("cuti/form", $data);
    }else{
      $this->cuti->update();
      redirect("cuti/index");
    }
  }
  
  function delete($id){
    filter_access("Cuti Transaction", "delete");
    $this->db->delete("cuti", array("id"=>$id));
    $this->db->delete("cuti_detail", array("cuti_id"=>$id));
    redirect("cuti/index");
  }
  
  function report(){
    switch ($this->input->get('c')) {
      case "1":
          $data['col'] = "staff_id";
          break;
      case "2":
          $data['col'] = "date_request";
          break;
      case "3":
          $data['col'] = "date_start";
          break;
      case "4":
          $data['col'] = "date_end";
          break;
      default:
          $data['col'] = "staff_id";
    }

    if ($this->input->get('d') == "1") {
        $data['dir'] = "DESC";
    } else {
        $data['dir'] = "ASC";
    }
    $total_rows = $this->cuti->get_all()->num_rows();
    $data['title'] = "Izin";
    $data['btn_add'] = anchor('cuti/add', 'Add New', array('class' => 'btn btn-primary'));
    $data['btn_home'] = anchor(base_url(), 'Home', array('class' => 'btn'));

    $uri_segment = 3;
    $offset = $this->uri->segment($uri_segment);

	$where = array();
	if ($this->input->get("staff_cabang") != "") {
		$where['staff_cabang'] = $this->input->get("staff_cabang");
	}

	if ($this->input->get("staff_departement") != "") {
		$where['staff_departement'] = $this->input->get("staff_departement");
	}

	if ($this->input->get("staff_jabatan") != "") {
		$where['staff_jabatan'] = $this->input->get("staff_jabatan");
	}

	if ($this->input->get("staff_name") != "") {
		$where['staff_name'] = $this->input->get("staff_name");
	}

    $data['cuti'] = $this->cuti->list_where($where);
    
    // update status purpose
    $data["status"] = array(
      "pending"=>"Pending",
      "approve"=>"Approve",
      "decline"=>"Decline"
    );

	// Branch
    $branch = new Branch();
    $list_branch = $branch->list_drop();
    $branch_selected = $this->input->get('staff_cabang');
    $data['staff_cabang'] = form_dropdown('staff_cabang',
                    $list_branch,
                    $branch_selected);

	// Departement
    $dept = new Department();
    $list_dpt = $dept->list_drop();
    $dpt_selected = $this->input->get('staff_departement');
    $data['staff_departement'] = form_dropdown('staff_departement',
                    $list_dpt,
                    $dpt_selected);

	//Jabatan
    $title = new Title();
    $list_jbt = $title->list_drop();
    $jbt_selected = $this->input->get('staff_jabatan');
    $data['staff_jabatan'] = form_dropdown('staff_jabatan',
                    $list_jbt,
                    $jbt_selected);

	$data['staff_name'] = array('name' => 'staff_name', 'value' => $this->input->get('staff_name'));

	if ($this->input->get('to') == 'pdf') {
		$this->load->library('html2pdf');

		$this->html2pdf->filename = 'cuti_report.pdf';
    	$this->html2pdf->paper('a4', 'landscape');
    	$this->html2pdf->html($this->load->view("cuti/to_pdf", $data, true));
	    
    	$this->html2pdf->create();
	} else if ($this->input->get('to') == 'xls') {
		$param['file_name'] = 'cuti_report.xls';
		$param['content_sheet'] = $this->load->view('cuti/to_pdf', $data, true);
		$this->load->view('to_excel',$param);
	} else if($this->input->get('to') == 'print'){
    	$this->load->view('cuti/to_pdf', $data);
    } else {
	    $config['base_url'] = site_url("cuti/index");
	    $config['total_rows'] = $total_rows;
	    $config['per_page'] = $this->limit;
	    $config['uri_segment'] = $uri_segment;
	    $this->pagination->initialize($config);
	    $data['pagination'] = $this->pagination->create_links();
    
    	$data["comment"] = array("name"=>"comment", "id"=>"comment");
    
    	$this->load->view("cuti/report", $data);
    }
  }
}