<?php

namespace Sample\Laptops\Entity;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\FloatField;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Sample\Laptops\Interfaces\ISeedable;

class LaptopTable extends DataManager implements ISeedable
{
    protected static int $seedingItemsCount = 250;

    public static function getTableName(): string
    {
        return 'sample_laptop';
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
            new IntegerField('YEAR'),
            new FloatField('PRICE'),
            (new StringField('DETAIL_IMAGE'))->configureNullable(),

            new IntegerField('MODEL_ID', [
                'required' => true,
            ]),
            (new Reference(
                'MODEL',
                ModelTable::class,
                Join::on('this.MODEL_ID', 'ref.ID')
            ))->configureJoinType('inner'),

            (new ManyToMany('OPTIONS', OptionTable::class))
                ->configureTableName('sample_laptop_options')
        ];
    }

    public static function seeding()
    {
        $serviceLocator = \Bitrix\Main\DI\ServiceLocator::getInstance();
        $seedingService = $serviceLocator->get("sample.laptops.SeedingService");

        for ($i = 0; $i < self::$seedingItemsCount; $i++) {
            $model = $seedingService->getRandomModel();
            $options = $seedingService->getRandomOptions(rand(1, 5));

            $item = self::createObject();

            $name = implode(' ', [
                $model->getName(),
                \Bitrix\Main\Security\Random::getString(rand(6, 20))
            ]);
            $item->setName($name);
            $item->setSlug(
                \CUtil::translit($name, "en", ["replace_space" => "-", "replace_other" => "-"])
            );
            $item->setYear(rand(2000, date("Y")));
            $item->setPrice(rand(25000, 150000));
            $item->setModel($model);
            $item->save();

            foreach ($options as $option) {
                $item->addToOptions($option);
            }
            $item->save();
        }
    }
}
