<?php
class Fiscal_model extends CI_Model{

  	function get_all($order_by = 'kurs_date', $order = "ASC", $limit = 0, $offset = 0){
	    if($limit == 0 && $offset == 0){
	      	return $this->db->order_by($order_by, $order)->get("kurs_pajak");
	    }else{
	      	return $this->db->order_by($order_by, $order)->get("kurs_pajak", $limit, $offset);
	    }
  	}

  	function get($id){
    	return $this->db->get_where("kurs_pajak", array("kurs_id"=>$id));      
  	}

  	function list_where($date, $limit = 10, $offset = 0){
		$this->db->where("kurs_date",$date);
		$this->db->limit($limit,$offset);

    	return $this->db->get("kurs_pajak");
  	}
  	
  	function get_last(){
  	  return $this->db->order_by("kurs_id DESC")->limit("1")->get("kurs_pajak");
  	}

  	function add(){
    	$kurs_date = $this->input->post("kurs_date");
    	$kurs_us_rp = $this->input->post("kurs_us_rp");
    	$kurs_yen_rp = $this->input->post("kurs_yen_rp");

    	if ($kurs_date && $kurs_us_rp && $kurs_yen_rp) {
      		$this->db->insert("kurs_pajak", array(
		        "kurs_date"=>$kurs_date,
		        "kurs_us_rp"=>$kurs_us_rp,
		        "kurs_yen_rp"=>$kurs_yen_rp
      		));

      		return $this->db->insert_id();
      	}

      	return false;
  	}
  
  	function update(){
    	$kurs_id = $this->input->post("kurs_id");
    	$kurs_us_rp = $this->input->post("kurs_us_rp");
    	$kurs_yen_rp = $this->input->post("kurs_yen_rp");
    	if($kurs_id){
      		if ($this->db->update("kurs_pajak", array(
		        "kurs_us_rp"=>$kurs_us_rp,
		        "kurs_yen_rp"=>$kurs_yen_rp), array("kurs_id"=>$kurs_id))) {
		        	return true;
		        }

      	}
      	return false;
  	}

	function delete($id) {
  		if ($this->db->delete("kurs_pajak", array("kurs_id"=>$id))) {
	        	return true;
    	}
      	return false;
	}
}