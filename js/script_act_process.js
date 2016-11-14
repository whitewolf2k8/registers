var month =['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень',
  'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'];
var days=['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'];
var monthSotr=['Січ','Лют','Бер','Квіт','Трав','Черв',
  'Лип','Серп','Вер','Жовт','Лист','Груд'];
function cleanFormImport() {
  document.getElementById("kd").value='';
  document.getElementById("kdmo").value='';
  document.getElementById("nuOrg").value='';
  document.getElementById("dateEnd").value='';
  document.getElementById("dateS").value='';
  document.getElementById("kodDis").value='';
  document.getElementById("kodDepNom").value='';
  document.getElementById("orgid").value='';
  document.getElementById("ad").value='';
  var fildDepNom = document.getElementById("kodDepList");
  var typeAct = document.getElementById("typeAct");
  $.ajax({
    type: "POST",
    url: "script/processAct.php",
    data: {mode:'getList', id:"" },
    scriptCharset: "CP1251",
    success: function(data){
      var res = JSON.parse(data);
      fildDepNom.innerHTML=res[0].list;
    //  fildDepNom.selectedIndex=0;
    }
  });
  $.ajax({
   type: "POST",
   url: "script/processAct.php",
   data: {mode:'getListType'},
   scriptCharset: "CP1251",
   success: function(data){
     var res = JSON.parse(data);
     typeAct.innerHTML="Ознака акту <select name=\"types[]\" style=\"width:150px;\">"+res[0]+"</select> "
     +"<select name=\"types[]\" style=\"width:150px;\">"+res[0]+"</select>"
     +"<input type=\"button\" value=\"\" name=\"add_type\" class=\"btn_add\"  onclick=\"addTypeSelect();\"/>";
   }
 });

}

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
       if(res[0].exists===0){
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

function searhOrg(){
  var kd = document.getElementById("kd");
  var kdmo = document.getElementById("kdmo");

  kdStr=cleanStrNom(kd.value);
  kdmoStr=cleanStrNom(kdmo.value);

  printErr("");
  document.getElementById("orgid").value="";
  document.getElementById("nuOrg").value="";

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
           document.getElementById("orgid").value=res[0].id;
           document.getElementById("nuOrg").value=res[0].nu;
           kd.value=res[0].kd;
           kdmo.value=res[0].kdmo;

         }
      }
   });
  }else{
    printErr("Не введено ні одного параметру!!");
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

function addToDb() {
  var res= checkData();
  if(res==null){
    printErr("Необхідно обрати підриємство для якого складається акт!");
  }else{
    $.ajax({
     type: "POST",
     url: "script/processAct.php",
     data: {mode:'addRow',inData:res},
     scriptCharset: "CP1251",
     success: function(data){
       var res = JSON.parse(data);
       updateTable(res);
       cleanFormImport();
       document.getElementById('bt_sev').disabled=true;
       document.getElementById('bt_del').disabled=true;
      }
   });
  }
}


function updateTable(arr) {
  var str="";
  var table =document.getElementById('table_id');
  table.innerHTML="";

  str+="<tr><th rowspan=\"2\">&nbsp;</th> <th rowspan=\"2\">ЄДРПОУ</th>"+
    "<th rowspan=\"2\">КДМО</th><th colspan=\"2\">Дата </th>"+
    "<th rowspan=\"2\">Номер рішення</th><th rowspan=\"2\">Тип акту</th>"+
    "<th rowspan=\"2\">Галузевий відділ</th><th rowspan=\"2\">Адреса складання</th>"+
    "</tr><tr class=\"second_level\"><th> складання акту</th>"+
    "<th>ліквідації по рішенню суду</th></tr>";
  for (var i = 0; i < arr.length; i++) {
    str+="<tr id=\""+arr[i].id+"\">";
    str+="<td  style =\" overflow:visible\" > <input type=\"checkbox\"  name=\"checkList[]\" value=\""+arr[i].id+"\" onchange=\"chacheCheck('"+arr[i].id+"');\" /></td>";
    str+="<td style =\" overflow:hidden;\" >"+arr[i].kd+"</td>";
    str+="<td style =\" overflow:hidden;\" >"+arr[i].kdmo+"</td>";
    str+="<td style =\" overflow:hidden;\" >"+arr[i].da+"</td>";
    str+="<td style =\" overflow:hidden;\" >"+arr[i].dl+"</td>";
    str+="<td style =\" overflow:hidden;\" >"+arr[i].rnl+"</td>";
    str+="<td style =\" overflow:hidden;\" >"+arr[i].types+"</td>";
    str+="<td style =\" overflow:hidden;\" >"+arr[i].dep+"</td>";
    str+="<td style =\" overflow:hidden;\" >"+arr[i].ad+"</td>";
    str+="</tr>";
  }
  table.innerHTML=str;
}


function  checkData() {
    var orgId = document.getElementById("orgid").value;
    var dataEnd=  document.getElementById("dateEnd").value;
    var dataS= document.getElementById("dateS").value;
    var kodDis= document.getElementById("kodDis").value;
    var dep= document.getElementById("kodDepList");
    dep=dep.options[dep.selectedIndex].value;
    var ad= document.getElementById("ad").value;
    var typeAct = document.getElementsByName("types[]");

    var type=[];
    for(var i=0;i<typeAct.length;i++){
      if(typeAct[i].value!=0){
        type.push(typeAct[i].value);
      }
    }

    if(orgId==""){
      return null;
    }else{
      var arr=[];
      arr[0]=orgId;
      arr[1]=dataS;
      arr[2]=dataEnd;
      arr[3]=kodDis;
      arr[4]=dep;
      arr[5]=ad;
      arr[6]=type;
      return arr;
    }
}


$(document).ready(function() {
  $( "#dateS" ).datepicker({showOn: "button",
              buttonImage: "../../img/cal.gif",
              showOtherMonths: true, autoSize: true,
              monthNames:month ,
              dayNamesMin:days ,
              changeMonth: true,
              changeYear: true,
              yearRange: "-1:+2",
              monthNamesShort: monthSotr});
  $( "#dateEnd" ).datepicker({showOn: "button",
              buttonImage: "../../img/cal.gif",
              showOtherMonths: true, autoSize: true,
              monthNames:month ,
              dayNamesMin:days,changeMonth: true,
              changeYear: true,
              yearRange: "-1:+2",
              monthNamesShort: monthSotr});

});


function chacheCheck(id){
  var arrCheck=document.getElementsByName("checkList[]");
  var cnt=0;
  for(var i=0;i<arrCheck.length;i++){
    if(arrCheck[i].checked){
      cnt++;
    }
    if(arrCheck[i].value==id){
      if(arrCheck[i].checked)
      {
        document.getElementById(id).className="changeData";
      }else{
        document.getElementById(id).className="";
      }
    }
  }

  var flag=((cnt==0)?true:false);
    document.getElementById("bt_sev").disabled=flag;
    document.getElementById("bt_del").disabled=flag;

}
