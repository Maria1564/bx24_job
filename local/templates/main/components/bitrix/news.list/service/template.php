<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
	
	$this->setFrameMode(true);
	$allManagers = Helper::getManagers();

	if (!function_exists('getServiceListStoredPropertyValue')) {
		function getServiceListStoredPropertyValue($iblockId, $elementId, $propertyCode) {
			global $DB;

			static $propertyIds = [];

			$iblockId = (int)$iblockId;
			$elementId = (int)$elementId;
			if ($iblockId <= 0 || $elementId <= 0 || $propertyCode == '') {
				return '';
			}

			$cacheKey = $iblockId . ':' . $propertyCode;
			if (!array_key_exists($cacheKey, $propertyIds)) {
				$propertyIds[$cacheKey] = 0;
				$dbProperty = CIBlockProperty::GetList(
					[],
					[
						'IBLOCK_ID' => $iblockId,
						'CODE' => $propertyCode,
					]
				);
				if ($arProperty = $dbProperty->Fetch()) {
					$propertyIds[$cacheKey] = (int)$arProperty['ID'];
				}
			}

			$propertyId = $propertyIds[$cacheKey];
			if ($propertyId <= 0) {
				return '';
			}

			$tableName = 'b_iblock_element_prop_s' . $iblockId;
			$fieldName = 'PROPERTY_' . $propertyId;
			$sql = "
				SELECT {$fieldName} AS VALUE
				FROM {$tableName}
				WHERE IBLOCK_ELEMENT_ID = {$elementId}
				LIMIT 1
			";
			$dbValue = $DB->Query($sql, false, 'service list stored property');
			if ($arValue = $dbValue->Fetch()) {
				return $arValue['VALUE'];
			}

			return '';
		}
	}

	if (!function_exists('getServiceListClientName')) {
		function getServiceListClientName($clientId) {
			$clientId = (int)$clientId;
			if ($clientId <= 0) {
				return '';
			}

			$arClient = Client::getClientById($clientId);
			if (!empty($arClient['NAME'])) {
				return $arClient['NAME'];
			}

			$dbClient = CIBlockElement::GetList(
				[],
				[
					'IBLOCK_ID' => Client::CLIENT_IBLOCK_ID,
					'ID' => $clientId,
				],
				false,
				false,
				['ID', 'NAME']
			);
			if ($arInactiveClient = $dbClient->Fetch()) {
				return str_replace('&quot;', '"', $arInactiveClient['NAME']);
			}

			return '';
		}
	}

	if (!function_exists('getServiceListManagerName')) {
		function getServiceListManagerName($managerId, $allManagers) {
			$managerId = (int)$managerId;
			if ($managerId <= 0) {
				return '';
			}

			if (!empty($allManagers[$managerId]['FIO'])) {
				return $allManagers[$managerId]['FIO'];
			}

			$dbUser = CUser::GetByID($managerId);
			if ($arUser = $dbUser->Fetch()) {
				$fio = trim($arUser['LAST_NAME'] . ' ' . $arUser['NAME']);
				return $fio != '' ? $fio : $arUser['EMAIL'];
			}

			return '';
		}
	}
	
	//l($arResult["ITEMS"]);
?>

<script>
	app.newlist = {
		pagen: "<?= $arResult['NAV_RESULT']->PAGEN ?>",
		sizen: "<?= $arResult['NAV_RESULT']->SIZEN ?>",
		count: "<?= $arResult['NAV_RESULT']->NavRecordCount ?>"
	};
	setListCount();
</script>


