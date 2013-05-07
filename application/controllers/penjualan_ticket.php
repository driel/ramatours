<?php
class Penjualan_Ticket extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model("Ticket_Agent_Model", "agent");
  }
  
  function index(){
    
  }
  
  function add(){
    $data = $this->_addData();
    $this->load->view("penjualan_ticket/form", $data);
  }
  
  function edit(){
      
  }
  
  function save(){
    
  }
  
  function update(){
    
  }
  
  function delete(){
    
  }
  
  // private functions
  private function _addData(){
    $agents = $this->agent->populate();
    
    $data["branch"] = form_hidden('branch', $this->session->userdata('branch'));
    $data["staff_id"] = form_hidden("staff_id", $this->session->userdata('sess_staff_id'));
    $data["tour_id"] = array("name"=>"tour_id");
    $data["invoice_no"] = array("name"=>"invoice_no");
    $data["date"] = array("name"=>"date", "class"=>"datepicker");
    $data["agent_id"] = form_dropdown("agent_id");
    $data["name"] = form_dropdown("ticket_agent", $agents);
    $data["address"] = form_textarea(array("name"=>"address"));
    $data["due_date"] = form_input(array("name"=>"due_date", "class"=>"datepicker"));
    $data["biaya_surcharge_rp"] = form_input(array("name"=>"biaya_surcharge_rp", "class"=>"auto-coma", "style"=>"margin:0!important"));
    $data["kurs_pajak"] = form_input(array("name"=>"kurs_pajak"));
    $data["glacc_dr"] = array("name"=>"glacc_dr");
    $data["glacc_cr"] = array("name"=>"glacc_cr");
    
    $data["form_action"] = site_url("penjualan_ticket/save");
    $data["submit"] = form_submit(array("name"=>"save", "value"=>"Save", "class"=>"btn btn-primary"));
    $data["back"] = anchor("penjualan_ticket/index", "Back", array("class"=>"btn btn-danger"));
    return $data;
  }
}