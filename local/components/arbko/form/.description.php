<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("DEEN_LIST_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("DEEN_LIST_COMPONENT_DESCRIPTION"),
	"ICON" => "/images/regions.gif",
	"SORT" => 500,
	"PATH" => array(
		"ID" => "deen_order_components",
		"SORT" => 500,
		"NAME" => GetMessage("DEEN_LIST_COMPONENTS_FOLDER_NAME"),
	),
);

?>