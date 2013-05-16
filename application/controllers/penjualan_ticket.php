<?php
class Penjualan_Ticket extends CI_Controller{
  private $perpage = 50;
  
  function __construct(){
    parent::__construct();
    $this->load->model("Penjualan_Ticket_Model", "penjualan");
    $this->load->model("Ticket_Agent_Model", "agent");
    $this->load->model("Kurs_model", "kurs");
    
    $this->load->helper("staff");
    $this->load->helper("branch");
    $this->load->helper("agent");
    $this->load->helper("penjualan_ticket");
    $this->load->helper("airline");
  }
  
  function index(){
    // get branch id
    $branch_id = $this->_get_tix_branch_id();
    // view to page
    $tp = $this->input->get("to_page");
    if(strlen($tp)){
      $this->session->set_userdata(array("to_page"=>$tp));
    }
    $this->perpage = $this->session->userdata("to_page") > 0 ? $this->session->userdata("to_page"):50;
    // order by
    $order_by = $this->input->get("order_by");
    $order = $this->input->get("order");
    $q = $this->input->get("q");
    $by = $this->input->get("search_by");
    $this->offset = $this->uri->segment(3);
    if(strlen($q)){
      if(strlen($by)){
        $data["penjualan"] = $this->penjualan->search($by, $q);
      }else{
        $data["penjualan"] = $this->penjualan->get_all($order_by, strtoupper($order), $this->perpage, $this->offset, $branch_id);
      }
    }else{
      $data["penjualan"] = $this->penjualan->get_all($order_by, strtoupper($order), $this->perpage, $this->offset, $branch_id);
      $config = init_paginate(base_url("penjualan_ticket/index"), $this->penjualan->get_all()->num_rows(), $this->perpage);
      $config["suffix"] = '?'.http_build_query($_GET, '', "&");
      $this->pagination->initialize($config);
    }
    // toggle order ASC DESC
    $data["order"] = ($order == "asc" ? "desc":"asc");
    $this->load->view("penjualan_ticket/index", $data);
  }
  
  function add(){
    $data = $this->_addData();
    $this->load->view("penjualan_ticket/form", $data);
  }
  
  function edit($id){
      $data = $this->_editData($id);
      $this->load->view("penjualan_ticket/form", $data);
  }
  
  function save(){
    $this->form_validation->set_rules(array(
        array("field"=>"tour_id", "label"=>"Tour ID", "rules"=>"required"),
        array("field"=>"agent_id", "label"=>"Ticket Agent", "rules"=>"required"),
        array("field"=>"name", "label"=>"Name", "rules"=>"required"),
        array("field"=>"address", "label"=>"Address", "rules"=>"required")
    ));
    $this->form_validation->set_message("required", "%s cannot be blank");
    if($this->form_validation->run()===false){
      $data = $this->_addData();
      $this->load->view("penjualan_ticket/form", $data);
    }else{
      $this->penjualan->add();
      $this->session->set_flashdata("message", "Penjualan ticket has been added");
      redirect("penjualan_ticket/index");
    }
  }
  
  function update(){
    $tix_id = $this->input->post("tix_id");
    $this->form_validation->set_rules(array(
        array("field"=>"tour_id", "label"=>"Tour ID", "rules"=>"required"),
        array("field"=>"agent_id", "label"=>"Ticket Agent", "rules"=>"required"),
        array("field"=>"name", "label"=>"Name", "rules"=>"required"),
        array("field"=>"address", "label"=>"Address", "rules"=>"required")
    ));
    $this->form_validation->set_message("required", "%s cannot be blank");
    if($this->form_validation->run()===false){
      $data = $this->_editData($tix_id);
      $this->load->view("penjualan_ticket/form", $data);
    }else{
      $this->penjualan->update();
      $this->session->set_flashdata("message", "Penjualan ticket has been updated");
      redirect("penjualan_ticket/index");
    }
  }
  
