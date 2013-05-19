<?php
function get_marital_detail($id){
  $ci = &get_instance();
  $marital = $ci->db->get_where("maritals_status", array("sn_id"=>$id));
  return $marital->row();
}