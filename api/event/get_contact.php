<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/api/json-header.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

//$_POST["id"] = 24249;

$arSelect = Array("ID", "NAME", "IBLOCK_ID");
$arFilter = Array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "PROPERTY_CLIENT" => $_POST["id"]);
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($ob = $res->GetNextElement())
{
$arFields[] = $ob->GetFields();
}

echo json_encode(['code' => REQUEST_CODE_SUCCESS,'result'=>$arFields]);