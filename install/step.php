<?
if(!check_bitrix_sessid()) return;
use Bitrix\Main\Localization\Loc;
RegisterModule("farexpo.registration");
echo CAdminMessage::ShowNote(Loc::getMessage("INSTALL_COMPLETE"));
?>