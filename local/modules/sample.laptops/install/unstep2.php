<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
if (!check_bitrix_sessid()) {
    return;
}

use Bitrix\Main\Localization\Loc;

CAdminMessage::ShowNote(Loc::getMessage('MOD_UNINST_OK'));

?>
<form action="<?= $this->GetCurPage() ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>"/>
    <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK'); ?>">
</form>
