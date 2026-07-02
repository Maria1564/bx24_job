<?
	
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
	$APPLICATION->SetPageProperty("TITLE", "Личный кабинет");
	$APPLICATION->SetPageProperty("keywords", "Личный кабинет");
	$APPLICATION->SetPageProperty("description", "Личный кабинет");
	
	$APPLICATION->IncludeComponent("bitrix:main.profile", "template1", 
	Array(
	"CHECK_RIGHTS" => "Y",	// Проверять права доступа
	"SEND_INFO" => "N",	// Генерировать почтовое событие
	"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
	"USER_PROPERTY" => "",	// Показывать доп. свойства
	"USER_PROPERTY_NAME" => "",	// Название закладки с доп. свойствами
	),
	false
);?>
<br>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>