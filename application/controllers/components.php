<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Components extends CI_Controller {

    private $limit = 10;

    public function __construct() {
        parent::__construct();
        $this->load->model('Component');
        $this->sess_username = $this->session->userdata('username');
        $this->sess_role_id = $this->session->userdata('sess_role_id');
        $this->sess_staff_id = $this->session->userdata('sess_staff_id');
        $this->session->userdata('logged_in') == true ? '' : redirect('users/sign_in');
    }

    public function index($offset = 0) {
        filter_access('Component', 'view');

        $component = new Component();
        switch ($this->input->get('c')) {
            case "1":
                $data['col'] = "comp_name";
                break;
            case "2":
                $data['col'] = "comp_type";
                break;
            case "3":
                $data['col'] = "comp_id";
                break;
            default:
                $data['col'] = "comp_id";
        }

        if ($this->input->get('d') == "1") {
            $data['dir'] = "DESC";
        } else {
            $data['dir'] = "ASC";
        }


        $data['title'] = "Component";
        $data['btn_add'] = anchor('components/add', 'Add New', array("class" => "btn btn-primary"));
        $data['btn_home'] = anchor(base_url(), 'Home');

        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        if ($this->input->get('search_by')) {
            $total_rows = $component->like($_GET['search_by'], $_GET['q'])->count();
            $component->like($_GET['search_by'], $_GET['q'])->order_by($data['col'], $data['dir']);
        } else {
            $total_rows = $component->count();
            $component->order_by($data['col'], $data['dir']);
        }


        $data['components'] = $component->get($this->limit, $offset)->all;

        $config['base_url'] = site_url("components/index");
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('components/index', $data);
    }

    function add() {
        filter_access('Component', 'add');
        $data['title'] = 'Add New Gaji';
        $data['form_action'] = site_url('components/save');
        $data['link_back'] = anchor('components/', 'Back', array("class" => "btn btn-danger"));

        $options = array(
            'Daily' => 'Daily',
            'Monthly' => 'Monthly',
            'Yearly' => 'Yearly',
        );
        $data['id'] = '';
        $selected = 'Monthly';
        $data['comp_name'] = array('name' => 'comp_name');
        $data['comp_type'] = form_dropdown('comp_type', $options, $selected);
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Save', "class" => "btn btn-primary");

        $this->load->view('components/frm_components', $data);
    }

    function edit($id) {
        filter_access('Component', 'edit');
        $component = new Component();
        $rs = $component->where('comp_id', $id)->get();
        $options = array(
            'Daily' => 'Daily',
            'Monthly' => 'Monthly',
            'Yearly' => 'Yearly',
        );
        $selected = $rs->comp_type;
        $data['id'] = $rs->comp_id;
        $data['comp_type'] = form_dropdown('comp_type', $options, $selected);
        $data['comp_name'] = array('name' => 'comp_name', 'value' => $rs->comp_name);
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Update', 'class' => 'btn btn-primary');

        $data['title'] = 'Update';
        $data['form_action'] = site_url('components/update');
        $data['link_back'] = anchor('components/', 'Back', array("class" => "btn btn-danger"));

        $this->load->view('components/frm_components', $data);
    }

    function save() {
        filter_access('Component', 'add');
        $component = new Component();
        $component->comp_name = $this->input->post('comp_name');
        $component->comp_type = $this->input->post('comp_type');
        if ($component->save()) {
            $this->session->set_flashdata('message', 'Component successfully created!');
            redirect('components/');
        } else {
            // Failed
            $component->error_message('custom', 'Component Name required');
            $msg = $component->error->custom;
            $this->session->set_flashdata('message', $msg);
            redirect('components/add');
        }
    }

    function update() {
        filter_access('Component', 'edit');
        $component = new Component();
        $component->where('comp_id', $this->input->post('id'))
                ->update(array(
                    'comp_name' => $this->input->post('comp_name'),
                    'comp_type' => $this->input->post('comp_type')
                ));

        $this->session->set_flashdata('message', 'Component Update successfuly.');
        redirect('components/');
    }

    function delete($id) {
        filter_access('Component', 'delete');
        $component = new Component();
        $component->_delete($id);

        $this->session->set_flashdata('message', 'Component successfully deleted!');
        redirect('components/');
    }

    function to_excel() {
        $this->load->view('components/to_excel');
    }
    
    function get_components(){
      $component = new Component();
      $components = $component->get()->all;
      $data = array();
      $i = 0;
      foreach($components as $x){
        $data[$i]["comp_name"] = $x->comp_name;
        $data[$i]["comp_type"] = $x->comp_type;
        $i++;
      }
      echo json_encode($data);
    }
    
    function get_where_component(){
      $comp = urldecode($this->uri->segment(3));
      $component = new Component();
      $component = $component->where("comp_name", $comp)->get();
      $components = array("comp_type"=>$component->comp_type, "id"=>$component->comp_id);
      echo json_encode($components);
    }

    public function report_detail($offset = 0) {
		$this->load->helper(array('report','bulan'));

        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

		// Period
        $list_period = array();
		for ($i=1; $i<=12; $i++) {
            if ($i < 10) { $i = '0'.$i; }
            $list_period[date('Y').'-'.$i] = bulan(date('Y').'-'.$i).' '.(date('Y'));
        }
        
        $period_selected = $this->input->get('period') == ''? date('Y-m'):$this->input->get('period');
        $data['period'] = form_dropdown('period',
                        $list_period,
                        $period_selected);

		// Branch
        $branch = new Branch();
        $list_branch = $branch->list_drop();
        $branch_selected = $this->input->get('staff_cabang');
        $data['staff_cabang'] = form_dropdown('staff_cabang',
                        $list_branch,
                        $branch_selected);

		// Departement
        $dept = new Department();
        $list_dpt = $dept->list_drop();
        $dpt_selected = $this->input->get('staff_departement');
        $data['staff_departement'] = form_dropdown('staff_departement',
                        $list_dpt,
                        $dpt_selected);

		//Jabatan
        $title = new Title();
        $list_jbt = $title->list_drop();
        $jbt_selected = $this->input->get('staff_jabatan');
        $data['staff_jabatan'] = form_dropdown('staff_jabatan',
                        $list_jbt,
                        $jbt_selected);

		$data['staff_name'] = array('name' => 'staff_name', 'value' => $this->input->get('staff_name'));

    	$this->db->select('staffs.staff_id,staffs.staff_name,staffs.staff_cabang,staffs.staff_departement,staffs.staff_jabatan,staffs.pph_by_company,absensi.hari_masuk,cuti.date_start,cuti.date_end,izin.izin_jumlah_hari');
    	$this->db->join('branches','branches.branch_name=staffs.staff_cabang');
    	$this->db->join('absensi','absensi.staff_id=staffs.staff_id','left');
    	$this->db->join('cuti','cuti.staff_id=staffs.staff_id AND `cuti`.`status` =  \'approve\'','left');
    	$this->db->join('izin','izin.izin_staff_id=staffs.staff_id','left');

		if ($this->input->get("period") != "") {
			$this->db->where("DATE_FORMAT(absensi.date,'%Y-%m')",$this->input->get("period"));
		} else {
			$this->db->where("DATE_FORMAT(absensi.date,'%Y-%m')",$period_selected);
		}

		$data['period_selected'] = $period_selected;

		if ($this->input->get("staff_cabang") != "") {
			$this->db->like('staffs.staff_cabang',$this->input->get("staff_cabang"));
		}

		if ($this->input->get("staff_departement") != "") {
			$this->db->like('staffs.staff_departement',$this->input->get("staff_departement"));
		}

		if ($this->input->get("staff_jabatan") != "") {
			$this->db->like('staffs.staff_jabatan',$this->input->get("staff_jabatan"));
		}

		if ($this->input->get("staff_name") != "") {
			$this->db->like('staffs.staff_name',$this->input->get("staff_name"));
		}

    	$this->db->order_by('branches.branch_name', 'ASC');
    	$this->db->limit($this->limit, $offset);
    	$staff_branch = $this->db->get('staffs');
        $total_rows = $staff_branch->num_rows();

    	$data['staff_branch'] = $staff_branch;

		if ($this->input->get('to') == 'pdf') {
			$this->load->library('html2pdf');

			$this->html2pdf->filename = 'detail_staff_component_report.pdf';
	    	$this->html2pdf->paper('a4', 'landscape');
	    	$this->html2pdf->html($this->load->view('components/detail_to_pdf', $data, true));
	    
	    	$this->html2pdf->create();
    	} else if ($this->input->get('to') == 'xls') {
    		$param['file_name'] = 'detail_staff_component_report.xls';
    		$param['content_sheet'] = $this->load->view('components/detail_to_pdf', $data, true);
    		$this->load->view('to_excel',$param);
		} else {
	        $config['base_url'] = site_url("components/report_detail");
	        $config['total_rows'] = $total_rows;
	        $config['per_page'] = $this->limit;
	        $config['uri_segment'] = $uri_segment;
	        $this->pagination->initialize($config);
	        $data['pagination'] = $this->pagination->create_links();

        	$this->load->view('components/report_detail', $data);
        }
    }

    public function report_recap($offset = 0) {
		$this->load->helper(array('report','bulan'));

        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

		// Period by
        $period_by_selected = $this->input->get('period_by') == ''? 'Monthly':$this->input->get('period_by');
        $data['period_by'] = form_dropdown('period_by',
                        array('Monthly'=>'Monthly','Yearly'=>'Yearly'),
                        $period_by_selected,'id="period_by"');

		$data['period_by_selected'] = $period_by_selected;

		// Monthly Period
        $list_period = array();
		for ($i=1; $i<=12; $i++) {
            if ($i < 10) { $i = '0'.$i; }
            $list_period[date('Y').'-'.$i] = bulan(date('Y').'-'.$i).' '.(date('Y'));
        }
        
        $period_selected = $this->input->get('period') == ''? date('Y-m'):$this->input->get('period');
        $data['period'] = form_dropdown('period',
                        $list_period,
                        $period_selected);

		$data['period_selected'] = $period_selected;

		// Yearly Period
        $years = array();
		for($i=date('Y'); $i>(date('Y')-5); $i--) {
	  		$years[$i] = $i;
	  	}

        $year_selected = $this->input->get('yearly') == ''? date('Y'):$this->input->get('yearly');
        $data['yearly'] = form_dropdown('yearly',
                        $years,
                        $year_selected);

		$data['year_selected'] = $year_selected;

		// Branch
        $branch = new Branch();
        $list_branch = $branch->list_drop();
        $branch_selected = $this->input->get('branch');
        $data['branch'] = form_dropdown('branch',
                        $list_branch,
                        $branch_selected);

		// Yearly by
        $yearly_by_selected = $this->input->get('yearly_by') == ''? 'Staff':$this->input->get('yearly_by');
        $data['yearly_by'] = form_dropdown('yearly_by',
                        array('Staff'=>'Staff','Branch'=>'Branch'),
                        $yearly_by_selected,'id="yearly_by"');

		$data['yearly_by_selected'] = $yearly_by_selected;

		if ($period_by_selected == 'Yearly' && $yearly_by_selected == 'Staff') {
    		$this->db->join('branches','branches.branch_name=staffs.staff_cabang','left');
			$this->db->order_by('branches.branch_name', 'ASC');
	    	$this->db->limit($this->limit, $offset);
	    	$staff_branch = $this->db->get('staffs');
	        $total_rows = $staff_branch->num_rows();

    		$data['staff_branch'] = $staff_branch;
		} else {
			if ($this->input->get("branch") != "" && $period_by_selected == 'Monthly') {
				$this->db->like('branch_name',$this->input->get("branch"));
			}

	    	$this->db->order_by('branch_id', 'ASC');
	    	$this->db->limit($this->limit, $offset);
	    	$branches = $this->db->get('branches');
	        $total_rows = $branches->num_rows();

    		$data['branches'] = $branches;
    	}

		if ($this->input->get('to') == 'pdf') {
			$this->load->library('html2pdf');

			$this->html2pdf->filename = strtolower($period_by_selected).'_'.strtolower($period_by_selected == 'Yearly' && $yearly_by_selected == 'Branch'? 'branch_':'').'recap_component_report.pdf';
	    	$this->html2pdf->paper('a4', 'landscape');
	    	$this->html2pdf->html($this->load->view('components/recap_to_pdf', $data, true));

	    	$this->html2pdf->create();
    	} else if ($this->input->get('to') == 'xls') {
    		$param['file_name'] = strtolower($period_by_selected).'_'.strtolower($period_by_selected == 'Yearly' && $yearly_by_selected == 'Branch'? 'branch_':'').'recap_component_report.xls';
    		$param['content_sheet'] = $this->load->view('components/recap_to_pdf', $data, true);
    		$this->load->view('to_excel',$param);
		} else {
	        $config['base_url'] = site_url("components/report_recap");
	        $config['total_rows'] = $total_rows;
	        $config['per_page'] = $this->limit;
	        $config['uri_segment'] = $uri_segment;
	        $this->pagination->initialize($config);
	        $data['pagination'] = $this->pagination->create_links();

        	$this->load->view('components/report_recap', $data);
        }
    }

}