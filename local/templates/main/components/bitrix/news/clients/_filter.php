
<?
if (!function_exists('getClientFilterYesEnumId')) {
	function getClientFilterYesEnumId($propertyCode) {
		$property_enums = CIBlockPropertyEnum::GetList(
			["SORT" => "ASC", "ID" => "ASC"],
			["IBLOCK_ID" => Client::CLIENT_IBLOCK_ID, "CODE" => $propertyCode, "XML_ID" => "Y"]
		);
		if ($enum = $property_enums->Fetch()) {
			return (string)$enum['ID'];
		}

		$property_enums = CIBlockPropertyEnum::GetList(
			["SORT" => "ASC", "ID" => "ASC"],
			["IBLOCK_ID" => Client::CLIENT_IBLOCK_ID, "CODE" => $propertyCode]
		);
		if ($enum = $property_enums->Fetch()) {
			return (string)$enum['ID'];
		}

		return '';
	}
}

$clientFilterYesEnumIds = [
	'KREATIV' => getClientFilterYesEnumId('KREATIV'),
	'WOMEN_BUSINESS' => getClientFilterYesEnumId('WOMEN_BUSINESS'),
	'OUTBOUND_TOURISM' => getClientFilterYesEnumId('OUTBOUND_TOURISM'),
	'APK' => getClientFilterYesEnumId('APK'),
	'ACTIVE_EXPORTER' => getClientFilterYesEnumId('ACTIVE_EXPORTER'),
];
?>

