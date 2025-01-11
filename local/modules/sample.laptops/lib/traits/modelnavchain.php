<?php

namespace Sample\Laptops\Traits;

use Bitrix\Main\Localization\Loc;
use Sample\Laptops\Entity\ModelTable;

trait ModelNavChain
{
    protected function getModel(int|string $modelPrimary)
    {
        $filter = [];
        if (!empty($this->isSefMode)) {
            $filter['=SLUG'] = $modelPrimary;
        } else {
            $filter['=ID'] = intval($modelPrimary);
        }

        return ModelTable::getList([
            'select' => [
                'ID', 'NAME', 'SLUG', 'BRAND'
            ],
            'filter' => $filter
        ])->fetchObject();
    }

    protected function addModelNavChain(): void
    {
        if (empty($this->settings['filter']['MODEL'])) {
            $GLOBALS['APPLICATION']->AddChainItem(
                Loc::getMessage("SAMPLE_LAPTOPS_CATALOG_NAVCHAIN_MODELS"),
            );
        } else {
            $model = $this->getModel($this->settings['filter']['MODEL']);
            if (!empty($model)) {
                $GLOBALS['APPLICATION']->AddChainItem(
                    $model->getName(),
                );
            }
        }
    }
}
