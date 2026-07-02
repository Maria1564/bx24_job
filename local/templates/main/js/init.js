$(document).ready(function () {
    console.log("------ app init ---------");
    setListCount();
	$('#client-departament-select').on('change',function(){
	  let val = $(this).val();
	  console.log(val);
	  $('#clinet-manger-select').val("");
	  $('#clinet-manger-select option').show();
	  if(val !== ""){
	  $('#clinet-manger-select option').each(function(){
		   let groupId = $(this).attr('group');
		    console.log('groupId='+groupId);
			if(groupId!==val){
				$(this).hide();
			}
	  })
	  $('#clinet-manger-select option:first-child').show();
	  }
	});
});

function setListCount() {
    console.log(app.newlist);
    try {
        $('.items-count').text(app.newlist.count);
    } catch (e) {
        console.log(e)
    }
}

function get(name){
   if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
      return decodeURIComponent(name[1]);
}

console.log(get('t'));
function ExelCreate(_thisElement,sizen = '') {
	var elementText = $(_thisElement).text();
	$(_thisElement).addClass('loading');
    console.log("------ ExelCreate --------- sizen = " +sizen);
    var formData = $('#' + filterFormId).serialize();
    formData += '&ajax=y&exel=y'+sizen;
	console.log(formData);
    $.ajax({type: "POST",
        url: window.location.href,
        data: formData, // serializes the form's elements.
        success: function (data) {
             //console.log(location.pathname);
			// let obj = JSON.parse(data);
			// console.log(obj);
			 if(data.MODE == "PROCESSING"){
			 let pageN = parseInt(data.PAGEN);
			  let totalN =  Math.ceil(parseInt(data.NAV_RESULT) / parseInt(data.SIZEN) );
			   $(_thisElement).find('span').text(''+pageN+' / '+totalN);
			   if(pageN >= totalN){
			     $(_thisElement).find('span').text('Формирование файла');

				  setTimeout( ()=>{  
					  $(_thisElement).find('span').text('');
					  },
					  2000 
				  );
				  pageN++;
					if(location.pathname == '/clients/' && get('t') && get('t')!='')
						ExelCreate(_thisElement , '&PAGEN_2='+pageN+"&ACTION=MAKE_FILE")	
					else
						ExelCreate(_thisElement , '&PAGEN_1='+pageN+"&ACTION=MAKE_FILE")
			   
			   }
			   else {
			       pageN++;
				   if(location.pathname == '/clients/' && get('t') && get('t')!='')
					   setTimeout( ()=>{   ExelCreate(_thisElement , '&PAGEN_2='+pageN) },300 );
				    else	   
						setTimeout( ()=>{   ExelCreate(_thisElement , '&PAGEN_1='+pageN) },300 );
			      
			   }
			 
			 }
			 else {
			 $(_thisElement).find('span').text('');
			 $(_thisElement).removeClass('loading');
			   window.location.href = data.fileName;
			 }
			 
           
        }
    });
}
function ExelCreateP(_thisElement,sizen = '') {
	var elementText = $(_thisElement).text();
	$(_thisElement).addClass('loading');
    console.log("------ ExelCreateP --------- sizen = " +sizen);
    var formData = $('#' + filterFormId).serialize();
    formData += '&ajax=y&exel_p=y'+sizen;
	console.log(formData);
    $.ajax({type: "POST",
        url: window.location.href,
        data: formData, // serializes the form's elements.
        success: function (data) {
             console.log(data);
			// let obj = JSON.parse(data);
			// console.log(obj);
			 if(data.MODE == "PROCESSING"){
			 let pageN = parseInt(data.PAGEN);
			  let totalN =  Math.ceil(parseInt(data.NAV_RESULT) / parseInt(data.SIZEN) );
			   $(_thisElement).find('span').text(''+pageN+' / '+totalN);
			   if(pageN >= totalN){
			     $(_thisElement).find('span').text('Формирование файла');

				  setTimeout( ()=>{  
					  $(_thisElement).find('span').text('');
					  },
					  2000 
				  );
				  pageN++;
			      ExelCreateP(_thisElement , '&PAGEN_1='+pageN+"&ACTION=MAKE_FILE")
			   
			   }
			   else {
			       pageN++;
				    setTimeout( ()=>{   ExelCreateP(_thisElement , '&PAGEN_1='+pageN) },300 );
			      
			   }
			 
			 }
			 else {
			 $(_thisElement).find('span').text('');
			 $(_thisElement).removeClass('loading');
			   window.location.href = data.fileName;
			 }
			 
           
        }
    });
}
function exportClientHTML(title,documentName){
       var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head><meta charset='utf-8'><title>"+title+"</title></head><body>";
			var footer = "</body></html>";
	   $('#client-detail').hide();
	    $('#word-content').show();
	   $("#word-content table td")
                            .attr('border', '2')
                            .attr('bordercolor', '#000')
                            .attr('style', 'xwidth:111.3pt;border:solid windowtext 1.0pt;mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:30.25pt');
                    $("#word-content table")
                            .attr('border', '2')
                            .attr('cellspacing', '1')
                            .attr('cellpadding', '2')
                            .attr('style', 'border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;mso-yfti-tbllook:480;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:.5pt solid windowtext;mso-border-insidev:.5pt solid windowtext');
                    $("#word-content table tr td:first-child").attr('style', 'width:20.3pt;');
       var sourceHTML = header+document.getElementById("word-content").innerHTML+footer;
       
       var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       var fileDownload = document.createElement("a");
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = documentName+'.doc';
       fileDownload.click();
       document.body.removeChild(fileDownload);
	    $('#client-detail').show();
		 $('#word-content').hide();
    }
function WordCreate() {
    console.log("------ ExelCreate ---------");
    var formData = $('#' + filterFormId).serialize();
    formData += '&ajax=y&word=y';
    $.ajax({type: "POST",
        url: window.location.href+"?t=1&word=y",
        data: formData, // serializes the form's elements.
        success: function (data) {
             console.log(data);
             window.location.href = data.fileName;
        }
    });
	return false;
}

function reloadPage(){
	location.reload();
}