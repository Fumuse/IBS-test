<?php

use Bitrix\Main\Localization\Loc;

class CLaptopsCatalog extends \CBitrixComponent
{
    protected string $componentPage = "list";

    protected array $defaultUrlTemplates = [
        "list" => "index.php",
        "detail" => "details/#LAPTOP#/",
        "model" => "#BRAND#/",
        "laptop" => "#BRAND#/#MODEL#/",
    ];

    protected array $defaultVariableAliases = [];
    protected array $variableAliases = [];

    protected array $componentVariables = [
        "BRAND", "LAPTOP", "LAPTOP_ID", "MODEL"
    ];
    public array $urlVariables = [];

    protected function isSefMode(): bool
    {
        return $this->arParams['SEF_MODE'] == 'Y';
    }

    protected function includeModules(): bool
    {
        if (!\Bitrix\Main\Loader::includeModule("sample.laptops")) {
            return false;
        }

        return true;
    }

    protected function prepareComponentPage()
    {
        $this->variableAliases = CComponentEngine::MakeComponentVariableAliases(
            $this->defaultVariableAliases,
            $this->arParams['VARIABLE_ALIASES']
        );

        if ($this->isSefMode()) {
            $this->prepareSefModeComponentPage();
        } else {
            $this->prepareNotSefModeComponentPage();
        }
    }

    protected function prepareSefModeComponentPage()
    {
        $arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates(
            $this->defaultUrlTemplates,
            $this->arParams['SEF_URL_TEMPLATES']
        );

        $componentPage = CComponentEngine::ParseComponentPath(
            $this->arParams['SEF_FOLDER'],
            $arUrlTemplates,
            $this->urlVariables
        );

        CComponentEngine::InitComponentVariables(
            $componentPage,
            $this->componentVariables,
            $this->variableAliases,
            $this->urlVariables
        );

        if (!empty($componentPage)) {
            $this->componentPage = $componentPage;
        }
    }

    protected function prepareNotSefModeComponentPage()
    {
        CComponentEngine::InitComponentVariables(
            false,
            $this->componentVariables,
            $this->variableAliases,
            $this->urlVariables
        );

        if (intval($this->urlVariables['LAPTOP']) > 0) {
            $this->componentPage = "detail";
        } elseif (intval($this->urlVariables['BRAND']) > 0) {
            if (intval($this->urlVariables['MODEL']) > 0) {
                $this->componentPage = "laptop";
            } else {
                $this->componentPage = "model";
            }
        }
    }

    public function executeComponent()
    {
        if (!$this->includeModules()) {
            ShowError(Loc::getMessage("LAPTOPS_CATALOG_COMPONENT_MODULE_ERROR"));
            return;
        }
        $this->prepareComponentPage();
        $this->IncludeComponentTemplate($this->componentPage);
    }
}
