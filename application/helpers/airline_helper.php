<?php
function get_airline($id){
  $ci = &get_instance();
  $ci->load->model("Airline_model", "airline");
  $items = $ci->airline->get($id)->row();
  return $items;
}