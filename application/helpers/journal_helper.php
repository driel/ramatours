<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_journal_detail')) {
	function get_journal_detail($id){
  		$ci = &get_instance();
  		$result = $ci->db->get_where("journal_detail", array("gltr_id"=>$id));
  		return $result;
	}
}

if (!function_exists('get_account')) {
	function get_account($acc_no){
  		$ci = &get_instance();
  		$result = $ci->db->get_where("chart_of_account", array("glacc_no"=>$acc_no))->row();
  		return $result;
	}
}