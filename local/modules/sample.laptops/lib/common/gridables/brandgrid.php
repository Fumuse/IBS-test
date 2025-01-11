<?php

namespace Sample\Laptops\Common\Gridables;

use Bitrix\Main\Localization\Loc;
use Sample\Laptops\Entity\BrandTable;

class BrandGrid extends BaseGrid
{
    public function getGridHeaders(): array
    {
        return [
            [
                "id" => "NAME",
                "name" => Loc::getMessage("SAMPLE_LAPTOP_MODULE_BRAND_GRID_NAME_HEADER"),
                "default" => true,
            ]
        ];
    }

    public function getGridRows(int $limit, int $offset): array
    {
        $items = $this->loadData($limit, $offset);

        $rows = [];
        foreach ($items as $item) {
            $brandUrl = $this->getBrandUrl($item);
            $data = [
                'NAME' => "<a href='{$brandUrl}'>{$item->getName()}</a>",
            ];
            $rows[] = [
                'data' => $data
            ];
        }
        return $rows;
    }

    protected function loadData(int $limit, int $offset)
    {
        $result = BrandTable::getList([
            'select' => [
                'NAME', 'SLUG'
            ],
            'limit' => $limit,
            'offset' => $offset,
            'order' => [
                'NAME' => 'ASC'
            ],
            'count_total' => true,
        ]);
        $this->recordsCount = $result->getCount();
        return $result->fetchCollection();
    }
}
