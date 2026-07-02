<?
///opt/php56/bin/php /var/www/www-root/data/www/dnlr.ru/local/cron/run.php > /var/www/www-root/data/www/dnlr.ru/local/cron/out.txt

/*
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/../.." ) ;
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('CHK_EVENT', true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php" ) ;

include '_update_user_data.php';
log2file("cron",[rand(0,999),date("H:i:s")],true);
*/