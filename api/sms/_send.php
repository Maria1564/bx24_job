<?
	
	define("SMS_RU_API_ID","542C1E06-35BF-F110-5942-E6CB4396887A");
	$phone = $_REQUEST['phone'];
	$link = $_REQUEST['link'];
	$serviceId = $_REQUEST['serviceID'];
	$smsText = "Добрый день, Вы обратились в Агентство Развития Бизнеса. Пожалуйста, оцените качество  ".$link."";	
	require_once 'sms.ru.php';
	
	$smsru = new SMSRU(SMS_RU_API_ID); // Ваш уникальный программный ключ, который можно получить на главной странице
	$data = new stdClass();
	$data->to = $phone;
	$data->text = $smsText;// Текст сообщения 542C1E06-35BF-F110-5942-E6CB4396887A
	// $data->from = 'ARB_KO'; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
	// $data->time = time() + 7*60*60; // Отложить отправку на 7 часов
	// $data->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
	// $data->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
	// $data->partner_id = '1'; // Можно указать ваш ID партнера, если вы интегрируете код в чужую систему
	$sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную
	
	if ($sms->status == "OK") { // Запрос выполнен успешно	
	   $raiting = new Raiting();
	    $arData = $raiting->setServiceRaiting($serviceId, 0,false , ["UF_SMS_LINK"=>$link,"UF_SMS_NUMBER"=>$phone,'UF_SMS_SEND_DATE'=>time()]);
	?>
	<div class="send-form">
		<h1>СМС отправлен!</h1>
		
	</div>
	<?
		} else {
	?>
	<div class="send-form">
		<h1 style="color:red">СМС НЕ отправлен!</h1>
		
	</div>
	<?
	}
?>



<style>
	body {color: #535c69;
    font: 14px/22px "Helvetica Neue",Helvetica,Arial,sans-serif;}
	input {padding: 5px;}
	.send-form {display: inline-block;
    border: 1px solid #ccc;
    padding: 24px;
    background: #f7f7f7;}
	.send-form h1{    font-size: 20px;
    color: #a0bd50;}
	.send-form h1 span{font-size: 14px;
    color: #000;}
</style>