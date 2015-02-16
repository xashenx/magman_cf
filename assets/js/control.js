var patterns = {
  "text" : /^[A-z 'àèìòù]*$/,
  "message" : /^[A-z 0-9'àèìòù&,\.\?\!()\$\€%"£^\@\;\:\n\+\-]*$/,
  "number" : /^[0-9]*(\.|\,)?[0-9]{0,20}$/,
  "email" : /.*@.*\..*$/,
  "phone" : /^[0-9]{0,20}$/,
  "price" : /^[0-9]{1,8}[\.\,]?[0-9]{0,2}$/,
  "company_address" : /^[A-z 0-9'àèìòù&\.\,]*$/,
  "url" : /^http[s]?:\/\/.*\..{0,3}.*$/,
  "pwd" : /^[\w\.-@\!\_\-\#]+$/,
  "hour" : /^[0-9]{2}\:[0-9]{2}$/
}

// funzione che controlla il contenuto degli input in base ad un tipo selezionato
//
// textToCheck    =>    testo che deve essere convalidato
// type           =>    deve essere una delle chiavi presenti nel oggetto patterns
// maxLength      =>    Optional. se inserito viene utilizzato come controllo dei caratteri massimi
// minLength      =>    se -1 non controllo l'empty

function checkInputValue(textToCheck, type, maxLength, minLength){
  maxLength = maxLength || null
  minLength = minLength || null
  var answer = {};

  if (patterns[type] == undefined){
    answer.status = 'ko';
    answer.msg = 'invalid type argument';
    return answer;
  }

  if (minLength != -1){
    if (textToCheck.length == 0){
      answer.status = 'ko';
      answer.msg = 'empty';
      return answer;
    }
  }

  if (maxLength != null){
    if(textToCheck.length > maxLength){
      answer.status = 'ko';
      answer.msg = 'overflow';
      return answer;
    }
  }

  if (minLength != null && minLength > -1){
    if(textToCheck.length < minLength){
      answer.status = 'ko';
      answer.msg = 'underflow';
      return answer;
    }
  }

  if(patterns[type].test(textToCheck)){
    answer.status = 'ok';
    return answer;
  } else {
    answer.status = 'ko';
    answer.msg = 'invalid';
    return answer;
  }

}

// funzione che scrive dei messaggi uniformi per tutto il tools
// il parametro obj è un oggetto che può contenere 5 valori
//
// result       => è il risultato della funzione checkInputValue() (vedi sopra)
// htmlElement  => è l elemento html in cui verrà scritto il messaggio di errore
// sex          => può essere "m", "f", "am" o "af", determina la frase che accompagna l'elemento
// elementName  => nome che verrà utilizzato per identificare il campo nel messaggio d'errore
// maxLength    => determina il numero da inserire in caso di errore "overflow"
// minLength    => determina il numero da inserire in caso di errore "underflow"


function showErrorMsg(obj){

  var result = obj.result;
  var htmlElement = obj.htmlElement;
  var sex = obj.sex;
  var elementName = obj.elementName;
  var maxLength = obj.maxLength || 1000;
  var minLength = obj.minLength || 0;

  // validation

  if(typeof result != 'object'){
    return {'status' : 'ko', 'msg' : 'result must be an object.'};
  }

  if (htmlElement.length == 0){
    return {'status' : 'ko', 'msg' : 'no htmlElement selected.'};
  }

  if (sex != 'm' && sex != 'f' && sex != 'am' && sex != 'af'){
    return {'status' : 'ko', 'msg' : 'sex must be \'m\' or \'f\'.'};
  }

  if (typeof elementName != 'string'){
    return {'status' : 'ko', 'msg' : 'elementName must be a string.'};
  }

  if (typeof maxLength != 'number'){
    return {'status' : 'ko', 'msg' : 'maxLength must be a number.'};
  }

  if (typeof minLength != 'number'){
    return {'status' : 'ko', 'msg' : 'minLength must be a number.'};
  }

  // show errors

  if (result.status != 'ok'){

    if (result.msg == 'empty'){

      if(sex == 'm'){
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> Non è stato inserito il ' + elementName + '.<br/>');
      } else if (sex == 'f') {
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> Non è stata inserita la ' + elementName + '.<br/>');
      } else if (sex == 'am') {
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> Non è stato inserito l\'' + elementName + '.<br/>');
      } else {
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> Non è stata inserita l\'' + elementName + '.<br/>');
      }

    } else if (result.msg == 'overflow'){

      if(sex == 'm'){
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> Il ' + elementName + ' inserito supera i ' + maxLength + ' caratteri.<br/>');
      } else if (sex == 'f') {
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> La ' + elementName + ' inserita supera i ' + maxLength + ' caratteri.<br/>');
      } else if (sex == 'am') {
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> L\'' + elementName + ' inserito supera i ' + maxLength + ' caratteri.<br/>');
      } else {
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> L\'' + elementName + ' inserita supera i ' + maxLength + ' caratteri.<br/>');
      }

    } else if (result.msg == 'underflow'){

      if(sex == 'm'){
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> Il ' + elementName + ' inserito deve superare i ' + minLength + ' caratteri.<br/>');
      } else if (sex == 'f') {
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> La ' + elementName + ' inserita deve superare i ' + minLength + ' caratteri.<br/>');
      } else if (sex == 'am') {
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> L\'' + elementName + ' inserito deve superare i ' + minLength + ' caratteri.<br/>');
      } else {
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> L\'' + elementName + ' inserita deve superare i ' + minLength + ' caratteri.<br/>');
      }

    } else if (result.msg == 'invalid'){

      if(sex == 'm'){
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> Il ' + elementName + ' inserito non è valido.<br/>');
      } else if (sex == 'f') {
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> La ' + elementName + ' inserita non è valida.<br/>');
      } else if (sex == 'am') {
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> L\'' + elementName + ' inserito non è valido.<br/>');
      } else {
        htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> L\'' + elementName + ' inserita non è valida.<br/>');
      }

    } else {
      htmlElement.append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Si è verificato un errore.<br/>');
    }
    htmlElement.show();

  } else {
    htmlElement.hide();
  }

  return {'status' : 'ok'};
}


