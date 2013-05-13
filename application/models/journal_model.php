<?php
class Journal_model extends CI_Model{

  	function get_all($order_by = 'gltr_date', $order = "ASC", $limit = 0, $offset = 0){
	    if($limit == 0 && $offset == 0){
	      	return $this->db->order_by($order_by, $order)->get("journal");
	    }else{
	      	return $this->db->order_by($order_by, $order)->get("journal", $limit, $offset);
	    }
  	}

  	function get($id){
    	return $this->db->get_where("journal", array("gltr_id"=>$id));      
  	}

  	function list_where($date, $limit = 10, $offset = 0){
		$this->db->where("gltr_date",$date);
		$this->db->limit($limit,$offset);

    	return $this->db->get("journal");
  	}

  	function add(){
    	$gltr_date = $this->input->post("gltr_date");
    	$gltr_voucher = $this->input->post("gltr_voucher");

    	if ($gltr_date && $gltr_voucher) {
      		if ($this->db->insert("journal", array(
		        "gltr_date"=>$gltr_date,
		        "gltr_voucher"=>$gltr_voucher
      		))) {
      			return $this->db->insert_id();
      		}
      	}

      	return false;
  	}
  
  	function update(){
    	$gltr_id = $this->input->post("gltr_id");
    	$gltr_date = $this->input->post("gltr_date");
    	$gltr_voucher = $this->input->post("gltr_voucher");

    	if ($gltr_date && $gltr_voucher) {
      		if ($this->db->update("journal", array(
		        "gltr_date"=>$gltr_date,
		        "gltr_voucher"=>$gltr_voucher
      		),array("gltr_id"=>$gltr_id))) {
      			if ($this->db->delete("journal_detail",array("gltr_id"=>$gltr_id))) {
					for($i=0; $i<count($_POST['gltr_accno']); $i++) {
						if (isset($_POST['gltr_accno'][$i]) && isset($_POST['gltr_keterangan'][$i]) && $_POST['gltr_dr'][$i] && $_POST['gltr_cr'][$i]) {
							$gltr_accno = $_POST['gltr_accno'][$i];
							$gltr_rti = $_POST['gltr_rti'][$i];
							$gltr_keteragan = $_POST['gltr_keterangan'][$i];
							$gltr_dr = $_POST['gltr_dr'][$i];
							$gltr_cr = $_POST['gltr_cr'][$i];

							$this->db->insert("journal_detail", array(
						        "gltr_id"=>$gltr_id,
						        "gltr_accno"=>$gltr_accno,
						        "gltr_rti"=>$gltr_rti,
						        "gltr_keterangan"=>$gltr_keterangan,
						        "gltr_dr"=>$gltr_dr,
						        "gltr_cr"=>$gltr_cr
				      		));
			      		}
					}
				}
      		}
      	}

      	return false;
  	}

	function delete($id) {
  		if ($this->db->delete("journal", array("gltr_id"=>$id))) {
	        if ($this->db->delete("journal_detail",array("gltr_id"=>$id))) {
				return true;
			}
    	}
      	return false;
	}
}