<?php

use Bitrix\Main\Application;
use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\DB;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Context;
use Bitrix\Main\Request;
use Bitrix\Main\Entity\Base;
use Sample\Laptops\Interfaces\ISeedable;

class sample_laptops extends \CModule
{
    private int $step = 0;

    private \CMain $application;
    private Request $request;
    private DB\Connection $connection;
    private ServiceLocator $serviceLocator;

    protected array $entitiesToInstall = [
        \Sample\Laptops\Entity\BrandTable::class,
        \Sample\Laptops\Entity\ModelTable::class,
        \Sample\Laptops\Entity\OptionTable::class,
        \Sample\Laptops\Entity\LaptopOptionsTable::class,
        \Sample\Laptops\Entity\LaptopTable::class,
    ];

    private array $errors = [];

    public function __construct()
    {
        $this->setModuleInformation();
        $this->setParams();
    }

    protected function setModuleInformation()
    {
        $this->MODULE_ID = "sample.laptops";
        $this->MODULE_NAME = Loc::getMessage('SAMPLE_LAPTOP_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('SAMPLE_LAPTOP_MODULE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('SAMPLE_LAPTOP_MODULE_AUTHOR');
        $this->PARTNER_URI = Loc::getMessage('SAMPLE_LAPTOP_MODULE_AUTHOR_URI');

        $this->setVersion();
    }

    protected function setVersion()
    {
        include __DIR__ . '/version.php';

        /** @var array $arModuleVersion */
        $this->MODULE_VERSION = $arModuleVersion['MODULE_VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['MODULE_VERSION_DATE'];
    }

    protected function setParams()
    {
        $this->serviceLocator = ServiceLocator::getInstance();
        $this->connection = Application::getConnection();
        $this->request = Context::getCurrent()->getRequest();
        $this->application = $GLOBALS['APPLICATION'];
        $this->step = intval($GLOBALS['step']);
    }

    public function DoInstall()
    {
        if ($this->step < 2) {
            $this->showInstallStep(1);
        } elseif ($this->step == 2) {
            ModuleManager::registerModule($this->MODULE_ID);
            self::IncludeModule($this->MODULE_ID);

            $this->InstallTasks();
            $this->installFiles();
            $this->installDB(
                $this->request->get("rollback_bd") == "Y"
            );

            if (!empty($this->errors)) {
                ModuleManager::unRegisterModule($this->MODULE_ID);
                $errorsService = $this->serviceLocator->get("sample.laptops.ErrorsService");
                $errorsService->addErrors($this->errors);
            }

            $this->showInstallStep(2);
        }
    }

    public function DoUninstall()
    {
        if ($this->step < 2) {
            $this->showInstallStep(1, true);
        } elseif ($this->step == 2) {
            if ($this->request->get("rollback_bd") == "Y") {
                $this->unInstallDB();
            }

            $this->UnInstallTasks();

            ModuleManager::unRegisterModule($this->MODULE_ID);
            $this->showInstallStep(2, true);
        }
    }

    public function installFiles(): bool
    {
        CopyDirFiles(
            __DIR__ . "/components",
            $_SERVER["DOCUMENT_ROOT"] . "/local/components",
            true,
            true
        );
        return true;
    }

    public function installDB(bool $rollBackDb = false): void
    {
        try {
            if ($rollBackDb) {
                $this->unInstallDB();
            }

            foreach ($this->entitiesToInstall as $entity) {
                $table = Base::getInstance($entity);
                if (!$this->connection->isTableExists($table->getDBTableName())) {
                    $table->createDBTable();

                    $reflectionClass = new ReflectionClass($entity);
                    if ($reflectionClass->implementsInterface(ISeedable::class)) {
                        $entity::seeding();
                    }
                }
            }
        } catch (\Exception $exception) {
            $this->errors[] = new \Bitrix\Main\Error($exception->getMessage(), $exception->getCode());
        }
    }

    public function unInstallDB(): void
    {
        global $DB;
        $DB->RunSQLBatch(__DIR__ . '/db/mysql/uninstall.sql');
    }

    protected function showInstallStep(int $step, bool $unistall = false)
    {
        $fileName = ($unistall ? "unstep" : "step") . $step;

        $this->application->IncludeAdminFile(
            Loc::getMessage("SAMPLE_LAPTOP_MODULE_" . ($unistall ? "UN" : "") . "INSTALL_STEP_TITLE"),
            __DIR__ . "/{$fileName}.php"
        );
    }

    public function GetModuleTasks()
    {
        return [
            'sample_laptops_deny' => [
                'LETTER' => 'D',
                'BINDING' => 'module',
                'OPERATIONS' => []
            ],
            'sample_laptops_read' => [
                'LETTER' => 'R',
                'BINDING' => 'module',
                'OPERATIONS' => [
                    'list_read',
                    'detail_read'
                ]
            ],
            'sample_laptops_add' => [
                'LETTER' => 'E',
                'BINDING' => 'module',
                'OPERATIONS' => [
                    'brand_add',
                    'model_add',
                    'laptop_add'
                ]
            ],
        ];
    }
}
