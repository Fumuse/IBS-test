<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die;
}

use Bitrix\Main\Localization\Loc;
return [
    'SAMPLE_LAPTOPS_DENY' => [
        'title' => Loc::getMessage('SAMPLE_LAPTOP_MODULE_PERMISSION_DENY'),
    ],
    'SAMPLE_LAPTOPS_READ' => [
        'title' => Loc::getMessage('SAMPLE_LAPTOP_MODULE_PERMISSION_READ'),
    ],
    'SAMPLE_LAPTOPS_ADD' => [
        'title' => Loc::getMessage('SAMPLE_LAPTOP_MODULE_PERMISSION_ADD'),
    ],
];
