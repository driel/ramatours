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
    return $this->db->join("airline air", "jual.tix_air=air.id")->get_where("penjualan_ticket_detail jual", array("jual.tix_id"=>$tix_id));
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
        "tix_biaya_surcharge_rp"=>str_replace(",", "", $this->input->post("biaya_shurcharge_rp")),
        "tix_kurs_pajak"=>$this->input->post("kurs_pajak"),
        "tix_glaccno_dr"=>$this->input->post("glacc_dr"),
        "tix_glaccno_cr"=>$this->input->post("glacc_cr")
    ));
    $tix_id = $this->db->insert_id();
    
    // detail
    $items = $this->input->post("invoice_items");
    if(is_array($items)){
      foreach($items as $item){
        list($air_name, $route, $description, $currency_price, $price, $currency_discount, $discount, $currency_komisi, $komisi, $air_id) = explode(";", $item);
        $price_rp = 0; $price_us = 0;
        if(strtolower($currency_price) == "rp"){
          $price_rp = $price;
        }else{
          $price_us = $price;
        }
        
        $discount_rp = 0; $discount_us = 0;
        if(strtolower($currency_discount) == "rp"){
          $discount_rp = $discount;
        }else{
          $discount_us = $discount;
        }
        
        $komisi_rp = 0; $komisi_us = 0;
        if(strtolower($currency_komisi) == "rp"){
          $komisi_rp = $komisi;
        }else{
          $komisi_us = $komisi;
        }
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
        "tix_biaya_surcharge_rp"=>str_replace(",", "", $this->input->post("biaya_shurcharge_rp")),
        "tix_kurs_pajak"=>$this->input->post("kurs_pajak"),
        "tix_glaccno_dr"=>$this->input->post("glacc_dr"),
        "tix_glaccno_cr"=>$this->input->post("glacc_cr")
    ), array("tix_id"=>$tix_id));
  
  // detail
    $items = $this->input->post("invoice_items");
    if(is_array($items)){
      foreach($items as $item){
        list($air_name, $route, $description, $currency_price, $price, $currency_discount, $discount, $currency_komisi, $komisi, $air_id, $tixd_id) = explode(";", $item);
        $price_rp = 0; $price_us = 0;
        if(strtolower($currency_price) == "rp"){
          $price_rp = $price;
        }else{
          $price_us = $price;
        }
        
        $discount_rp = 0; $discount_us = 0;
        if(strtolower($currency_discount) == "rp"){
          $discount_rp = $discount;
        }else{
          $discount_us = $discount;
        }
        
        $komisi_rp = 0; $komisi_us = 0;
        if(strtolower($currency_komisi) == "rp"){
          $komisi_rp = $komisi;
        }else{
          $komisi_us = $komisi;
        }
        if($tixd_id=="undefined"){ // berarti ga ada IDnya
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
  }
  
  function delete($id){
    $this->db->delete("penjualan_ticket", array("tix_id"=>$id));
    $this->db->delete("penjualan_ticket_detail", array("tix_id"=>$id));
  }
  
  function sum_total($what, $tix_id){
    return $this->db->select("SUM($what) AS $what")->get_where("penjualan_ticket_detail", array("tix_id"=>$tix_id))->row();
  }
  
  function update_item(){
    $currency_price = $this->input->post("currency_price");
    $price_rp = 0; $price_us = 0;
    if(strtolower($currency_price) == "rp"){
      $price_rp = $this->input->post("price");
    }else{
      $price_us = $this->input->post("price");
    }
    
    $currency_discount = $this->input->post("currency_discount");
    $discount_rp = 0; $discount_us = 0;
    if(strtolower($currency_discount) == "rp"){
      $discount_rp = $this->input->post("discount");
    }else{
      $discount_us = $this->input->post("discount");
    }
    
    $currency_komisi = $this->input->post("currency_komisi");
    $komisi_rp = 0; $komisi_us = 0;
    if(strtolower($currency_komisi) == "rp"){
      $komisi_rp = $this->input->post("komisi");
    }else{
      $komisi_us = $this->input->post("komisi");
    }
    
    $this->db->update("penjualan_ticket_detail", array(
        "tix_air"=>$this->input->post("air_id"),
        "tix_route"=>$this->input->post("route"),
        "tix_description"=>$this->input->post("description"),
        "tix_price_rp"=>$price_rp,
        "tix_price_us"=>$price_us,
        "tix_discount_rp"=>$discount_rp,
        "tix_discount_us"=>$discount_us,
        "tix_komisi_rp"=>$komisi_rp,
        "tix_komisi_us"=>$komisi_us
    ), array("tixd_id"=>$this->input->post("tixd_id")));
  }
}