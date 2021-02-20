<?
/**
 * component.php
 *
 * create table from ibblock data
 *
 * @author     byNickSan
 * @copyright  2021 Nikolay
 * @license    https://mit-license.org  MIT License
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate *//
/** @var array $arParams */


    $IBLOCK_ID = 15;

	if(CModule::IncludeModule("iblock"))
	{
        $arSelect = false;
        $arFilter = Array("IBLOCK_ID"=> 15, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $arResult = CIBlockElement::GetList(
            Array(),
            $arFilter,
            false,
            Array("nPageSize"=>20),
            $arSelect
        );
        $arResult->NavPrint("Элементы инфоблока");
		$plist=["CSV_ID","CSV_NAME","CSV_VAL1","CSV_VAL2","CSV_VAL3"];

        echo '<table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">name</th>
                  <th scope="col">val1</th>
                  <th scope="col">val2</th>
                  <th scope="col">val3</th>
                </tr>
              </thead>
              <tbody>';
        while ($row = $arResult->GetNext()) {
            $VALUES = array();
            $res = CIBlockElement::GetProperty(15, $row['ID'], "sort", "asc", false);
            while ($ob = $res->getNext()) {
                $VALUES[] = $ob['VALUE'];
            }
            echo '<tr>';
            foreach ($VALUES as $k => $v) {
                echo "<td>$v</td>";
            }
            echo '</tr>';
        }
        echo '</tbody></table>';

        $arResult->NavPrint("Элементы инфоблока");
	}else{
		echo 'err ib load';
	}
?>
