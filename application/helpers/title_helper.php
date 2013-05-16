<?php
function get_title_detail($id){
  $ci = &get_instance();
  $branch = $ci->db->get_where("titles", array("title_id"=>$id));
  return $branch->row();
}