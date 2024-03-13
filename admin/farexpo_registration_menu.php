<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;


require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/farexpo.registration/prolog.php");


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");


if(!Loader::includeModule('farexpo.registration')) {
    throw new Exception("Не установен модуль: Регистрация на выставку");
    
}

$APPLICATION->SetTitle(Loc::getMessage("FAREXPO_REG_ADM_TITLE"));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");