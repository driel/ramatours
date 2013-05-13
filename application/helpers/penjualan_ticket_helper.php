<?php
function get_items($tix_id){
  $ci = &get_instance();
  $ci->load->model("Penjualan_Ticket_Model", "penjualan");
  $items = $ci->penjualan->get_items($tix_id);
  return $items;
}

function invoice_number_format($invoice_no, $prefix, $year){
  $setting = new Setting();
  $invoice_no_len = strlen($invoice_no); // fetch from penjualan_ticket.tix_invoice_no
  $invoice_len = $setting->get_val("invoice_number_length");
  $zero_count = $invoice_len - $invoice_no_len;
  
  $invoice = str_repeat("0", $zero_count).$invoice_no."/".$prefix."-".substr($year, 0, 4);
  return $invoice;
}