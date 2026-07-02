<?

//
CModule::IncludeModule("iblock");

//require_once($_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php');
require_once "config.php";
require_once "functions.php";
require "class/ChangeHistory.php";
include_once "events/history-change.php";
include_once "events/client-events.php";
include_once "class/Dadata.php";
include_once "class/Manager.php";
include_once "class/Helper.php";
include_once "class/Client.php";
include_once "class/Service.php";
include_once "class/Raiting.php";
include_once "class/Contact.php";
include_once "class/Bx24.php";
include_once "class/MSP.php";
include_once "class/BX24SyncCompany.php";
include_once "class/BX24SyncTask.php";
include_once "class/BX24SyncDeal.php";
if (defined('ADMIN_SECTION') && (ADMIN_SECTION === true)) {
	require_once "events/admin-events.php";
}