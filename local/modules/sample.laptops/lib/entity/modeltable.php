<?php

namespace Sample\Laptops\Entity;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Sample\Laptops\Interfaces\ISeedable;

class ModelTable extends DataManager implements ISeedable
{
    protected static array $seedingData = [
        [
            "NAME" => "MacBook Air",
            "BRAND_ID" => 1,
        ],
        [
            "NAME" => "MacBook Pro",
            "BRAND_ID" => 1,
        ],

        [
            "NAME" => "XPS",
            "BRAND_ID" => 2,
        ],
        [
            "NAME" => "Inspiron",
            "BRAND_ID" => 2,
        ],
        [
            "NAME" => "Alienware",
            "BRAND_ID" => 2,
        ],

        [
            "NAME" => "Pavilion",
            "BRAND_ID" => 3,
        ],
        [
            "NAME" => "Envy",
            "BRAND_ID" => 3,
        ],
        [
            "NAME" => "Omen",
            "BRAND_ID" => 3,
        ],

        [
            "NAME" => "Legion",
            "BRAND_ID" => 4,
        ],
        [
            "NAME" => "Yoga",
            "BRAND_ID" => 4,
        ],
        [
            "NAME" => "ThinkPad",
            "BRAND_ID" => 4,
        ],

        [
            "NAME" => "ROG",
            "BRAND_ID" => 5,
        ],
        [
            "NAME" => "TUF",
            "BRAND_ID" => 5,
        ],
        [
            "NAME" => "ExpertBook",
            "BRAND_ID" => 5,
        ],
    ];

    public static function getTableName(): string
    {
        return 'sample_model';
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

            new IntegerField('BRAND_ID', [
                'required' => true,
            ]),
            (new Reference(
                'BRAND',
                BrandTable::class,
                Join::on('this.BRAND_ID', 'ref.ID')
            ))->configureJoinType('inner'),
        ];
    }

    public static function seeding()
    {
        $collection = self::createCollection();

        foreach (self::$seedingData as $data) {
            $brand = BrandTable::wakeUpObject($data['BRAND_ID']);

            $item = self::createObject();
            $item->setName($data['NAME']);
            $item->setSlug(
                \CUtil::translit($data['NAME'], "en", ["replace_space" => "-", "replace_other" => "-"])
            );
            $item->setBrand($brand);

            $collection[] = $item;
        }

        $collection->save(true);
    }
}
