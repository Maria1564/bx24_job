$(document).ready(function(){
	console.log('client script init')
	$('.f-checkbox').on('change',function(){
	  let val = $(this).is(':checked');
	  let name = $(this).attr('name');
	  console.log(name+" | "+val);
	  let type ='';
	  if(name === 'only_service'){
	  if(val)$('.item-consult').hide(); else  $('.item-consult').show(); 		  
	  }
	  if(name === 'only_consult'){
	  if(val)$('.item-service').hide(); else  $('.item-service').show(); 
	  }	
	});
	
})