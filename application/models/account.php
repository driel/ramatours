<?php

class Account extends DataMapper {

  var $table = "chart_of_account";
  var $has_many = array("chart_of_account_detail");
  var $validation = array(
      'glacc_no' => array(
          'label' => 'Account No',
          'rules' => array('required')
      ),
      'glacc_name' => array(
          'label' => 'Account Name',
          'rules' => array('required')
      )
  );

  function __construct() {
    parent::__construct();
  }

  function _delete($id) {
    $this->db->where('glacc_id', $id);
    $this->db->delete($this->table);
  }

  function list_drop() {
    $data = array();
    $account = new Account();
    $account->get();
    foreach ($account as $row) {
      $data["0"] = "[ Pilih Kode Akun ]";
      $data[$row->glacc_id] = $row->glacc_name;
    }
    return $data;
  }

}

?>
