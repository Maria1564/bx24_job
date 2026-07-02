<?
	AddEventHandler("main", "OnAdminTabControlBegin", "MyOnAdminTabControlBegin");
	function MyOnAdminTabControlBegin(&$form)
	{
		if($GLOBALS["APPLICATION"]->GetCurPage() == "/bitrix/admin/user_edit.php")
		{
			//	l($form);
			CJSCore::Init(array("jquery"));
			$form->tabs[] = array("DIV" => "my_edit", "TAB" => "Дополнительно", "ICON"=>"main_user_edit", "TITLE"=>"Дополнительные параметры", "CONTENT"=>
            '<tr valign="top">
			<td>Дополнительные заголовки письма:</td>
			<td>
			<input type="text" name="MY_HEADERS[]" value="" size="30"><br>
			<input type="text" name="MY_HEADERS[]" value="" size="30"><br>
			<input type="text" name="MY_HEADERS[]" value="" size="30"><br>
			</td>
            </tr>'
			);
			include $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/events/__js.php';
		}
	}	
	
	AddEventHandler("main", "OnBeforeUserUpdate", Array("CUserEvents", "OnBeforeUserUpdateHandler"));
	
	class CUserEvents
	{
		// создаем обработчик события "OnBeforeUserUpdate"
		function OnBeforeUserUpdateHandler(&$arFields)
		{
		    $arFields['PERSONAL_ICQ'] = $arFields['WORK_DEPARTMENT'];
		}
	}	