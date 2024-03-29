<?

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
class farexpo_registration extends CModule
{
    var $MODULE_ID = "farexpo.registration";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $PARTNER_NAME;

    function __construct()
    {
        $arModuleVersion = array();
        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path . "/version.php");
        $this->PARTNER_NAME = Loc::getMessage("FAREXPO_REG_PARTNER_NAME");
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("FAREXPO_REG_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("FAREXPO_REG_MODULE_DESCRIPTION");
    }

    function InstallFiles()
    {
        CopyDirFiles(
            $_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/admin",
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin",
            true,
            true
        );
        CopyDirFiles(
            $_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/components",
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components/farexpo",
            true,
            true
        );
        /* CopyDirFiles(
            $_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/js",
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/js/" . $this->MODULE_ID,
            true,
            true
        ); */
        /* CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/" . $this->MODULE_ID . "/install/panel", $_SERVER["DOCUMENT_ROOT"]."/bitrix/panel", true, true); */
        return true;
    }

    function UnInstallFiles()
    {
        DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/admin", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin");
        /* DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/js", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/js/" . $this->MODULE_ID);
        rmdir($_SERVER["DOCUMENT_ROOT"] . "/bitrix/js/" . $this->MODULE_ID); */
        /*  DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/" . $this->MODULE_ID . "/install/panel/" . $this->MODULE_ID, $_SERVER["DOCUMENT_ROOT"]."/bitrix/panel/" . $this->MODULE_ID);
        rmdir($_SERVER["DOCUMENT_ROOT"]."/bitrix/panel/" . $this->MODULE_ID); */
        return true;
    }

    function DoInstall()
    {
        global $USER, $APPLICATION;

        if ($USER->IsAdmin()) {
            $this->InstallFiles();
            $APPLICATION->IncludeAdminFile(Loc::getMessage("FAREXPO_REG_DO_INSTALL_MESS"), $_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/step.php");
            return true;
        }
    }

    function DoUninstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION, $USER;
        if ($USER->IsAdmin()) {
            $this->UnInstallFiles();
            $APPLICATION->IncludeAdminFile(Loc::getMessage("FAREXPO_REG_DO_UNINSTALL_MESS"), $DOCUMENT_ROOT . "/local/modules/" . $this->MODULE_ID . "/install/unstep.php");
        }
        return true;
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }
}
