<?php
function get_roled($role_id, $module_id){
  $ci = &get_instance();
  $roled = $ci->db->get_where("user_roled", array(
    "role_id"=>$role_id,
    "module_id"=>$module_id
  ));
  return $roled;
}

function filter_access($controller, $method){
  $CI = &get_instance();
  $role_id = $CI->session->userdata("sess_role_id");
  if(!_isList($CI, $controller)){
    $CI->session->set_flashdata("denied", "you don't have permission to view {$controller} page");
    redirect("/");
  }
  $isAllowed = true;
  switch($method){
    case "add":
      $isAllowed = _isAdd($CI, $controller);
      break;
    case "edit":
      $isAllowed = _isEdit($CI, $controller);
      break;
    case "delete":
      $isAllowed = _isDelete($CI, $controller);
      break;
  }
  if(!$isAllowed){
    $CI->session->set_flashdata("denied", "you don't have permission to <b><i>{$method} {$controller}</i></b>");
    redirect("/");    
  }
}

// check if user role can see the content
function _isList($_instance, $module){
  $module = $_instance->db->get_where("module", array("name"=>$module))->row();
  $roles = $_instance->db->get_where("user_roled", array("module_id"=>$module->id));
  if($roles->num_rows()){
    $role = $roles->row();
    if($role->roled_add == "1" || 
    $role->roled_edit == "1" || 
    $role->roled_delete == "1" || 
    $role->roled_approve == "1"){
      return true;    
    }else{
      return false; // can't see    
    }  
  }else{
    return false; // error, module not exists
  }
}

function _isAdd($_instance, $module){
  $module = $_instance->db->get_where("module", array("name"=>$module))->row();
  $roles = $_instance->db->get_where("user_roled", array("module_id"=>$module->id));
  if($roles->num_rows()){
    $role = $roles->row();
    if($role->roled_add == "1"){
      return true;    
    }else{
      return false; // can't see    
    }  
  }else{
    return false; // error, module not exists
  }
}

function _isEdit($_instance, $module){
  $module = $_instance->db->get_where("module", array("name"=>$module))->row();
  $roles = $_instance->db->get_where("user_roled", array("module_id"=>$module->id));
  if($roles->num_rows()){
    $role = $roles->row();
    if($role->roled_edit == "1"){
      return true;    
    }else{
      return false; // can't see    
    }  
  }else{
    return false; // error, module not exists
  }
}

function _isDelete($_instance, $module){
  $module = $_instance->db->get_where("module", array("name"=>$module))->row();
  $roles = $_instance->db->get_where("user_roled", array("module_id"=>$module->id));
  if($roles->num_rows()){
    $role = $roles->row();
    if($role->roled_delete == "1"){
      return true;    
    }else{
      return false; // can't see    
    }  
  }else{
    return false; // error, module not exists
  }
}