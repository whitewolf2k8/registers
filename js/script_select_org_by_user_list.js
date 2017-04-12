$( document ).ready(function() {
    visibleFild(1);
    $('.spoiler-body').hide();
    $('.spoiler-title').click(function(){
      $(this).next().slideToggle();
    });
});

function printErrorMessage(mes, id) {
  if (id === undefined) {
    id = "errorM";
  }
  if(mes==""){
     document.getElementById(id).innerHTML='';
  }else{
    document.getElementById(id).innerHTML='<p class="error">'+mes+'</p>';
  }
}

function visibleFild(timers){
  if (timers === undefined) {
    timers = 600;
  }
  $("#unvis").slideToggle(timers);
}

function cleanForm() {
  cleanOrgSelect();
  var element = document.getElementById("orgList");
  var indexArr=[];
  for (var i = 0; i < element.children.length; i++) {
     indexArr.push(element.children[i].id);
  }
  for (var i = 0; i < indexArr.length; i++) {
    delFromList(indexArr[i]);
  }
}


function checkAllFild() {
  var checkbox=document.getElementsByName("fildList[]");
  for (var i = 0; i < checkbox.length; i++) {
    checkbox[i].checked=true;
  }
}

function unCheckAllFild() {
  var checkbox=document.getElementsByName("fildList[]");
  for (var i = 0; i < checkbox.length; i++) {
    checkbox[i].checked=false;
  }
}

function exportTable(){
  showWindowLoad(1);
  var myVar = setInterval(function() {
      ls_ajax_progress();
  }, 1000);
  var forms= new FormData(document.getElementById("adminForm"));
  forms.append("mode",'generationFile');
  $.ajax({
    type: "POST",
   url: "script/process_select_org_by_user_list.php",
   data: forms,
   scriptCharset:"CP1251",
   processData: false,
   contentType: false ,
   success: function(data){
    var res = JSON.parse(data);

      if(res.er!=""){
        printErrorMessage(res.er);
        clearInterval(myVar);
      }else{
        cleanForm();
        clearInterval(myVar);
        openUrl('script/unloadDocuments.php',{file:res.file});
      }
      closeWindowLoad();
    }
  });
}

function showWindowLoad(type) {
  document.getElementById("lo").innerHTML='<div id="preloader"></div>';
  if(type>0){
      document.getElementById('centered').removeAttribute("hidden");
  }
}

function closeWindowLoad() {
  document.getElementById("lo").innerHTML='';
  document.getElementById('centered').setAttribute("hidden","");
}


function ls_ajax_progress() {
  $.ajax({
      type: 'POST',
      url: "..\\..\\lib\\readLoad.php",
      success: function(data) {
        $(".knob").val(Math.round(data));
        $(".knob").trigger('change');
      },
  });
}
function searhOrg(){
  var kd=document.getElementById("kd").value;
  var kdmo=document.getElementById("kdmo").value;
  kd=cleanStrNom(kd);
  kdmo=cleanStrNom(kdmo);

  printErrorMessage("","errorMes");
  document.getElementById("orgid").value="";
  document.getElementById("nuOrg").value="";

  if(kd!="" || kdmo!=""){
    $.ajax({
     type: "POST",
     url: "script/process_select_org_by_user_list.php",
     data: {mode:'getOrg',"kd": kd, "kdmo" : kdmo },
     scriptCharset: "CP1251",
     success: function(data){
         var res = JSON.parse(data);
         if(res==null){
           printErrorMessage("Підприємство не знайдено в довіднику!!","errorMes");
           document.getElementById("btnAddOrg").setAttribute("disabled","");
         }else{
           document.getElementById("orgid").value=res[0].id;
           document.getElementById("kd").value=res[0].kd;
           document.getElementById("kdmo").value=res[0].kdmo;
           document.getElementById("nuOrg").value=res[0].nu;
           kd.value=res[0].kd;
           kdmo.value=res[0].kdmo;
           document.getElementById("btnAddOrg").removeAttribute("disabled");
         }
      }
   });
  }else{
    printErrorMessage("Не введено ні одного параметру!!","errorMes");
  }
}

function cleanStrNom(str) {
  str=str.replace(/\s/g, '');
  str=str.replace(/[^-0-9]/gim,'');
  return str;
}

function addToListOrg() {
  var id=document.getElementById("orgid").value;
  if(checkedExistOrgInList(id)){
    var element= document.createElement("p");
    element.setAttribute("id",id);
    element.setAttribute("name",id);
    var kd=document.getElementById("kd").value;
    var kdmo=document.getElementById("kdmo").value;
    var name=document.getElementById("nuOrg").value;
    element.innerHTML+="<input type=\"hidden\" name=\"idList[]\" value=\""+id+"\"/>";
    element.innerHTML+=" ЄДРПОУ : "+kd+" ; ";
    element.innerHTML+=" КДМО : "+kdmo+" ; ";
    element.innerHTML+=" Назва : "+name+" ; ";
    element.innerHTML+="<input type=\"button\" class=\"btn_del\" onclick=\"delFromList("+id+");\"/>";
    document.getElementById("orgList").appendChild(element);
    cleanOrgSelect();
    btnExportEnabled();
  }else{
    printErrorMessage("Дане підприємство вже в списку !!","errorMes");
  }
}

function cleanOrgSelect() {
  document.getElementById("orgid").value="";
  document.getElementById("kd").value="";
  document.getElementById("kdmo").value="";
  document.getElementById("nuOrg").value="";
  document.getElementById("btnAddOrg").setAttribute("disabled","");
}

function checkedExistOrgInList(id) {
  var elements=document.getElementsByName(id);
  if(elements.length>0){
    return false;
  }else{
    return true;
  }
}

function btnExportEnabled() {
  var element=document.getElementById("orgList");
  if(element.children.length>0){
    document.getElementById("Ch1").removeAttribute("disabled");
    document.getElementById("Ch2").removeAttribute("disabled");
    document.getElementById("btEx").removeAttribute("disabled");
  }else{
    document.getElementById("Ch1").setAttribute("disabled","");
    document.getElementById("Ch2").setAttribute("disabled","");
    document.getElementById("btEx").setAttribute("disabled","");
  }
}


function delFromList(id) {
  document.getElementById(id).remove();
  btnExportEnabled();
}

function openUrl(url, post)
 {
     if ( post ) {
         var form = $('<form/>', {
             action: url,
             method: 'POST',
             target: '_blank',
             style: {
                display: 'none'
             }
         });
         for(var key in post) {
             form.append($('<input/>',{
                 type: 'hidden',
                 name: key,
                 value: post[key]
             }));
         }
         form.appendTo(document.body); // Необходимо для некоторых браузеров
         form.submit();

     } else {
         window.open( url, '_blank' );
     }
}
$(function() {
     $(".knob").knob();
     var val,up=0,down=0,i=0
         ,$idir = $("div.idir")
         ,$ival = $("div.ival")
         ,incr = function() { i++; $idir.show().html("+").fadeOut(); $ival.html(i); }
         ,decr = function() { i--; $idir.show().html("-").fadeOut(); $ival.html(i); };
     $("input.infinite").knob(
          {
             'min':0
             ,'max':20
             ,'stopper':false
             ,'change':function(v){
                         if(val>v){
                             if(up){
                                decr();
                                up=0;
                             }else{up=1;down=0;}
                          }else{
                            if(down){
                              incr();
                               down=0;
                             }else{down=1;up=0;}
                         }
                         val=v;
            }
          }
    );
});
