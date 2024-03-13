<?
if(!check_bitrix_sessid()) return;
use Bitrix\Main\Localization\Loc;
UnRegisterModule("farexpo.registration");
echo CAdminMessage::ShowNote(Loc::getMessage("UNINSTALL_COMPLETE"));
?>