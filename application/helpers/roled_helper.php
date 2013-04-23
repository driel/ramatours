<?php
function get_roled($role_id, $module_id){
  $ci = &get_instance();
  $roled = $ci->db->get_where("user_roled", array(
    "role_id"=>$role_id,
    "module_id"=>$module_id
  ));
  return $roled;
}

function filter_access($controller, $method, $onDenied = "redirect"){
  $CI = &get_instance();
  $role_id = $CI->session->userdata("sess_role_id");
  $h_controller = humanize($controller);
  $controller = underscore($controller);
  if($method == "view"){
    if(!_isList($CI, $controller, $role_id)){
      if($onDenied == "redirect"){
        $CI->session->set_flashdata("denied", "you don't have permission to <b><i>{$method} {$h_controller}</i></b>");
        redirect("/");    
      }else{
        die("haha you're dead!");
      }      
    }  
  }else{
    $isAllowed = true;
    switch($method){
      case "add":
        $isAllowed = _isAdd($CI, $controller, $role_id);
        break;
      case "edit":
        $isAllowed = _isEdit($CI, $controller, $role_id);
        break;
      case "delete":
        $isAllowed = _isDelete($CI, $controller, $role_id);
        break;
    }
    if(!$isAllowed){
      $control = $CI->uri->segment(1); // get controller from URL
      if($onDenied == "redirect"){
        $CI->session->set_flashdata("denied", "you don't have permission to <b><i>{$method} {$h_controller}</i></b>");
        redirect("{$control}/index");    
      }else{
        die("haha you're dead!");
      }    
    }
  }
}

// check if user role can see the content
function _isList($_instance, $module, $role_id){
  $module = $_instance->db->get_where("module", array("name"=>$module))->row();
  $roles = $_instance->db->get_where("user_roled", array("module_id"=>$module->id, "role_id"=>$role_id));
  if($roles->num_rows()){
    $role = $roles->row();
    if($role->roled_view == "1"){
      return true;    
    }else{
      return false; // can't see    
    }  
  }else{
    return false; // error, module not exists
  }
}

function _isAdd($_instance, $module, $role_id){
  $module = $_instance->db->get_where("module", array("name"=>$module))->row();
  $roles = $_instance->db->get_where("user_roled", array("module_id"=>$module->id, "role_id"=>$role_id));
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

function _isEdit($_instance, $module, $role_id){
  $module = $_instance->db->get_where("module", array("name"=>$module))->row();
  $roles = $_instance->db->get_where("user_roled", array("module_id"=>$module->id, "role_id"=>$role_id));
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

function _isDelete($_instance, $module, $role_id){
  $module = $_instance->db->get_where("module", array("name"=>$module))->row();
  $roles = $_instance->db->get_where("user_roled", array("module_id"=>$module->id, "role_id"=>$role_id));
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

function isSuper(){
  $CI = &get_instance();
  $role_id = $CI->session->userdata("sess_role_id");
  $roles = $CI->db->get_where("user_roled", array("role_id"=>$role_id));
  if($roles->num_rows()){
    $role = $roles->row();
    if($role->roled_super == "1"){
      return true;    
    }else{
      return false; // can't see    
    }  
  }else{
    return false; // error, module not exists
  }
}