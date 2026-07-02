$(document).ready(function(){
	$( "#org_type_3" ).on( "change", function() {
	  if( $(this).is(':checked') ){
		  $("#plus_samoz").show();
	  }
	  else{
		$("#plus_samoz").hide(); 
		$("#plus_samoz input[type=checkbox]").prop('checked', false);
	  }
	} );
});
