<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accounts extends CI_Controller {

    private $limit = 10;

    function __construct() {
        parent::__construct();
        $this->load->model("Account");
        $this->sess_username = $this->session->userdata('username');
        $this->sess_role_id = $this->session->userdata('sess_role_id');
        $this->sess_staff_id = $this->session->userdata('sess_staff_id');
        $this->session->userdata('logged_in') == true ? '' : redirect('users/sign_in');
    }

    public function index($offset = 0) {
        //filter_access(__CLASS__, "view");
        $account_list = new Account();
        $data['account'] = new Account();
        switch ($this->input->get('c')) {
        	case "1":
	          	$data['col'] = "glacc_id";
	          	break;
	      	case "2":
	          	$data['col'] = "glacc_parent";
	          	break;
	      	case "3":
	          	$data['col'] = "glacc_no";
	          	break;
	      	case "4":
	          	$data['col'] = "glacc_name";
	          	break;
	      	default:
	          	$data['col'] = "glacc_id";
	    }
	
	    if ($this->input->get('d') == "1") {
	        $data['dir'] = "DESC";
	    } else {
	        $data['dir'] = "ASC";
	    }

	    $total_rows = $account_list->count();
        $data['title'] = "Chart of Account";
        $data['btn_add'] = anchor('accounts/add', 'Add New', array('class' => 'btn btn-primary'));
        $data['btn_home'] = anchor(base_url(), 'Home', array('class' => 'btn'));

        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        $account_list->order_by($data['col'], $data['dir']);
        $data['account_list'] = $account_list->get($this->limit, $offset)->all;

        $config['base_url'] = site_url("accounts/index");
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('accounts/index', $data);
    }

    function add() {
        //filter_access(__CLASS__, "add");
        $data['title'] = 'Add New Chart of Account';
        $data['form_action'] = site_url('accounts/save');
        $data['link_back'] = anchor('accounts/', 'Back', array('class' => 'btn btn-danger'));

        $data['glacc_id'] = "";
        $data["glacc_parent_stat"] = form_checkbox(array('name'=>'glacc_parent_stat', 'id'=>'glacc_parent_stat'));
        
        $account = new Account();
        $list_account = $account->list_drop();
        $data["glacc_parent"] = form_dropdown('glacc_parent', $list_account, '','id="glacc_parent"');

        $data['glacc_name'] = array('name' => 'glacc_name');
        $data["glacc_no"] = array("name"=>"glacc_no");

        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');

        $this->load->view('accounts/form', $data);
    }

    function edit($id) {
        //filter_access(__CLASS__, "edit");
        $account = new Account();
        $rs = $account->where('glacc_id', $id)->get();

        $data['glacc_id'] = $rs->glacc_id;
        $data['glacc_no'] = array('name' => 'glacc_no', 'value' => $rs->glacc_no);
        $data['glacc_name'] = array('name' => 'glacc_name', 'value' => $rs->glacc_name);
        $status_selected = $rs->glacc_parent_stat == 'y' ? TRUE:FALSE;
        $data["glacc_parent_stat"] = form_checkbox(array('name'=>'glacc_parent_stat', 'id'=>'glacc_parent_stat', 'checked'=>$status_selected));

        $account = new Account();
        $list_account = $account->list_drop();
        $data["glacc_parent"] = form_dropdown('glacc_parent', $list_account, $rs->glacc_parent, 'id="glacc_parent"');
        
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Update', 'class' => 'btn btn-primary');

        $data['title'] = 'Update';
        $data['form_action'] = site_url('accounts/update');
        $data['link_back'] = anchor('accounts/', 'Back', array('class' => 'btn btn-danger'));

        $this->load->view('accounts/form', $data);
    }

    function save() {
        //filter_access(__CLASS__, "add");
        $account = new Account();
        $account->glacc_parent = $this->input->post('glacc_parent');
        $account->glacc_parent_stat = $this->input->post('glacc_parent_stat') == "on" ? "y":"n" ;
        $account->glacc_no = $this->input->post('glacc_no');
        $account->glacc_name = $this->input->post('glacc_name');
        if ($account->save()) {
            $this->session->set_flashdata('message', 'Chart of Account successfully created.');
            redirect('accounts/');
        } else {
            // Failed
            $asset->error_message('custom', 'Field required');
            $msg = $asset->error->custom;
            $this->session->set_flashdata('message', $msg);
            redirect('accounts/add');
        }
    }

    function update() {
        //filter_access(__CLASS__, "edit");
        $account = new Account();
        $status = $this->input->post('glacc_parent_stat') == "on" ? "y":"n";
        $account->where('glacc_id', $this->input->post('glacc_id'))
                ->update(array(
                    'glacc_parent' => $this->input->post('glacc_parent'),
                    'glacc_parent_stat' => $status,
                    'glacc_no'=>$this->input->post('glacc_no'),
                    'glacc_name'=>$this->input->post('glacc_name')
                        )
        );

        $this->session->set_flashdata('message', 'Chart of Account Update successfuly.');
        redirect('accounts/');
    }

    function delete($id) {
        filter_access(__CLASS__, "delete");
        $account = new Account();
        $account->_delete($id);

        $this->session->set_flashdata('message', 'Chart of Account successfully deleted!');
        redirect('accounts/');
    }
    
    function get_account_number($key){
      $account = new Account();
      echo json_encode($account->get_account_number($key)->result());
    }
    
    function get(){
      $account = new Account();
      $id = $this->uri->segment(3);
      echo $account->where('glacc_id', $id)->get()->glacc_no;
    }

}
