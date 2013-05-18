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
  
  function reports(){
    $method = $this->uri->segment(3);
    $this->{"report_".$method}();
  }
  
  function report_harian(){
    if($this->input->get("to")){
      $data["title"] = "Penjualan Ticket Harian";
      $data["results"] = $this->penjualan->report_harian($this->input->get("branch"), $this->input->get("staff_id"));
      switch($this->input->get("to")){
        case "xls":
          header("Content-type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=Report penjualan harian (".date("Y-m-d").").xls");
          header("Pragma: no-cache");
          header("Expires: 0");
          $this->load->view("penjualan_ticket/report", $data);
          break;
        
        case "pdf":
          $this->load->library('html2pdf');
          
          $this->html2pdf->filename = 'Report penjualan harian ('.date("Y-m-d").').pdf';
          $this->html2pdf->paper('a4', 'landscape');
          $this->html2pdf->html($this->load->view("penjualan_ticket/report", $data, true));
           
          $this->html2pdf->create();
          break;
          
        default:
          $this->load->view("penjualan_ticket/report", $data);
          break;
      }
    }else{
      $branch = new Branch();
      $list_branch = $branch->list_drop();
      $branch_selected = $this->input->get('staff_cabang');
      $data['staff_cabang'] = form_dropdown('branch', $list_branch, $branch_selected);
      
      $data["staff"] = array("id"=>"staff");
      
      $data["periode"] = array("name"=>"periode", "id"=>"periode");
      
      $this->load->view("penjualan_ticket/report_harian", $data);
    }
  }
  
  function report_airline(){
    if($this->input->get("to")){
      $data["title"] = "Penjualan Ticket per Airline, Periode {$this->input->get("periode")}";
      $data["results"] = $this->penjualan->report_airline($this->input->get("branch"), $this->input->get("air_id"), $this->input->get("periode"));
      switch($this->input->get("to")){
        case "xls":
          header("Content-type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=Report penjualan harian (".date("Y-m-d").").xls");
          header("Pragma: no-cache");
          header("Expires: 0");
          $this->load->view("penjualan_ticket/report", $data);
          break;
  
        case "pdf":
          $this->load->library('html2pdf');
  
          $this->html2pdf->filename = 'Report penjualan harian ('.date("Y-m-d").').pdf';
          $this->html2pdf->paper('a4', 'landscape');
          $this->html2pdf->html($this->load->view("penjualan_ticket/report", $data, true));
           
          $this->html2pdf->create();
          break;
  
        default:
          $this->load->view("penjualan_ticket/report", $data);
          break;
      }
    }else{
      $branch = new Branch();
      $list_branch = $branch->list_drop();
      $branch_selected = $this->input->get('staff_cabang');
      $data['staff_cabang'] = form_dropdown('branch', $list_branch, $branch_selected);
  
      $data["periode"] = array("name"=>"periode", "id"=>"periode", "value"=>date("M Y"));
  
      $data["airline"] = array("id"=>"airline");
  
      $this->load->view("penjualan_ticket/report_airline", $data);
    }
  }
  
  function report_staff(){
    if($this->input->get("to")){
      $data["title"] = "Penjualan Ticket per Staff, Periode {$this->input->get("periode")}";
      $data["results"] = $this->penjualan->report_staff($this->input->get("staff_id"), $this->input->get("periode"));
      switch($this->input->get("to")){
        case "xls":
          header("Content-type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=Report penjualan harian (".date("Y-m-d").").xls");
          header("Pragma: no-cache");
          header("Expires: 0");
          $this->load->view("penjualan_ticket/report", $data);
          break;
  
        case "pdf":
          $this->load->library('html2pdf');
  
          $this->html2pdf->filename = 'Report penjualan harian ('.date("Y-m-d").').pdf';
          $this->html2pdf->paper('a4', 'landscape');
          $this->html2pdf->html($this->load->view("penjualan_ticket/report", $data, true));
           
          $this->html2pdf->create();
          break;
  
        default:
          $this->load->view("penjualan_ticket/report", $data);
          break;
      }
    }else{
      $branch = new Branch();
      $list_branch = $branch->list_drop();
      $branch_selected = $this->input->get('staff_cabang');
      $data['staff_cabang'] = form_dropdown('branch', $list_branch, $branch_selected);
  
      $data["periode"] = array("name"=>"periode", "id"=>"periode", "value"=>date("M Y"));
  
      $data["staff"] = array("id"=>"staff");
  
      $this->load->view("penjualan_ticket/report_staff", $data);
    }
  }
  
  function rekap(){
    if($this->input->get("to")){
      $periode = $this->input->get("periode");
      if($periode == "monthly"){
        $date_start = date("Y-m")."-01";
        $date_end = date("Y-m")."-31";
      }else{
        $date_start = date("Y")."-01-01";
        $date_end = date("Y")."-12-31";
      }
      $query = "SELECT
      branch.branch_name AS branch_name,
      air.name AS airline,
      SUM(pjd.tix_price_rp) AS price_rp,
      SUM(pjd.tix_price_us) AS price_us,
      SUM(pjd.tix_discount_rp) AS discount_rp,
      SUM(pjd.tix_discount_us) AS discount_us,
      SUM(pjd.tix_komisi_rp) AS komisi_rp,
      SUM(pjd.tix_komisi_us) AS komisi_us
      FROM penjualan_ticket pj
      JOIN penjualan_ticket_detail pjd ON pj.tix_id=pjd.tix_id
      JOIN branches branch ON branch.branch_id=pj.tix_branch_id
      JOIN airline air ON air.id=pjd.tix_air
      WHERE pj.tix_date_time BETWEEN '{$date_start}' AND '{$date_end}' GROUP BY pjd.tix_air";
      
      $data["results"] = $this->penjualan->rekap($query);
      $data["title"] = "Rekap penjualan ticket per airline";
      
      switch($this->input->get("to")){
        case "xls":
          header("Content-type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=Rekap penjualan ticket (".date("Y-m-d").").xls");
          header("Pragma: no-cache");
          header("Expires: 0");
          $this->load->view("penjualan_ticket/rekap_{$periode}", $data);
          break;
      
        case "pdf":
          $this->load->library('html2pdf');
      
          $this->html2pdf->filename = 'Rekap penjualan ticket ('.date("Y-m-d").').pdf';
          $this->html2pdf->paper('a4', 'landscape');
          $this->html2pdf->html($this->load->view("penjualan_ticket/rekap_{$periode}", $data, true));
           
          $this->html2pdf->create();
          break;
      
        default:
          $this->load->view("penjualan_ticket/rekap_{$periode}", $data);
          break;
      }
    }else{
      $branch = new Branch();
      $data["branch"] = form_dropdown("branch", $branch->list_drop(), "");
      $data["periode"] = form_dropdown("periode", array(
          "monthly"=>"Monthly",
          "yearly"=>"Yearly"
      ), "monthly");
      $this->load->view("penjualan_ticket/rekap", $data);
    }
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