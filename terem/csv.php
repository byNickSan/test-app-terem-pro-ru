<?php
/**
 * csv.php
 *
 * parse csv data
 *
 * @author     byNickSan
 * @copyright  2021 Nikolay
 * @license    https://mit-license.org  MIT License
 */

include('parsecsv.inc.php');

$dataArray = parse_csv_file('MOCK_DATA.csv');

echo '<pre>';
print_r($dataArray);
echo '</pre>';
?>