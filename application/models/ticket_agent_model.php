<?php
class Ticket_Agent_Model extends CI_Model{
  function populate(){
    $agents = $this->db->select("tixa_name AS name")->get("ticket_agent");
    $list[""] = "[Select agent]";
    foreach($agents->result() as $agent){
      $list[$agent->name] = $agent->name;
    }
    return $list;
  }
}