<form action="" method="get" id="filter-form" onsubmit="filterGetData();return false;">
    <input type="hidden" name="sort" id="form-sort" value="">
	
    <div class="form-group search-text-wrap">
		<input type="text" class="form-control" name="t" value="<?= $_REQUEST['t'] ?>" placeholder="Поиск">
	</div>
    <div class="row">
		<div class="col-md-2">
			
			<div class="form-group">
                <label>ОКВЭД</label>
                <input
                    type="text"
                    class="form-control"
                    name="PROP[OKVED]"
                    value="<?= htmlspecialchars($_REQUEST['PROP']['OKVED']) ?>"
                    placeholder="Например 47.11"
                >
            </div>

			<div class="form-group">
				<label>Отрасль промышленности</label>
				<select class="form-control" name="PROP[INDUSTRIAL_SECTORS]" onchange="filterGetData()">
					<option value="">Все</option>
					<? foreach ($arIndustrialSectors as $id => $name): ?>
					<option value="<?= $id ?>" <?= $_REQUEST['PROP']['INDUSTRIAL_SECTORS'] == $id ? 'selected' : '' ?>>
						<?= $name ?>
					</option>
					<? endforeach ?>
				</select>
			</div>

			<div class="form-group">
				<label for="">Фильтр по району</label>
				<select class="form-control" name='PROP[RAION_NEW]'>
					<option value="">Все</option>
					<? foreach ($arRAION_NEW as $id => $regionArr): ?>
					<option value='<?= $id ?>' <?= $_REQUEST['PROP']['RAION_NEW'] == $id ? 'selected' : '' ?>> 
						<?= $regionArr['VALUE'] ?>
					</option>
					<? endforeach ?>
				</select>
			</div>
			
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label>Категория МСП</label>
				<select class="form-control" name="PROP[MSP_TYPE]">
					<option value="">Все</option>
					<option value="18" <?= $_REQUEST['PROP']['MSP_TYPE'] == '18' ? 'selected' : '' ?>>микро</option>
					<option value="19" <?= $_REQUEST['PROP']['MSP_TYPE'] == '19' ? 'selected' : '' ?>>малое</option>
					<option value="20" <?= $_REQUEST['PROP']['MSP_TYPE'] == '20' ? 'selected' : '' ?>>среднее</option>
				</select>
			</div>

			<div class="form-check">
				<input class="form-check-input" type="radio" name="MSP" id="MSP1" value="" <?= $_REQUEST['MSP'] == '' ? 'checked' : '' ?>>
				<label class="form-check-label" for="MSP1">
					Все
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="MSP" id="MSP2" value="Y" <?= $_REQUEST['MSP'] == 'Y' ? 'checked' : '' ?>>
				<label class="form-check-label" for="MSP2">
					МСП
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="MSP" id="MSP3" value="N" <?= $_REQUEST['MSP'] == 'N' ? 'checked' : '' ?>>
				<label class="form-check-label" for="MSP3">
					Не МСП
				</label>
			</div>
			
		</div>
		<div class="col-md-2">
			
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="org_type_3" 
				name='PROP[ORG_TYPE][]' 
				value="<?= Client::ORG_TYPE_INDIVIDUAL_ID ?>"
				<?= in_array(Client::ORG_TYPE_INDIVIDUAL_ID, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
				>
				<label class="form-check-label" for="org_type_3">
					ИП
				</label>
			</div>
			
			
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox" 
				id="org_type_4" 
				name='PROP[ORG_TYPE][]' 
				value="<?= Client::ORG_TYPE_OOO_ID ?>"
				<?= in_array(Client::ORG_TYPE_OOO_ID, $_REQUEST['PROP']['ORG_TYPE']) ? 'checked' : '' ?>
				>
				<label class="form-check-label" for="org_type_4">
					Юр Лицо
				</label>
			</div>

			
		</div>
		<div class="col-md-2">
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="KREATIV" 
				name='PROP[KREATIV][]' 
				value="<?= $clientFilterYesEnumIds['KREATIV'] ?>"
				<?= in_array($clientFilterYesEnumIds['KREATIV'], (array)($_REQUEST['PROP']['KREATIV'] ?? [])) ? 'checked' : '' ?>
				>
				<label style="display: inline;" class="form-check-label" for="KREATIV">
					Креативный предприниматель
				</label>
			</div>
			
			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="WOMEN_BUSINESS" 
				name='PROP[WOMEN_BUSINESS][]' 
				value="<?= $clientFilterYesEnumIds['WOMEN_BUSINESS'] ?>"
				<?= in_array($clientFilterYesEnumIds['WOMEN_BUSINESS'], (array)($_REQUEST['PROP']['WOMEN_BUSINESS'] ?? [])) ? 'checked' : '' ?>
				>
				<label style="display: inline;" class="form-check-label" for="WOMEN_BUSINESS">
					Женское предпринимательство
				</label>
			</div>

			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="OUTBOUND_TOURISM" 
				name='PROP[OUTBOUND_TOURISM][]' 
				value="<?= $clientFilterYesEnumIds['OUTBOUND_TOURISM'] ?>"
				<?= in_array($clientFilterYesEnumIds['OUTBOUND_TOURISM'], (array)($_REQUEST['PROP']['OUTBOUND_TOURISM'] ?? [])) ? 'checked' : '' ?>
				>
				<label style="display: inline;" class="form-check-label" for="OUTBOUND_TOURISM">
					Выездной туризм
				</label>
			</div>

			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="APK" 
				name='PROP[APK][]' 
				value="<?= $clientFilterYesEnumIds['APK'] ?>"
				<?= in_array($clientFilterYesEnumIds['APK'], (array)($_REQUEST['PROP']['APK'] ?? [])) ? 'checked' : '' ?>
				>
				<label style="display: inline;" class="form-check-label" for="APK">
					АПК
				</label>
			</div>

			<div class="form-check">
				<input 
				class="form-check-input" 
				type="checkbox"  
				id="ACTIVE_EXPORTER" 
				name='PROP[ACTIVE_EXPORTER][]' 
				value="<?= $clientFilterYesEnumIds['ACTIVE_EXPORTER'] ?>"
				<?= in_array($clientFilterYesEnumIds['ACTIVE_EXPORTER'], (array)($_REQUEST['PROP']['ACTIVE_EXPORTER'] ?? [])) ? 'checked' : '' ?>
				>
				<label style="display: inline;" class="form-check-label" for="ACTIVE_EXPORTER">
					Действующий экспортер
				</label>
			</div>
		</div>
		
	</div>

	<div style="margin-top: 20px; display: flex; gap: 8px;">	
		<button type="button" onclick="filterGetData()" class="btn btn-dark btn-sm" >Фильтровать</button>
		<button type="button" onclick="window.location.href = '/clients/'"class="btn btn-default btn-sm">Сбросить фильтр</button>
	</div>
</form>
