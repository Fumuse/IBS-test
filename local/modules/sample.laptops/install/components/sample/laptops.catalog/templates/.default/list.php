<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var CMain $APPLICATION
 * @var CLaptopsCatalog $component
 * @var array $arParams
 */

?>
<?php
$APPLICATION->IncludeComponent(
    "sample:laptops.list",
    "",
    [
        "ENTITY" => "BRAND",
        "SEF_MODE" => $arParams['SEF_MODE'] ?? "N",
        "SEF_FOLDER" => $arParams['SEF_FOLDER'],
        "SEF_URL_TEMPLATES" => $arParams['SEF_URL_TEMPLATES'] ?? [],
    ],
    $component
);
