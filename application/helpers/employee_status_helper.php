<?php
function get_employee_status_detail($id){
  $ci = &get_instance();
  $emp_status = $ci->db->get_where("employees_status", array("sk_id"=>$id));
  return $emp_status->row();
}