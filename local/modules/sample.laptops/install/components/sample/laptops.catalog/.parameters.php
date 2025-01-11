<?php

use Bitrix\Main\Localization\Loc;

$arComponentParameters = [
    "PARAMETERS" => [
        "SEF_MODE" => [
            "list" => [
                "NAME" => Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_SEF_BRANDS_URL_TITLE"),
                "DEFAULT" => "index.php",
                "VARIABLES" => []
            ],
            "detail" => [
                "NAME" => Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_SEF_DETAIL_URL_TITLE"),
                "DEFAULT" => "details/#LAPTOP#/",
                "VARIABLES" => ["LAPTOP"]
            ],
            "model" => [
                "NAME" => Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_SEF_MODELS_URL_TITLE"),
                "DEFAULT" => "#BRAND#/",
                "VARIABLES" => ["BRAND"]
            ],
            "laptop" => [
                "NAME" => Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_SEF_LAPTOPS_URL_TITLE"),
                "DEFAULT" => "#BRAND#/#MODEL#/",
                "VARIABLES" => ["BRAND", "MODEL"]
            ],
        ],
    ]
];
