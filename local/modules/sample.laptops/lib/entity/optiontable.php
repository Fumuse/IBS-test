<?php

namespace Sample\Laptops\Entity;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Sample\Laptops\Interfaces\ISeedable;

class OptionTable extends DataManager implements ISeedable
{
    protected static array $seedingData = [
        [
            "NAME" => "CPU: Intel Core i3",
        ],
        [
            "NAME" => "CPU: Intel Core i5",
        ],
        [
            "NAME" => "CPU: Intel Core i7",
        ],
        [
            "NAME" => "CPU: Intel Core i9",
        ],

        [
            "NAME" => "Matrix: IPS",
        ],
        [
            "NAME" => "Matrix: OLED",
        ],
        [
            "NAME" => "Matrix: TN",
        ],

        [
            "NAME" => "RAM type: DDR3",
        ],
        [
            "NAME" => "RAM type: DDR4",
        ],
        [
            "NAME" => "RAM type: DDR5",
        ],

        [
            "NAME" => "RAM: 4GB",
        ],
        [
            "NAME" => "RAM: 8GB",
        ],
        [
            "NAME" => "RAM: 16GB",
        ],
        [
            "NAME" => "RAM: 32GB",
        ],
    ];

    public static function getTableName(): string
    {
        return 'sample_laptop_option';
    }

    public static function getMap(): array
    {
        return [
            new IntegerField(
                'ID',
                [
                    'primary' => true,
                    'autocomplete' => true,
                ]
            ),
            new StringField('NAME'),
        ];
    }

    public static function seeding()
    {
        $collection = self::createCollection();

        foreach (self::$seedingData as $data) {
            $item = self::createObject();
            $item->setName($data['NAME']);

            $collection[] = $item;
        }

        $collection->save(true);
    }
}
