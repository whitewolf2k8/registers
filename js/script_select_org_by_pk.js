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
  var formData = new FormData();
  formData.append("mode", "generationFile");
  formData.append("fildList", getArrFildList());
  formData.append("orgs",  getArrOrgsList());
  formData.append("typeF",  ((document.getElementById('Ch1').checked) ? "dbf" : "exel"));


  $.ajax({
    type: "POST",
   url: "script/process_select_org_by_pk.php",
   data: formData,
   scriptCharset:"CP1251",
   processData: false,
   contentType: false ,
   success: function(data){
    var res = JSON.parse(data);
      if(res.er!=""){
        printErrorMessage(res.er);
        clearInterval(myVar);
      }else{
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

function searhOrgs(){
  document.getElementById('lo').innerHTML='<div id="preloader"></div>';
  printErrorMessage("","errorMes");
  if(document.getElementById('pkNu').value!=''){ 
    var formData = new FormData();
    formData.append("mode", "getOrgs");
    formData.append("fildList", getArrFildList());
    formData.append("pkNu", document.getElementById('pkNu').value);

    $.ajax({
     type: "POST",
     url: "script/process_select_org_by_pk.php",
     data: formData,
     scriptCharset:"CP1251",
     processData: false,
     contentType: false ,
     success: function(data){
         var res = JSON.parse(data);
         var headerAr=res['hed'];
         var bodyAr=res['res'];
         console.log(res);
         var header ='<tr>';
         header+="<th>&nbsp;</th>";
         for (var i = 0; i < headerAr.length; i++) {
           header+="<th>"+headerAr[i]['nu']+"</th>";
         }
         header+='</tr>';
         var bodyTab ='';
         if(bodyAr.length>0){
           for (var i = 0; i < bodyAr.length; i++) {
             bodyTab+='<tr>';
             bodyTab+='<td style =\" overflow:hidden;\" > <input type="checkbox" name="orgs[]" value="'+bodyAr[i]["id"]+'" checked></td>';
             for (var j = 0; j < headerAr.length; j++) {
               if((headerAr[j]['kod']=="kd"||headerAr[j]['kod']=="kdmo")){
                bodyTab+='<td style =" overflow:hidden;" ><a OnClick="openUrl(\'index.php\',{filtr_edrpou:\''+bodyAr[i]["kd"]+'\', filtr_kdmo:\''+bodyAr[i]["kdmo"]+'\'});">'+bodyAr[i][headerAr[j]['kod']]+'</a></td>';

               }else{
                bodyTab+='<td style =\" overflow:hidden;\" >'+bodyAr[i][headerAr[j]['kod']]+'</td>';
               }
             }
             bodyTab +='</tr>';
           }
           btnExportEnabled(1);
         }else{
           btnExportEnabled(0);
           bodyTab+='<tr><td colspan="'+(headerAr.length+1)+'"> <h2 style="float:left"> Дані по даному запиту не знайдено </h2> </td></tr>';
         }
         document.getElementById('table_id').innerHTML=header+bodyTab;
      }
    });

  }else{
    printErrorMessage("Для здійснення пошуку необхідно ввести керівника.","errorMes");
  }
  document.getElementById('lo').innerHTML=' ';
}

function getArrFildList() {
   var fild=document.getElementsByName("fildList[]");
   var resArr=[];
   for (var i = 0; i < fild.length; i++) {
     if(fild[i].checked){
       resArr.push(fild[i].value);
     }
   }
   return resArr;
}

function getArrOrgsList() {
   var fild=document.getElementsByName("orgs[]");
   var resArr=[];
   for (var i = 0; i < fild.length; i++) {
     if(fild[i].checked){
       resArr.push(fild[i].value);
     }
   }
   return resArr;
}


function btnExportEnabled(type=1) {
  if(type>0){
    document.getElementById("Ch1").removeAttribute("disabled");
    document.getElementById("Ch2").removeAttribute("disabled");
    document.getElementById("btEx").removeAttribute("disabled");
  }else{
    document.getElementById("Ch1").setAttribute("disabled","");
    document.getElementById("Ch2").setAttribute("disabled","");
    document.getElementById("btEx").setAttribute("disabled","");
  }
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
