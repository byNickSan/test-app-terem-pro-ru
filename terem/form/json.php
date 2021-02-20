<?php
/**
 * json.php
 *
 * test form
 *
 * @author     byNickSan
 * @copyright  2021 Nikolay
 * @license    https://mit-license.org  MIT License
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    $dat = isJson($_GET['json']);
    if($dat == true){
        echo $dat;
    }else{
        echo 'BAD DATA';
    }
}else{
    echo 'Method '.$_SERVER['REQUEST_METHOD'];
}
?>