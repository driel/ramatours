<?php
function get_branch_detail($id){
  $ci = &get_instance();
  $branch = $ci->db->get_where("branches", array("branch_id"=>$id));
  return $branch->row();
}