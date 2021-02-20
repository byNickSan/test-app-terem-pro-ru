<?
/**
 * index.php
 *
 * view ibblock elemnts
 *
 * @author     byNickSan
 * @copyright  2021 Nikolay
 * @license    https://mit-license.org  MIT License
 */

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetAdditionalCSS("/terem/style.css");
$APPLICATION->SetTitle("Тест");
$APPLICATION->SetPageProperty("description", "lorem ipsum");
?>
<div class="row terem">

    <div class="col-xs-12 col-md-12 text-center">
        <?php

        $APPLICATION->IncludeComponent(
            "bitrix:terem-csv-parser",
            "",
            Array(
                "SEF_MODE" => "N",
                "IBLOCK_TYPE_ID" => "blog",
                "CACHE_TIME" => -1,
            )
        );
        ?>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>