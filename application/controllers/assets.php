<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assets extends CI_Controller {

    private $limit = 10;

    function __construct() {
        parent::__construct();
        $this->load->model('Asset');
        $this->load->model('Asset_Detail');
        $this->sess_username = $this->session->userdata('username');
        $this->sess_role_id = $this->session->userdata('sess_role_id');
        $this->sess_staff_id = $this->session->userdata('sess_staff_id');
        $this->session->userdata('logged_in') == true ? '' : redirect('users/sign_in');
    }

    public function index($offset = 0) {
        filter_access(__CLASS__, "view");
        $asset_list = new Asset();
        $data['staff'] = new Staff();

        switch ($this->input->get('c')) {
            case "1":
                $data['col'] = "asset_name";
                break;
            case "2":
                $data['col'] = "asset_status";
                break;
            case "3":
                $data['col'] = "staff_id";
                break;
            case "4":
                $data['col'] = "date";
                break;
            case "5":
                $data['col'] = "asset_id";
                break;
            default:
                $data['col'] = "asset_id";
        }

        if ($this->input->get('d') == "1") {
            $data['dir'] = "DESC";
        } else {
            $data['dir'] = "ASC";
        }

        $total_rows = $asset_list->count();
        $data['title'] = "Assets";
        $data['btn_add'] = anchor('assets/add', 'Add New', array('class' => 'btn btn-primary'));
        $data['btn_home'] = anchor(base_url(), 'Home', array('class' => 'btn'));

        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        $asset_list->order_by($data['col'], $data['dir']);
        $data['asset_list'] = $asset_list->get($this->limit, $offset)->all;

        $config['base_url'] = site_url("assets/index");
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('assets/index', $data);
    }

    function add() {
        filter_access(__CLASS__, "add");
        $data['title'] = 'Add New Asset';
        $data['form_action'] = site_url('assets/save');
        $data['link_back'] = anchor('assets/', 'Back', array('class' => 'btn btn-danger'));

        $data['id'] = '';
        $data['asset_name'] = array('name' => 'asset_name');
        
        $data["date_buy"] = array("name"=>"date_buy", "class"=>"datepicker");
        $data["date_terms"] = array("name"=>"date_terms", "class"=>"datepicker");
        $data["description"] = array("name"=>"description", "id"=>"description");
        $data["code"] = array("name"=>"code");
        
        $data["status"] = form_checkbox(array('name'=>'asset_status', 'id'=>'status'));
        
        $branch = new Branch();
        $list_branch = $branch->list_drop();
        $data["branch"] = form_dropdown('branch', $list_branch, '');

        // Staffs
        $staff = new Staff();
        $list_staff = $staff->list_drop();
        $staff_selected = '';
        $data['staff_id'] = form_dropdown('staff_id', $list_staff, $staff_selected);

        $data['date'] = array('name' => 'date', 'id' => 'date');
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');

        $this->load->view('assets/frm_assets', $data);
    }

    function edit($id) {
        filter_access(__CLASS__, "edit");
        $asset = new Asset();
        $rs = $asset->where('asset_id', $id)->get();
        $data['id'] = $rs->asset_id;
        $data['asset_name'] = array('name' => 'asset_name', 'value' => $rs->asset_name);
        $status_selected = $rs->asset_status == 'enable' ? TRUE:FALSE;
        $data["status"] = form_checkbox(array('name'=>'asset_status', 'id'=>'status', 'checked'=>$status_selected));

        // Staffs
        $staff = new Staff();
        $list_staff = $staff->list_drop();
        $staff_selected = $rs->staff_id;
        $data['staff_id'] = form_dropdown('staff_id', $list_staff, $staff_selected);
        
        $branch = new Branch();
        $list_branch = $branch->list_drop();
        $data["branch"] = form_dropdown('branch', $list_branch, $rs->branch);
        
        $data["date_buy"] = array("name"=>"date_buy", "class"=>"datepicker", "value"=>$rs->date_buy);
        $data["date_terms"] = array("name"=>"date_terms", "class"=>"datepicker", "value"=>$rs->date_tempo);
        $data["description"] = array("name"=>"description", "id"=>"description", "value"=>$rs->description);
        $data["code"] = array("name"=>"code", "value"=>$rs->asset_code);


        $data['date'] = array('name' => 'date', 'id' => 'date', 'value' => $rs->date);
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Update', 'class' => 'btn btn-primary');

        $data['title'] = 'Update';
        $data['form_action'] = site_url('assets/update');
        $data['link_back'] = anchor('assets/', 'Back', array('class' => 'btn btn-danger'));

        $this->load->view('assets/frm_assets', $data);
    }

    function save() {
        filter_access(__CLASS__, "add");
        $asset = new Asset();
        $asset->asset_name = $this->input->post('asset_name');
        $asset->asset_status = $this->input->post('asset_status') == "on" ? "enable":"disable" ;
        $asset->date_buy = $this->input->post('date_buy');
        $asset->date_tempo = $this->input->post('date_terms');
        $asset->description = $this->input->post('description');
        $asset->asset_code = $this->input->post('code');
        $asset->branch = $this->input->post('branch');
        if ($asset->save()) {
            $this->session->set_flashdata('message', 'Asset successfully created!');
            redirect('assets/');
        } else {
            // Failed
            $asset->error_message('custom', 'Field required');
            $msg = $asset->error->custom;
            $this->session->set_flashdata('message', $msg);
            redirect('assets/add');
        }
    }

    function update() {
        filter_access(__CLASS__, "edit");
        $asset = new Asset();
        $status = $this->input->post('asset_status') == "on" ? "enable":"disable";
        $asset->where('asset_id', $this->input->post('id'))
                ->update(array(
                    'asset_name' => $this->input->post('asset_name'),
                    'asset_code'=> $this->input->post('code'),
                    'date_buy'=>$this->input->post('date_buy'),
                    'date_tempo'=>$this->input->post('date_terms'),
                    'asset_status' => $status,
                    'description'=>$this->input->post('description'),
                    'branch'=>$this->input->post('branch')
                        )
        );

        $this->session->set_flashdata('message', 'Asset Update successfuly.');
        //print_r($this->input->post());
        redirect('assets/');
    }

    function delete($id) {
        filter_access(__CLASS__, "delete");
        $asset = new Asset();
        $asset->_delete($id);

        $this->session->set_flashdata('message', 'Asset successfully deleted!');
        redirect('assets/');
    }
  
  	function get_asset($asset_name){
    	$asset = $this->db->like("asset_name", $asset_name)->get("assets");
    	if($asset){
      		echo json_encode($asset->result());
    	}
  	}

    public function report_list($offset = 0) {
        //$this->filter_access('Assets', 'roled_select', base_url());

        $asset_list = new Asset();
        $data['staff'] = new Staff();

        switch ($this->input->get('c')) {
            case "1":
                $data['col'] = "asset_name";
                break;
            case "2":
                $data['col'] = "asset_status";
                break;
            case "3":
                $data['col'] = "staff_id";
                break;
            case "4":
                $data['col'] = "date";
                break;
            case "5":
                $data['col'] = "asset_id";
                break;
            case "6":
                $data['col'] = "branch";
                break;
            default:
                $data['col'] = "asset_id";
        }

        if ($this->input->get('d') == "1") {
            $data['dir'] = "DESC";
        } else {
            $data['dir'] = "ASC";
        }

    	//Asset
		$data["asset"] = form_input(array("id"=>"asset"));
		$data["asset_id"] = form_input(array("name"=>"asset_id", "type"=>"hidden", "id"=>"asset_id"));

        $total_rows = $asset_list->count();
        $data['title'] = "Assets";
        $data['btn_home'] = anchor(base_url(), 'Home', array('class' => 'btn'));

        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

		if ($this->input->get("branch") != "") {
			$asset_list->like('branch',$this->input->get("branch"));
		}

		if ($this->input->get("asset_id") != "") {
			$asset_list->where('asset_id',$this->input->get("asset_id"));
		}

        $asset_list->order_by($data['col'], $data['dir']);
        $data['asset_list'] = $asset_list->get($this->limit, $offset)->all;

		// Branch
        $branch = new Branch();
        $list_branch = $branch->list_drop();
        $branch_selected = $this->input->get('branch');
        $data['branch'] = form_dropdown('branch',
                        $list_branch,
                        $branch_selected);

		if ($this->input->get('to') == 'pdf') {
			$this->load->library('html2pdf');

			$this->html2pdf->filename = 'asset_list_report.pdf';
	    	$this->html2pdf->paper('a4', 'landscape');
	    	$this->html2pdf->html($this->load->view('assets/to_pdf', $data, true));
	    
	    	$this->html2pdf->create();
    	} else if ($this->input->get('to') == 'xls') {
    		$param['file_name'] = 'asset_list_report.xls';
    		$param['content_sheet'] = $this->load->view('assets/to_pdf', $data, true);
    		$this->load->view('to_excel',$param);
		} else if($this->input->get('to') == 'print'){
        	$this->load->view('assets/to_pdf', $data);
        } else {
	        $config['base_url'] = site_url("assets/index");
	        $config['total_rows'] = $total_rows;
	        $config['per_page'] = $this->limit;
	        $config['uri_segment'] = $uri_segment;
	        $this->pagination->initialize($config);
	        $data['pagination'] = $this->pagination->create_links();

        	$this->load->view('assets/report_list', $data);
        }
    }

}