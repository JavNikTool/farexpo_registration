<?

use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Localization\Loc;

$module_id = "farexpo.registration";
$moduleAccessLevel = $APPLICATION->GetGroupRight($module_id);

if ($moduleAccessLevel >= 'R') 
{
	Loader::includeModule($module_id);
	Loc::loadMessages(__FILE__);

	$arAllOptions = [
		"Главные настройки",
		[
			"ID" => "set_sending_data_time",
			"NAME" => Loc::getMessage("FAREXPO_REG_OPT_SET_SENDING_DATA_TIME_NAME"),
			"DESCRIPTION" => Loc::getMessage("FAREXPO_REG_OPT_SET_SENDING_DATA_TIME_DESCRIPTION"),
			"PARAMS" => [
				"TYPE" => "text"
			]
		],
		"URL сайтов",
		[
			"ID" => "set_rosgas_url",
			"NAME" => Loc::getMessage("FAREXPO_REG_OPT_SET_ROSGAS_URL"),
			"DESCRIPTION" => Loc::getMessage("FAREXPO_REG_OPT_SET_ROSGAS_DESCRIPTION"),
			"PARAMS" => [
				"TYPE" => "text"
			]
		],
		[
			"ID" => "set_fiexpo_url",
			"NAME" => Loc::getMessage("FAREXPO_REG_OPT_SET_FIEXPO_URL"),
			"DESCRIPTION" => Loc::getMessage("FAREXPO_REG_OPT_SET_FIEXPO_DESCRIPTION"),
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
		],
		[
			"DIV" => "edit2",
			"TAB" => "Доступ",
			"TITLE" => "Настройка параметров модуля"
		]
	];

	$request = HttpApplication::getInstance()->getContext()->getRequest();
	$tabControl = new CAdminTabControl("tabControl", $aTabs);
	$tabControl->Begin();
	?>

	<form action="<? echo $APPLICATION->GetCurPage() ?>?mid=<?= htmlspecialcharsbx($mid) ?>&lang=<? echo LANG ?>" method="post">
		<?php
		echo bitrix_sessid_post();

		$tabControl->BeginNextTab();
		if ($_REQUEST['RestoreDefaults'] === 'Y') 
		{
			include_once('default_option.php');
			if (is_array($reg_default_option)) {
				foreach ($reg_default_option as $option => $value) {
					Option::set($module_id, $option, $value);
				}
			}
		}
		foreach ($arAllOptions as $arOption) 
		{
			if (!is_array($arOption)) 
			{
				?>
					<tr class="heading">
					<td colspan="2"><?= $arOption ?></td>
				<?
			} 
			else 
			{
				$option_id = $arOption["ID"];
				$option_value = $request->get($option_id) !== null ? $request->get($option_id) : Option::get($module_id, $option_id);
				Option::set($module_id, $option_id, $option_value);
				?>
					<tr>
					<td width="50%" align="end" style="padding: 5px 4px 7px 0;"><p title="<?=$arOption["DESCRIPTION"]?>"><?= $arOption["NAME"] ?></p>
				</td>
					<td width="50%" style="padding: 5px 0 7px 4px;">
					<input type="<?= $arOption["PARAMS"]["TYPE"] ?>" value="<?= Option::get($module_id, $option_id) ?>" name="<?= $arOption['ID'] ?>"><?
					/* echo '<pre>';
					var_dump($arOption);
					echo '</pre>'; */
			}
		}
		$tabControl->BeginNextTab();
		require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/admin/group_rights.php');
		$tabControl->Buttons(); ?>

		<script type="text/javascript">
			function RestoreDefaults() {
				if (confirm('<? echo CUtil::JSEscape(Loc::getMessage("FAREXPO_REG_OPT_RESTORE_MESS")); ?>'))
					window.location = "<? echo $APPLICATION->GetCurPage() ?>?lang=<? echo LANGUAGE_ID; ?>&mid=<? echo $module_id; ?>&RestoreDefaults=Y&<?= bitrix_sessid_get() ?>";
			}
		</script>

		<input type="submit" name="Apply" value="<?= Loc::getMessage("FAREXPO_REG_OPT_BTN_SAVE") ?>" title="<?= Loc::getMessage("FAREXPO_REG_OPT_SAVE_TITLE") ?>" class="adm-btn-save">
		<input type="hidden" name="Update" value="Y">
		<input type="button" title="<?= Loc::getMessage("FAREXPO_REG_OPT_HINT_RESTORE_DEFAULTS_TITLE") ?>" OnClick="RestoreDefaults();" value="<?= Loc::getMessage("FAREXPO_REG_OPT_HINT_RESTORE_DEFAULTS") ?>">
	</form>
	<? $tabControl->End();

	/* echo "<pre>";
	print_r($request->get('time'));
	echo "</pre>"; */
	/* echo Option::get($module_id, "time"); */
}
	
	