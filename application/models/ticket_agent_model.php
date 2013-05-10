<?php
class Ticket_Agent_Model extends CI_Model{
  function get_all($order_by = 'tixa_code', $order = "ASC", $per_page = 0, $offset = 0){
    $order_by = strlen($order_by) ? $order_by:"tixa_code";
    if($per_page == 0 && $offset == 0){
      $bank = $this->db->order_by($order_by, $order)->get("ticket_agent");
    }else{
      $bank = $this->db->order_by($order_by, $order)->get("ticket_agent", $per_page, $offset);
    }
    return $bank;
  }
  
  function get($id){
    return $this->db->get_where("ticket_agent", array("tixa_id"=>$id));
  }
  
  function search($by, $key){
    return $this->db->like($by, $key)->get("ticket_agent");
  }
  
  function populate(){
    $agents = $this->db->select("tixa_name AS name")->get("ticket_agent");
    $list[""] = "[Select agent]";
    foreach($agents->result() as $agent){
      $list[$agent->name] = $agent->name;
    }
    return $list;
  }
  
  function get_by($field = "tixa_name", $val = ""){
    return $this->db->like($field, $val)->get("ticket_agent");
  }

  function add(){
    $this->db->insert("ticket_agent", array(
        "tixa_code"=>$this->input->post("code"),
        "tixa_name"=>$this->input->post("name"),
        "tixa_address"=>$this->input->post("address"),
        "tixa_city"=>$this->input->post("city"),
        "tixa_since"=>$this->input->post("since"),
        "tixa_disable_date"=>$this->input->post("disable_date"),
        "tixa_credit_limit_rp"=>str_replace(",", "", $this->input->post("limit_rp")),
        "tixa_credit_limit_us"=>str_replace(",", "", $this->input->post("limit_us")),
        "tixa_glacc_dr"=>$this->input->post("glacc_dr"),
        "tixa_glacc_cr"=>$this->input->post("glacc_cr")
    ));
  }
  
  function update(){
    $id = $this->input->post("id");
    $this->db->update("ticket_agent", array(
        "tixa_code"=>$this->input->post("code"),
        "tixa_name"=>$this->input->post("name"),
        "tixa_address"=>$this->input->post("address"),
        "tixa_city"=>$this->input->post("city"),
        "tixa_since"=>$this->input->post("since"),
        "tixa_disable_date"=>$this->input->post("disable_date"),
        "tixa_credit_limit_rp"=>str_replace(",", "", $this->input->post("limit_rp")),
        "tixa_credit_limit_us"=>str_replace(",", "", $this->input->post("limit_us")),
        "tixa_glacc_dr"=>$this->input->post("glacc_dr"),
        "tixa_glacc_cr"=>$this->input->post("glacc_cr")
    ), array("tixa_id"=>$id));
  }
  
  function delete($id){
    $this->db->delete("ticket_agent", array("tixa_id"=>$id));
  }
}