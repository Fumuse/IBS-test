<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die;
}

use Bitrix\Main\Localization\Loc;
return [
    'LIST_READ' => [
        'title' => Loc::getMessage('SAMPLE_LAPTOP_MODULE_PERMISSION_OPERATION_LIST_READ'),
    ],
    'DETAIL_READ' => [
        'title' => Loc::getMessage('SAMPLE_LAPTOP_MODULE_PERMISSION_OPERATION_DETAIL_READ'),
    ],
    'BRAND_ADD' => [
        'title' => Loc::getMessage('SAMPLE_LAPTOP_MODULE_PERMISSION_OPERATION_BRAND_ADD'),
    ],
    'MODEL_ADD' => [
        'title' => Loc::getMessage('SAMPLE_LAPTOP_MODULE_PERMISSION_OPERATION_MODEL_ADD'),
    ],
    'LAPTOP_ADD' => [
        'title' => Loc::getMessage('SAMPLE_LAPTOP_MODULE_PERMISSION_OPERATION_LAPTOP_ADD'),
    ],
];
