<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/pag.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/modal-contact-form.css"  type="text/css" />
<title>Головна</title>
<link rel="shortcut icon" href="../../../images/favicon.png" type="image/png">

<script src="../../../js/jquery-1.7.2.js"></script>
<script src="../../../js/scripts.js"></script>
<script src="../../../js/script_fact_adress.js"></script>
<script type="text/javascript">
  function submitForm(mode) {
    correct = true;
    form = document.forms['adminForm'];
    if(mode=='import'){
      if (form.fileImp.value=="") {
        correct = false;
        document.getElementById('fileImp').className="error";
        document.getElementById('errorMes').className="error";
        document.getElementById('errorMes').innerHTML="<p>Будь ласка оберіть файл для імпорту.</p>";
      }
    }

    if(mode=='edit'){
      correct= confirm("Ви впевнені в змінах ??");
      if(correct){
        var arrCheck=document.getElementsByName("checkList[]");
        for(var i=0;i<arrCheck.length;i++){
          arrCheck[i].disabled=false;
        }
      }
    }

    if (correct) {
      document.getElementById('lo').innerHTML='<div id="preloader"></div>';
      form.mode.value = mode;
      var x = document.getElementsByName("limitstart");
        x[0].value=0;
      form.submit();
    }
  }

  function chacheCheck(id){

    var  chDead =  document.getElementById('ch_'+id);
    var arrCheck=document.getElementsByName("checkList[]");
    var cnt=0;
    for(var i=0;i<arrCheck.length;i++){
      if(arrCheck[i].value==id){
        arrCheck[i].checked=true;
        document.getElementById(id).className="changeData";
        var flag = ((chDead.checked)? true:false);
        document.getElementById('li_'+id).disabled=flag;
      }
    }
    checkButton();
  }

  function checkButton() {
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
      document.getElementById("saveBtn").disabled=true;
      document.getElementById("addBtn").disabled=false;
    }else{
      document.getElementById("saveBtn").disabled=false;
      document.getElementById("addBtn").disabled=true;
    }
  }




  function addAdres(mode){
    var pib = document.getElementById('text_pib').value;

    var idDep = document.getElementById('depatment_id');
    idDep=idDep.options[idDep.selectedIndex].value;
    if(pib!="" && idDep!=0){
      $.ajax({
       type: "POST",
       url: "script\\processMeneger.php",
       data: {"mode":mode, "pib":pib, "dep":idDep },
       scriptCharset: "CP1251",
       success: function(data){
          var res = JSON.parse(data);
          pib.value="";
          updateTable(res);
          showHide('add_maneger');
        }
     });
   }else{
     var er="";
     if(pib==""){
       er+="Прізвище та ініціали повинні бути заповнені<br>";
     }
     if(idDep==0){
       er+="Необхідно обрати відділ в якому працює<br>";
     }
     document.getElementById("errorMesAdd").innerHTML="<p class=\"error\">"+er+"</p>   <div class=\"clr\"></div>";
   }
  }


  function openAddMeneget() {
    $.ajax({
     type: "POST",
     url: "script\\processMeneger.php",
     data: {"mode":"getList"},
     scriptCharset: "CP1251",
     success: function(data){
        var res = JSON.parse(data);
        addLists(res);
        showHide('add_maneger');
      }
    });
   }


  function addLists(arr) {
    var x= document.getElementById("depatment_id");
    x.innerHTML = "";
    var opt = document.createElement('option');
    opt.value = "0";
    opt.selected = true;
    opt.innerHTML = " - не обрано - ";
    x.appendChild(opt);
    for(var i = 0; i < arr.length; i++)
    {
      var opt = document.createElement('option');
      opt.value = arr[i].id;
      opt.innerHTML = arr[i].nu;
      x.appendChild(opt);
    }
  }


  function updateTable( arr ){
    var table = document.getElementById("table_id");
    var text='';
    table.innerHTML="";
    if(arr.length>0) text+="<tr><th>&nbsp;</th><th>П.І.Б.</th><th>Не активний</th></tr>"
    for(var i=0; i<arr.length;i++){
      text+="<tr id=\""+arr[i].id+"\" "+((arr[i].dead==1)?"class=\"notactive\"":"")+">";
      text+="<td style =\" overflow:visible\" ><input type=\"checkbox\"  name=\"checkList[]\" value=\""+arr[i].id+"\" onclick=\"return false\" /></td>";
      text+="<td style =\" overflow:hidden;\" >"+arr[i].nu+"</td>";
      text+="<td style =\" overflow:hidden;\" > <select id=\"li_"+arr[i].id+"\" name=\"depSelect["+arr[i].id+"]\" "+((arr[i].dead==1)?"disabled":"")+" onchange=\"chacheCheck("+arr[i].id+");\">"+arr[i].ld+"</select></td>";
      text+="<td style =\" overflow:hidden;\" > <input type=\"checkbox\" id=\"ch_"+arr[i].id+"\" name=\"checkDead["+arr[i].id+"]\"  onchange=\"chacheCheck("+arr[i].id+");\" "+((arr[i].dead==1)?"checked":"")+"/></td>";
      text+="</tr>";
    }
    table.innerHTML=text;
  }


