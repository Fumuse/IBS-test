<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 */

?>
<?php
$APPLICATION->includeComponent(
    "bitrix:main.ui.grid",
    "",
    [
        "GRID_ID" => $arParams['GRID_ID'],
        "COLUMNS" => $arResult['HEADERS'],
        "ROWS" => $arResult['ROWS'],
        'NAV_OBJECT' => $arResult['NAV_OBJECT'],
        'SHOW_ROW_CHECKBOXES' => false,
        'SHOW_ACTION_PANEL' => false,
        'SHOW_ROW_ACTIONS_MENU' => false,
        'SHOW_SELECTED_COUNTER' => false,
        'SHOW_TOTAL_COUNTER' => false,
        'SHOW_GRID_SETTINGS_MENU' => false,

        'SHOW_PAGINATION' => true,
        'SHOW_PAGESIZE' => true,
        'PAGE_SIZES' => [
            ["NAME" => "5", "VALUE" => "5"],
            ["NAME" => "10", "VALUE" => "10"],
            ["NAME" => "20", "VALUE" => "20"],
            ["NAME" => "50", "VALUE" => "50"],
        ],
        'DEFAULT_PAGE_SIZE' => 5,
    ]
);
