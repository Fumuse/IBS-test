<?php

namespace Sample\Laptops\Factories;

use Sample\Laptops\Common\Gridables\BrandGrid;
use Sample\Laptops\Common\Gridables\LaptopGrid;
use Sample\Laptops\Common\Gridables\ModelGrid;
use Sample\Laptops\Interfaces\IGridable;

class GridableEntityFactory
{
    public static function create(string $entity, array $settings = []): ?IGridable
    {
        switch ($entity) {
            case "BRAND":
                return new BrandGrid($settings);
            case "MODEL":
                return new ModelGrid($settings);
            case "LAPTOP":
                return new LaptopGrid($settings);
        }

        return null;
    }
}
