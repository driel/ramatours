<?php
class Ticket_Agent extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->session->userdata("logged_in") == TRUE ? "":redirect("/");
    $this->load->model("Ticket_Agent_Model", "agent");
    
    $this->load->helper("gl_account");
  }
  
  function index(){
    filter_access("Ticket Agent", "view");
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
        $data["agents"] = $this->agent->search($by, $q);
      }else{
        $data["agents"] = $this->agent->get_all($order_by, strtoupper($order), $this->perpage, $this->offset);
      }
    }else{
      $data["agents"] = $this->agent->get_all($order_by, strtoupper($order), $this->perpage, $this->offset);
      $config = init_paginate(base_url("ticket_agent/index"), $this->agent->get_all()->num_rows(), $this->perpage);
      $config["suffix"] = '?'.http_build_query($_GET, '', "&");
      $this->pagination->initialize($config);
    }
    // toggle order ASC DESC
    $data["order"] = ($order == "asc" ? "desc":"asc");
    $this->load->view("ticket_agent/index", $data);
  }
  
  function add(){
    filter_access("Ticket Agent", "add");
    $data = $this->_addData();
    $this->load->view("ticket_agent/form", $data);
  }
  
  function edit($id){
    filter_access("Ticket Agent", "edit");
    $data = $this->_editData($id);
    $this->load->view("ticket_agent/form", $data);
  }
  
  function save(){
    filter_access("Ticket Agent", "add");
    $this->form_validation->set_rules(array(
        array("field"=>"code", "label"=>"Code", "rules"=>"required"),
        array("field"=>"name", "label"=>"Name", "rules"=>"required"),
        array("field"=>"limit_rp", "label"=>"Credit Limit (Rp)", "rules"=>"required"),
        array("field"=>"limit_us", "label"=>"Credit Limit (US)", "rules"=>"required"),
        array("field"=>"glacc_dr", "label"=>"GL Account DR", "rules"=>"required"),
        array("field"=>"glacc_cr", "label"=>"GL Account CR", "rules"=>"required"),
    ));
    $this->form_validation->set_message("required", "<i>%s</i> cannot be blank");
    if($this->form_validation->run() === false){
      $data = $this->_addData();
      $this->load->view("ticket_agent/form", $data);
    }else{
      $this->agent->add();
      $this->session->set_flashdata("message", "Ticket agent has been added.");
      redirect("ticket_agent/index");
    }
  }
  
  function update(){
    filter_access("Ticket Agent", "edit");
    $this->form_validation->set_rules(array(
        array("field"=>"code", "label"=>"Code", "rules"=>"required"),
        array("field"=>"name", "label"=>"Name", "rules"=>"required"),
        array("field"=>"limit_rp", "label"=>"Credit Limit (Rp)", "rules"=>"required"),
        array("field"=>"limit_us", "label"=>"Credit Limit (US)", "rules"=>"required"),
        array("field"=>"glacc_dr", "label"=>"GL Account DR", "rules"=>"required"),
        array("field"=>"glacc_cr", "label"=>"GL Account CR", "rules"=>"required"),
    ));
    $this->form_validation->set_message("required", "<i>%s</i> cannot be blank");
    if($this->form_validation->run() === false){
      $id = $this->input->post("id");
      $data = $this->_editData($id);
      $this->load->view("ticket_agent/form", $data);
    }else{
      $this->agent->update();
      $this->session->set_flashdata("message", "Ticket agent has been updated.");
      redirect("ticket_agent/index");
    }
  }
  
  function delete($id){
    filter_access("Ticket Agent", "delete");
    $this->agent->delete($id);
    redirect("ticket_agent/index");
  }
  
  function get_agent($agent){
    $agent = urldecode($agent);
    $agents =$this->agent->get_by("tixa_code", $agent);
    echo json_encode($agents->result());
  }
  
  // private functions
  
  private function _addData(){
    $data["id"] = null;
    $data["code"] = array("name"=>"code");
    $data["name"] = array("name"=>"name");
    $data["address"] = array("name"=>"address");
    $data["city"] = array("name"=>"city");
    $data["since"] = array("name"=>"since", "class"=>"datepicker");
    $data["disable_date"] = array("name"=>"disable_date", "class"=>"datepicker", "placeholder"=>"Disable on");
    $data["limit_rp"] = array("name"=>"limit_rp", "class"=>"auto-coma");
    $data["limit_us"] = array("name"=>"limit_us", "class"=>"auto-coma");
    $data["glacc_dr"] = form_input(array("id"=>"glacc_dr"));
    $data["glacc_cr"] = form_input(array("id"=>"glacc_cr"));
    $data["glacc_dr_hidden"] = form_input(array("name"=>"glacc_dr", "type"=>"hidden", "id"=>"glacc_dr_hidden"));
    $data["glacc_cr_hidden"] = form_input(array("name"=>"glacc_cr", "type"=>"hidden", "id"=>"glacc_cr_hidden"));
    
    $data["form_action"] = site_url("ticket_agent/save");
    $data["submit"] = form_submit(array("name"=>"save", "value"=>"Save", "class"=>"btn btn-primary"));
    $data["back"] = anchor("ticket_agent/index", "Back", array("class"=>"btn btn-danger"));
    
    return $data;
  }
  
  function _editData($id){
    $agent = $this->agent->get($id)->row();
    $account = new Account();
    $dr = $account->where("glacc_id", $agent->tixa_glacc_dr)->get();
    
    $account = new Account();
    $cr = $account->where("glacc_id", $agent->tixa_glacc_cr)->get();
    
    
    $data["id"] = form_hidden("id", $id);
    $data["code"] = array("name"=>"code", "value"=>$agent->tixa_code);
    $data["name"] = array("name"=>"name", "value"=>$agent->tixa_name);
    $data["address"] = array("name"=>"address", "value"=>$agent->tixa_address);
    $data["city"] = array("name"=>"city", "value"=>$agent->tixa_city);
    $data["since"] = array("name"=>"since", "class"=>"datepicker", "value"=>$agent->tixa_since);
    $data["disable_date"] = array("name"=>"disable_date", "class"=>"datepicker", "placeholder"=>"Disable on", "value"=>$agent->tixa_disable_date);
    $data["limit_rp"] = array("name"=>"limit_rp", "class"=>"auto-coma", "value"=>$agent->tixa_credit_limit_rp);
    $data["limit_us"] = array("name"=>"limit_us", "class"=>"auto-coma", "value"=>$agent->tixa_credit_limit_us);
    $data["glacc_dr"] = form_input(array("id"=>"glacc_dr", "value"=>$dr->glacc_no));
    $data["glacc_cr"] = form_input(array("id"=>"glacc_cr", "value"=>$cr->glacc_no));
    $data["glacc_dr_hidden"] = form_input(array("name"=>"glacc_dr", "type"=>"hidden", "id"=>"glacc_dr_hidden", "value"=>$agent->tixa_glacc_dr));
    $data["glacc_cr_hidden"] = form_input(array("name"=>"glacc_cr", "type"=>"hidden", "id"=>"glacc_cr_hidden", "value"=>$agent->tixa_glacc_cr));
    
    $data["form_action"] = site_url("ticket_agent/update");
    $data["submit"] = form_submit(array("name"=>"save", "value"=>"Save", "class"=>"btn btn-primary"));
    $data["back"] = anchor("ticket_agent/index", "Back", array("class"=>"btn btn-danger"));
    
    return $data;
  }
}