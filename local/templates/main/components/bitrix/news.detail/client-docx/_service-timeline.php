<?
/**
 * Отрисовка Таймлайна
 */
 $last_manager_id = 0;
$allServices = Client::getAllServicesConsultsHistory($arResult['ID']);
$allManagers = Helper::getManagers();
  
  //l($allServices );
?>
<div class="timeline-content">


    <span  class="add-btn-circle"><img src="/test-files/+.svg">
	<span>
	    <a href="/service/add/?client_id=<?= $arResult['ID'] ?>">добавить услугу</a>
	    <a href="/consult/add/?client_id=<?= $arResult['ID'] ?>">добавить консультацию</a>
	</span>
    </span>
    <ul class="timeline">

	<? foreach ($allServices as $i => $ar): ?>

	<? 
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
		?>
		<li class="event" data-date="">
		    <span class="date"> <?= $ar['DATE'] ?></span>
		    <h3><a href="<?= $ar['DETAIL_PAGE_URL'] ?>" xtarget="_blank"><?= $ar['NAME'] ?></a>
			<? if ($ar['TYPE'] == 'SERVICE'): ?>
				<span <?= $ar['STATUS'] == Service::STATUS_ACTIVE ? 'class="active"' : '' ?>><?= $ar['STATUS_TEXT'] ?></span>
			<? endif ?>
		    </h3>
		    <? if ($ar['MONEY'] > 0): ?>
			    <div class="item-summa-wrap">
				<span>Сумма</span><br>
				<span><?=number_format($ar['MONEY'], 0,'', ' ' ) ?></span> руб.
			    </div>

		    <? endif ?>
		    <div class="info">
			<div>
			    <span class="tl-info-title">ответсвтенный</span>
			    <span class="tl-user"><?= $allManagers[$ar['MANAGER_ID']]['FIO'] ?></span>
			</div>
			<div>
			    <span class="tl-info-title">
				<? if ($ar['TYPE'] == 'CONSULT'): ?>
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
			<? if ($ar['TYPE'] == 'CONSULT' && $ar['SERVICE']['ID'] != null): ?>
				<div>
				    <span class="tl-info-title">Услуга</span>
				    <span class="tl-user"><?= $ar['SERVICE']['NAME'] ?></span>
				</div>
			<? endif ?>
			  	<div>
				    <span class="tl-info-title">Дополнительно</span>
				    <span class="tl-user">
					<?
					$link ='https://arbko.bitrix24.ru/company/personal/user/6/tasks/task/view/'.$ar['BX24_TASK_ID'].'/' ;
					if($ar['TYPE']=='CONSULT'){
					  $link ='https://arbko.bitrix24.ru/crm/deal/details/'.$ar['BX24_TASK_ID'].'/' ;
					}
					?>
					   <a  href="<?=$link?>"target="_blank">Смотреть в Битрикс 24</a></span>
				</div>
		    </div>
		    <p><?= $ar['PREVIEW_TEXT'] ?></p>    
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
