<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

echo '--------------';

$oBitrix = new \Zloykolobok\Bitrix24\Classes\Company();
$oBitrix->setUrl(BX_WEBHOOK_URL);
$oBitrix->setTimeout(100);
if ($_GET['act'] == 'insert') {
	$ars = json_decode(file_get_contents('ids.txt'));
	echo '<br><b style="color:red">Обновляю!</b>';
	echo '<br>Общее количество записей: ' . count($ars);
	$count = file_get_contents('count.txt');
	$count2 = 0;
	foreach ($ars as $k => $id) {

		if ($k > $count) {
			$count = $k;
			/*
			 * Делаем запрос
			 */
			$res = $oBitrix->companyGet($id);
			l($res->result);
			if($res->result!=1){
				echo '<b style="color:red">--- ошибка ----</b>';
				l($res);
				exit;
			}
			$count2++;
			if ($count2 == 5) {
				?>
				<script>
					setTimeout(function () {
					    window.location.href = "?act=insert";
					}, 1000);
				</script>
				<?
				break;
			}
		}
	}
	echo '<b>' . $count;
	file_put_contents('count.txt', $count);
	//$res = $oBitrix->companyUpdate(26,['IS_MY_COMPANY' => 'N'],[]);
	//l($res);
} 
else if ($_GET['act'] == 'update') {
	$ars = json_decode(file_get_contents('ids.txt'));
	echo '<br><b style="color:red">Обновляю!</b>';
	echo '<br>Общее количество записей: ' . count($ars);
	$count = file_get_contents('count.txt');
	$count2 = 0;
	foreach ($ars as $k => $id) {

		if ($k > $count) {
			$count = $k;
			/*
			 * Делаем запрос
			 */
			$res = $oBitrix->companyUpdate($id, ['IS_MY_COMPANY' => 'N'], []);
			l($res->result);
			if($res->result!=1){
				echo '<b style="color:red">--- ошибка ----</b>';
				l($res);
				exit;
			}
			$count2++;
			if ($count2 == 5) {
				?>
				<script>
					setTimeout(function () {
					    window.location.href = "?act=update";
					}, 1000);
				</script>
				<?
				break;
			}
		}
	}
	echo '<b>' . $count;
	file_put_contents('count.txt', $count);
	//$res = $oBitrix->companyUpdate(26,['IS_MY_COMPANY' => 'N'],[]);
	//l($res);
} else {
	$n = $_GET['n'] > 0 ? $_GET['n'] : 0;

	$res = $oBitrix->companyList([], [], ["ID"], $n * 50);

	$count = count($res->result);
//l($res);
	$arIds = [];
	$ars = json_decode(file_get_contents('ids.txt'));
	if ($ars != "" && $n != 0) {
		$arIds = $ars;
	}

	foreach ($res->result as $obj) {
		$arIds[] = $obj->ID;
	}
	file_put_contents('ids.txt', json_encode($arIds));
	echo '<br>Добавлено ' . $count . ' записей!';
	echo '<br>Общее количество записей: ' . count($arIds);
	if ($res->next == null) {
		echo '<br><b style="color:red">все!</b>';
		?>
		<script>
			window.location.href = "?act=update";
		</script>
		<?
		exit;
	} else {
		?>
		<script>
			window.location.href = "?n=<?= $n + 1 ?>";
		</script>
		<?
	}
}
?>




