<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
	//Детальная страница организации
	/*
		* https://api-fns.ru/api_help
		* https://dadata.ru/api/suggest/party/
		* 
		* 
	*/
	$this->setFrameMode(true);
	/**
 * Отрисовка Таймлайна
 */
 $last_manager_id = 0;
$allServices = Client::getAllServicesConsultsHistory($arResult['ID']);
$allManagers = Helper::getManagers();
$orgType_VALUE_ENUM_ID = $arResult['PROPERTIES']['ORG_TYPE']['VALUE_ENUM_ID'];
$hasExpiredContractDeadline = Client::hasExpiredContractDeadline($arResult['ID']);


$clients_id = Contact::getClientContactsReturnId($arResult['ID']);
if($clients_id){
	$arSelect = Array("ID", "NAME", "IBLOCK_ID", "DATE_ACTIVE_FROM", "PROPERTY_CONTACT", "PREVIEW_TEXT", "DATE_ACTIVE_TO", "PROPERTY_MANAGER");
	$arFilter = Array("IBLOCK_ID"=>7, "ACTIVE"=>"Y", "PROPERTY_CONTACT" => $clients_id);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
	if ($res->SelectedRowsCount()!=0){
		while($ob = $res->GetNextElement())
		{
			$fields = $ob->GetFields();
			$date1 = explode(" ", $fields['DATE_ACTIVE_FROM']);
			$date2 = explode(" ", $fields['DATE_ACTIVE_TO']);
			
			$contact_res = CIBlockElement::GetByID($fields["PROPERTY_CONTACT_VALUE"]);
			if($ar_contact = $contact_res->GetNext()){
			   $name_contact =  $ar_contact['NAME'];
			   $arFields[$fields["ID"]]["CONTACT"][] = $name_contact;
			}   
			$arFields[$fields["ID"]]["ID"] = $fields["ID"];
			$arFields[$fields["ID"]]["DATE_ACTIVE_FROM"] = $fields["DATE_ACTIVE_FROM"];
			$arFields[$fields["ID"]]["DATE_ACTIVE_TO"] = $fields["DATE_ACTIVE_TO"];
			$arFields[$fields["ID"]]["NAME"] = $fields["NAME"];
			$arFields[$fields["ID"]]["DATE"] = $date1[0];
			$arFields[$fields["ID"]]["DATE_UNIX"] = MakeTimeStamp($fields["DATE_ACTIVE_FROM"], "DD.MM.YYYY HH:MI:SS");
			$arFields[$fields["ID"]]["DATE_TO"] = $date2[0];
			$arFields[$fields["ID"]]["TYPE"] = 'EVENT';
			$arFields[$fields["ID"]]["MANAGER_ID"] = $fields["PROPERTY_MANAGER_VALUE"];
			$arFields[$fields["ID"]]["DETAIL_PAGE_URL"] = '/event/'.$fields["ID"].'/';
			
		}

		$allServices = array_merge($allServices, $arFields);

		usort($allServices, function ($item1, $item2) {
			return $item2['DATE_UNIX'] <=> $item1['DATE_UNIX'];
		});	
	}	
}


?>


<div class="clinet-detail" id="client-detail">
	<div class="top-btn word-export-hide">
		<a href="/clients/"  class="btn"><i class="fa fa-arrow-left"></i> В список</a>
		<a   class="btn" onclick="exportClientHTML('<?= $arResult['NAME'] ?>','<?= $arResult['NAME'] ?>')"><i class="fa fa-file-word-o"></i> скачать </a>
		<br/><br/>
	</div>
    <div class="row">
		
		<div class="col-md-3 client-logo word-export-hide">
			<?
				if ($arResult["PREVIEW_PICTURE"]["SRC"] == "") {
					$arResult["PREVIEW_PICTURE"]["SRC"] = "/test-files/no-photo.png";
					$isNoImg = true;
				}
				
				
				if($arResult['PROPERTIES']['LOGO']['~VALUE']!=""){
				  $arLogo = json_decode($arResult['PROPERTIES']['LOGO']['~VALUE'],true);
				//  l( $arLogo);
				//l(BX_CRM_SITE_URL.$arLogo['showUrl']);
				//$arResult["PREVIEW_PICTURE"]["SRC"]  = BX_CRM_SITE_URL.$arLogo['showUrl'];
				}
			?>
			<img src="<?= $arResult["PREVIEW_PICTURE"]["SRC"] ?>" alt="" class="">
		</div>
		
		<div class="col-md-6">
			<? include '_inform.php'; ?>
		</div>
		
		
		<div class="col-md-3">
			<a href="/clients/edit/?id=<?= $arResult['ID'] ?>"><i class="word-export-hide fa fa-edit"></i> редактировать</a>
			<br> <br>
			<? include '_raiting.php'; ?>
		</div>
		
		</div>
		
		<div>
			<ul class="nav nav-tabs word-export-hide">
			<li class="active">
				<a data-toggle="tab" href="#description">История работы</a>
			</li>
			<li>
				<a data-toggle="tab" href="#characteristics" onclick="client.getInformationFromEGRNById(<?= $arResult['ID'] ?>)">О контрагенте</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="description">
				<? include '_service-timeline.php'; ?>
			</div>
			<div class="tab-pane" id="characteristics">
				<div class="timeline-content">
					<div class="client-contragent-info">
						
					</div>
					
				</div>
			</div>
			
		</div>
	
    </div>
	
	
	</div>
	
	<? include '_export_word.php'; ?>	
