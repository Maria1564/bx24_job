<div id="filter-content">
	<button type="button" onclick="downLoadExcel()" class="btn btn-success btn-sm">скачать Excel</button>
	<div class="ritz grid-container" dir="ltr">
		<table class="waffle" id="main-table" cellspacing="0" cellpadding="0">
			<tbody>
				<tr style="height: 20px;">
					
					<td class="s0" dir="ltr">Период</td>
					<td class="s0" dir="ltr">отдел</td>
					<td class="s0" dir="ltr">менеджер</td>
					<td class="s0" dir="ltr">реализована?</td>
					<td></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td class="s0" dir="ltr" Период><?=$arResult['FILTER']['PERIOD_TEXT']?></td>
					<td class="s0" dir="ltr" data-n="отдел" ><?=$arResult['FILTER']['DIRECTION']?></td>
					<td class="s0" dir="ltr" data-n="менеджер"><?=$arResult['FILTER']['MANAGER']?></td>
					<td class="s0" dir="ltr" реализована><?=$arResult['FILTER']['STATUS']?></td>
					<td></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td class="s2" dir="ltr">Услуги</td>
					<td class="s2"></td>
					<td class="s2" dir="ltr">Клиентов</td>
					<td></td>
					<td class="s3 softmerge" dir="ltr"><div class="softmerge-inner" style="width: 198px; left: -1px;">Уникальных за период</div></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td class="s2" dir="ltr"><?=$arResult['SERVICE_COUNT']?></td>
					<td class="s2"></td>
					<td class="s2" dir="ltr" data-n="Клиентов"><?=$arResult['CLIENT_COUNT']?></td>
					<td></td>
					<td class="s2" dir="ltr"><?=$arResult['CLIENT_UNIQ_PERIOD_COUNT']?></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td class="s2"></td>
					<td class="s2"></td>
					<td class="s2"></td>
					<td></td>
					<td class="s3 softmerge" dir="ltr"><div class="softmerge-inner" style="width: 198px; left: -1px;">Уникальных за <?=$arResult['CLIENT_UNIQ_YEAR'] ?> год</div></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td class="s2" dir="ltr">Консультации</td>
					<td class="s2"></td>
					<td class="s2"></td>
					<td></td>
					<td class="s2" dir="ltr" Уникальных за год><?=$arResult['CLIENT_UNIQ_YEAR_COUNT']?></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td class="s2" dir="ltr"><?=$arResult['CONSULT_COUNT']?></td>
					<td class="s2"></td>
					<td class="s2"></td>
					<td></td>
					<td></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td class="s2"></td>
					<td class="s2"></td>
					<td class="s2"></td>
					<td></td>
					<td></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td class="s2" dir="ltr">Денег получено</td>
					<td class="s5" dir="ltr"><?=$arResult['TOTAL_MONEY_FORAMTTED']?></td>
					<td></td>
					<td></td>
					<td></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td class="s2 softmerge" dir="ltr"><div class="softmerge-inner" style="width: 113px; left: -1px;">субсидии/гранты</div></td>
					<td class="s5" dir="ltr"><?=$arResult['MONEY_FORMATTED']?></td>
					<td></td>
					<td></td>
					<td></td>
					
				</tr>
				<tr style="height: 20px;">
					
					<td class="s2" dir="ltr">госбюджет/АРБ</td>
					<td class="s5" dir="ltr"><?=$arResult['MONEY3_FORMATTED']?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="height: 20px;">
					
					<td class="s2" dir="ltr">кредиты/займы</td>
					<td class="s5" dir="ltr"><?=$arResult['MONEY2_FORMATTED']?></td>
					<td></td>
					<td></td>
					<td></td>
					
				</tr>
			</tbody>
		</table>
	</div>
	
	
	
</div>
