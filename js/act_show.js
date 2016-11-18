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
  if(selectId==0){
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


function cleanFormImport() {
  document.getElementById("fileImp").value="";
  $.ajax({
   type: "POST",
   url: "script/process_amount_pv.php",
   data: {mode:'getList'},
   scriptCharset: "CP1251",
   success: function(data){
       var res = JSON.parse(data);
       formCleanList(res);
    }
 });
}

function formCleanList(arr) {
  document.getElementById("filtr_year_insert").innerHTML=arr.insert_year;
  document.getElementById("filtr_period_insert").innerHTML=arr.insert_period;
}

function chacheCheck(){
  var arrText=document.getElementsByClassName("amo");
  var arrCheck=document.getElementsByName("checkList[]");
  var cnt=0;
  for(var i=0;i<arrCheck.length;i++){
    if(arrCheck[i].checked)
      cnt++;
  }
  var flag=true;
  if(cnt==0)
  {
    flag=false;
    document.getElementById("delBtn").disabled=true;
    document.getElementById("addBtn").disabled=false;
  }else{
    document.getElementById("delBtn").disabled=false;
    document.getElementById("addBtn").disabled=true;
  }
  for(var i=0;i<arrText.length;i++){
    arrText[i].disabled = flag;
  }
}

function printErr(str) {
  if(str===""){
     document.getElementById("errorM").innerHTML='';
  }else{
    document.getElementById("errorM").innerHTML='<p class="error">'+str+'</p>';
  }
}

function changeAmountAction(id) {
  var arrCheck=document.getElementsByName("checkList[]");
  for(var i=0;i<arrCheck.length;i++){
    arrCheck[i].disabled="disabled";
    if(id==arrCheck[i].value) arrCheck[i].checked=true;
  }
  document.getElementById("saveBtn").disabled=false;
}

function checkInputDataKved(){
  var input = document.getElementById("text_kved").value;
  var bt = document.getElementById("text_kved").value;
  if(input!=""){
    $.ajax({
     type: "POST",
     url: "script/processAct.php",
     data: {mode:'checkKved',"info":input},
     scriptCharset: "CP1251",
     success: function(data){
        var res = JSON.parse(data);
        printErr(res.erroMes);
        addKved(res.kved_kod);
      }
   });
 }
}

function addKved(arr) {
  var co = arr.length;
  if (co>0) {
    var str ="<abbr id=\""+arr[0].id+"\"  title=\""+arr[0].nu+"\">"+arr[0].kod+"</abbr>"+
    "<input type=\"button\" id=\"b_"+arr[0].id+"\" class=\"btn_del\"  onclick=\"delKved('"+arr[0].id+"');\"/>";
    $("input[name=add_kved]").after(str);
    document.getElementById("text_kved").value="";
  }
}

function delKved(id) {
  var el1 =document.getElementById(id);
  el1.parentNode.removeChild(el1);
  var el =document.getElementById("b_"+id);
  el.parentNode.removeChild(el);
}


function checkInputDataKise(){
  var input = document.getElementById("text_kise").value;
  if(input!=""){
    $.ajax({
     type: "POST",
     url: "script/processAct.php",
     data: {mode:'checkKise',"info":input},
     scriptCharset: "CP1251",
     success: function(data){
        var res = JSON.parse(data);
        printErr(res.erroMes);
        addKise(res.kise_kod);
      }
   });
 }
}

function addKise(arr) {
  var co = arr.length;
  if (co>0) {
    var str ="<abbr id=\"kise_"+arr[0].kd+"\"  title=\""+arr[0].nu+"\">"+arr[0].kod+"</abbr>"+
    "<input type=\"button\" id=\"kise_b_"+arr[0].kd+"\" class=\"btn_del\"  onclick=\"delKise('"+arr[0].kd+"');\"/>";
    $("input[name=add_kise]").after(str);
    document.getElementById("text_kise").value="";
  }
}

function delKise(id) {
  var el1 =document.getElementById("kise_"+id);
  el1.parentNode.removeChild(el1);
  var el =document.getElementById("kise_b_"+id);
  el.parentNode.removeChild(el);
}

function generateTeLists() {
  var obl= document.getElementById("obl_select");
  var ray= document.getElementById("ray_select");
  var selectedObl= obl.options[obl.selectedIndex].value;
  var selectedRay= ray.options[ray.selectedIndex].value;

    if(selectedRay!=""){
      $.ajax({
       type: "POST",
       url: "script\\processTeaForAct.php",
       data: {ob:selectedObl,ra:selectedRay},
       scriptCharset: "CP1251",
       success: function(data){
           var res = JSON.parse(data);
           formList(res,"ter_select"); // распарсим JSON
        }
     });

    }else{
      cleanLists("ter_select");
    }
}


function updateLists() {
  var obl= document.getElementById("obl_select");
  var selected= obl.options[obl.selectedIndex].value;

  if(selected!="")
  {
    $.ajax({
     type: "POST",
     url: "script\\processAct.php",
     data: {mode:"getRay",obl:selected},
     scriptCharset: "CP1251",
     success: function(data){
         var res = JSON.parse(data);
         formList(res,"ray_select"); // распарсим JSON
      }
   });
  }else{
    cleanLists("ray_select");
    cleanLists("ter_select");
  }
}

function formList(arr,id) {
  var arrSize=count(arr);

    var x = document.getElementById(id);
    if(x.getAttribute("disabled")){
      x.removeAttribute("disabled");
    }
    x.setAttribute("disabled","disabled");
    x.innerHTML = "";
    var opt = document.createElement('option');
    opt.value = "";
    opt.innerHTML = "- Всі -";
    opt.selected = true;
    x.appendChild(opt);
    for(var i = 0; i < arrSize; i++)
    {
      var opt = document.createElement('option');
      opt.value = arr[i].kod;
      opt.innerHTML = arr[i].nu;
      x.appendChild(opt);
    }
    if(x.getAttribute("disabled")){
      x.removeAttribute("disabled");
    }
}

function cleanLists(id) {
  var x = document.getElementById(id);
  x.innerHTML = "";
  var opt = document.createElement('option');
  opt.value = "";
  opt.innerHTML = "- Всі -";
  x.appendChild(opt);
  x.setAttribute("disabled","disabled");
}


function searhOrg(){
  var kd = document.getElementById("kd");
  var kdmo = document.getElementById("kdmo");

  kdStr=cleanStrNom(kd.value);
  kdmoStr=cleanStrNom(kdmo.value);

  printErr("");

  if(kdStr!="" || kdmoStr!=""){
    $.ajax({
     type: "POST",
     url: "script/processAct.php",
     data: {mode:'getOrg',"kd": kdStr, "kdmo" : kdmoStr },
     scriptCharset: "CP1251",
     success: function(data){
         var res = JSON.parse(data);
         if(res==null){
           printErr("Підприємство не знайдено в довіднику!!");
         }else{
           kd.value=res[0].kd;
           kdmo.value=res[0].kdmo;

         }
      }
   });
  }
}

function cleanOrg() {
  document.getElementById('kd').value="";
  document.getElementById('kdmo').value="";
}

function getKveds() {
  var tt=document.getElementById('kved').getElementsByTagName('abbr');
  var arr=[];
  for(var i=0; i<tt.length;i++){
    arr.push(tt[i].id);
  }
  return arr;
}

function getKises() {
  var tt=document.getElementById('kise').getElementsByTagName('abbr');
  var arr=[];
  for(var i=0; i<tt.length;i++){
    arr.push(tt[i].id);
  }
  return arr;
}
