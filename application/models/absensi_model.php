<?php
class Absensi_model extends CI_Model{
  function get_all(){
    return $this->db->get("absensi");
  }
  
  function get($id){
    return $this->db->get_where("absensi", array("id"=>$id));
  }

  function list_where($where = null, $limit = 10, $offset = 0){
  	$this->db->join('staffs','staffs.staff_id=absensi.staff_id');  	
  	$this->db->join('branches','branches.branch_id=staffs.staff_cabang');  	

	foreach($where as $key=>$value) {
		if ((isset($key) && isset($value)) && (($key != '0' || $key != '') && $value != '')) {
			$this->db->like($key,$value);
		}
	}

	$this->db->limit($limit,$offset);

    return $this->db->get("absensi");
  }
  
  // this is actually add or update
  function add(){
    $periode = $this->input->post("periode");
    $year = $this->input->post("year");
    $periode = $year."-".$periode."-01";
    $absen = $this->input->post("absensi");
    foreach($absen as $a){
      list($sid, $absen) = explode(";", $a);
      $is_saved = $this->db->get_where("absensi", array("staff_id"=>$sid, "date"=>$periode));
      if($is_saved->num_rows() > 0){ // update if is_saved
        $this->db->update("absensi", array(
            "hari_masuk"=>$absen
        ), array("staff_id"=>$sid, "date"=>$periode));
      }else{
        $this->db->insert("absensi", array(
            "staff_id"=>$sid,
            "date"=>$periode,
            "hari_masuk"=>$absen
        ));
      }
    }
  }
  
  function add_csv($data){
    $staff = $this->db->get_where("staffs", array("staff_kode_absen"=>$data["kode_absen"]));
    if($staff->num_rows() > 0){
      $staff = $staff->row();
      $staff_id = $staff->staff_id;
      $periode = $this->input->post("periode");
      $year = $this->input->post("year");
      $periode = $year."-".$periode."-01";
      $hari_masuk = $data["hari_masuk"];
      $this->db->insert("absensi", array(
        "staff_id"=>$staff_id,
        "date"=>$periode,
        "hari_masuk"=>$hari_masuk
      ));
    }
  }
  
  function update(){
    $id = $this->input->post("id");
    $staff_id = $this->input->post("staff_id");
    $date = $this->input->post("date");
    $hari_masuk = $this->input->post("hari_masuk");
    $this->db->update("absensi", array(
      "staff_id"=>$staff_id,
      "date"=>$date,
      "hari_masuk"=>$hari_masuk
    ), array("id"=>$id));
  }
  
  function get_staff($by, $staff_name){
    return $this->db->like($by, $staff_name)->get("staffs");
  }
  
  function get_staff_absensi($staff_id,$period){
    return $this->db->where("staff_id", $staff_id)->where("DATE_FORMAT(absensi.date,'%Y-%m')",$period)->get("absensi");
  }
  
  function get_periode($staff_id, $start, $end){
    return $this->db->select("hari_masuk AS absen")->where("date BETWEEN '$start' AND '$end' AND staff_id='$staff_id'")->get("absensi");
  }
  
}
