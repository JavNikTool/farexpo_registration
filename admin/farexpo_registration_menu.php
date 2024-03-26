<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/farexpo.registration/prolog.php");

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Main\UI\Extension;

$module_id = "farexpo.registration";
$moduleAccessLevel = $APPLICATION->GetGroupRight($module_id);

if ($moduleAccessLevel == "D") {
        $APPLICATION->AuthForm("Доступ запрещен!");
    }

if(!Loader::includeModule('farexpo.registration')) {
    throw new Exception("Не установен модуль: Регистрация на выставку");
    
}

include __DIR__ . '/assets/style.php';

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
    [
        "ID" => "fi-expo_ex",
        "NAME" => "Мода"
    ],
    [
        "ID" => "gaz_ex",
        "NAME" => "Газ-Котлы-Энерго"
    ],
];

$arAllOptions = [
    [
        "ID" => "active_status",
        "NAME" => "Статус:",
        "DESCRIPTION" => "Статус активности работы программы",
        "TYPE" => "p",
        "DEFAULT" => "неактивно"
    ],
   /*  [
        "ID" => "active_btn",
        "NAME" => "Запустить разовую отправку",
        "DESCRIPTION" => "Статус активности работы программы",
        "TYPE" => "button",
    ], */
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

<form method="post" id="forma" action="<? echo $APPLICATION->GetCurPage() ?>?lang=<? echo LANG ?>&<?= bitrix_sessid_get() ?>" name="form<?=ACTION_REGISTRATION?>"><?
$tabControl->BeginNextTab();

$posts = $request->getPostList();
$gets = $request->getQueryList();

    /* echo $moduleAccessLevel; */

    /* echo "<pre>";
        var_dump($posts);
    echo "</pre>";

    echo "<pre>";
        var_dump($gets);
    echo "</pre>"; */

    if(isset($posts["exhibition"])) {
        $exhibition = $posts["exhibition"];
    
        Option::set($module_id, "exhibition", $exhibition);
        
    }

    if(isset($gets["StopSending"]) && $gets["StopSending"] == "Y") {
        Option::delete($module_id, array(
            "name" => "exhibition"
        ));
    }

    $exhibitionId = Option::get($module_id, "exhibition");

    /* echo $exhibitionId;
    echo "<pre>";
    print_r(Option::getForModule($module_id));
    echo "</pre>"; */

    ?>
        <tr>
            <td width="40%" align="end">
                <p>
                    <b> Статус: </b>
                </p>
            </td>
            <td width="60%">
                <p>
                    <span class="<?= strlen($exhibitionId) > 0 ? "green" : "red" ?>">
                    <?= strlen($exhibitionId) > 0 ? "активно" : "неактивно" ?>
                    </span>
                    <span data-hint="Моя первая подсказка"></span>
                </p>
            </td>
        </tr>

        <tr>
            <td width="40%" align="end">
                    <p>Выбрать выставку: </p>
            </td>
            <td width="60%">
                <select name="exhibition">
                <?
                    foreach ($arExhibitions as $exhibition) {
                        ?>
                            
                            <option <? if ($exhibition["ID"] == $exhibitionId) echo "selected"; ?> value="<?= $exhibition["ID"]?>"><?= $exhibition["NAME"]?></option>
                            
                        <?
                    }
                ?>
                </select>
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

<script type="text/javascript">
    function StopRun() {
        window.location = "<? echo $APPLICATION->GetCurPage() ?>?lang=<?= LANGUAGE_ID ?>&mid=<? echo $module_id; ?>&StopSending=Y&<?= bitrix_sessid_get() ?>";
    }
</script>

    <input type="submit" <? if(strlen($exhibitionId) > 0) echo "disabled"; ?> id="tr_submit" class="adm-btn-green" data-action="<?= $currentAction ?>" value="Запуск">
    <input type="hidden" name="run" value="Y">
    <input type="button" onClick="StopRun();" <? if(isset($gets["StopSending"]) && $gets["StopSending"] == "Y") echo "disabled"; ?> id="tr_submit_stop" class="adm-btn" data-action="<?= $currentAction ?>" value="Остановить работу">
    <input type="button" id="tr_submit_once" class="adm-btn" data-action="<?= $currentAction ?>" value="Отправить один раз">
    <?
$tabControl->EndTab();
?>
	</form>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");