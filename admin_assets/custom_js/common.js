function it_formatNumber( num, fixed ) { 
    var decimalPart;

    var array = Math.floor(num).toString().split('');
    var index = -3; 
    while ( array.length + index > 0 ) { 
        array.splice( index, 0, '.' );              
        index -= 4;
    }

    if(fixed > 0){
        decimalPart = num.toFixed(fixed).split(".")[1];
        return array.join('') + "," + decimalPart; 
    }
    return array.join(''); 
}

function en_formatNumber(numberString){

    numberString = numberString.replace(/\./, '').replace(/,/, '.');
    parsed = parseFloat(numberString);
    return parsed.toFixed(2);
}

function currentDate(delimiter){
    var today = new Date();
    var currentDate = ("0" + today.getDate()).slice(-2)+delimiter+("0" + (today.getMonth() + 1)).slice(-2)+delimiter+today.getFullYear();
    return currentDate;
}

function currentDateTime(delimiter){
    var today = new Date();
    var currentDate = ("0" + today.getDate()).slice(-2)+delimiter+("0" + (today.getMonth() + 1)).slice(-2)+delimiter+today.getFullYear();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = currentDate+' '+time;
    return dateTime;
}

function createFormatWiseDate(date){ //  11/08/2017
    var split_date = date.split("/");
    var day = split_date[0];
    var month = split_date[1];
    var year =split_date[2];
    var new_date = year+'-'+month+'-'+day;
    return new_date;
}


//===========common function end=============
