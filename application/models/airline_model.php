<?php
class Airline_model extends CI_Model{
  function add(){
    $this->db->insert("airline", array(
        "name"=>$this->input->post("name"),
        "address"=>$this->input->post("address"),
        "phone"=>$this->input->post("phone"),
        "fax"=>$this->input->post("fax"),
        "email"=>$this->input->post("email"),
        "contact_name1"=>$this->input->post("cp_name1"),
        "contact_title1"=>$this->input->post("cp_title1"),
        "contact_phone1"=>$this->input->post("cp_phone1"),
        "contact_email1"=>$this->input->post("cp_email1"),
        "contact_name2"=>$this->input->post("cp_name2"),
        "contact_title2"=>$this->input->post("cp_title2"),
        "contact_phone2"=>$this->input->post("cp_phone2"),
        "contact_email2"=>$this->input->post("cp_email2")
    ));
  }
}