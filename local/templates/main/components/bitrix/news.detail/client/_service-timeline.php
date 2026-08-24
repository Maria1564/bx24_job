<?
	
	if($_GET['t']==1){
	//	l($allServices );
		
	}
	//l($allServices );
?>
<div class="client-service-filter">
	<label> <input type="checkbox" class="f-checkbox" name="only_service" value="only-service" >	Только услуги</label>
	<label> <input type="checkbox" class="f-checkbox" name="only_consult" value="only-consult">	Только консультации</label>
</div>
<div class="timeline-content">
	
	
    <span  class="word-export-hide add-btn-circle"><img src="/test-files/+.svg">
		<span>
			<a href="/service/add/?client_id=<?= $arResult['ID'] ?>" >добавить услугу</a>
			<a href="/consult/add/?client_id=<?= $arResult['ID'] ?>">добавить консультацию</a>
		</span>
	</span>
    <ul class="timeline">
		
		<? foreach ($allServices as $i => $ar): ?>
		
		<? 
			
			$taskStatusClass = '';
			if($ar['BX24_STATUS_EXT'] == 1){
				$taskStatusClass = 'task-status-success';		   
			}
			if($ar['TYPE'] != 'CONSULT' && $ar['STATUS'] == Service::STATUS_CLOSED){
				if($ar['IS_CONTRACT_DEADLINE_EXPIRED']){
					$taskStatusClass = 'task-status-failed';
				} else {
					$taskStatusClass = 'task-status-success';
				}
			}
			
			if($ar['CLIENT_REFUSED'] == 1){
				$taskStatusClass = 'task-status-refused';		   
			}
			
			//Если у консультации есть связь с услугой то пропускаем!!!
			if ($ar['TYPE'] == 'CONSULT' && $ar['SERVICE']['ID'] != null){
				continue;	
			}
			
			//C2:WON
			//	$stausBx24 = 
		?>
		<?
			/*
				//отображение смены менджеров
				if ($i != 0 && $ar['MANAGER_ID'] != $last_manager_id &&  $ar['MANAGER_ID']!='') {
				?>
				<li class="event event-user-changed" data-date="8:30 - 9:30pm">
			    <span class="date"><?= $ar['DATE'] ?></span>
			    <p>Смена менеджера от 
				<b><?= $allManagers[$ar['MANAGER_ID']]['FIO'] ?></b>
				к  
				<b><?= $allManagers[$last_manager_id]['FIO'] ?></b>
			    </p>    
				</li>
				<?
				}
			*/
			if($ar['DATE_TO']){
			  $ar['STATUS'] = 0;
			}
		?>
		<li class="item-<?=$ar['TYPE']== 'CONSULT'?'consult':'service'?> event <?= $taskStatusClass?>" data-date="">
		    <span class="date"> <?= $ar['DATE'] ?></span>
		    <h3><a href="<?= $ar['DETAIL_PAGE_URL'] ?>" xtarget="_blank"><?= $ar['NAME'] ?></a>
				<? if ($ar['TYPE'] == 'SERVICE'): ?>
				<span <?= $ar['STATUS'] == Service::STATUS_ACTIVE ? 'class="active"' : '' ?>><?= $ar['STATUS_TEXT'] ?></span>
				<? endif ?>
				<?if($ar['TYPE'] == "EVENT"):?>
				<div class="cs-lable">Мероприятие</div>
				<?else:?>
				<div class="cs-lable <?=$ar['TYPE']== 'CONSULT'?'consult':'service'?>"><?=$ar['TYPE']== 'CONSULT'?'консультация':'услуга'?></div>
				<?endif?>
			</h3>
			
			
			<? if ($ar['MONEY'] > 0 || $ar['MONEY2'] >0|| $ar['MONEY3'] >0): ?>
				<div class="item-summa-wrap">
				    <span class="tl-info-title">Получено денег</span>
					<?if($ar['MONEY']):?>
					 <span class="tl-user"><?=number_format($ar['MONEY'], 0, ',', ' ') ?> руб. <desc>(субсидии/гранты)</desc></span>
					 <?endif?>
					 <?if($ar['MONEY2']):?>
					 <span class="tl-user"><?=number_format($ar['MONEY2'], 0, ',', ' ') ?> руб. <desc>(кредиты/займы)</desc></span>
					 <?endif?>
					<?if($ar['MONEY3']):?>
				    <span class="tl-user"><?=number_format($ar['MONEY3'], 0, ',', ' ') ?> руб.  <desc>(госбюджет/АРБ)</desc></span>
					 <?endif?>
					
					
				</div>
				<? endif ?>
				
		  
		    <div class="info">
				<div>
					<span class="tl-info-title">ответственный</span>
					<span class="tl-user"><?= $allManagers[$ar['MANAGER_ID']]['FIO'] ?></span>
				</div>
				<? if ($ar['TYPE'] == 'EVENT'): ?>
					<div>
					<p>Участники: </p>
					<?foreach($ar["CONTACT"] as $contact):?>
						<p><?=$contact?></p>
					<?endforeach?>
					</div>
				<?endif?>
				<div>
					<span class="tl-info-title">
					    <? if ($ar['TYPE'] == 'EVENT'): ?>
						Время проведения мероприятия
						<?elseif ($ar['TYPE'] == 'CONSULT'): ?>
						Время оказания услуги
						<? else: ?>
						Период оказания услуги
						<? endif ?>
						
					</span>
					
					<span class="tl-user">
						<? if ($ar['TYPE'] == 'CONSULT'): ?>
						<?= $ar['DATE_ACTIVE_FROM'] ?>
						<? else: ?>
						<?= $ar['DATE'] ?> - <?= $ar['DATE_TO'] ? $ar['DATE_TO'] : 'в работе' ?>
						<? endif ?>
					</span>
				</div>
				<? if ($ar['CONTRACT_DEADLINE']): ?>
				<div class="<?= $ar['IS_CONTRACT_DEADLINE_EXPIRED'] ? 'timeline-contract-deadline-expired' : '' ?>">
					<span class="tl-info-title">Дедлайн по контракту</span>
					<span class="tl-user"><?= $ar['CONTRACT_DEADLINE'] ?></span>
				</div>
				<div>
					<span class="tl-info-title">Предоставил контракт:</span>
					<span class="tl-user"><?= $ar['CONTRACT_PROVIDED_INFO']['STATUS'] ?></span>
					<span class="tl-user"><?= $ar['CONTRACT_PROVIDED_INFO']['TEXT'] ?></span>
				</div>
				<? endif ?>
				
				<? if ($ar['TYPE'] == 'CONSULT' && $ar['SERVICE']['ID'] != null): ?>
				<div>
				    <span class="tl-info-title">Услуга</span>
				    <span class="tl-user"><?= $ar['SERVICE']['NAME'] ?></span>
				</div>
				<? endif ?>
			  	<div>
				<?if($ar['BX24_TASK_ID']>0):?>
				    <span class="tl-info-title">Дополнительно</span>
				    <span class="tl-user">
						<?
							$link ='https://arbko.bitrix24.ru/company/personal/user/6/tasks/task/view/'.$ar['BX24_TASK_ID'].'/' ;
							if($ar['TYPE']=='CONSULT'){
								$link ='https://arbko.bitrix24.ru/crm/deal/details/'.$ar['BX24_TASK_ID'].'/' ;
							}
						?>
					<a  href="<?=$link?>"target="_blank">Смотреть в Битрикс 24</a></span>
				<?endif?>
				</div>
				
				<?
			$raiting = new Raiting();
			$serviceRaiting = $raiting->getServiceRaitingArray($ar['ID']);
			//l($serviceRaiting);
		     ?>
				<?if($serviceRaiting['UF_RAITING'] ):?>
					<div>
				    <span class="tl-info-title">Удовлетворенность клиента: <?= $serviceRaiting['UF_RAITING'] > 0 ? $serviceRaiting['UF_RAITING'] : 'нет' ?></span>
					</div>
				<?endif?>
			</div>
			<? /*****************/?>
			
			<?// l($ar['SMS_RAITING'])?>
			<? if (count($ar['SMS_RAITING'])>0): ?>
			<div>
				<?if($ar['SMS_RAITING']['UF_USER_VOTE']>0):?>
				<div>
					<table class="sms-table">
						<tr><td> Смс оценка клиента: </td><td> <?= $ar['SMS_RAITING']['UF_USER_VOTE'] ?></td></tr>
						<tr><td> Комментарий: </td><td> <?= $ar['SMS_RAITING']['UF_SMS_TEXT'] ?></td></tr>
						<tr><td>   Время отправки смс:  </td><td> <?=date('d:m:Y H:i:s',$ar['SMS_RAITING']['UF_SMS_SEND_DATE'])?></td></tr>
						<tr><td>  Время оценки :  </td><td> <?=date('d:m:Y H:i:s',$ar['SMS_RAITING']['UF_SMS_VOTE_DATE'])?></td></tr>
					</table>
				</div>
				<?elseif($ar['SMS_RAITING']['UF_SMS_SEND_DATE']!=""):?>
				<span class="tl-info-title">Клиенту отправлен смс <?=date('d:m:y H:i:s',$ar['SMS_RAITING']['UF_SMS_SEND_DATE'])?>, но оценка не поставлена:</span>
				<span class="tl-user"><?= $ar['SMS_RAITING']['UF_USER_VOTE'] ?></span>
				<?else:?>
				
				<?endif?>
				
			</div>
			<? endif ?>
			
			
		    <p><?=strip_tags($ar['~PREVIEW_TEXT']) ?></p>    
			</li>
			<? $last_manager_id = $ar['MANAGER_ID']; ?>
			
			<? endforeach ?>
			
			</ul>
			<div class="time-line-first-item"></div>
			<?
			//l($arResult['PROPERTIES']);
			//l($allServices);
			?>
			</div>			
