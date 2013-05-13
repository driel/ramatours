<?php
class Penjualan_Ticket_Model extends CI_Model{
  function get_all($order_by = 'tix_tour_id', $order = "ASC", $per_page = 0, $offset = 0, $tix_branch_id = "0"){
    $order_by = strlen($order_by) ? $order_by:"tix_tour_id";
    if($per_page == 0 && $offset == 0){
      if($tix_branch_id == 0){
        $jual_ticket = $this->db->order_by($order_by, $order)->get("penjualan_ticket");
      }else{
        $jual_ticket = $this->db->where("tix_branch_id", $tix_branch_id)->order_by($order_by, $order)->get("penjualan_ticket");
      }
    }else{
      if($tix_branch_id == 0){
        $jual_ticket = $this->db->order_by($order_by, $order)->get("penjualan_ticket", $per_page, $offset);
      }else{
        $jual_ticket = $this->db->where("tix_branch_id", $tix_branch_id)->order_by($order_by, $order)->get("penjualan_ticket", $per_page, $offset);
      }
    }
    return $jual_ticket;
  }
  
  function get($id){
    return $this->db->join("penjualan_ticket_detail", "penjualan_ticket.tix_id=penjualan_ticket_detail.tix_id")->get_where("penjualan_ticket", array("penjualan_ticket.tix_id"=>$id));
  }
  
  function get_items($tix_id){
    return $this->db->get_where("penjualan_ticket_detail", array("tix_id"=>$tix_id));
  }

  function search($k, $v){
    return $this->db->like($k, $v)->order_by($k, "asc")->get("penjualan_ticket");
  }

  function add(){
    $this->db->insert("penjualan_ticket", array(
        "tix_branch_id"=>$this->input->post("branch"),
        "tix_staff"=>$this->input->post("staff_id"),
        "tix_tour_id"=>$this->input->post("tour_id"),
        "tix_invoice_no"=>$this->input->post("invoice_no"),
        "tix_date_time"=>$this->input->post("date"),
        "tix_agent_id"=>$this->input->post("agent_id"),
        "tix_name"=>$this->input->post("name"),
        "tix_address"=>$this->input->post("address"),
        "tix_due_date"=>$this->input->post("due_date"),
        "tix_biaya_surcharge_rp"=>$this->input->post("biaya_shurcharge_rp"),
        "tix_kurs_pajak"=>$this->input->post("kurs_pajak"),
        "tix_glaccno_dr"=>$this->input->post("glacc_dr"),
        "tix_glaccno_cr"=>$this->input->post("glacc_cr")
    ));
    $tix_id = $this->db->insert_id();
    
    // detail
    $items = $this->input->post("invoice_items");
    if(is_array($items)){
      foreach($items as $item){
        list($air_name, $route, $description, $price_rp, $price_us, $discount_rp, $discount_us, $komisi_rp, $komisi_us, $air_id) = explode(";", $item);
        $this->db->insert("penjualan_ticket_detail", array(
            "tix_id"=>$tix_id,
            "tix_air"=>$air_id,
            "tix_route"=>$route,
            "tix_description"=>$description,
            "tix_price_rp"=>$price_rp,
            "tix_price_us"=>$price_us,
            "tix_discount_rp"=>$discount_rp,
            "tix_discount_us"=>$discount_us,
            "tix_komisi_rp"=>$komisi_rp,
            "tix_komisi_us"=>$komisi_us
        ));
      }
    }
  }
  
  function update(){
    $tix_id = $this->input->post("tix_id");
    $this->db->update("penjualan_ticket", array(
        "tix_branch_id"=>$this->input->post("branch"),
        "tix_staff"=>$this->input->post("staff_id"),
        "tix_tour_id"=>$this->input->post("tour_id"),
        "tix_invoice_no"=>$this->input->post("invoice_no"),
        "tix_date_time"=>$this->input->post("date"),
        "tix_agent_id"=>$this->input->post("agent_id"),
        "tix_name"=>$this->input->post("name"),
        "tix_address"=>$this->input->post("address"),
        "tix_due_date"=>$this->input->post("due_date"),
        "tix_biaya_surcharge_rp"=>$this->input->post("biaya_shurcharge_rp"),
        "tix_kurs_pajak"=>$this->input->post("kurs_pajak"),
        "tix_glaccno_dr"=>$this->input->post("glacc_dr"),
        "tix_glaccno_cr"=>$this->input->post("glacc_cr")
    ), array("tix_id"=>$tix_id));
  
    // detail
    $this->db->update("penjualan_ticket_detail", array(
        "tix_id"=>$tix_id,
        "tix_air"=>$this->input->post("tix_air"),
        "tix_route"=>$this->input->post("tix_route"),
        "tix_description"=>$this->input->post("tix_description"),
        "tix_price_rp"=>str_replace(",", "", $this->input->post("tix_price_rp")),
        "tix_price_us"=>str_replace(",", "", $this->input->post("tix_price_us")),
        "tix_discount_rp"=>str_replace(",", "", $this->input->post("tix_discount_rp")),
        "tix_discount_us"=>str_replace(",", "", $this->input->post("tix_discount_us")),
        "tix_komisi_rp"=>str_replace(",", "", $this->input->post("tix_komisi_rp")),
        "tix_komisi_us"=>str_replace(",", "", $this->input->post("tix_komisi_us"))
    ), array("tix_id"=>$tix_id));
  }
  
  function delete($id){
    $this->db->delete("penjualan_ticket", array("tix_id"=>$id));
    $this->db->delete("penjualan_ticket_detail", array("tix_id"=>$id));
  }
}