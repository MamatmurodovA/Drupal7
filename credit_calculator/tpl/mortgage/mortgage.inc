<?php


function mortgage_credits_list(){
  $query = db_query("SELECT  n.nid FROM node n INNER JOIN field_data_field_credit_type  credit_type ON credit_type.entity_id = n.nid WHERE n.status = 1 AND n.language = :lang AND credit_type.field_credit_type_value = 'mortgage'", array(":lang" => $GLOBALS['language']->language));
  $nids = $query->fetchAll(PDO::FETCH_COLUMN);
  
  $mortgages = node_load_multiple($nids);
  return theme('mortgage_calculator_list', array('mortgages' => $mortgages));
}

function mortgage_credit_detail(){
  $mortgage = node_load(arg(2));
  return theme('mortgage_credit_details', array('mortgage' => $mortgage));
}
function reformat_payment($payment){
  return sprintf("%.2f", $payment);
};
function get_calculator_data($credit_sum, $percent, $months, $current_month){
  
  $percent = $percent / 100;
  $result = array();
  $result['main_debit_for_per_month'] = $credit_sum / $months;
  
  if($current_month == 1){
	$total_credit = $credit_sum;
  }else{
	$total_credit = $credit_sum - $result['main_debit_for_per_month'] * $current_month;
	$total_credit = ($total_credit > 0)? $total_credit : 0;
  }
  
  $result['debit_percent'] = $total_credit * $percent / 12;
  $result['total_payment'] = $result['debit_percent'] + $result['main_debit_for_per_month'];
  
  $result['credit_sum'] = $total_credit;
  
  return $result;
}

function calculator_data_young_family($credit_sum, $percent, $months, $current_month, $grace_period){
  $percent = $percent / 100;
  $result = array();
  if ($current_month <= $grace_period){
	$result['main_debit_for_per_month'] = 0;
	
	$total_credit = $credit_sum;
	
	$result['debit_percent'] = $total_credit * $percent / 12;
	
  }else{
	
	$result['main_debit_for_per_month'] = $credit_sum / ($months - $grace_period);
	
	if($current_month == 1){
	  $total_credit = $credit_sum;
	}else{
	  $total_credit = $credit_sum - $result['main_debit_for_per_month'] * $current_month;
	  $total_credit = ($total_credit > 0)? $total_credit : 0;
	}
	
	$result['debit_percent'] = $total_credit * $percent / 12;
	
  }
  
  $result['total_payment'] = $result['debit_percent'] + $result['main_debit_for_per_month'];
  $result['credit_sum'] = $total_credit;
  
  return $result;
}

function mortgage_credit_calculate_result(){
  $mortgage = node_load(arg(2));
  $credit_sum = $_GET['credit_sum'];
  $credit_sum = $credit_sum - $credit_sum * $mortgage->field_first_payment['und'][0]['value'] / 100;
  return theme('mortgage_credit_calculate_results', array('mortgage' => $mortgage, 'credit_sum' => $credit_sum));
}
