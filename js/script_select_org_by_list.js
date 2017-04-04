$( document ).ready(function() {
    visibleFild(1);
});

function checkFile() {
  var file= document.getElementById('fileImp');
  if(file.value!=""){
    var forms= new FormData(document.getElementById("adminForm"));
      forms.append("mode",'getFileInformathion');
        $.ajax({
         type: "POST",
         url: "script/process_select_org_by_list.php",
         data: forms,
         scriptCharset:"CP1251",
         processData: false,
         contentType: false ,
         success: function(data){
          var res = JSON.parse(data);
          if(res.er!=""){
            printErrorMessage(res.er);
          }else{
            if(res.problem==0){
              printErrorMessage("Вибачте але в файлі не знайдено ні одного поля для ідентифікації підпривств (kd , kdmo)");
              showFildSelect([],[]);
              showFildError([]);
              showFildNotFind([]);
            }else{
              printErrorMessage("");
              document.getElementById("fildsDiv").style.visibility="";
              document.getElementById("btnCleanForm").removeAttribute("disabled");

              showFildSelect(res.fildList,res.exist);
              document.getElementById("btnLoad").setAttribute("disabled","true");
              if(document.getElementById('unvis').getAttribute("display")!=null)
              {
                visibleFild(1);
              }
              showFildError(res.promF.errorF);
              showFildNotFind(res.promF.notF);
            }
          }
         }
      });
  }else{
    printErrorMessage("Необхідно обрати файл!");
  }
}

function showFildSelect(listFild,listExist) {
  if(listExist.length>0){
    var htmlText="<p>";
    for (var i = 0; i < listFild.length; i++) {
      htmlText+="<input type=\"checkbox\" name=\"fildList[]\" value=\""+listFild[i]['nu']+"\" "+((listExist.indexOf(""+i+"")> -1)?"checked":"")+" > &nbsp;<font>"+listFild[i]['nu']+"</font> &nbsp; "+listFild[i]['de']+"<br>";
    }
    htmlText+="</p>";
    document.getElementById('fild_d').innerHTML=htmlText;
    document.getElementById('counts').innerHTML= "У вхідному файлі ідентифіковано:<font style=\"color:red;\"> "+listExist.length+" </font>полів ";
  }else{
    document.getElementById('fild_d').innerHTML="";
    document.getElementById('counts').innerHTML=""
  }
}

function showFildError(listFild) {
  var textHead="";
  var textBody="";
  if(listFild.length>0){
    var fild=[];
    for (var i = 0; i < listFild.length; i++) {
        fild.push(listFild[i]['name']);
    }
    textHead= "У вхідному файлі  знайдено  :<font style=\"color:red;\"> "+listFild.length+" </font>полів невірної структури.";
    var textBody="<p style:'word-wrap: break-word;'> Поле(я), що мають невірну структуру : "+fild.join()+"</p>" ;
  }
  document.getElementById('ErrrFild').innerHTML=textHead;
  document.getElementById('fild_er').innerHTML=textBody;
}

function showFildNotFind(listFild) {
  var textHead="";
  var textBody="";
  if(listFild.length>0){
    var fild=[];
    for (var i = 0; i < listFild.length; i++) {
        fild.push(listFild[i]['name']);
    }
    textHead= "У вхідному файлі не ідентифіковано :<font style=\"color:red;\"> "+listFild.length+" </font> полів.";
    var textBody="<p style='word-wrap: break-word;'> Поле(я), що не ідентифіковано: "+fild.join()+"</p>" ;
  }
  document.getElementById('NotFindFild').innerHTML=textHead;
  document.getElementById('fild_not_f').innerHTML=textBody;
}

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
  document.getElementById("fildsDiv").style.visibility="hidden";
  document.getElementById("fileImp").value="";
  document.getElementById("paginatorT").innerHTML="";
  document.getElementById("errorM").innerHTML="";
  document.getElementById("btnLoad").removeAttribute("disabled");
  document.getElementById("btnCleanForm").setAttribute("disabled","true");
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
   url: "script/process_select_org_by_list.php",
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