</script>


</head>

<body>

  <div class="wrapper">

	  <div class="header">
         <?php  require_once('header.php'); ?>
	  </div>

	  <div class="content">
      <div class="mainConteiner">
        <div id='errorMes' style='display="none"'>
      		    <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
      	</div>

        <h2>Перелік керівників відділів</h2>

        <div id="add_maneger" class="parent_popup" >
          <div id="popup" class="popup" style="width:400px;left:40%;">
            <div id='errorMesAdd' style='display="none";'>
            </div>
            <h2>Внесення нового керівника</h2>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Прізвище І.Б.</div>
              <div class="navigation_right"><input align="right" type="text" id="text_pib" maxlength="250" name="text_pib" style="width:250px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Відділ</div>
              <div class="navigation_right"><select id="depatment_id"  style="width:250px;text-align:center;"><select></div>
            </p>
            <div class="clr"></div>
            <div>
              <p align="center">
                <input type="button" value="Скасувати" class="button" onclick="showHide('add_maneger');" />
                <input type="button" value="Зберегти" class="button" onclick="addAdres('add')" />
              </p>
            </div>
          </div>
        </div>


        <form name="adminForm" action="manegers.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" id="limitstart" name="limitstart" value="0"/>
          <input type="hidden" id="limit" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />

          <div class="item_blue" style="float:left;margin-left:40%; width:320px;">
  	        <p>
          	   <div class="navigation_left">Пошук по "П.І.Б."</div>
               <div class="navigation_right"><input align="right" type="text" id="filtr_pib"  name="filtr_pib" value="<?php echo $filtr_pib; ?>" style="width:160px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <p>
          	   <div class="navigation_left">Пошук по відділу</div>
               <div class="navigation_right"> <select name="filtr_dep"  id="filtr_dep" style="width:160px;text-align:center;" ><? echo $list_department; ?></select></div>
            </p>
            <div class="clr"></div>

            <p align="center">
  	          <input type="button" value="Пошук" class="button" onclick="submitForm('')" />
              <input type="button" value="Додати" id="addBtn" class="button" onclick="openAddMeneget();" />
              <input type="button" value="Зберегти" id="saveBtn" class="button" disabled=true onclick="submitForm('edit')" />
  	        </p>
  	    	</div>

          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){ ?>
          <div align="center">
            <table id="table_id">
              <tr>
                <th>&nbsp;</th>
                <th>П.І.Б.</th>
                <th>відділ</th>
                <th>Не активний</th>
              </tr>
            <? foreach ($ListResult as $key => $value) {
                echo "<tr id=\"".$value['id']."\"  ".(($value['dead']==1)?"class=\"notactive\"":"").">";
                echo "<td style =\" overflow:visible\" > <input type=\"checkbox\"  name=\"checkList[]\" value=\"".$value["id"]."\" onclick=\"return false\" /></td>";
                echo "<td style =\" overflow:hidden;\" >".$value["nu"]."</td>";
                echo "<td style =\" overflow:hidden;\" > <select id=\"li_".$value['id']."\" name=\"depSelect[".$value['id']."]\" ".(($value['dead']==1)?"disabled":"")." onchange=\"chacheCheck(".$value['id'].");\">".$value["ld"]."</select></td>";
                echo "<td style =\" overflow:hidden;\" > <input type=\"checkbox\" id=\"ch_".$value['id']."\" name=\"checkDead[".$value["id"]."]\"  onchange=\"chacheCheck(".$value['id'].");\" ".(($value['dead']==1)?"checked":"")."   /></td>";
                echo"</tr>";
              }
        } ?>
          </table>
        </div>
        </form>
     </div>

	  </div>

</div><!-- .wrapper -->
  <div id="paginatorT">
      <? if(isset($pagination)) echo $pagination; ?>
  </div>
<div class="footer">
	 <?php  require_once('footer.php'); ?>
</div>
  <div id="toTop" > ^ Наверх </div>
</body>
</html>
