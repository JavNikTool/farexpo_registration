<?
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Localization\Loc;

$module_id = "farexpo.registration";

if(!$USER->IsAdmin() || !Loader::includeModule($module_id))
return;1232

$arAllOptions = [
	"Главные настройки",
	[
		"ID" => "set_sending_data_time",
		"NAME" => Loc::getMessage("REG_OPT_SET_SENDING_DATA_TIME_NAME"),
		"Y",
		"PARAMS" => [
			"TYPE" => "text"
		]
	]
];

$aTabs = [
	[
		"DIV" => "edit1",
		"TAB" => "Настройки",
		"TITLE" => "Настройка параметров модуля"
	]
];

$request = HttpApplication::getInstance()->getContext()->getRequest();

$tabControl = new CAdminTabControl("tabControl", $aTabs);
?>

<?$tabControl->Begin();?>
<form action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?echo LANG?>" method="post">
<?php 
echo bitrix_sessid_post();


$tabControl->BeginNextTab();
if($_REQUEST['RestoreDefaults'] === 'Y') {
	include_once('default_option.php');
	if (is_array($reg_default_option))
		{
			foreach ($reg_default_option as $option => $value)
			{
				Option::set($module_id, $option, $value);
			}
		}
}
foreach($arAllOptions as $arOption) {
	if (!is_array($arOption)) {
		?><tr class="heading">
	<td colspan="2"><?=$arOption?></td><?
	}else{
		
	$time = $request->get('set_sending_data_time') !== null ? $request->get('set_sending_data_time') : Option::get($module_id, $arOption['ID']);
	Option::set($module_id, "set_sending_data_time", $time);
		?><tr>
	<td width="50%" align="end" style="padding: 5px 4px 7px 0;"><?= $arOption["NAME"] ?></td>
	<td width="50%" style="padding: 5px 0 7px 4px;">
	<input type="<?= $arOption["PARAMS"]["TYPE"] ?>" value="<?=Option::get($module_id, $arOption['ID'])?>" name="<?=$arOption['ID']?>"><?
		/* echo '<pre>';
		var_dump($arOption);
		echo '</pre>'; */
	}
}
$tabControl->Buttons();?>

<script type="text/javascript">
function RestoreDefaults()
{
	if (confirm('<? echo CUtil::JSEscape(Loc::getMessage("REG_OPT_RESTORE_MESS")); ?>'))
		window.location = "<?echo $APPLICATION->GetCurPage()?>?lang=<? echo LANGUAGE_ID; ?>&mid=<? echo $module_id; ?>&RestoreDefaults=Y&<?=bitrix_sessid_get()?>";
}
</script>

	<input type="submit" name="Apply" value="<?= Loc::getMessage("REG_OPT_BTN_SAVE")?>" title="<?= Loc::getMessage("REG_OPT_SAVE_TITLE")?>" class="adm-btn-save">
	<input type="hidden" name="Update" value="Y">
	<input type="button" title="<?= Loc::getMessage("REG_OPT_HINT_RESTORE_DEFAULTS_TITLE")?>" OnClick="RestoreDefaults();" value="<?= Loc::getMessage("REG_OPT_HINT_RESTORE_DEFAULTS")?>">
</form>
<?

/* echo "<pre>";
print_r($request->get('time'));
echo "</pre>"; */
/* echo Option::get($module_id, "time"); */