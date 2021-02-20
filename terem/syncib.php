<?php
/**
 * syncib.php
 *
 * Import data from CSV table to ibblock
 *
 * @author     byNickSan
 * @copyright  2021 Nikolay
 * @license    https://mit-license.org  MIT License
 */

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Application;
global $USER;

$sqldrv = Application::getConnection();
$data = $sqldrv->query('SELECT * FROM csv_terem ORDER BY id ASC')->fetchAll();

if(CModule::IncludeModule("iblock")) {
    foreach ($data as $k => $v){
        $el = new CIBlockElement;
        $PROP = array();
        $PROP["CSV_ID"] = intval($v["id"]);
        $PROP["CSV_NAME"] = $v["name"];
        $PROP["CSV_VAL1"] = $v["value1"];
        $PROP["CSV_VAL2"] = $v["value2"];
        $PROP["CSV_VAL3"] = $v["value3"];
        $arLoadProductArray = Array(
            "MODIFIED_BY"    => $USER->GetID(),
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID"      => 15,
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => $PROP["CSV_NAME"],
            "ACTIVE"         => "Y",
            "PREVIEW_TEXT"   => $PROP["CSV_ID"],
            "DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif")
        );

        if($PRODUCT_ID = $el->Add($arLoadProductArray))
            echo "New ID: ".$PRODUCT_ID.";<br>";
        else {
            echo "Error: " . $el->LAST_ERROR;
            die();
        }
    }
}
?>