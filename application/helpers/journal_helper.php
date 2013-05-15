<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_journal_detail')) {
	function get_journal_detail($id){
  		$ci = &get_instance();
  		$result = $ci->db->get_where("journal_detail", array("gltr_id"=>$id));
  		return $result;
	}
}

if (!function_exists('get_account')) {
	function get_account($acc_no){
  		$ci = &get_instance();
  		$result = $ci->db->get_where("chart_of_account", array("glacc_no"=>$acc_no))->row();
  		return $result;
	}
}

if (!function_exists('posting_journal')) {
	function posting_journal($period){
		$status = false;

  		$ci = &get_instance();
  		$journal = $ci->db->get_where("journal", array("gltr_date"=>$date))->row();
  		$journal_detail = $ci->db->get_where("journal_detail", array("gltr_id"=>$journal->gltr_id));

		$debit = 0;
		$credit = 0;
		foreach($journal_detail->result() as $row) {
			$debit += $row->gltr_dr;
			$credit += $row->gltr_cr;
		}

		if ($ci->db->update("journal",array("gltr_status"=>"Post"),array("gltr_date"=>$period))) {
			$coa_detail = $ci->db->get_where("chart_of_account_detail", array("glacc_period"=>$period))->row();
			if ($coa_detail->num_rows() == 0) {
				$status = $ci->db->insert("chart_of_account_detail",array("glacc_period"=>$period,"glacc_saldo"=>($debit-$credit),"glacc_dr"=>$debit,"glacc_cr"=>$credit));
			} else {
				$status = $ci->db->update("chart_of_account_detail",array("glacc_saldo"=>($coa_detail->glacc_saldo+($debit-$credit)),"glacc_dr"=>($coa_detail->glacc_dr+$debit),"glacc_cr"=>($coa_detail->glacc_cr+$credit)),array("glacc_period"=>$period));
			}
		}

  		return $status;
	}
}