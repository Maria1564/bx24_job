function validDate(date, theInput) {
    var date = document.getElementById("startDate").value;
    todayDate = getTodaysDate();
    if (date > todayDate)
        theInput.value = todayDate;
}

function getTodaysDate(){
    date = new Date();
    day = date.getDate();
    month = date.getMonth() + 1;
    year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    today = year + "-" + month + "-" + day; 

    return today;
}

