<?php

return [
    'services' => [
        'value' => [
            'sample.laptops.SeedingService' => [
                'className' => \Sample\Laptops\Services\SeedingService::class,
            ],
            'sample.laptops.ErrorsService' => [
                'className' => \Sample\Laptops\Services\ErrorsService::class,
            ],
            'sample.laptops.UrlService' => [
                'className' => \Sample\Laptops\Services\UrlService::class,
            ],
        ],
        'readonly' => true,
    ],
];
