
class SMSVote {
	constructor(){
		console.log("SMSVote init");		
		
	}
	
	openPopup(){
	console.log("SMSVote openPopup");
	
	
	}
	
	
	
}

$(window).on('DOMContentLoaded', () => {
	window.app.SMSVote = new SMSVote();
});
