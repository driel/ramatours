<?php
function get_dept_detail($id){
  $ci = &get_instance();
  $branch = $ci->db->get_where("departments", array("dept_id"=>$id));
  return $branch->row();
}