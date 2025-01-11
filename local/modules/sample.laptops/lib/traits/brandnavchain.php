<?php

namespace Sample\Laptops\Traits;

use Bitrix\Main\Localization\Loc;
use Sample\Laptops\Entity\BrandTable;

trait BrandNavChain
{
    protected function getBrand(int|string $brandPrimary)
    {
        $filter = [];
        if (!empty($this->isSefMode)) {
            $filter['=SLUG'] = $brandPrimary;
        } else {
            $filter['=ID'] = intval($brandPrimary);
        }

        return BrandTable::getList([
            'select' => [
                'ID', 'NAME', 'SLUG'
            ],
            'filter' => $filter
        ])->fetchObject();
    }

    protected function addBrandNavChain(): void
    {
        if (empty($this->settings['filter']['BRAND'])) {
            $GLOBALS['APPLICATION']->AddChainItem(
                Loc::getMessage("SAMPLE_LAPTOPS_CATALOG_NAVCHAIN_BRANDS"),
            );
        } else {
            if (!method_exists($this, "getBrandUrl")) {
                return;
            }

            $brand = $this->getBrand($this->settings['filter']['BRAND']);
            if (!empty($brand)) {
                $GLOBALS['APPLICATION']->AddChainItem(
                    $brand->getName(),
                    $this->getBrandUrl($brand)
                );
            }
        }
    }
}
