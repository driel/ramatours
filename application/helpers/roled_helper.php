<?php
function get_roled($role_id, $module_id){
  $ci = &get_instance();
  $roled = $ci->db->get_where("user_roled", array(
    "role_id"=>$role_id,
    "module_id"=>$module_id
  ));
  return $roled;
}