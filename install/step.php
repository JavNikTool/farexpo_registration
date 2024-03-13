<?

use Bitrix\Main\Localization\Loc;

if(!check_bitrix_sessid()) return;

global $errors;

if (empty($errors))
{
	RegisterModule("farexpo.registration");
    echo CAdminMessage::ShowNote(Loc::getMessage("FAREXPO_REG_INSTALL_COMPLETE"));
}
else
{
	CAdminMessage::ShowMessage(
		array(
			'TYPE' => 'ERROR',
			'MESSAGE' => Loc::getMessage("FAREXPO_REG_INSTALL_ERROR"),
			'DETAILS' => implode('<br>', $errors),
			'HTML' => true
		)
	);
}

?>
<form action="<? echo $APPLICATION->GetCurPage(); ?>">
<p>
	<input type="hidden" name="lang" value="<? echo LANGUAGE_ID; ?>">
	<input type="submit" name="" value="<? echo GetMessage('MOD_BACK'); ?>">
</p>
<form>