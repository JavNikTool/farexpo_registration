<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/farexpo.registration/prolog.php");

$module_id = "farexpo.registration";
$moduleAccessLevel = $APPLICATION->GetGroupRight($module_id);

if (!$moduleAccessLevel == "R") {
        $APPLICATION->AuthForm("Доступ запрещен!");
    }

if(!Loader::includeModule('farexpo.registration')) {
    throw new Exception("Не установен модуль: Регистрация на выставку");
    
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$APPLICATION->SetTitle(Loc::getMessage("FAREXPO_REG_ADM_TITLE"));

$arExhibitions = [
    "Газ-Котлы-Энерго",
    "Мода"
];

$arAllOptions = [
    [
        "ID" => "set_sending_data_time",
        "NAME" => "Статус",
        "PARAMS" => [
            "TYPE" => "text"
        ]
    ],
];

?>

<?

echo "<pre>";
	print_r(Option::getForModule($module_id));
	echo "</pre>";

echo $moduleAccessLevel;




require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");