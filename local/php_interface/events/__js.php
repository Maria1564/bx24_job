<?
	$arDirections = Helper::getDirections();
	$option = '<select id="UF_DIRECTIONS" multiple onchange="selectWORK_DEPARTMENT()" size="10"><option value="">Выберите отдел</option>';
	foreach(	$arDirections  as $arr){
	  //$arDirectionsF[$arr['UF_XML_ID']] = $arr['UF_NAME'];
	  $option.= '<option value="'.$arr['UF_XML_ID'].'"><b>'.$arr['UF_XML_ID'].'</b>   '.$arr['UF_DESCRIPTION'].'</option>';
	}
	$option.= '</select>';
?>

<script>
	console.log('-----------------');
	var sel = '<?=$option?>';
	console.log(sel);
	$(document).ready(function(){
		let val = $('input[name="UF_DIRECTIONS"]').val();
		console.log(val)
		//$('input[name="WORK_DEPARTMENT"]').replaceWith(sel);
		$('input[name="UF_DIRECTIONS"]').after(sel).hide();
		$('#UF_DIRECTIONS').val(val.split(','));
	});
	
	function selectWORK_DEPARTMENT(){
	   let val = $('#UF_DIRECTIONS').val();
	   console.log(val);
	   $('input[name="UF_DIRECTIONS"]').val(val.join(','))
	}
</script>
