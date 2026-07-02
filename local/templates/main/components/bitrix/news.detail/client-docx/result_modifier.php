<?php

//IBLOCK_SECTION_ID
$uf_arresult = CIBlockSection::GetList(
		["SORT" => "ASC"], ["IBLOCK_ID" => $arParams['IBLOCK_ID'], "ID" => $arResult['IBLOCK_SECTION_ID']], false, ['ID', "NAME", "DESCRIPTION"]
);

if ($res = $uf_arresult->GetNext()) {
	$arResult['SECTION_DESCRIPTION'] = $res['~DESCRIPTION'];
}
if( strpos($arResult['NAME'],'хо ')!==false){
	$prop['MSP'] = array('VALUE' => 13);
	CIBlockElement::SetPropertyValuesEx($arResult['ID'], $arParams['IBLOCK_ID'], $prop);
	
}
//MSP
//l($arResult['PROPERTIES']['MSP']['VALUE']);
if (false /*$arResult['PROPERTIES']['INN']['VALUE'] != "" && $arResult['PROPERTIES']['MSP_TEXT']['VALUE'] == ""*/) {
	require($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/class/Rusprofile.php');
	$inn = $arResult['PROPERTIES']['INN']['VALUE'];
	$rp = new Rusprofile();
	//$rp->log = true;
	$rp->inn = $inn;
	$result = $rp->isMSP();
	$prop = [];
	if ($result['result']) {
		$prop['MSP'] = array('VALUE' => 13);
	}
	$prop['MSP_TEXT'] = array('VALUE' => $result['result_text']);
	//CIBlockElement::SetPropertyValuesEx($arResult['ID'], $arParams['IBLOCK_ID'], $prop);
}

