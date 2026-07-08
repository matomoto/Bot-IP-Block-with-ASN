<?php

require __DIR__ . '/mmdbASNarray.php';

$mmdb_visitor_ip = $_SERVER['REMOTE_ADDR'];

require __DIR__ . '/composer/vendor/autoload.php';

use MaxMind\Db\Reader;

function mmdb_scandir_function($mmdb_scandir_path) {
	
	$mmdb_scandir_array = array();
	
	if (is_dir($mmdb_scandir_path) === true) {
		$mmdb_scandir_array = scandir($mmdb_scandir_path);
	}

	unset($mmdb_scandir_array[array_search(".", $mmdb_scandir_array, true)]);
	unset($mmdb_scandir_array[array_search("..", $mmdb_scandir_array, true)]);
	$mmdb_scandir_array_clean = array_values($mmdb_scandir_array);
	
	for ($i = 0; $i < count($mmdb_scandir_array_clean); $i++) {
		if (pathinfo($mmdb_scandir_array_clean[$i], PATHINFO_EXTENSION) != 'mmdb') {
			unset($mmdb_scandir_array_clean[$i]);
		}
	}
	$mmdb_scandir_array_clean_clean = array_values($mmdb_scandir_array_clean);
	
	sort($mmdb_scandir_array_clean_clean, SORT_NATURAL | SORT_FLAG_CASE);
	
	return $mmdb_scandir_array_clean_clean;
}

$mmdb_scandir_path_full = __DIR__ . '/database';
$mmdb_scandir_filename_array = mmdb_scandir_function($mmdb_scandir_path_full);
$mmdb_scandir_filename = end($mmdb_scandir_filename_array);

$mmdb_reader = new Reader(__DIR__ . '/database/' . $mmdb_scandir_filename);

$mmdb_record = $mmdb_reader->get($mmdb_visitor_ip);

// var_dump($mmdb_record);
/*
array(2) {
  ["autonomous_system_number"]=>
  int(15169)
  ["autonomous_system_organization"]=>
  string(10) "Google LLC"
}
*/

$mmdb_reader->close();

foreach ($mmdb_ASN_array as $mmdb_asn_name) {
	if (str_contains(strtolower($mmdb_record["autonomous_system_organization"]), strtolower($mmdb_asn_name)) == true) {
		// 451 - Unavailable For Legal Reasons (Copyright, etc.)
		http_response_code(451);
		exit(0);
	}
}
