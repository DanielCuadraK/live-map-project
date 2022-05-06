<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once __DIR__.'/libraries/SimpleXLSX.php';

if ( $xlsx = SimpleXLSX::parse('../resources/sailingSchedule.xlsx')) {

	// Produce array keys from the array values of 1st array element
	$header_values = $rows = [];

	foreach ( $xlsx->rows() as $k => $r ) {
		if ( $k === 0 ) {
			$header_values = $r;
			continue;
		}
		$rows[] = array_combine( $header_values, $r );
	}
	echo json_encode( $rows );
}