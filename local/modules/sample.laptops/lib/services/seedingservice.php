<?php

namespace Sample\Laptops\Services;

use Bitrix\Main\Entity\ExpressionField;
use Sample\Laptops\Entity\ModelTable;
use Sample\Laptops\Entity\OptionTable;

class SeedingService
{
    public function getRandomModel()
    {
        return ModelTable::getList([
            'order' => [
                "RAND" => "ASC"
            ],
            'runtime' => [
                new ExpressionField('RAND', 'RAND()'),
            ],
            'limit' => 1,
        ])->fetchObject();
    }

    public function getRandomOptions(int $optionsCount)
    {
        return OptionTable::getList([
            'order' => [
                "RAND" => "ASC"
            ],
            'select' => [
                'ID'
            ],
            'runtime' => [
                new ExpressionField('RAND', 'RAND()'),
            ],
            'limit' => $optionsCount,
        ])->fetchCollection();
    }
}
