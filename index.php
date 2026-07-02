<?
//define("NEED_AUTH", true);

/* https://getbootstrap.com/docs/4.3/components/modal/
 * https://getbootstrap.com/docs/3.4/examples/theme/#
 * bx24abko  Z5p6X4m5
 */
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Главная');
if(!$USER->isAuthorized()){
	header('location:/auth/');
	exit;
}
header('location:/clients/');
exit;
?> 

<?

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>

<?

/*
 * https://www.nalog.ru/opendata/7707329152-rsmp/ - реестр малого и среднего 
 *  https://www.rusprofile.ru/search?query=4026005184
 * zwo4gd1en91xzxkx
Пример URL для вызова REST: https://example.bitrix24.ru/rest/USER_ID/WEBHOOK_CODE/METHOD
 * 
 * https://pm.admoblkaluga.ru/marketplace/local/
 * http://ekhlakov.blogspot.com/2015/09/bitrix24-api.html
 * 
 * https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=7985&LESSON_PATH=3913.4776.7985
 * 
 * 
 * 
 * Код приложения: 9

Ключ приложения: 17b78b701de6b06cd2901b10a3dbe022

 * 
 * https://pm.admoblkaluga.ru/crm/company/list/
 */