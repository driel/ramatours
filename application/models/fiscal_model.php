<?php
class Fiscal_model extends CI_Model{

  	function get_all($order_by = 'fiskal_date', $order = "ASC", $limit = 0, $offset = 0){
	    if($limit == 0 && $offset == 0){
	      	return $this->db->order_by($order_by, $order)->get("tahun_fiskal");
	    }else{
	      	return $this->db->order_by($order_by, $order)->get("tahun_fiskal", $limit, $offset);
	    }
  	}

  	function get($fiscal_date){
    	return $this->db->get_where("tahun_fiskal", array("fiskal_date"=>$fiscal_date));      
  	}
  	
  	function get_last(){
  	  return $this->db->order_by("fiskal_date","DESC")->limit("1")->get("tahun_fiskal");
  	}

  	function add(){
    	$fiskal_date = $this->input->post("period_year").$this->input->post("period_month");
    	$fiskal_status = strtolower($this->input->post("fiskal_status")) == "on"? "Open":"Close";

    	if ($this->db->insert("tahun_fiskal", array("fiskal_date"=>$fiskal_date,"fiskal_status"=>$fiskal_status))) {
      		return $this->db->insert_id();
      	}

      	return false;
  	}

  	function update(){
    	$fiskal_date = $this->input->post("id");
    	$fiskal_status = strtolower($this->input->post("fiskal_status")) == "on"? "Open":"Close";

    	if ($this->db->update("tahun_fiskal", array("fiskal_status"=>$fiskal_status),array("fiskal_date"=>$fiskal_date))) {
      		return true;
      	}

      	return false;
  	}

	function delete($fiscal_date) {
  		if ($this->db->delete("tahun_fiskal", array("fiskal_date"=>$fiscal_date))) {
   			return true;
    	}
      	return false;
	}
}