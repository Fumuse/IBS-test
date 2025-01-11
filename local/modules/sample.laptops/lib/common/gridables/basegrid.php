<?php

namespace Sample\Laptops\Common\Gridables;

use Bitrix\Main\DI\ServiceLocator;
use Sample\Laptops\Interfaces\IGridable;
use Sample\Laptops\Services\UrlService;

abstract class BaseGrid implements IGridable
{
    protected UrlService $urlService;

    protected bool $isSefMode = false;
    protected array $settings = [];

    protected int $recordsCount = 0;

    public function __construct(array $settings)
    {
        $serviceLocator = ServiceLocator::getInstance();
        $this->urlService = $serviceLocator->get("sample.laptops.UrlService");

        $this->settings = $settings;
        $this->isSefMode = $settings['sefMode'] ?? false;
    }

    public function getRecordsCount(): int
    {
        return $this->recordsCount;
    }

    protected function getBrandUrl($brand)
    {
        return $this->urlService->generateUrl(
            $this->isSefMode,
            $this->settings['sefUrlTemplates']['model'] ?? null,
            $this->settings['sefFolder'] ?? null,
            [
                'default' => [
                    'BRAND' => $brand?->getId(),
                ],
                'sef' => [
                    'BRAND' => $brand?->getSlug(),
                ]
            ]
        );
    }

    protected function getModelUrl($brand, $model)
    {
        return $this->urlService->generateUrl(
            $this->isSefMode,
            $this->settings['sefUrlTemplates']['laptop'] ?? null,
            $this->settings['sefFolder'] ?? null,
            [
                'default' => [
                    'BRAND' => $brand?->getId(),
                    'MODEL' => $model?->getId(),
                ],
                'sef' => [
                    'BRAND' => $brand?->getSlug(),
                    'MODEL' => $model?->getSlug(),
                ]
            ]
        );
    }

    protected function getDetailUrl($laptop)
    {
        return $this->urlService->generateUrl(
            $this->isSefMode,
            $this->settings['sefUrlTemplates']['detail'] ?? null,
            $this->settings['sefFolder'] ?? null,
            [
                'default' => [
                    'LAPTOP_ID' => $laptop?->getId(),
                ],
                'sef' => [
                    'LAPTOP' => $laptop?->getSlug(),
                ]
            ]
        );
    }
}
