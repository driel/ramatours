<?php
class Ticket_Agent extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->session->userdata("logged_in") == TRUE ? "":redirect("/");
  }
  
  function index(){
    $this->load->view("ticket_agent/index");
  }
  
  function add(){
    $data["code"] = array("name"=>"code");
    $data["name"] = array("name"=>"name");
    $data["address"] = array("name"=>"address");
    $data["city"] = array("name"=>"city");
    $data["since"] = array("name"=>"since", "class"=>"datepicker");
    $data["disable_date"] = array("name"=>"disable_date", "class"=>"datepicker", "placeholder"=>"Disable on");
    $data["limit_rp"] = array("name"=>"limit_rp", "class"=>"auto-coma");
    $data["limit_us"] = array("name"=>"limit_us", "class"=>"auto-coma");
    $this->load->view("ticket_agent/form", $data);
  }
}