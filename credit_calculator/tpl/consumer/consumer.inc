<?php


function consumer_credits_list(){
  
  $query = db_query("SELECT  n.nid FROM node n INNER JOIN field_data_field_credit_type  credit_type ON credit_type.entity_id = n.nid WHERE n.status = 1 AND n.language = :lang AND credit_type.field_credit_type_value = 'consumer'", array(":lang" => $GLOBALS['language']->language));
  $nids = $query->fetchAll(PDO::FETCH_COLUMN);

  $consumer_credits = node_load_multiple($nids);

  return theme('consumer_calculator_list', array('consumer_credits' => $consumer_credits));
}

function consumer_credit_detail($nid){
  $consumer_data = node_load($nid);
  return theme('consumer_credit_details', array('nid' => $nid, 'consumer_data' => $consumer_data));
}