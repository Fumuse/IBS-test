<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arResult
 * @var array $arParams
 * @var ?string $templateFolder
 */

\Bitrix\Main\UI\Extension::load("ui.bootstrap4");

?>
<div class="laptop-detail container">
    <div class="d-flex">
        <!-- Laptop image -->
        <div class="col-3 d-flex justify-content-center align-items-start">
            <?php
            $detailImage = $arResult['LAPTOP']->getDetailImage();
            if ($detailImage) {
                ?>
                <img src="<?= $detailImage; ?>"/>
                <?php
            } else {
                ?>
                <img src="<?= $templateFolder; ?>/images/default-image.png"/>
                <?php
            }
            ?>
        </div>
        <!-- Laptop general information -->
        <div class="col card">
            <div class="card-body">
                <h1 class="mt-0">
                    <?= $arResult['LAPTOP']->getName(); ?>
                </h1>
                <div class="d-flex">
                    <div class="col d-flex align-items-center display-6">
                        <?= number_format($arResult['LAPTOP']->getPrice(), 2, ',', ' '); ?>
                        <?= Loc::getMessage("LAPTOPS_CATALOG_DETAIL_TEMPLATE_CURRENCY"); ?>
                    </div>
                    <div class="col-3 d-flex align-items-center">
                        <button class="btn btn-primary" disabled>
                            <?= Loc::getMessage("LAPTOPS_CATALOG_DETAIL_TEMPLATE_BUTTON_TO_BUY"); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <!-- Brand -->
        <div class="card-header">
            <?= Loc::getMessage("LAPTOPS_CATALOG_DETAIL_TEMPLATE_BRAND_TITLE"); ?>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="<?= $arParams['PATHS']['BRAND']; ?>">
                    <?= $arResult['LAPTOP_MODEL']->getBrand()?->getName() ?? "-"; ?>
                </a>
            </li>
        </ul>
        <!-- Model -->
        <div class="card-header">
            <?= Loc::getMessage("LAPTOPS_CATALOG_DETAIL_TEMPLATE_MODEL_TITLE"); ?>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="<?= $arParams['PATHS']['MODEL']; ?>">
                    <?= $arResult['LAPTOP_MODEL']->getName(); ?>
                </a>
            </li>
        </ul>
        <!-- Year -->
        <div class="card-header">
            <?= Loc::getMessage("LAPTOPS_CATALOG_DETAIL_TEMPLATE_YEAR_TITLE"); ?>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <?= $arResult['LAPTOP']->getYear(); ?>
            </li>
        </ul>
        <!-- Options -->
        <div class="card-header">
            <?= Loc::getMessage("LAPTOPS_CATALOG_DETAIL_TEMPLATE_OPTIONS_TITLE"); ?>
        </div>
        <ul class="list-group list-group-flush">
            <?php
            foreach ($arResult['LAPTOP_OPTIONS'] as $option) {
                ?>
                <li class="list-group-item">
                    <?= $option->getName(); ?>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>
