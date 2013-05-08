<?php
class Ticket_Agent extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->session->userdata("logged_in") == TRUE ? "":redirect("/");
    $this->load->model("Ticket_Agent_Model", "agent");
  }
  
  function index(){
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
    $data = $this->_addData();
    $this->load->view("ticket_agent/form", $data);
  }
  
  function edit(){
    
  }
  
  function save(){
    $this->agent->add();
  }
  
  function get_agent($agent){
    $agent = urldecode($agent);
    $agents =$this->agent->get_by("tixa_name", $agent);
    echo json_encode($agents->result());
  }
  
  // private functions
  
  private function _addData(){
    $data["code"] = array("name"=>"code");
    $data["name"] = array("name"=>"name");
    $data["address"] = array("name"=>"address");
    $data["city"] = array("name"=>"city");
    $data["since"] = array("name"=>"since", "class"=>"datepicker");
    $data["disable_date"] = array("name"=>"disable_date", "class"=>"datepicker", "placeholder"=>"Disable on");
    $data["limit_rp"] = array("name"=>"limit_rp", "class"=>"auto-coma");
    $data["limit_us"] = array("name"=>"limit_us", "class"=>"auto-coma");
    $data["glacc_dr"] = form_input(array("name"=>"glacc_dr"));
    $data["glacc_cr"] = form_input(array("name"=>"glacc_cr"));
    
    $data["form_action"] = site_url("ticket_agent/save");
    $data["submit"] = form_submit(array("name"=>"save", "value"=>"Save", "class"=>"btn btn-primary"));
    $data["back"] = anchor("ticket_agent/index", "Back", array("class"=>"btn btn-danger"));
    
    return $data;
  }
}