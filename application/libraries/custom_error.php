<?php
class Custom_Error extends CI_Form_validation{
  function __consturct(){
    parent::__construct();
  }
  
  function set_error(){
    if (empty($error)){
      return FALSE;
    }else{
      $CI =& get_instance();
      $CI->form_validation->_error_array['custom_error'] = $error;
      return TRUE;
    }
  }
}