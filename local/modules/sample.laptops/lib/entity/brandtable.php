<?php

namespace Sample\Laptops\Entity;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Sample\Laptops\Interfaces\ISeedable;

class BrandTable extends DataManager implements ISeedable
{
    protected static array $seedingData = [
        [
            "NAME" => "Apple",
        ],
        [
            "NAME" => "Dell",
        ],
        [
            "NAME" => "HP",
        ],
        [
            "NAME" => "Lenovo",
        ],
        [
            "NAME" => "ASUS",
        ],
    ];

    public static function getTableName(): string
    {
        return 'sample_brand';
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
            (new StringField('SLUG'))->configureUnique(),
        ];
    }

    public static function seeding()
    {
        $collection = self::createCollection();

        foreach (self::$seedingData as $data) {
            $item = self::createObject();
            $item->setName($data['NAME']);
            $item->setSlug(
                \CUtil::translit($data['NAME'], "en", ["replace_space" => "-", "replace_other" => "-"])
            );

            $collection[] = $item;
        }

        $collection->save(true);
    }
}
