BX.ready(function() {
    BX.UI.Hint.init(BX('forma'));
})

function StopRun() {
    window.location = "<? echo $APPLICATION->GetCurPage() ?>?lang=<?= LANGUAGE_ID ?>&mid=<? echo $module_id; ?>&StopSending=Y&<?= bitrix_sessid_get() ?>";
}

function SendingOnce() {
    window.location = "<? echo $APPLICATION->GetCurPage() ?>?lang=<?= LANGUAGE_ID ?>&mid=<? echo $module_id; ?>&SendingOnce=Y&<&StopSending=Y&?= bitrix_sessid_get() ?>";
}