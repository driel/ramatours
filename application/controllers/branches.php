<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Branches extends CI_Controller {

    private $limit = 10;

    public function __construct() {
        parent::__construct();
        $this->load->helper('bulan');
        $this->load->model('Branch');
        $this->sess_username = $this->session->userdata('username');
        $this->sess_role_id = $this->session->userdata('sess_role_id');
        $this->sess_staff_id = $this->session->userdata('sess_staff_id');
        $this->session->userdata('logged_in') == true ? '' : redirect('users/sign_in');
    }

    public function index($offset = 0) {
        filter_access("Branch", "view");

        $branch_list = new Branch();

        switch ($this->input->get('c')) {
            case "1":
                $data['col'] = "branch_name";
                break;
            case "2":
                $data['col'] = "branch_id";
                break;
            default:
                $data['col'] = "branch_id";
        }

        if ($this->input->get('d') == "1") {
            $data['dir'] = "DESC";
        } else {
            $data['dir'] = "ASC";
        }

        $data['title'] = "Branch";
        $data['btn_add'] = anchor('branches/add', 'Add New', "class='btn btn-primary'");
        $data['btn_home'] = anchor(base_url(), 'Home', "class='btn btn-home'");

        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        if ($this->input->get('search_by')) {
            $total_rows = $branch_list->like($_GET['search_by'], $_GET['q'])->count();
            $branch_list->like($_GET['search_by'], $_GET['q'])->order_by($data['col'], $data['dir']);
        } else {
            $total_rows = $branch_list->count();
            $branch_list->order_by($data['col'], $data['dir']);
        }

        $data['branch_list'] = $branch_list->get($this->limit, $offset)->all;

        $config['base_url'] = site_url("branches/index");
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('branches/index', $data);
    }

    function add() {
        filter_access("Branch", "add");

        $data['title'] = 'Add New Branch';
        $data['form_action'] = site_url('branches/save');
        $data['link_back'] = anchor('branches/', 'Back', array('class' => 'btn btn-danger'));

        $data['id'] = '';
        
        $data['branch_name'] = array('name' => 'branch_name');
        $data['branch_number_invoice_ticketing'] = array('name'=>'branch_number_ticketing_invoice');
        $data['branch_number_invoice'] = array('name'=>'branch_number_invoice');
        $data['branch_number_invoice_optional'] = array('name'=>'branch_number_invoice_optional');
        $data['branch_number_voucher'] = array('name'=>'branch_number_voucher');
        $data['branch_prefix_invoice'] = array('name'=>'branch_prefix_invoice');
        
        $data['branch_invoice_name'] = array('name'=>'branch_invoice_name');
        $data['branch_invoice_title'] = array('name'=>'branch_invoice_title');
        
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Save', "class" => "btn btn-primary");

        $this->load->view('branches/frm_branch', $data);
    }

    function edit($id) {
        filter_access("Branch", "edit");

        $branch = new Branch();
        $rs = $branch->where('branch_id', $id)->get();
        $data['id'] = $rs->branch_id;
        
        $data['branch_name'] = array('name' => 'branch_name', 'value' => $rs->branch_name);
        $data['branch_number_invoice_ticketing'] = array('name'=>'branch_number_ticketing_invoice', 'value'=>$rs->branch_number_ticketing_invoice);
        $data['branch_number_invoice'] = array('name'=>'branch_number_invoice', 'value'=>$rs->branch_number_invoice);
        $data['branch_number_invoice_optional'] = array('name'=>'branch_number_invoice_optional', 'value'=>$rs->branch_number_invoice_optional);
        $data['branch_number_voucher'] = array('name'=>'branch_number_voucher', 'value'=>$rs->branch_number_voucher);
        $data['branch_prefix_invoice'] = array('name'=>'branch_prefix_invoice', 'value'=>$rs->branch_prefix_invoice);
        
        $data['branch_invoice_name'] = array('name'=>'branch_invoice_name', 'value'=>$rs->branch_invoice_name);
        $data['branch_invoice_title'] = array('name'=>'branch_invoice_title', 'value'=>$rs->branch_invoice_title);
        
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Update', "class" => "btn btn-primary");

        $data['title'] = 'Update Branch';
        $data['form_action'] = site_url('branches/update');
        $data['link_back'] = anchor('branches/', 'Back', array("class" => "btn btn-danger"));

        $this->load->view('branches/frm_branch', $data);
    }

    function save() {
        filter_access("Branch", "add");

        $branch = new Branch();
        $branch->branch_name = $this->input->post('branch_name');
        $branch->branch_number_ticketing_invoice = $this->input->post("branch_number_ticketing_invoice");
        $branch->branch_number_invoice = $this->input->post("branch_number_invoice");
        $branch->branch_number_invoice_optional = $this->input->post("branch_number_invoice_optional");
        $branch->branch_number_voucher = $this->input->post("branch_number_voucher");
        $branch->branch_prefix_invoice = $this->input->post("branch_prefix_invoice");
        $branch->branch_invoice_name = $this->input->post("branch_invoice_name");
        $branch->branch_invoice_title = $this->input->post("branch_invoice_title");
        if ($branch->save()) {
            $this->session->set_flashdata('message', 'Branch successfully created!');
            redirect('branches/');
        } else {
            // Failed
            $branch->error_message('custom', 'Branch Name required');
            $msg = $branch->error->custom;
            $this->session->set_flashdata('message', $msg);
            redirect('branches/add');
        }
    }

    function update() {
        filter_access("Branch", "edit");

        $branch = new Branch();
        $branch->where('branch_id', $this->input->post('id'))->update(array(
            "branch_name"=>$this->input->post('branch_name'),
            "branch_number_ticketing_invoice"=>$this->input->post("branch_number_ticketing_invoice"),
            "branch_number_invoice"=>$this->input->post("branch_number_invoice"),
            "branch_number_invoice_optional"=>$this->input->post("branch_number_voucher"),
            "branch_prefix_invoice"=>$this->input->post("branch_prefix_invoice"),
            "branch_invoice_name"=>$this->input->post("branch_invoice_name"),
            "branch_invoice_title"=>$this->input->post("branch_invoice_title")
        ));

        $this->session->set_flashdata('message', 'Branch Update successfuly.');
        redirect('branches/');
    }

    function delete($id) {
        filter_access("Branch", "delete");

        $branch = new Branch();
        $branch->_delete($id);

        $this->session->set_flashdata('message', 'Branch successfully deleted!');
        redirect('branches/');
    }

    function get_employee_per_branch() {
        sleep(1);
        $arr = array();
        $bln = array();
        $query = $this->db->query("SELECT DISTINCT DATE_FORMAT(created_at, '%Y-%m') 
            AS Month, COUNT(staff_id)
            AS iCount FROM staffs GROUP BY Month ORDER BY Month ASC");
        foreach ($query->result() as $row) {
            $arr[] = $row->iCount;
            $bln[] = bulan($row->Month);
        }
        $b = json_encode($bln);
        $x = json_encode($arr);
        $y = str_replace('"', '', $x);
        $result = array($y, $b);
        echo json_encode($bln);
    }

    function to_excel() {
        $this->load->view('branches/to_excel');
    }
    
    function update_invoice_number($id){
      $branch = new Branch();
      $last_number = $branch->where("branch_id", $id)->get()->branch_number_ticketing_invoice;
      $updated_number = ++$last_number;
      $branch->where("branch_id", $id)->update("branch_number_ticketing_invoice", $updated_number);
      echo $updated_number;
    }

}

