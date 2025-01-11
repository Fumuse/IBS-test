<?php

namespace Sample\Laptops\Common\Gridables;

use Bitrix\Main\Localization\Loc;
use Sample\Laptops\Entity\LaptopTable;
use Sample\Laptops\Traits\BrandNavChain;
use Sample\Laptops\Traits\ModelNavChain;

class LaptopGrid extends BaseGrid
{
    use BrandNavChain;
    use ModelNavChain;

    protected array $filter = [];

    public function __construct(array $settings)
    {
        parent::__construct($settings);
        $this->prepareFilter();
        $this->prepareNavChain();
    }

    protected function prepareFilter()
    {
        if (isset($this->settings['filter']['MODEL'])) {
            $this->filter = [];
            if ($this->isSefMode) {
                $this->filter['=MODEL.SLUG'] = $this->settings['filter']['MODEL'];
            } else {
                $this->filter['=MODEL.ID'] = intval($this->settings['filter']['MODEL']);
            }
        }
    }

    protected function prepareNavChain()
    {
        if (!$this->settings['generateChain']) {
            return;
        }

        $this->addBrandNavChain();
        $this->addModelNavChain();
    }

    public function getGridHeaders(): array
    {
        return [
            [
                "id" => "NAME",
                "name" => Loc::getMessage("SAMPLE_LAPTOP_MODULE_LAPTOP_GRID_NAME_HEADER"),
                "default" => true,
            ],
            [
                "id" => "YEAR",
                "name" => Loc::getMessage("SAMPLE_LAPTOP_MODULE_YEAR_GRID_NAME_HEADER"),
                "sort" => "YEAR",
                "default" => true,
            ],
            [
                "id" => "PRICE",
                "name" => Loc::getMessage("SAMPLE_LAPTOP_MODULE_PRICE_GRID_NAME_HEADER"),
                "sort" => "PRICE",
                "default" => true,
            ],
        ];
    }

    public function getGridRows(int $limit, int $offset): array
    {
        $items = $this->loadData($limit, $offset);

        $rows = [];
        foreach ($items as $item) {
            $detailUrl = $this->getDetailUrl($item);

            $data = [
                'NAME' => "<a href='{$detailUrl}'>{$item->getName()}</a>",
                'PRICE' => number_format($item->getPrice(), 2, ',', ' '),
                'YEAR' => $item->getYear(),
            ];
            $rows[] = [
                'data' => $data
            ];
        }
        return $rows;
    }

    protected function loadData(int $limit, int $offset)
    {
        $sort = $this->settings['sort']['sort'] ?? [
            'NAME' => 'asc'
        ];

        $result = LaptopTable::getList([
            'select' => [
                'NAME', 'SLUG', 'PRICE', 'YEAR'
            ],
            'filter' => $this->filter,
            'limit' => $limit,
            'offset' => $offset,
            'order' => $sort,
            'count_total' => true,
        ]);
        $this->recordsCount = $result->getCount();
        return $result->fetchCollection();
    }
}
