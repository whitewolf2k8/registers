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

}

function cleanStrNom(str) {
  str=str.replace(/\s/g, '');
  str=str.replace(/[^-0-9]/gim,'');
  return str;
}

function printErr(str) {
  if(str===""){
    document.getElementById("errorMes").innerHTML='';
  }else{
    document.getElementById("errorMes").innerHTML='<p class="error">'+str+'</p>';
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

function getElementList(id){
  var list=document.getElementById(id);
  return list.options[list.selectedIndex].value;
}



function inmportInformathion() {
  printErr('');
  var fileName= document.getElementById("fileImp").files.name;
  var year= getElementList("filtr_year_insert");

  if(fileName!="" &&  year!=""){
    var forms= new FormData(document.getElementById("adminForm"));
    	forms.append("action","load");
    	showWindowLoad(1);
    	var myVar = setInterval(function() {
    			ls_ajax_progress();
    	}, 1000);
      $.ajax({
  			 type: "POST",
  			 url: "script/processConsent.php",
  			 data: forms,
  			 scriptCharset: "CP1251",
  			 processData: false,
    	 	 contentType: false ,
  			 success: function(data){
          var res = JSON.parse(data);
          console.log(res);
          updateTable(res.table);
          document.getElementById("paginatorT").innerHTML=res.paginator;
          var str="";
          str+=res.ERROR_MSG+"<br>";
          str+=res.INFO_MSG+"<br>";
          printErr(str);
  			  clearInterval(myVar);
          cleanImport();
  				closeWindowLoad();
  			 }
  		});
  }else{
    var str='';
    if(fileName==""){
      str+="Необхідно обрати файл для імпорту!! <br>";
    }
    if(year==""){
      str+="Необхідно обрати рік за який проводиться імпорт!!<br>";
    }
    printErr(str);
  }
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



function updateTable(arr) {
  var str="";
  var table =document.getElementById('table_id');
  table.innerHTML="";

  str+="<tr><th>ЄДРПОУ</th><th>КДМО</th>"
    +"<th>Назва</th><th>Рік імпорту</th>"
    +" <th>Ознака активності</th></tr>";
  for (var i = 0; i < arr.length; i++) {
    str+="<tr>";
    str+="<td>"+arr[i].kd+"</td>";
    str+="<td>"+arr[i].kdmo+"</td>";
    str+="<td>"+arr[i].nu+"</td>";
    str+="<td>"+arr[i].Nuperiod+"</td>";
    str+="<td>"+arr[i].type+"</td>";
    str+="</tr>";
  }
  table.innerHTML=str;
}
