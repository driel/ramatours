<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Settings extends CI_Controller {

  private $limit = 10;

  public function __construct() {
    parent::__construct();
    $this->load->model('Setting');
    $this->sess_username = $this->session->userdata('username');
    $this->sess_role_id = $this->session->userdata('sess_role_id');
    $this->sess_staff_id = $this->session->userdata('sess_staff_id');
    $this->session->userdata('logged_in') == true ? '' : redirect('users/sign_in');
  }

  public function index() {
    $setting = new Setting();
     
    $data['form_action'] = site_url('settings/save');
    
    // general
    $data['logo'] = $setting->get_val('logo');
    $data['company_name'] = array('name' => 'company_name', 'value'=>$setting->get_val('company_name'));
    $data['address'] = array('name' => 'address', 'value'=>$setting->get_val('address'));
    $data['phone'] = array('name' => 'phone', 'value'=>$setting->get_val('phone'));
    $data['fax'] = array('name' => 'fax', 'value'=>$setting->get_val('fax'));
    $data['email'] = array('name' => 'email', 'value'=>$setting->get_val('email'));
    $data['city'] = array('name' => 'city', 'value'=>$setting->get_val('city'));
    $data['no_npwp'] = array('name' => 'no_npwp', 'value'=>$setting->get_val('no_npwp'));
    $data["login_page_bg"] = $setting->get_val('login_page_bg');

    // taxes variable
    $data["hrd_wp"] = array('name'=>'hrd_wp', 'value'=>$setting->get_val('hrd_wp'));
    $data["hrd_tj_percent"] = array('name'=>'hrd_tj_percent', 'value'=>$setting->get_val('hrd_tj_percent'));
    $data["hrd_tj_max"] = array('name'=>'hrd_tj_max', 'value'=>$setting->get_val('hrd_tj_max'));
    $data["hrd_net1"] = array('name'=>'hrd_net1', 'value'=>$setting->get_val('hrd_net1'));
    $data["hrd_net2"] = array('name'=>'hrd_net2', 'value'=>$setting->get_val('hrd_net2'));
    $data["hrd_net3"] = array('name'=>'hrd_net3', 'value'=>$setting->get_val('hrd_net3'));
    $data["hrd_pph_percent1"] = array('name'=>'hrd_pph_percent1', 'value'=>$setting->get_val('hrd_pph_percent1'));
    $data["hrd_pph_percent2"] = array('name'=>'hrd_pph_percent2', 'value'=>$setting->get_val('hrd_pph_percent2'));
    $data["hrd_pph_percent3"] = array('name'=>'hrd_pph_percent3', 'value'=>$setting->get_val('hrd_pph_percent3'));
    $data["hrd_pph_percent4"] = array('name'=>'hrd_pph_percent4', 'value'=>$setting->get_val('hrd_pph_percent4'));
    
    // finance
    $data["invoice_note"] = array("name"=>"invoice_note", "id"=>"invoice_note", "value"=>$setting->get_val("invoice_note"));
    $data["invoice_number_length"] = array("name"=>"invoice_number_length", "value"=>$setting->get_val("invoice_number_length"));
    $data["invoice_ticketing_ho_start"] = array("name"=>"invoice_ticketing_ho_start", "value"=>$setting->get_val("invoice_ticketing_ho_start"));
    $data["invoice_ticketing_jkt_start"] = array("name"=>"invoice_ticketing_jkt_start", "value"=>$setting->get_val("invoice_ticketing_jkt_start"));
    $data["invoice_ticketing_jog_start"] = array("name"=>"invoice_ticketing_jog_start", "value"=>$setting->get_val("invoice_ticketing_jog_start"));
    $data["code_behind_invoice"] = array("name"=>"code_behind_invoice", "value"=>$setting->get_val("code_behind_invoice"));
    
    // reservation
    $data["rti_start_from"] = array("name"=>"rti_start_from", "value"=>$setting->get_val("rti_start_from"));
    $data["rti_length"] = array("name"=>"rti_length", "value"=>$setting->get_val("rti_length"));

    $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Update', 'class' => 'btn -btn-primary');

    $this->load->view('settings/frm_settings', $data);
  }

  public function save(){
    $setting = new Setting();
    if(isset($_POST["btn_save"])){
      $keys = array(
          "company_name","address","phone","fax","email", "city","no_npwp",
          "hrd_wp","hrd_tj_percent", "hrd_tj_max","hrd_net1","hrd_net2","hrd_net3","hrd_pph_percent1","hrd_pph_percent2","hrd_pph_percent3","hrd_pph_percent4",
          "invoice_note","invoice_number_length","invoice_ticketing_ho_start","invoice_ticketing_jkt_start","invoice_ticketing_jog_start","code_behind_invoice",
          "rti_start_from","rti_length"
      );
      foreach($keys as $k){
        $v = $this->input->post($k);
        $setting->update($k, $v);
      }
      
      // upload logo routine
      if(strlen($_FILES["logo"]["name"]) > 0){ // don't bother if not
        $config['upload_path'] = 'assets/upload';
        $config['allowed_types'] = 'gif|jpg|png|bmp';
        $this->load->library("upload", $config);
        if($this->upload->do_upload("logo")){
          $data = $this->upload->data();
          $setting->update("logo", $data['file_name']);
        }
      }
      
      // upload login_page_bg routine
      if(strlen($_FILES["login_page_bg"]["name"]) > 0){ // don't bother if not
        $config['upload_path'] = 'assets/upload';
        $config['allowed_types'] = 'gif|jpg|png|bmp';
        $this->load->library("upload", $config);
        if($this->upload->do_upload("login_page_bg")){
          $data = $this->upload->data();
          $setting->update("login_page_bg", $data['file_name']);
        }
      }
      redirect("settings/index");
    }
  }

  function update() {
    $setting = new Setting();

    // upload photo
    $config['upload_path'] = 'assets/upload';
    $config['allowed_types'] = 'gif|jpg|png|bmp';
    $this->load->library("upload", $config);
    if ($this->upload->do_upload("logo")) {
      $data = $this->upload->data();
    } else {
      //print_r($this->upload->display_errors());
    }

    $setting->where('id', $this->input->post('id'))
    ->update(array(
        'logo' => $data["file_name"],
        'company_name' => $this->input->post('company_name'),
        'address' => $this->input->post('address'),
        'phone' => $this->input->post('phone'),
        'fax' => $this->input->post('fax'),
        'email' => $this->input->post('email'),
        'city' => $this->input->post('city'),
        'no_npwp' => $this->input->post('no_npwp')
    )
    );

    $this->session->set_flashdata('message', 'Config Update successfuly.');
    redirect('settings/edit/1');
  }

  function delete($id) {
    redirect('settings/edit/1');
    $this->filter_access('Config', 'roled_delete', 'settings/index');

    $setting = new Setting();
    $setting->_delete($id);

    $this->session->set_flashdata('message', 'Config successfully deleted!');
    redirect('settings/');
  }
  
  function update_tour_id(){
    $setting = new Setting();
    $last_tour_id = $setting->get_val("rti_start_from");
    
    $updated_tour_id = ++$last_tour_id;
    $setting->update("rti_start_from", $updated_tour_id);
    
    echo $updated_tour_id;
  }

}

