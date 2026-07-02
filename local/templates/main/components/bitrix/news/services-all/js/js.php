<script>
	$(document).ready(function () {
		console.log("------ app init 1 ---------");
		setListCount();
		$('#client-departament-select-new').on('change',function(){
			let val = $(this).val();
			console.log(val);
			$('#clinet-manger-select').val("");
			$('#clinet-manger-select option').hide();
			if(val !== ""){
				$('#clinet-manger-select option').each(function(){
					let groupId = $(this).attr('group');
					console.log('groupId='+groupId);
					if(groupId){
					if(groupId.includes(val) ){
						$(this).show();
					}
					}
				})
				$('#clinet-manger-select option:first-child').show();
			}else {
			$('#clinet-manger-select option').show();
			}
		});
	});
	
</script>