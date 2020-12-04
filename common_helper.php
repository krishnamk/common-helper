<?php
/**
 * This function Used to display messages in bootstrap design from codeigniter
 * just message(); used to display session variable msg contant into live
 */
function message(){
	$CI =& get_instance();
	if(!empty($CI->session->userdata('msg'))){
		if($CI->session->userdata('msg')['result']== 'failed'){
			echo "<p class='alert alert-danger'>".$CI->session->userdata('msg')['message']."</p>";
		}elseif($CI->session->userdata('msg')['result']== 'warning'){
			echo "<p class='alert alert-warning'>".$CI->session->userdata('msg')['message']."</p>";
		}else{
			echo "<p class='alert alert-success'>".$CI->session->userdata('msg')['message']."</p>";
		}
		//echo "<script> Notify('Thank You! All of your information saved successfully.', 'bottom-right', '5000', 'blue', 'fa-check', true); </script>";
		$CI->session->unset_userdata('msg');
	}
}
/**
 * This function used to return session messsage return to ajax function
 * @param  [array] $message message array
 */
function return_message($message){
	if($message['result']== 'failed'){
		$list = "<p class='alert alert-danger'>".$message['message']."</p>";
	}elseif($message['result']== 'warning'){
		$list = "<p class='alert alert-warning'>".$message['message']."</p>";
	}else{
		$list = "<p class='alert alert-success'>".$message['message']."</p>";
	}
	return $list;
}
function created_on($format ='Y-m-d H:i:s'){
	return date($format);
}
function created_by(){
	$CI = &get_instance();
	return $CI->session->userdata('user_id');
}
function me(){
	$CI = &get_instance();
	return $CI->session->userdata('user_id');
}
function updated_on($format ='Y-m-d H:i:s'){
	return date($format);
}
function empty_datetime(){
	return '0000-00-00 00:00:00';
}
/**
 * Custom implode used to implode values based on customer need
 */
function custom_implode($first,$second,$implode_value='-'){
	return $first.''.$implode_value.''.$second;
}
/**
 * This function display return next digit , this mainly usefull when foreach function key value display
 */
function next_number($number){
	$number = $number+1;
	return $number;
}
/**
 * Convert multi dimentional arrays into select options
 */
function convert_options($results,$value,$label,$option='',$additonallabelinfo=''){
	$options = '';
	if($option != ''){
		$options .= '<option value=""> SELECT '.$option.'</option>';
	}
	if($results){
		foreach ($results as $key => $result) {
			if($additonallabelinfo!=''){
				$options .= '<option value="'.$result[$value].'">'.$result[$label].'('.$result[$additonallabelinfo].')</options>';
			}else{
				$options .= '<option value="'.$result[$value].'">'.$result[$label].'</options>';
			}
		}
	}
	return $options;
}
function convert_options_selected($results,$value,$label,$option,$selected=''){
	$options = '<option value=""> SELECT '.$option.'</option>';
	if($results){
		foreach ($results as $key => $result) {
			$select = '';
			if($selected == $result[$value]){
				$select = 'selected';
			}
			$options .= '<option '.$select.' value="'.$result[$value].'">'.$result[$label].'</options>';
		}
	}
	return $options;
}
function convert_options_multi_selected($results,$value,$label,$option = "",$selected = array()){
	$options = "";
	if($option != ""){
		$options = '<option value=""> SELECT '.$option.'</option>';
	}
	if($results){
		foreach ($results as $key => $result) {
			$select = '';
			if(!empty($selected)){
				if(in_array($result[$value], $selected)){
					$select = 'selected';
				}
			}
			$options .= '<option '.$select.' value="'.$result[$value].'">'.$result[$label].'</options>';
		}
	}
	return $options;
}
/**
 * Decimal digit maintainer function used to maintain digits after deciaml point(.) this function helps to always maintain digits
 */
