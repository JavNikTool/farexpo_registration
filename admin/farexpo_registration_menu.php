<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/farexpo.registration/prolog.php");

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Main\UI\Extension;
use Bitrix\Main\Page\Asset;

$module_id = "farexpo.registration";
$moduleAccessLevel = $APPLICATION->GetGroupRight($module_id);

if ($moduleAccessLevel == "D") {
        $APPLICATION->AuthForm("Доступ запрещен!");
    }

if(!Loader::includeModule('farexpo.registration')) {
    throw new Exception("Не установен модуль: Регистрация на выставку");
    
}

Asset::getInstance()->addCss("/home/bitrix/www/bitrix/panel/farexpo.registration/farexpo_registration.css");

$APPLICATION->SetTitle(Loc::getMessage("FAREXPO_REG_ADM_TITLE"));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$request = \Bitrix\Main\Context::getCurrent()->getRequest();

define("ACTION_REGISTRATION", "registration");

$aTabs = array(
	array(
		'DIV' => ACTION_REGISTRATION,
		'TAB' => "Регистрация",
		'TITLE' => "Регистрация",
	)
);

$arExhibitions = [
    "Газ-Котлы-Энерго",
    "Мода"
];

$arAllOptions = [
    [
        "ID" => "active_status",
        "NAME" => "Статус:",
        "DESCRIPTION" => "Статус активности работы программы",
        "TYPE" => "p",
        "DEFAULT" => "неактивно"
    ],
];

$tabControl = new \CAdminTabControl('tabControl', $aTabs, false, true);
$tabControl->Begin();

Extension::load("ui.hint");

?>

<script type="text/javascript">
    BX.ready(function() {
        BX.UI.Hint.init(BX('forma'));
    })
</script>

<form method="post" id="forma" action="<? echo $APPLICATION->GetCurPage() ?>?lang=<? echo LANG ?>" name="form<?=ACTION_REGISTRATION?>"><?
$tabControl->BeginNextTab();
/* echo "<pre>";
    print_r(Option::getForModule($module_id));
    echo "</pre>";
     
    echo $moduleAccessLevel; */

    ?>
        <tr>
            <td width="40%" align="end">
                <p>
                    <b> Статус: </b>
                </p>
            </td>
            <td width="60%">
                <p>
                    <span class="red">
                    неактивно
                    </span>
                    <span data-hint="Моя первая подсказка"></span>
                </p>
            </td>
        </tr>
    <?


    $all_options = Option::getForModule($module_id);

    foreach ($arAllOptions as $option) {
        ?>
    <!-- <tr>
        <td width="40%" align="end">
            <p>
            <b></b>
            </p>
        </td>
        <td width="60%">
            <p>
            <span style="color:red">
                
            </span>
            <span data-hint="Моя первая подсказка"></span>
            </p>
        </td>
    </tr> -->
    <?
    }
    $tabControl->Buttons();
    ?>
    <input type="submit" id="tr_submit" class="adm-btn-green" data-action="<?= $currentAction ?>" value="Запуск">
    <input type="submit" id="tr_submit" class="adm-btn" data-action="<?= $currentAction ?>" value="Остановить работу">
    <?
$tabControl->EndTab();
?>
	</form>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");