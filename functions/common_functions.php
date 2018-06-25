<?php
function checkDateFormat($date) {
	$arr = explode('-', $date);
	if(count($arr) != 3) {
		return false;
	}

	$year = +$arr[0];
	$month = +$arr[1];
	$day = +$arr[2];

	return checkdate($month, $day, $year);
}

function getHHList() {
	return array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
}

function getMMList() {
	return array('00', '15', '30', '45');
}

function getTTList() {
	return array('AM', 'PM');
}

function get12HourFormat($time) {
	return date('g:i A', strtotime($time));
}

function get24HourFormat($hh, $mm, $tt) {
	return date('H:i:s', strtotime($hh . ':' . $mm . $tt));
}

function getHHMMTT($time) {
	$t = date('g|i|A', strtotime($time));
	return explode('|', $t);
}

function getCollectionTimeList($opening_time, $closing_time) {
	$time = date_create_from_format('H:i:s', $opening_time);
	$end_time = date_create_from_format('H:i:s', $closing_time);
	$time_list = array();

	if($time && $end_time) {
		date_modify($time, '+30 mins');
		date_modify($end_time, '-60 mins');

		while($time <= $end_time) {
			$time_list[] = date_format($time, 'g:i A');
			date_modify($time, '+15 mins');
		}
	}

	return $time_list;
}