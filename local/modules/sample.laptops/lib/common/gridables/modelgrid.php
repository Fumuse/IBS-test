<?php

namespace Sample\Laptops\Common\Gridables;

use Bitrix\Main\Localization\Loc;
use Sample\Laptops\Entity\ModelTable;
use Sample\Laptops\Traits\BrandNavChain;

class ModelGrid extends BaseGrid
{
    use BrandNavChain;

    protected array $filter = [];

    public function __construct(array $settings)
    {
        parent::__construct($settings);
        $this->prepareFilter();
        $this->prepareNavChain();
    }

    protected function prepareFilter()
    {
        if (isset($this->settings['filter']['BRAND'])) {
            $this->filter = [];
            if ($this->isSefMode) {
                $this->filter['=BRAND.SLUG'] = $this->settings['filter']['BRAND'];
            } else {
                $this->filter['=BRAND.ID'] = intval($this->settings['filter']['BRAND']);
            }
        }
    }

    protected function prepareNavChain()
    {
        if (!$this->settings['generateChain']) {
            return;
        }

        $this->addBrandNavChain();
    }

    public function getGridHeaders(): array
    {
        return [
            [
                "id" => "NAME",
                "name" => Loc::getMessage("SAMPLE_LAPTOP_MODULE_MODEL_GRID_NAME_HEADER"),
                "default" => true,
            ],
            [
                "id" => "BRAND",
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
            $brand = $item->getBrand();
            $modelUrl = $this->getModelUrl($brand, $item);

            $data = [
                'NAME' => "<a href='{$modelUrl}'>{$item->getName()}</a>",
                'BRAND' => $brand?->getName(),
            ];
            $rows[] = [
                'data' => $data
            ];
        }
        return $rows;
    }

    protected function loadData(int $limit, int $offset)
    {
        $result = ModelTable::getList([
            'select' => [
                'NAME', 'SLUG', 'BRAND'
            ],
            'filter' => $this->filter,
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
