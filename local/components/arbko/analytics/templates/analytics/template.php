
<div class="add-form-wrapper">
	<? include '_filter.php'?>
	
	<? 
		 if (isset($_REQUEST['ajax'])) {

	    $APPLICATION->RestartBuffer();
    }
		include '_table.php';
		//	l($_REQUEST);
           // l($arResult);
		 if (isset($_REQUEST['ajax'])) {
	    exit;
    }
		?>
</div>
<?

?>