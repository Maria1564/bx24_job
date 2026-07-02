<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
	if (isset($_REQUEST['ajax']))
	$APPLICATION->RestartBuffer();
	$arResult2 = [];
	$arHelper = [];
	foreach($arResult["SEARCH"] as $arItem){
		$arResult2[$arItem['PARAM1']][] =  $arItem['ITEM_ID'];
		$arHelper[$arItem['ITEM_ID']] = ["URL"=>$arItem['URL']];
	}
//	l($arResult2);
	$arResult["SEARCH_EXT"] = [];
	foreach($arResult2 as $iblockCode => $arID){
		$IBLOCK_ID = 0;
		if($iblockCode == 'service'){
			$IBLOCK_ID = IBLOCK_ID_SERVICE;
		}
		if($iblockCode == 'clients'){
			$IBLOCK_ID = IBLOCK_ID_CLIENT;
		}
		
		$arFilter = [
		'IBLOCK_ID' => $IBLOCK_ID,
		'ID' =>  $arID,
		
		array(
				"LOGIC" => "OR",
				array("NAME" => "%".$_GET["q"]."%"),
				array("PROPERTY_INN" => "%".$_GET["q"]."%"),
				array("PROPERTY_OGRN" => "%".$_GET["q"]."%"),
			),
		//"NAME" => "%".$_GET["q"]."%", // fixed 04/09/24 - поиск по вхождению
		];
		//l($arFilter);
		$uf_arresult = CIBlockElement::GetList([], $arFilter, false, false, []);
		$arr = [];
		while ($ob = $uf_arresult->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();
			if($arFields['IBLOCK_ID']==IBLOCK_ID_SERVICE){
				$type = $arProps['TYPE']['VALUE_ENUM_ID'];
				//l( $type);
				if($type ==2){
					$iblockCode = 'consult';
				}
				if($type ==1){
					$iblockCode = 'service';
				}
				// Если у услуги нет клиента то исключаем из посиковой выдачи
				if($arProps['CLIENT']['VALUE'] >0 ){
				$arClient = Client::getClientById($arProps['CLIENT']['VALUE'],true);
				  if(!$arClient)continue;
				}
			}
			//l($arClient);
			$arResult["SEARCH_EXT"][$iblockCode][] = [
			"TITLE"=> $arFields['NAME'],
			"URL"=> $arHelper[$arFields['ID']]['URL'],
			"CLIENT"=>$arClient,
			];
		}
	}
	
//	l($arResult["SEARCH_EXT"]);
?>

<? if( count($arResult["SEARCH_EXT"]['clients'])>0):?>
<div class="serch-item">
	<div class="section">Клиенты:</div>
	
	<?   foreach ($arResult["SEARCH_EXT"]['clients'] as $arItem)://l( $arItem); ?>
	<div class="serach-list">
		<a href="<? echo $arItem["URL"] ?>"><? echo $arItem["TITLE"] ?></a>
	</div>
	
	<? endforeach; ?>
</div>
<?endif?>

<? if( count($arResult["SEARCH_EXT"]['service'])>0):?>
<div class="serch-item">
	<div class="section">Услуги:</div>
	<?   foreach ($arResult["SEARCH_EXT"]['service'] as $arItem)://l( $arItem); ?>
	<div class="serach-list">
		<a href="<? echo $arItem["URL"] ?>"><? echo $arItem["TITLE"] ?></a>
		<div style="color:#808080"><? echo $arItem["CLIENT"]['NAME'] ?></div>
	</div>
	
	<? endforeach; ?>
</div>
<?endif?>


<? if( count($arResult["SEARCH_EXT"]['consult'])>0):?>
<div class="serch-item">
	<div class="section">Консультации:</div>
	
	<?   foreach ($arResult["SEARCH_EXT"]['consult'] as $arItem)://l( $arItem); ?>
	<div class="serach-list">
		<a href="<? echo $arItem["URL"] ?>"><? echo $arItem["TITLE"] ?></a>
		<div style="color:#808080"><? echo $arItem["CLIENT"]['NAME'] ?></div>
	</div>
	
	<? endforeach; ?>
</div>
<?endif?>
<?
	if (isset($_REQUEST['ajax']))
exit;