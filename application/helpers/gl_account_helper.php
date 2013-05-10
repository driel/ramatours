<?php
function get_account_detail($id){
  $ci = &get_instance();
  return $ci->db->get_where("chart_of_account", array("glacc_id"=>$id))->row();
}