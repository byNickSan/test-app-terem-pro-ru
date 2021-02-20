<?php
/**
 * csv2mysql.php
 *
 * import data from csv to mysql database
 *
 * @author     byNickSan
 * @copyright  2021 Nikolay
 * @license    https://mit-license.org  MIT License
 */

define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');


use Bitrix\Main\Application;
use Bitrix\Main\Diag\Debug;

include('parsecsv.inc.php');
$filename = $_REQUEST['file'];
echo '<h1>'.($filename).'</h1>';
if(!is_null($filename)) {
    $dataArray = parse_csv_file($filename);

    $prep = array();
    foreach ($dataArray as $k => $v) {
        $prep[':' . $k] = $v;
    }

    $create_string = '';
    foreach (array_keys($prep[':0']) as $val) {
        if ($val == 'id') {
            $create_string .= '`' . $val . '` ' . 'int(11) NOT NULL auto_increment, ';
        } else {
            $create_string .= '`' . $val . '` ' . "varchar(100) NOT NULL default '', ";
        }
    }
    $create_string .= 'PRIMARY KEY  (`id`)';
    $sql = ("CREATE TABLE IF NOT EXISTS csv_terem ($create_string); ");

    $record = Application::getConnection();
    $record->query($sql);

    foreach ($dataArray as $k => $v) {
        $id = $v["id"];
        unset ($v["id"]);
        $query = "INSERT INTO csv_terem (id," .
            implode(',', array_keys($v)) .
            ") VALUES ($id,\"" .
            implode('","', $v) .
            "\")";
        $query .= " ON DUPLICATE KEY UPDATE id = $id,";
        $numItems = count($v);
        $i = 0;
        foreach($v as $key => $value){
            $query .= $key.'="'.$v[$key].'"';
            if(++$i === $numItems) {
            }else{
                $query .= ',';
            }
        }
        $query .= "; ";
        echo '<pre>';
        echo $query;
        echo '</pre>';
        $record->query($query);
    }
}else{
    echo 'Undefined';
}
?>