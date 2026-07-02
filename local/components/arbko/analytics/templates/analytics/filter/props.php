<?
	foreach ($_REQUEST['PROP'] as $code => $value)
	{
		if ($value == "") continue;
		$GLOBALS[$arParams["FILTER_NAME"]]['PROPERTY_' . $code] = $value;
	}