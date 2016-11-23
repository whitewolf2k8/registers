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

    var  chDead =  document.getElementById(id);
    var arrCheck=document.getElementsByName("checkList[]");
    var cnt=0;
    for(var i=0;i<arrCheck.length;i++){
      if(arrCheck[i].value==id){
        if(arrCheck[i].checked){


          if(document.getElementById('ch_'+id).checked){
            document.getElementById(id).className="notactive";
          }else{
            document.getElementById(id).className="";
          }
          arrCheck[i].checked=false;
        }else{
          arrCheck[i].checked=true;
          document.getElementById(id).className="changeData";
        }
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
    var nu = document.getElementById('text_depatment').value;
    var nom = document.getElementById('nom_depatment').value;
    nom=nom.replace(/[^-0-9]/gim,'');
    nu=nu.replace(/ +/g," ");
	  nu=nu.replace(/^\s*/,'').replace(/\s*$/,'');
    if(nu!="" && nom!="" ){
      $.ajax({
       type: "POST",
       url: "script\\processDepatment.php",
       data: {"mode":mode, "nu":nu ,"nom":nom },
       scriptCharset: "CP1251",
       success: function(data){
          var res = JSON.parse(data);
          document.getElementById('text_depatment').value="";
          document.getElementById('nom_depatment').value="";
          updateTable(res);
          showHide('add_depatment');
        }
     });
   }else{
     var er='';
     if(nu==""){
       er+="Не було введено назву відділу<br>";
     }
     if(nom==""){
       er+="Не було введено номер відділу<br>";
     }

     document.getElementById("errorMesAdd").innerHTML="<p class=\"error\">"+er+"</p>   <div class=\"clr\"></div>";
   }
  }



  function updateTable( arr ){
    var table = document.getElementById("table_id");
    var text='';
    table.innerHTML="";
    if(arr.length>0) text+="<tr><th>&nbsp;</th><th>Назва</th><th>Номер</th><th>Активність</th></tr>"
    for(var i=0; i<arr.length;i++){
      text+="<tr id=\""+arr[i].id+"\" "+((arr[i].dead==1)?"class=\"notactive\"":"")+">";
      text+="<td style =\" overflow:visible\" ><input type=\"checkbox\"  name=\"checkList[]\" value=\""+arr[i].id+"\" onclick=\"return false\" /></td>";
      text+="<td style =\" overflow:hidden;\" >"+arr[i].nu+"</td>";
      text+= "<td style =\" overflow:hidden;\" >"+arr[i].nom+"</td>";
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

        <h2>Довідник відділів</h2>

        <div id="add_depatment" class="parent_popup" >
          <div id="popup" class="popup" style="width:400px;left:40%;">
            <div id='errorMesAdd' style='display="none";'>
            </div>
            <h2>Внесення нового відділу</h2>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Назва віддулу</div>
              <div class="navigation_right"><input align="right" type="text" id="text_depatment" maxlength="250" name="text_depatment" style="width:250px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Номер віддулу</div>
              <div class="navigation_right"><input align="right" type="text" maxlength="4"  id="nom_depatment" maxlength="250" name="nom_depatment" style="width:250px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>

            <div>
              <p align="center">
                <input type="button" value="Скасувати" class="button" onclick="showHide('add_depatment');document.getElementById('errorMesAdd').innerHTML='';" />
                <input type="button" value="Зберегти" class="button" onclick="addAdres('add')" />
              </p>
            </div>
          </div>
        </div>

        <form name="adminForm" action="department.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />

          <div class="item_blue" style="float:left;margin-left:40%; width:320px;">
  	        <p>
          	   <div class="navigation_left">Пошук по назві</div>
               <div class="navigation_right"><input align="right" type="text" id="filtr_nu"  name="filtr_nu" value="<?php echo $filtr_nu; ?>" style="width:160px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <div class="clr"></div>
            <p align="center">
  	          <input type="button" value="Пошук" class="button" onclick="submitForm('')" />
              <input type="button" value="Додати" id="addBtn" class="button" onclick="showHide('add_depatment')" />
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
                <th>Назва</th>
                <th>Номер</th>
                <th>Активність</th>
              </tr>
            <? foreach ($ListResult as $key => $value) {
                echo "<tr id=\"".$value['id']."\"  ".(($value['dead']==1)?"class=\"notactive\"":"").">";
                echo "<td style =\" overflow:visible\" > <input type=\"checkbox\"  name=\"checkList[]\" value=\"".$value["id"]."\" onclick=\"return false\" /></td>";
                echo "<td style =\" overflow:hidden;\" >".$value["nu"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["nom"]."</td>";
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
