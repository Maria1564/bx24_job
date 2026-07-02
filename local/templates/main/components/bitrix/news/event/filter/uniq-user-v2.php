<?
	//CLIENT_UNIQ
	
	
	if ($_REQUEST['CLIENT_UNIQ'] == "Y")
	{

		
		//Параметры фильтров
	$DATE_TO =  false;
	if($_REQUEST['DATE_TO']){
	    $s = strtotime($_REQUEST['DATE_TO']);
		$DATE_TO = date('d.m.Y 23:59:59', $s);
	}
	
	$DATE_FROM =  false;
	if($_REQUEST['DATE_FROM']){
	    $s = strtotime($_REQUEST['DATE_FROM']);
		$DATE_FROM = date('d.m.Y 00:00:01', $s);
	}
	
		
		$arFilter = Array(
		     'ACTIVE'=>'Y',
		    "IBLOCK_ID" => IBLOCK_ID_SERVICE,
			'PROPERTY_TYPE'=> $isConsultPage?Service::TYPE_CONSALT_ID:Service::TYPE_SERVICE_ID,
		    ">DATE_ACTIVE_FROM"=> $DATE_FROM,
			"<DATE_ACTIVE_FROM"=> $DATE_TO,
			">PROPERTY_CLIENT"=>1,
		    //'<DATE_ACTIVE_FROM'=>$DATE_TO?$DATE_TO:$arItem['DATE_ACTIVE_FROM'],'>DATE_ACTIVE_FROM'=>$DATE_FROM?$DATE_FROM:'01.01.'.date('Y').' 01:01:00',
		);
		//l($arFilter);
		$arGroupCount = [];
			$needIds = [];
		$rsData = CIBlockElement::GetList(Array(), $arFilter, false,false,  array('ID', 'IBLOCK_ID', 'NAME','PROPERTY_CLIENT')   );
		while($arFields = $rsData->Fetch()) {
		
		if(!$arGroupCount[$arFields['PROPERTY_CLIENT_VALUE']]){
		  $needIds[] = $arFields['ID'];
		}
		   if($arFields['PROPERTY_CLIENT_VALUE']>0){
			$arGroupCount[$arFields['PROPERTY_CLIENT_VALUE']]++; 
		   }
		}
		$arClientsId = [];
		foreach($arGroupCount as $clientID => $consultCount){
			if($consultCount <= 1){
				$arClientsId[] = $clientID;
			}	
		}
		if($_GET['log'] == 1){
		     l($arGroupCount);
		}
		//$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_CLIENT'] = $arClientsId;
			$GLOBALS[$arParams["FILTER_NAME"]]['ID'] = $needIds;
	}//$_REQUEST['CLIENT_UNIQ']
	
	/*
	
	Смотри. Смысл этого фильтра в том, чтобы быстро понять скольким людям оказали консультации за период. То есть консультаций оказали например 100, но некоторых консультировали по 2-3-4-5 раз. В итоге реально людей консультировалось, например 55. Вон фильтр должен показывать сколько людей было проконсультировано, не учитывая повторы

там есть нюанс, что он с начала года должен учитывать этих уникальных. Но если речь идет про то, что они с начала года и выгружают, то по-сути фильтр должен просто показывать всех людей которым 1 или более раз оказаывалась консультация
то есть, если  выбрать фильтр "Только уникальные клиенты" , то  в результат должна попасть одна консультация музыченко

Демьянович 13:13
да

13:13
которая самая первая

Демьянович 13:13
да

13:13
остальные игнорятся

Демьянович 13:13
верно

13:14
если не выбрать этот фильтр, то в результат попадают все консультации музыченко, но в выгрузке у самой первой будет уникальность = 1 , остальные три = 0

Демьянович 13:14
да

13:14
понял теперь что нужно . сделаю

Демьянович 13:14
там еще нюанс с годом есть, не знаю правильно ли ты его учитываешь или нет

сейчас опишу

если они например берут выгрузку не с 1 января, а с 1 февраля

И предположим у той же Музыченко была одна консультация в январе уже, а остальные три в феврале-марте. 

То выгружая консультации только за фераль-март, мы все равно учитываем, что в январе музыченко уже консультировали, значит за февраль-март у нее будет три консультации, но все неуникальные.

То есть идея в том, что уникальные клиенты в этом фильтре считаются всегда в рамках этого года

если сейчас это не так работает, то пока забей, просто поправь то, что есть, а я на этот фильтр напишу подробное ТЗ со схемами

13:18

То есть идея в том, что уникальные клиенты в этом фильтре считаются всегда в рамках этого года
Демьянович Артем, Сегодня в 13:17

	*/