<div class="service-list-items">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
	
	<?
		//continue;
		$taskStatusClass = '';
	    if($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] != 'CONSULT' && $arItem['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_CLOSED){
			$taskStatusClass = 'task-status-success';		   
		}
		if($arItem['PROPERTIES']['CLIENT_REFUSED']['VALUE'] == 1){
			$taskStatusClass = 'task-status-refused';	
			$arItem['PROPERTIES']['STATUS']['VALUE'] = false;
		}
		
		//убираем точное время
		$arT = explode(" ",$arItem["DATE_ACTIVE_FROM"]);
		$arItem["DATE_ACTIVE_FROM"] =  $arT [0];
		$arT = explode(" ",$arItem["DATE_ACTIVE_TO"]);
		$arItem["DATE_ACTIVE_TO"] =  $arT [0];

		$isClosedService = $arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] != 'CONSULT'
			&& $arItem['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_CLOSED;
		$deadlineDate = Service::calculateDeadline($arItem["DATE_ACTIVE_FROM"], $arItem["DATE_ACTIVE_TO"]);
		$isDeadlineExpired = false;
		$contractProvidedInfo = [
			'STATUS' => 'Нет',
			'TEXT' => '',
			'IS_PROVIDED' => false,
		];
		if ($isClosedService && $deadlineDate != '') {
			$deadlineTimestamp = MakeTimeStamp($deadlineDate);
			$todayTimestamp = MakeTimeStamp(date('d.m.Y'));
			$contractProvidedValue = $arItem['PROPERTIES']['CONTRACT_PROVIDED']['VALUE'];
			if ($contractProvidedValue == '') {
				$contractProvidedValue = getServiceListStoredPropertyValue($arItem['IBLOCK_ID'], $arItem['ID'], 'CONTRACT_PROVIDED');
			}
			$contractProvidedDate = $arItem['PROPERTIES']['CONTRACT_PROVIDED_DATE']['VALUE'];
			if ($contractProvidedDate == '') {
				$contractProvidedDate = getServiceListStoredPropertyValue($arItem['IBLOCK_ID'], $arItem['ID'], 'CONTRACT_PROVIDED_DATE');
			}
			$contractProvidedInfo = Service::getContractProvidedInfo($contractProvidedValue, $contractProvidedDate, $deadlineDate);
			$isContractProvidedInTime = false;
			if ($contractProvidedValue != '' && $contractProvidedDate != '') {
				$contractProvidedTimestamp = MakeTimeStamp($contractProvidedDate);
				if (!$contractProvidedTimestamp) {
					$contractProvidedTimestamp = strtotime($contractProvidedDate);
				}
				$isContractProvidedInTime = $contractProvidedTimestamp && $contractProvidedTimestamp <= $deadlineTimestamp;
			}
			$isDeadlineExpired = $deadlineTimestamp && $deadlineTimestamp < $todayTimestamp && !$isContractProvidedInTime;
		}
		if ($isDeadlineExpired) {
			$taskStatusClass .= ' deadline-expired';
		}
		
		
	?>
	<div class="row list-item <?=$taskStatusClass?>" >
		
		<div class="col-md-1 date-col">
		    <? echo $arItem["DISPLAY_ACTIVE_FROM"] ?>
			<?if($arParams['ALL_DATA_PAGE']):?>
			<span class="list-s-type <?=$arItem['PROPERTIES']['TYPE']['VALUE_XML_ID']?>"><?=$arItem['PROPERTIES']['TYPE']['VALUE_ENUM']?></span>
			<?endif?>
		</div>
		<div class="col-md-10">
		    <? if ($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] != 'CONSULT'): ?>
			<div class="status">  
			<?
				if ($arItem['PROPERTIES']['STATUS']['VALUE'] == Service::STATUS_ACTIVE)
				echo '<span class="cleint-active">В работе</span>';
				else
				echo '<span class="cleint-deactive">Завершен</span>';
			?>
			</div>
		    <? endif ?>
			
		    <a class="name" href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><? echo $arItem["NAME"] ?></a>
			
		    <div class="info">
				<div>
					<?
						$clientId = (int)$arItem['PROPERTIES']['CLIENT']['VALUE'];
						if ($clientId <= 0) {
							$clientId = (int)getServiceListStoredPropertyValue($arItem['IBLOCK_ID'], $arItem['ID'], 'CLIENT');
						}
						$clientName = getServiceListClientName($clientId);
					?>
					<span class="tl-info-title">клиент</span>
					<span class="tl-user"><?= htmlspecialcharsbx($clientName) ?></span>
				</div>
				<div>
					<?
						$managerId = (int)$arItem['PROPERTIES']['MANAGER']['VALUE'];
						if ($managerId <= 0) {
							$managerId = (int)getServiceListStoredPropertyValue($arItem['IBLOCK_ID'], $arItem['ID'], 'MANAGER');
						}
						$managerName = getServiceListManagerName($managerId, $allManagers);
					?>
					<span class="tl-info-title">ответственный</span>
					<span class="tl-user"><?= htmlspecialcharsbx($managerName) ?></span>
				</div>
				
				<div>
					<? if ($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'CONSULT'): ?>
				    <span class="tl-info-title">дата </span>
				    <span class="tl-user"> <?= $arItem["DATE_ACTIVE_FROM"] ?></span>
					<? else: ?>
				    <span class="tl-info-title">Период оказания услуги</span>
				    <span class="tl-user"> <?= $arItem["DATE_ACTIVE_FROM"] ?>  <?= $arItem["DATE_ACTIVE_TO"]!=""?'- '.$arItem["DATE_ACTIVE_TO"]:'' ?></span>
					<? endif ?>
					
				</div>
				<? if ($isClosedService && $deadlineDate != ''): ?>
				<div class="<?= $isDeadlineExpired ? 'contract-deadline-expired' : '' ?>">
				    <span class="tl-info-title">Дедлайн по контракту</span>
				    <span class="tl-user"><?= $deadlineDate ?></span>
				</div>
				<div>
				    <span class="tl-info-title">Предоставил контракт:</span>
				    <span class="tl-user"><?= $contractProvidedInfo['STATUS'] ?></span>
				    <span class="tl-user"><?= $contractProvidedInfo['TEXT'] ?></span>
				</div>
				<? endif ?>
				<? if ($ar['TYPE'] == 'CONSULT' && $ar['SERVICE']['ID'] != null): ?>
				<div>
				    <span class="tl-info-title">Услуга</span>
				    <span class="tl-user"><?= $ar['SERVICE']['NAME'] ?></span>
				</div>
				<? endif ?>
				
				<? if ($arItem['PROPERTIES']['MONEY']['VALUE'] > 0 || $arItem['PROPERTIES']['MONEY2']['VALUE'] >0|| $arItem['PROPERTIES']['MONEY3']['VALUE'] >0): ?>
				<div>
				    <span class="tl-info-title">Получено денег</span>
					<?if($arItem['PROPERTIES']['MONEY']['VALUE']):?>
				    <span class="tl-user"><?=number_format($arItem['PROPERTIES']['MONEY']['VALUE'], 0, ',', ' ') ?> руб.  (субсидии/гранты)</span>
					 <?endif?>
					<?if($arItem['PROPERTIES']['MONEY2']['VALUE']):?>
					 <span class="tl-user"><?=number_format($arItem['PROPERTIES']['MONEY2']['VALUE'], 0, ',', ' ') ?> руб. (кредиты/займы)</span>
					 <?endif?>
					<?if($arItem['PROPERTIES']['MONEY3']['VALUE']):?>
					 <span class="tl-user"><?=number_format($arItem['PROPERTIES']['MONEY3']['VALUE'], 0, ',', ' ') ?> руб. (госбюджет/АРБ)</span>
					 <?endif?>
				</div>
				<? endif ?>
				<?// l($arItem['PROPERTIES']['SMS_VOTE'])?>
				
				
				<? 
					/*
						----------------------------------------------------------------------------------------
						----------------------------------------------------------------------------------------
						----------------------------------------------------------------------------------------
						----------------------------------------------------------------------------------------
						----------------------------------------------------------------------------------------
						Выводим СМС данные
					*/
					//l($arItem['SMS_DATA']);
					//СМС отправлен но клиент не поставил оценку
					$smsStatus = 0;
					if($arItem['SMS_DATA']['UF_SMS_SEND_DATE']>0 && $arItem['SMS_DATA']['UF_SMS_VOTE_DATE'] == ""){
					  $smsStatus = 1;
					
					}
					//СМС отправлен клиент поставил оценку 
					if($arItem['SMS_DATA']['UF_SMS_SEND_DATE']>0 && $arItem['SMS_DATA']['UF_SMS_VOTE_DATE']>0 && $arItem['SMS_DATA']['UF_USER_VOTE']>0){
					$smsStatus = 2;
					
					}
				?>
				<? if ($smsStatus>0): ?>
				<div>
				    <span class="tl-info-title">SMS оценка </span>
				    <span class="tl-user">
					     <?if($smsStatus == 1):?>
						   Отправлен:  <?= date('d:m:y H:i:s',$arItem['SMS_DATA']['UF_SMS_SEND_DATE']) ?><br>
						   Оценка: нет
						 <?endif?>
						 
						  <?if($smsStatus == 2):?>
						Отправлен: <?= date('d:m:y H:i:s',$arItem['SMS_DATA']['UF_SMS_SEND_DATE']) ?><br>
						Оценка: <?= $arItem['SMS_DATA']['UF_USER_VOTE'] ?> (<?= date('d:m:y H:i:s',$arItem['SMS_DATA']['UF_SMS_VOTE_DATE']) ?>)<br> 
						 <?endif?>
					   
					</span>
					
				</div>
				<? endif ?>
			</div>
		    
			<div class="description"><? echo strip_tags($arItem["PREVIEW_TEXT"]) ?></div>
			
			
		</div>
	</div>
    <? endforeach; ?>
    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
	<br /><?= $arResult["NAV_STRING"] ?>
    <? endif; ?>
</div>
