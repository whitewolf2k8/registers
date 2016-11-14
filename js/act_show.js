var month =['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень',
  'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'];
var days=['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'];
var monthSotr=['Січ','Лют','Бер','Квіт','Трав','Черв',
  'Лип','Серп','Вер','Жовт','Лист','Груд'];

function cleanStrNom(str) {
  str=str.replace(/\s/g, '');
  str=str.replace(/[^-0-9]/gim,'');
  return str;
}

function chandeDep() {
  var depId=document.getElementById("kodDepNom").value;
  var option = document.getElementById("kodDepList");
  printErr('');
  depId=cleanStrNom(depId);
  $.ajax({
   type: "POST",
   url: "script/processAct.php",
   data: {mode:'getList', kod:depId },
   scriptCharset: "CP1251",
   success: function(data){
       var res = JSON.parse(data);
       option.innerHTML=res[0].list;
       if(res[0].exists==0){
         printErr("Не знайдено відділу з таким кодом!!");
       }
    }
 });
}

function chengeIdListDep() {
  var list = document.getElementById("kodDepList");
  var selectId=list.options[list.selectedIndex].value;
  var fildDepNom = document.getElementById("kodDepNom");
  if(selectId===0){
    fildDepNom.value="";
  }else{
    $.ajax({
     type: "POST",
     url: "script/processAct.php",
     data: {mode:'kodDepList', id:selectId },
     scriptCharset: "CP1251",
     success: function(data){
       var res = JSON.parse(data);
      fildDepNom.value=res[0];
      }
    });
  }
}

function printErr(str) {
  if(str==""){
     document.getElementById("errorM").innerHTML='';
  }else{
    document.getElementById("errorM").innerHTML='<p class="error">'+str+'</p>';
  }
}

function addTypeSelect() {
  $.ajax({
   type: "POST",
   url: "script/processAct.php",
   data: {mode:'getListType'},
   scriptCharset: "CP1251",
   success: function(data){
     var res = JSON.parse(data);
     $("input[name=add_type]").before("  <select name=\"types[]\" style=\"width:150px;\">"+res[0]+"</select>");
    }
  });
}
function setDataPoclerFild(name) {
  var names="#"+name;
  $(names).datepicker({showOn: "button",
              buttonImage: "../../img/cal.gif",
              showOtherMonths: true, autoSize: true,
              monthNames:month ,
              dayNamesMin:days ,
              changeMonth: true,
              changeYear: true,
              yearRange: "-1:+2",
              monthNamesShort: monthSotr});
}
