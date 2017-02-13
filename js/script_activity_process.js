//функция для работы с прогресс баром
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


function cleanImport() {
  document.getElementById("fileImp").value='';
  document.getElementById("filtr_year_insert").selectedIndex=0;
  document.getElementById("filtr_period_insert").selectedIndex=0;
}

function cleanStrNom(str) {
  str=str.replace(/\s/g, '');
  str=str.replace(/[^-0-9]/gim,'');
  return str;
}

function printErr(str) {
  if(str===""){
     document.getElementById("errorM").innerHTML='';
  }else{
    document.getElementById("errorM").innerHTML='<p class="error">'+str+'</p>';
  }
}


function inmportInformathion() {
  var forms= new FormData(document.getElementById("adminForm"));
  	forms.append("action","load");
  	showPopup("progressDisplay");
  	var myVar = setInterval(function() {
  			ls_ajax_progress();
  	}, 1000);
      $.ajax({
  			 type: "POST",
  			 url: "\\logic\\jsonScript\\kved10Function.php",
  			 data: forms,
  			 scriptCharset: "CP1251",
  			 processData: false,
    	 	 contentType: false ,
  			 success: function(data){
  				clearInterval(myVar);
  				showOffPopup("progressDisplay");
  				}
  		});

}


function ls_ajax_progress() {
	var progress = document.getElementById('progressbar');
	var progressStr = document.getElementById('progress_value');
		$.ajax({
				type: 'POST',
				url: "\\logic\\jsonScript\\readLoad.php",
				success: function(data) {
					progress.value=Math.round(data);
					progressStr.innerHTML=data+"%";
				},
		});
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
