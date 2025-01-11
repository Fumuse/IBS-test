<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
if (!check_bitrix_sessid()) {
    return;
}

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Localization\Loc;

$serviceLocator = ServiceLocator::getInstance();
$errorsService = $serviceLocator->get("sample.laptops.ErrorsService");

if ($errorsService->hasErrors()) {
    foreach ($errorsService->getErrors() as $error) {
        CAdminMessage::ShowOldStyleError($error->getMessage());
    }
} else {
    CAdminMessage::ShowNote(Loc::getMessage('MOD_INST_OK'));
}

?>
<form action="<?= $this->GetCurPage() ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>"/>
    <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK'); ?>">
</form>
