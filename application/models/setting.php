<?php

class Setting extends DataMapper {

    public $table = "settings";
    public $validation = array(
        'name' => array(
            'label' => 'Config Name',
            'rules' => array('required')
        )
    );

    function __construct() {
        parent::__construct();
    }


     function update($k, $v){
        $this->db->like('name', $k);
        $this->db->from($this->table);
        $count = $this->db->count_all_results();
        if($count==0){
          $this->db->insert($this->table, array("name"=>$k, "value"=>$v));
        }else{
          $this->db->update($this->table, array("name"=>$k, "value"=>$v), array("name"=>$k));
        }
      }
      
      function get_val($key){
        $setting = new Setting();
        $result = $setting->where("name", $key)->get();
        return $result->value;
      }


}

?>
