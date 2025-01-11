<?php

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Localization\Loc;
use Sample\Laptops\Services\UrlService;

class CLaptopsCatalogDetail extends \CBitrixComponent
{
    private UrlService $urlService;

    protected int $laptopId = 0;
    protected ?string $laptopSlug;

    protected ?string $error = null;

    public function __construct($component = null)
    {
        parent::__construct($component);

        if (!$this->includeModules()) {
            $this->error = Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_MODULE_ERROR");
        }
    }

    public function onPrepareComponentParams($arParams)
    {
        $serviceLocator = ServiceLocator::getInstance();
        if ($serviceLocator->has("sample.laptops.UrlService")) {
            $this->urlService = $serviceLocator->get("sample.laptops.UrlService");
        }

        if (!empty($arParams['LAPTOP']) || !empty($arParams['LAPTOP_ID'])) {
            $this->laptopId = intval($arParams['LAPTOP_ID']);
            $this->laptopSlug = $arParams['LAPTOP'] ?? null;
        }

        return parent::onPrepareComponentParams($arParams);
    }

    protected function isSefMode(array $arParams = []): bool
    {
        if (empty($arParams)) {
            $arParams = $this->arParams;
        }
        return $arParams['SEF_MODE'] == 'Y';
    }

    protected function includeModules(): bool
    {
        if (!\Bitrix\Main\Loader::includeModule("sample.laptops")) {
            return false;
        }

        return true;
    }

    public function executeComponent()
    {
        if (!empty($this->error)) {
            ShowError($this->error);
            return;
        }

        $this->loadData();
        if (empty($this->arResult['LAPTOP'])) {
            ShowError(Loc::getMessage("LAPTOPS_CATALOG_DETAIL_COMPONENT_LAPTOP_EMPTY_ERROR"));
            return;
        }
        $this->prepareUrls();
        $this->setTitle();
        $this->prepareNavChain();

        $this->IncludeComponentTemplate();
    }

    protected function loadData()
    {
        if (empty($this->laptopSlug) && empty($this->laptopId)) {
            return;
        }

        $filter = [];
        if (!empty($this->laptopSlug)) {
            $filter['=SLUG'] = $this->laptopSlug;
        } else {
            $filter['=ID'] = $this->laptopId;
        }

        $item = \Sample\Laptops\Entity\LaptopTable::getList([
            'select' => [
                "*", "MODEL", "MODEL.BRAND", "OPTIONS"
            ],
            'filter' => $filter
        ])->fetchObject();

        if (empty($item)) {
            return;
        }

        $this->arResult['LAPTOP'] = $item;
        $this->arResult['LAPTOP_MODEL'] = $item->getModel();
        $this->arResult['LAPTOP_OPTIONS'] = $item->getOptions();
    }

    protected function prepareUrls()
    {
        $this->arParams['PATHS'] = [];

        $this->arParams['PATHS']["BRAND"] = $this->urlService->generateUrl(
            $this->isSefMode(),
            $this->arParams['SEF_URL_TEMPLATES']['model'] ?? null,
            $this->arParams['SEF_FOLDER'] ?? null,
            [
                'default' => [
                    'BRAND' => $this->arResult['LAPTOP_MODEL']->getBrand()?->getId(),
                ],
                'sef' => [
                    'BRAND' => $this->arResult['LAPTOP_MODEL']->getBrand()?->getSlug(),
                ]
            ]
        );

        $this->arParams['PATHS']["MODEL"] = $this->urlService->generateUrl(
            $this->isSefMode(),
            $this->arParams['SEF_URL_TEMPLATES']['laptop'] ?? null,
            $this->arParams['SEF_FOLDER'] ?? null,
            [
                'default' => [
                    'BRAND' => $this->arResult['LAPTOP_MODEL']->getBrand()?->getId(),
                    'MODEL' => $this->arResult['LAPTOP_MODEL']->getId(),
                ],
                'sef' => [
                    'BRAND' => $this->arResult['LAPTOP_MODEL']->getBrand()?->getSlug(),
                    'MODEL' => $this->arResult['LAPTOP_MODEL']->getSlug(),
                ],
            ]
        );
    }

    protected function setTitle()
    {
        $GLOBALS['APPLICATION']->SetTitle(
            $this->arResult['LAPTOP']->getName()
        );
    }

    protected function prepareNavChain()
    {
        $GLOBALS['APPLICATION']->AddChainItem(
            $this->arResult['LAPTOP_MODEL']->getBrand()?->getName(),
            $this->arParams['PATHS']["BRAND"]
        );

        $GLOBALS['APPLICATION']->AddChainItem(
            $this->arResult['LAPTOP_MODEL']->getName(),
            $this->arParams['PATHS']["MODEL"]
        );

        $GLOBALS['APPLICATION']->AddChainItem(
            $this->arResult['LAPTOP']->getName(),
        );
    }
}
