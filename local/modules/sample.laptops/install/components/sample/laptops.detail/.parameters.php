<?php

use Bitrix\Main\Localization\Loc;

$arComponentParameters = [
    "PARAMETERS" => [
        "LAPTOP_ID" => [
            "NAME" => Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_LAPTOP_ID_VARIABLE_VALUE_TITLE"),
            "PARENT" => "DATA_SOURCE",
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
        ],
        "LAPTOP" => [
            "NAME" => Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_LAPTOP_VARIABLE_VALUE_TITLE"),
            "PARENT" => "DATA_SOURCE",
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
        ],
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
