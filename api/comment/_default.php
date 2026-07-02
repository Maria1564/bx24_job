<?
	
	
	//l($arContacts );
?>
<div class="comment">
	<?foreach($taskCommentsArr as $commentObj):?>
	
	<?
	// $commentObj->POST_MESSAGE = str_replace(["[QUOTE]","[/QUOTE]"],["<quote>","</quote>"], $commentObj->POST_MESSAGE);
	 $commentObj->POST_MESSAGE = preg_replace("'\[QUOTE\].*?\[/QUOTE\]'si","", $commentObj->POST_MESSAGE);
	?>
	<div class="item">
		<div class="name">
			<span><?=$commentObj->AUTHOR_NAME?></span>
			<span class="date"><?=$commentObj->POST_DATE?></span>
		</div>
		<div class="text">
			<?=$commentObj->POST_MESSAGE?>
		</div>
		<div class="btns">
		  <a class="btn-a" href="?act=add&taskId=<?=$taskId?>&comment_id=<?=$commentObj->ID?>">создать консультацию</a>
		</div>
	</div>
	<?endforeach?>
</div>





