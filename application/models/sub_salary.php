<?php

class Sub_Salary extends DataMapper {

    public $table = "sub_salaries";
    public $validation = array(
        'salary_amount_value' => array(
            'label' => 'Branch Name',
            'rules' => array('required')
        )
    );

    function __construct() {
        parent::__construct();
    }

    function _delete($id) {
        $this->db->where('sub_id', $id);
        $this->db->delete($this->table);
    }

}

?>