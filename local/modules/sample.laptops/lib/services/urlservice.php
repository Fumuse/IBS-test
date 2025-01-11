<?php

namespace Sample\Laptops\Services;

use Bitrix\Main\Routing\Router;

class UrlService
{
    protected Router $router;

    public function __construct()
    {
        $this->router = \Bitrix\Main\Application::getInstance()->getRouter();
    }

    public function generateUrl(bool $ifSefMode, ?string $sefUrlTemplate, ?string $sefFolder, array $urlVariables)
    {
        if ($ifSefMode) {
            return \CComponentEngine::makePathFromTemplate(
                $sefFolder . $sefUrlTemplate,
                $urlVariables['sef'] ?? $urlVariables
            );
        }

        return $this->router->url($sefFolder, $urlVariables['default'] ?? $urlVariables);
    }
}
