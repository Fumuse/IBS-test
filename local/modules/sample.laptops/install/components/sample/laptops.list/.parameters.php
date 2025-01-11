<?php

use Bitrix\Main\Localization\Loc;

$arComponentParameters = [
    "PARAMETERS" => [
        "ENTITY" => [
            "NAME" => Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_ENTITY_VARIABLE_VALUE_TITLE"),
            "PARENT" => "DATA_SOURCE",
            "TYPE" => "LIST",
            "VALUES" => [
                "BRAND" => Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_ENTITY_VARIABLE_LIST_BRAND_TITLE"),
                "MODEL" => Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_ENTITY_VARIABLE_LIST_MODEL_TITLE"),
                "LAPTOP" => Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_ENTITY_VARIABLE_LIST_LAPTOP_TITLE"),
            ],
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
