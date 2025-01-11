<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;

/**
 * @var \CMain $this
 */

\Bitrix\Main\UI\Extension::load("ui.alerts");
$request = Context::getCurrent()->getRequest();
?>
<form action="<?= $this->GetCurPage(); ?>" method="POST">
    <?= bitrix_sessid_post(); ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>">
    <input type="hidden" name="id" value="sample.laptops">
    <input type="hidden" name="uninstall" value="Y">
    <input type="hidden" name="step" value="2">

    <table class="list-table">
        <tr class="head">
            <td colspan="2">
                <div class="ui-alert ui-alert-warning" role="alert">
                    <div class="ui-alert-message">
                        <input type="checkbox" name="rollback_bd" id="rollback_bd" value="Y"
                                <?= (($request->get("rollback_bd") ?? null) == "Y" ? "checked" : "") ?>
                        />
                        <label for="rollback_bd">
                            <?= Loc::getMessage("SAMPLE_LAPTOP_MODULE_UNINSTALL_STEP_DELETE_TABLES"); ?>
                        </label>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="<?= Loc::getMessage("MOD_UNINST_DEL") ?>"/>
            </td>
        </tr>
    </table>
</form>
