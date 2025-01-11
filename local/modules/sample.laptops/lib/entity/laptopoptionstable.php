<?php

namespace Sample\Laptops\Entity;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class LaptopOptionsTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'sample_laptop_options';
    }

    public static function getMap(): array
    {
        return [
            (new IntegerField('LAPTOP_ID'))->configurePrimary(true),
            (new Reference(
                'LAPTOP',
                LaptopTable::class,
                Join::on('this.LAPTOP_ID', 'ref.ID')
            ))->configureJoinType('inner'),

            (new IntegerField('OPTION_ID'))->configurePrimary(true),
            (new Reference(
                'OPTION',
                OptionTable::class,
                Join::on('this.OPTION_ID', 'ref.ID')
            ))->configureJoinType('inner'),
        ];
    }
}
