<?php
class Airline extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model("Airline_model", "airline");
    $this->session->userdata("logged_in") == TRUE ? "":redirect("/");
  }

  function index(){
    $this->load->view("airline/index");
  }

  private function _addData(){
    $data["form_action"] = site_url("airline/save");
    $data["name"] = array("name"=>"name");
    $data["address"] = array("name"=>"address");
    $data["phone"] = array("name"=>"phone");
    $data["fax"] = array("name"=>"fax");
    $data["email"] = array("name"=>"email");

    $data["cp_name1"] = array("name"=>"cp_name1");
    $data["cp_title1"] = array("name"=>"cp_title1");
    $data["cp_phone1"] = array("name"=>"cp_phone1");
    $data["cp_email1"] = array("name"=>"cp_email1");

    $data["cp_name2"] = array("name"=>"cp_name2");
    $data["cp_title2"] = array("name"=>"cp_title2");
    $data["cp_phone2"] = array("name"=>"cp_phone2");
    $data["cp_email2"] = array("name"=>"cp_email2");

    $data["submit"] = form_submit(array("name"=>"save", "value"=>"Save", "class"=>"btn btn-primary"));
    $data["back"] = anchor("airline/index", "Back", array("class"=>"btn btn-danger"));
    return $data;
  }

  function add(){
    $data = $this->_addData();
    $this->load->view("airline/form", $data);
  }

  function edit(){

  }

  function save(){
    $this->form_validation->set_rules(array(
      array("field"=>"name", "label"=>"Name", "rules"=>"required"),
      array("field"=>"address", "label"=>"Address", "rules"=>"required"),
      array("field"=>"phone", "label"=>"Phone", "rules"=>"required"),
      array("field"=>"fax", "label"=>"Fax", "rules"=>"required"),
      array("field"=>"email", "label"=>"Email", "rules"=>"required")
    ));
    $this->form_validation->set_message("required", "%s cannot be blank");
    if($this->form_validation->run() === false){
      $data = $this->_addData();
      $this->load->view("airline/form", $data);
    }else{
      $this->airline->add();
      redirect("airline/index");
    }
  }
}