<?php
class Accountdetail_model extends CI_Model{

  	function get_all($order_by = 'glacc_period', $order = "ASC", $limit = 0, $offset = 0){
	    if($limit == 0 && $offset == 0){
	      	return $this->db->order_by($order_by, $order)->get("chart_of_account_detail");
	    }else{
	      	return $this->db->order_by($order_by, $order)->get("chart_of_account_detail", $limit, $offset);
	    }
  	}

  	function get($glacc_period){
    	return $this->db->get_where("chart_of_account_detail", array("glacc_period"=>$glacc_period));
  	}

  	function add($glacc_period,$glacc_saldo,$glacc_dr,$glacc_cr){
    	if ($glacc_period && $glacc_saldo && $glacc_dr && $glacc_cr) {
      		$this->db->insert("chart_of_account_detail", array(
		        "glacc_period"=>$glacc_period,
		        "glacc_saldo"=>$glacc_saldo,
		        "glacc_dr"=>$glacc_dr,
		        "glacc_cr"=>$glacc_cr
      		));

      		return true;
      	}

      	return false;
  	}
  
  	function update($glacc_period,$glacc_saldo,$glacc_dr,$glacc_cr){
    	if($glacc_period){
      		if ($this->db->update("chart_of_account_detail", array(
		        "glacc_saldo"=>$glacc_saldo,
		        "glacc_dr"=>$glacc_dr,
		        "glacc_cr"=>$glacc_cr), array("glacc_period"=>$glacc_period))) {
		        	return true;
		        }

      	}
      	return false;
  	}

	function delete($id) {
  		if ($this->db->delete("chart_of_account_detail", array("glacc_period"=>$id))) {
	        	return true;
    	}
      	return false;
	}
}