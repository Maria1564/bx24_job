<?
/**
 * Отрисовка Таймлайна
 */
$last_manager_id = 0;
$allServices = Service::getConsults($arResult['ID']);
//l($allServices);
$allManagers = Helper::getManagers();
//l($allManagers );
?>
<?if( count($allServices)==0) return?>
 <h2>
		Консультации по задаче    
	</h2>
	
<div class="timeline-content">


    <a href="/consult/add/?service_id=<?=$arResult['ID']?>" class="add-btn-circle"><img src="/test-files/+.svg"></a>
    <ul class="timeline">

	<? foreach ($allServices as $i => $ar): ?>

		<?
		if ($i != 0 && $ar['MANAGER_ID'] != $last_manager_id) {
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
		?>
		<li class="event" data-date="">
		    <span class="date"> <?= $ar['DATE'] ?></span>
		    <h3><?= $ar['NAME'] ?> 
			<? if ($ar['TYPE'] == 'SERVICE'): ?>
				<span <?= $ar['STATUS'] == Service::STATUS_ACTIVE ? 'class="active"' : '' ?>><?= $ar['STATUS_TEXT'] ?></span>
			<? endif ?>
		    </h3>
		    <div class="info">
			<div>
			    <span class="tl-info-title">ответсвтенный</span>
			    <span class="tl-user"><?= $allManagers[$ar['MANAGER_ID']]['FIO'] ?></span>
			</div>
		
			<? if ($ar['TYPE'] == 'CONSULT' && $ar['SERVICE']['ID'] != null): ?>
				<div>
				    <span class="tl-info-title">Услуга</span>
				    <span class="tl-user"><?= $ar['SERVICE']['NAME'] ?></span>
				</div>
			<? endif ?>
		    </div>
		    <p><?= $ar['PREVIEW_TEXT'] ?></p>    
		</li>
		<? $last_manager_id = $ar['MANAGER_ID']; ?>

	<? endforeach ?>

	<? /*
	  Источник прихода клиента
	 */ ?>
	<? if ($arResult['PROPERTIES']['SOURCE_OF_INCOME']['VALUE'] != ""): ?>
		<li class="event event-user-changed" data-date="8:30 - 9:30pm">
		    <p><?= $arResult['PROPERTIES']['SOURCE_OF_INCOME']['VALUE'] ?></p>    
		</li>

	<? endif ?>
    </ul>
    <?
//l($arResult['PROPERTIES']);
//l($allServices);
    ?>
</div>