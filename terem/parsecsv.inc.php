<?php
/*
Copyright (c) 2013, Manu Manjunath
All rights reserved.
 
Redistribution and use of this program in source/binary forms, with or without modification are permitted.
Link to this gist is preferred, but not a condition for redistribution/use.
*/

function parse_csv_file($csvfile) {
	$csv = Array();
	$rowcount = 0;
	if (($handle = fopen($csvfile, "r")) !== FALSE) {
		$max_line_length = defined('MAX_LINE_LENGTH') ? MAX_LINE_LENGTH : 10000;
		$header = fgetcsv($handle, $max_line_length);
		$header_colcount = count($header);
		while (($row = fgetcsv($handle, $max_line_length)) !== FALSE) {
			$row_colcount = count($row);
			if ($row_colcount == $header_colcount) {
				$entry = array_combine($header, $row);
				$csv[] = $entry;
			}
			else {
				error_log("csvreader: Invalid number of columns at line " . ($rowcount + 2) . " (row " . ($rowcount + 1) . "). Expected=$header_colcount Got=$row_colcount");
				return null;
			}
			$rowcount++;
		}
		//echo "Totally $rowcount rows found\n";
		fclose($handle);
	}
	else {
		error_log("csvreader: Could not read CSV \"$csvfile\"");
		return null;
	}
	return $csv;
}