  function delete($id){
    $this->penjualan->delete($id);
    redirect("penjualan_ticket/index");
  }
  
  function cetak(){
    $id = $this->uri->segment(3);
    $data["penjualan"] = $this->penjualan->get($id)->row();
    $this->load->view("penjualan_ticket/print", $data);
  }
  
  function update_item(){
    $this->penjualan->update_item();
  }
  
  function delete_item($id){
    $this->penjualan->delete_item($id);
  }
  
  // private functions
  private function _addData(){
    $kurs = $this->kurs->get_last();
    $kurs_pajak = $kurs->num_rows() > 0 ? $kurs->row():0;
    
    $data["id"] = false;
    
    $data["tix_id"] = form_hidden("tix_id", "");
    
    $data["branch"] = form_hidden('branch', $this->session->userdata('branch'));
    $data["staff_id"] = form_hidden("staff_id", $this->session->userdata('sess_staff_id'));
    $data["tour_id"] = form_input(array("name"=>"tour_id", "id"=>"tour_id"));
    $data["invoice_no"] = form_input(array("name"=>"invoice_no", "id"=>"invoice_no"));
    $data["date"] = form_input(array("name"=>"date", "class"=>"datepicker", "value"=>date("Y-m-d")));
    $data["agent_id"] = form_input(array("type"=>"hidden", "name"=>"agent_id", "id"=>"agent_id"));
    $data["agent"] = form_input(array("id"=>"agent"));
    $data["name"] = form_input(array("name"=>"name", "id"=>"agent_name"));
    $data["address"] = form_textarea(array("name"=>"address", "id"=>"agent_address"));
    $data["due_date"] = form_input(array("name"=>"due_date", "class"=>"datepicker", "id"=>"due_date"));
    $data["biaya_surcharge_rp"] = form_input(array("name"=>"biaya_surcharge_rp", "class"=>"auto-coma"));
    $data["kurs_pajak"] = form_input(array("name"=>"kurs_pajak", "value"=>$kurs_pajak->kurs_us_rp, "class"=>"auto-coma"));
    $data["glacc_dr"] = form_input(array("name"=>"glacc_dr"));
    $data["glacc_cr"] = form_input(array("name"=>"glacc_cr"));
    
    // detail
    $data["airline"] = form_input(array("name"=>"tix_air", "id"=>"tix_air"));
    $data["route"] = form_input(array("name"=>"tix_route"));
    $data["description"] = form_textarea(array("name"=>"tix_description"));
    
    // pricing
    $data["price_rp"] = form_input(array("name"=>"tix_price_rp", "class"=>"auto-coma"));
    $data["price_us"] = form_input(array("name"=>"tix_price_us", "class"=>"auto-coma"));
    $data["discount_rp"] = form_input(array("name"=>"tix_discount_rp", "class"=>"auto-coma"));
    $data["discount_us"] = form_input(array("name"=>"tix_discount_us", "class"=>"auto-coma"));
    $data["komisi_rp"] = form_input(array("name"=>"tix_komisi_rp", "class"=>"auto-coma"));
    $data["komisi_us"] = form_input(array("name"=>"tix_komisi_us", "class"=>"auto-coma"));
    
    $data["form_action"] = site_url("penjualan_ticket/save");
    $data["submit"] = form_submit(array("name"=>"save", "value"=>"Save", "class"=>"btn btn-primary"));
    $data["back"] = anchor("penjualan_ticket/index", "Back", array("class"=>"btn btn-danger"));
    return $data;
  }
  
