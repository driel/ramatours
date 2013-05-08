<?php
function get_agent_detail($id){
  $ci = &get_instance();
  $agent = $ci->db->get_where("ticket_agent", array("tixa_id"=>$id));
  return $agent->row();
}