// funzione che controlla se la prima data inserita è precedente alla seconda
//
// firstDateToCheck       => prima data
// secondDateToCheck      => seconda data
// equal                  => determina se le date possono essere uguali
//


function checkDates(firstDateToCheck, secondDateToCheck, equal){

  equal = equal || false;

  var d1g = firstDateToCheck.slice(0,2);
  var d1m = firstDateToCheck.slice(3,5);
  var d1a = firstDateToCheck.slice(6,10);

  var d2g = secondDateToCheck.slice(0,2);
  var d2m = secondDateToCheck.slice(3,5);
  var d2a = secondDateToCheck.slice(6,10);

  var date1 = new Date(d1m + '/' + d1g + '/' + d1a);
  var date2 = new Date(d2m + '/' + d2g + '/' + d2a);

  if (equal){

    if (date1.getTime() <= date2.getTime()){
      return true;
    } else {
      return false;
    }

  } else {

    if (date1.getTime() < date2.getTime()){
      return true;
    } else {
      return false;
    }

  }


}

// funzione che controlla se nell'url è presente 'http://' o 'https://'
// e in caso di assenza aggiunge 'http://'
//
// urlToCheck     => url da controllare

function checkUrl(urlToCheck){
  var answer = {};

  if (urlToCheck.length == 0){
    answer.status = 'ko';
    answer.msg = 'empty';
    return answer;
  }

  if(patterns['url'].test(urlToCheck)){
    answer.status = 'ok';
    answer.new_url = null;
    return answer;
  } else {

    var array = urlToCheck.split(':/');

    if (array.length > 1){
      urlToCheck = 'http://' + array[1];
    } else {
      urlToCheck = 'http://' + array[0];
    }

    if(patterns['url'].test(urlToCheck)){
      answer.status = 'ok';
      answer.new_url = urlToCheck;
      return answer;
    } else {
      answer.status = 'ko';
      answer.msg = 'invalid';
      return answer;
    }
  }

}

// funzione che restituisce la data di oggi in formato tools
function getToday(){
  var today = new Date();

  var dd = today.getDate();
  var mm = today.getMonth()+1;
  var yyyy = today.getFullYear();

  if(dd<10) {
      dd='0'+dd
  }

  if(mm<10) {
      mm='0'+mm
  }

  today = dd+'/'+mm+'/'+yyyy;

  return today;
}