  private function _editData($id){
    $penjualan = $this->penjualan->get($id)->row();
    $agent = $this->agent->get($penjualan->tix_agent_id)->row();
    
    $agent_name = $agent ? $agent->tixa_name:"";
    
    $data["id"] = $penjualan->tix_id;
    $data["tix_id"] = form_hidden("tix_id", $penjualan->tix_id);
    
    $data["branch"] = form_hidden('branch', $penjualan->tix_branch_id);
    $data["staff_id"] = form_hidden("staff_id", $penjualan->tix_staff);
    $data["tour_id"] = form_input(array("name"=>"tour_id", "value"=>$penjualan->tix_tour_id, "readonly"=>"readonly"));
    $data["invoice_no"] = form_input(array("name"=>"invoice_no", "value"=>$penjualan->tix_invoice_no, "readonly"=>"readonly"));
    $data["date"] = form_input(array("name"=>"date", "class"=>"datepicker", "value"=>$penjualan->tix_date_time));
    $data["agent_id"] = form_input(array("type"=>"hidden", "name"=>"agent_id", "id"=>"agent_id", "value"=>$penjualan->tix_agent_id));
    $data["agent"] = form_input(array("id"=>"agent", "value"=>$agent_name));
    $data["name"] = form_input(array("name"=>"name", "value"=>$penjualan->tix_name));
    $data["address"] = form_textarea(array("name"=>"address", "value"=>$penjualan->tix_address));
    $data["due_date"] = form_input(array("name"=>"due_date", "class"=>"datepicker", "value"=>$penjualan->tix_due_date));
    $data["biaya_surcharge_rp"] = form_input(array("name"=>"biaya_surcharge_rp", "class"=>"auto-coma", "value"=>$penjualan->tix_biaya_surcharge_rp));
    $data["kurs_pajak"] = form_input(array("name"=>"kurs_pajak", "value"=>$penjualan->tix_kurs_pajak));
    $data["glacc_dr"] = form_input(array("name"=>"glacc_dr", "value"=>$penjualan->tix_glaccno_dr));
    $data["glacc_cr"] = form_input(array("name"=>"glacc_cr", "value"=>$penjualan->tix_glaccno_cr));
    
    // detail
    $data["airline"] = form_input(array("name"=>"tix_air", "id"=>"tix_air", "value"=>$penjualan->tix_glaccno_cr));
    $data["route"] = form_input(array("name"=>"tix_route", "value"=>$penjualan->tix_route));
    $data["description"] = form_textarea(array("name"=>"tix_description", "value"=>$penjualan->tix_description));
    
    // pricing
    $data["price_rp"] = form_input(array("name"=>"tix_price_rp", "class"=>"auto-coma", "value"=>$penjualan->tix_price_rp));
    $data["price_us"] = form_input(array("name"=>"tix_price_us", "class"=>"auto-coma", "value"=>$penjualan->tix_price_us));
    $data["discount_rp"] = form_input(array("name"=>"tix_discount_rp", "class"=>"auto-coma", "value"=>$penjualan->tix_discount_rp));
    $data["discount_us"] = form_input(array("name"=>"tix_discount_us", "class"=>"auto-coma", "value"=>$penjualan->tix_discount_us));
    $data["komisi_rp"] = form_input(array("name"=>"tix_komisi_rp", "class"=>"auto-coma", "value"=>$penjualan->tix_komisi_rp));
    $data["komisi_us"] = form_input(array("name"=>"tix_komisi_us", "class"=>"auto-coma", "value"=>$penjualan->tix_komisi_us));
    
    $data["form_action"] = site_url("penjualan_ticket/update");
    $data["submit"] = form_submit(array("name"=>"save", "value"=>"Save", "class"=>"btn btn-primary"));
    $data["back"] = anchor("penjualan_ticket/index", "Back", array("class"=>"btn btn-danger"));
    return $data;
  }
  
  function _get_tix_branch_id(){
    $role_id = $this->session->userdata("sess_role_id");
    $role = $this->db->get_where("user_roled", array("role_id"=>$role_id));
    if($role->num_rows()){
      $role = $role->row();
      if($role->roled_super == "1"){
        return 0;
      }else{
        return $this->session->userdata("branch");
      }
    }
    return false;
  }
}