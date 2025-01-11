<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\PageNavigation;
use Sample\Laptops\Factories\GridableEntityFactory;
use Sample\Laptops\Interfaces\IGridable;
use Bitrix\Main\Grid\Options;

class CLaptopsCatalogList extends \CBitrixComponent
{
    protected const DEFAULT_PAGE_SIZE = 10;

    protected array $componentVariables = [
        "BRAND", "MODEL",
        "LAPTOP", "LAPTOP_ID"
    ];
    protected array $urlVariables = [];

    private IGridable $gridableEntity;
    private PageNavigation $pageNavigation;
    private Options $gridOptions;

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
        $this->prepareUrlVariables($arParams);

        $arParams['GRID_ID'] = 'LAPTOP_GRID_' . $arParams['ENTITY'];

        return parent::onPrepareComponentParams($arParams);
    }

    protected function prepareUrlVariables(array $arParams)
    {
        $parent = $this->getParent();
        if (!empty($parent) && isset($parent->urlVariables)) {
            $this->urlVariables = $parent->urlVariables;
            return;
        }

        if ($this->isSefMode($arParams)) {
            $arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates(
                [],
                $arParams['SEF_URL_TEMPLATES']
            );
            CComponentEngine::ParseComponentPath(
                $arParams['SEF_FOLDER'],
                $arUrlTemplates,
                $this->urlVariables
            );
        } else {
            CComponentEngine::InitComponentVariables(
                false,
                $this->componentVariables,
                [],
                $this->urlVariables
            );
        }
    }

    protected function prepareGridableEntity()
    {
        $this->gridableEntity = GridableEntityFactory::create(
            $this->arParams['ENTITY'] ?? null,
            [
                'filter' => $this->urlVariables,
                'sort' => $this->gridOptions->getSorting(),
                'sefMode' => $this->isSefMode(),
                'sefUrlTemplates' => $this->arParams['SEF_URL_TEMPLATES'],
                'sefFolder' => $this->arParams['SEF_FOLDER'],
                'generateChain' => true,
            ]
        );
        if (empty($this->gridableEntity)) {
            $this->error = Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_GRIDABLE_ENTITY_ERROR");
        }
    }

    protected function includeModules(): bool
    {
        if (!\Bitrix\Main\Loader::includeModule("sample.laptops")) {
            return false;
        }

        return true;
    }

    protected function isSefMode(array $arParams = []): bool
    {
        if (empty($arParams)) {
            $arParams = $this->arParams;
        }
        return $arParams['SEF_MODE'] == 'Y';
    }

    public function executeComponent()
    {
        if (!empty($this->error)) {
            ShowError($this->error);
            return;
        }

        $this->prepareGridOptions();
        $this->prepareGridableEntity();
        if (!empty($this->error)) {
            ShowError($this->error);
            return;
        }

        $this->prepareGridHeaders();
        $this->prepareNavigation();
        $this->prepareGridRows();

        $this->IncludeComponentTemplate();
    }

    public function prepareGridOptions()
    {
        $this->gridOptions = new Options($this->arParams['GRID_ID']);
    }

    public function prepareGridHeaders()
    {
        $this->arResult['HEADERS'] = $this->gridableEntity->getGridHeaders();
    }

    public function prepareGridRows()
    {
        $this->arResult['ROWS'] = $this->gridableEntity->getGridRows(
            $this->pageNavigation->getLimit(),
            $this->pageNavigation->getOffset(),
        );
        $this->pageNavigation->setRecordCount($this->gridableEntity->getRecordsCount());
    }

    protected function prepareNavigation()
    {
        $navParams = $this->gridOptions->getNavParams([
            'nPageSize' => self::DEFAULT_PAGE_SIZE
        ]);
        $pageSize = (int)$navParams['nPageSize'];

        $this->pageNavigation = new PageNavigation('page');
        $this->pageNavigation->allowAllRecords(false)->setPageSize($pageSize)->initFromUri();

        $this->arResult['NAV_OBJECT'] = $this->pageNavigation;
    }
}
