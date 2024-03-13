<?

use Bitrix\Main\Localization\Loc;

$aMenu[] = array(
	"parent_menu" => "global_menu_settings",
	"sort" => 10,
	"text" => Loc::getMessage("FAREXPO_REG_MENU_TEXT"),
	"title" => Loc::getMessage("FAREXPO_REG_MENU_TITLE"),
	"url" => "farexpo_registration_menu.php?lang=".LANGUAGE_ID,
	"icon" => "util_menu_icon",
	"page_icon" => "util_page_icon",
	"items_id" => "menu_util",
	
);

return $aMenu;