function decimal_digit_maintainer($value){
	 define("AFTER_DESIMAL_DIGITS ",2);
	$value_array = explode('.',$value);
	if(isset($value_array[1])){
			$value_array[1] =  str_pad($value_array[1],AFTER_DESIMAL_DIGITS,'0',STR_PAD_RIGHT);
	}else{
		$value_array[1] = '00';
	}
	return implode('.',$value_array);
}
/**
 * Convert nunmbers into words(amount)
 */
function convert_number_to_words($number) {
	$no = round($number);
	$point = round($number - $no, 2) * 100;
	$hundred = null;
	$digits_1 = strlen($no);
	$i = 0;
	$str = array();
	$words = array(
		'0' => '',
		'1' => 'One',
		'2' => 'Two',
		'3' => 'Three',
		'4' => 'Four',
		'5' => 'Five',
		'6' => 'Six',
		'7' => 'Seven',
		'8' => 'Eight',
		'9' => 'Nine',
		'10' => 'Ten',
		'11' => 'Eleven',
		'12' => 'Twelve',
		'13' => 'Thirteen',
		'14' => 'Fourteen',
		'15' => 'Fifteen',
		'16' => 'Sixteen',
		'17' => 'Seventeen',
		'18' => 'Eighteen',
		'19' => 'Nineteen',
		'20' => 'Twenty',
		'30' => 'Thirty',
		'40' => 'Forty',
		'50' => 'Fifty',
		'60' => 'Sixty',
		'70' => 'Seventy',
		'80' => 'Eighty',
		'90' => 'Ninety'
	);
	$digits = array(
		'',
		'Hundred',
		'Thousand',
		'Lakh',
		'Crore'
	);
	while ($i < $digits_1) {
		$divider = ($i == 2) ? 10 : 100;
		$number = floor($no % $divider);
		$no = floor($no / $divider);
		$i += ($divider == 10) ? 1 : 2;
		if ($number) {
			$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
			$hundred = ($counter == 1 && $str[0]) ? ' And ' : null;
			$str [] = ($number < 21) ? $words[$number] .
			" " . $digits[$counter] . $plural . " " . $hundred
			:
			$words[floor($number / 10) * 10]
			. " " . $words[$number % 10] . " "
			. $digits[$counter] . $plural . " " . $hundred;
		} else $str[] = null;
	}
	$str = array_reverse($str);
	$result = implode('', $str);
	$points = ($point) ?
	"." . $words[$point / 10] . " " .
	$words[$point = $point % 10] : '';
	return $result . "Rupees  ";
}
/**
 * this function used to reduct if condition in checbox
 */
function check_checked($current,$selected){
	if($current == $selected){
		echo "checked";
	}
}
/**
 * this function used to calculate gst rate 
 */
function gst_percentage($percentage = 5 , $price = 1, $quantity = 1, $tax_type = 1 ){
	$taxs = array(
		array(
			'percentage'	=> 5,
			'inclusive'		=> 1.05,
			'exclusive'		=> 0.05,
		),
		array(
			'percentage'	=> 12,
			'inclusive'		=> 1.12,
			'exclusive'		=> 0.12,
		),
		array(
			'percentage'	=> 18,
			'inclusive'		=> 1.18,
			'exclusive'		=> 0.18,
		),
		array(
			'percentage'	=> 28,
			'inclusive'		=> 1.28,
			'exclusive'		=> 0.28,
		)
	);
	if($percentage != 0){
		foreach ($taxs as $key => $tax) {
			if($percentage == $tax['percentage']){
				if($tax_type == 1){
					$return['price'] = round( ($price/$tax['inclusive']), 2);
					$return['tax'] = round( ($price-$return['price']), 2);
					$return['total'] = round( ($price*$quantity), 2);
				}else{
					$return['tax'] = round( ($price*$tax['exclusive']), 2);
					$return['price'] = $price;
					$return['total'] = round((($price + $return['tax']) * $quantity), 2);
				}
				return $return;
			}
		}
	}
}