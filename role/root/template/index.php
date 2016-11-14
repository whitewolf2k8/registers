<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/modal-contact-form.css" media="screen" type="text/css" />
<title>Головна</title>
<link rel="shortcut icon" href="/images/favicon.png" type="image/png">

<script src="../../../js/jquery-1.7.2.js"></script>
<script src="../../../js/scripts.js"></script>
<script src="../../../js/script_fact_adress.js"></script>
<script type="text/javascript">
  function submitForm(mode) {
    correct = true;
    form = document.forms['adminForm'];

    if (form.filtr_edrpou.value==""&&form.filtr_kdmo.value=="") {
      correct = false;
      text='';
      text+=' Введіть код ЄДРПОУ або КДМО. <br>'
      document.getElementById('errorMes').className="error";
      document.getElementById('errorMes').innerHTML=text;
    }

    if (correct) {
    //  document.getElementById('lo').innerHTML='<div id="preloader"></div>';
      form.submit();
    }
  }

  function buttonDisplay(){
    var chk_arr =  document.getElementsByName("sections[]");
    var chklength = chk_arr.length;
    var count=0;
    for(k=0;k< chklength;k++)
    {
        if(chk_arr[k].checked){
          count++;
        }
    }
    if(count==0){
        document.getElementById("delButton").disabled=true;
    }else{
        document.getElementById("delButton").disabled=false;
    }
  }

  function fillChangeForm(arr) {
    var arrSize=count(arr);
    if(arrSize!=0) {
      var fruits = [ "Root","Администратор","Користувач"];
      var x = document.getElementById("typeCh");
      x.innerHTML = "";
      var opt = document.createElement('option');
      opt.value = "";
      opt.innerHTML = "- Всі -";
      x.appendChild(opt);
      for(var i = 0; i < 3; i++)
      {
        var opt = document.createElement('option');
        opt.value = i;
        opt.innerHTML = fruits[i];
        if((arr[0].type)==i){
          opt.selected = true;
        }
        x.appendChild(opt);
      }
      var name = document.getElementById("loginCh").value=arr[0].login;
      var pas = document.getElementById("passCh").value=arr[0].pass;
      document.getElementById("pathCh").value=arr[0].locathion;
      document.getElementById("idRow").value=arr[0].id;
    }
  }

  function editUser(id) {
    $.ajax({
     type: "POST",
     url: "script\\processUser.php",
     data: {mode:"get", idRow:id,"arrS":getSelectOption()},
     scriptCharset: "CP1251",
     success: function(data){
         var res = JSON.parse(data);
         fillChangeForm(res);
      }
   });
    showHide("userChange");
  }


  function changeUser() {
    var id = document.getElementById("idRow").value;
    var name = document.getElementById("loginCh").value;
    var pas = document.getElementById("passCh").value;
    var path = document.getElementById("pathCh").value;
    var x = document.getElementById("typeCh");
    var type = x.options[x.selectedIndex].value;
    var er = checkChange(name, pas, path, type);
    if(er==""){
      $.ajax({
       type: "POST",
       url: "script\\processUser.php",
       data: {mode:"update", idRow:id, "name":name, "pass":pas, "path":path, "type":type, "arrS":getSelectOption()},
       scriptCharset: "CP1251",
       success: function(data){
           var res = JSON.parse(data);
           updateTable(res);
           showHide("userChange");
        }
     });
    }else{
      var x=document.getElementById("errorMesCh");
      x.innerHTML="";
      x.innerHTML = "<p class=\"error\">"+er+"<div class=\"clr\"></div>";
    }
  }

  function checkChange(name, pass,path,type) {
    var result="";
    if((name.replace(/^\s*(.*)\s*$/, '$1'))==""){
      result+="Логін не може бути пустим!<br>";
    }
    if((pass.replace(/^\s*(.*)\s*$/, '$1'))==""){
      result+="Пароль повинен містити символи!<br>";
    }
    if((path.replace(/^\s*(.*)\s*$/, '$1'))==""){
      result+="Шлях перенаправлення повинен бути заповненим!<br>";
    }
    if(type==""){
      result+="Користувач повинен входити в одну із груп користувачів.<br>";
    }
    return result;
  }


  function updateTable(arr){
    var arrSize=count(arr);
      var table= document.getElementById("tableDiv");
      var htmlText="<tr>"
          +"<table><th>&nbsp;</th>"
          +"<th>id</th>"
          +"<th>Логін</th>"
          +"<th>Пароль(MD5)</th>"
          +"<th>Шлях</th>"
          +"<th>Тип</th>"
          +"<th>Назва типу</th>"
          +"<th>&nbsp;</th>"
          +"</tr>";
      for (var i = 0; i < arrSize; i++) {
        htmlText+="<tr>";
        htmlText+="<td> <input type=\"checkbox\" name=\"sections[]\" value="+arr[i].id+"  onchange=\"buttonDisplay()\" /></td>";
        htmlText+="<td>"+arr[i].id+"</td>";
        htmlText+="<td>"+arr[i].login+"</td>";
        htmlText+="<td>"+arr[i].pass+"</td>";
        htmlText+="<td>"+arr[i].locathion+"</td>";
        htmlText+="<td>"+arr[i].type+"</td>";
        htmlText+="<td>"+arr[i].typeNu+"</td>";
        htmlText+="<td><input type=\"button\" value=\"\" class=\"btn_edit\"  onclick=\"editUser('"+arr[i].id+"');\"/></td></tr>";
      }
      htmlText+="</table>"
      table.innerHTML=htmlText;
  }


  function openFormAdd(){
    document.getElementById("idRow").value="";
    document.getElementById("loginAdd").value="";
    document.getElementById("passAdd").value="";
    document.getElementById("pathAdd").value="";
    var x=document.getElementById("typeAdd");
    var fruits = [ "Root","Администратор","Користувач"];
    x.innerHTML= "";
    x.innerHTML+="<option value=\"\" selected >- Всі -</option>";
    for(var i = 0; i < 3; i++)
    {
      x.innerHTML+="<option value=\""+i+"\">"+fruits[i]+"</option>";
    }
    showHide("userAdd");
  }

  function addUser(){
    var name = document.getElementById("loginAdd").value;
    var pas = document.getElementById("passAdd").value;
    var path = document.getElementById("pathAdd").value;
    var x = document.getElementById("typeAdd");
    var type = x.options[x.selectedIndex].value;
    var er = checkChange(name, pas, path, type);
    if(er==""){
      $.ajax({
       type: "POST",
       url: "script\\processUser.php",
       data: {mode:"add", "name":name, "pass":pas, "path":path, "type":type, "arrS":getSelectOption()},
       scriptCharset: "CP1251",
       success: function(data){
           var res = JSON.parse(data);
           updateTable(res);
           showHide("userAdd");
        }
     });
    }else{
      var v = document.getElementById('errorMesAdd');
      v.innerHTML="";
      v.innerHTML = "<p class=\"error\">"+er+"<div class=\"clr\"></div>";
    }
  }

  function delUser() {
    var chk_arr =  document.getElementsByName("sections[]");
    var chklength = chk_arr.length;
    var count=0;
    var arr = [];
    for(k=0;k< chklength;k++)
    {
        if(chk_arr[k].checked){
          arr.push(chk_arr[k].value);
          count++;
        }
    }
    alert(count);
    $.ajax({
     type: "POST",
     url: "script\\processUser.php",
     data: {mode:"del", "arr":arr, "arrS":getSelectOption()},
     scriptCharset: "CP1251",
     success: function(data){
         var res = JSON.parse(data);
         updateTable(res);
         //showHide("userAdd");
       }
   });
  }

  function getSelectOption() {
    var arr=[];
    arr.push(document.getElementById("loginS").value);
    var x = document.getElementById("typeS");
    arr.push(x.options[x.selectedIndex].value);
    return arr;
  }

  function searchUser() {
    $.ajax({
     type: "POST",
     url: "script\\processUser.php",
     data: {mode:"", "arrS":getSelectOption()},
     scriptCharset: "CP1251",
     success: function(data){
         var res = JSON.parse(data);
         updateTable(res);
         //showHide("userAdd");
       }
   });
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

        <div id="userChange" class="parent_popup" >
          <div id="popup" class="popup" style="width:400px;left:40%;">
            <div id='errorMesCh' style='display="none";'></div>
            <input type="hidden" id="idRow" name="idRow" />
              <h2>Редагувати дані користувача</h2>
            <div class="clr"></div>
            <div id="typeC"> </div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Логін</div>
              <div class="navigation_right">
                <input align="right" type="text" id="loginCh" maxlength="250" name="loginCh" style="width:300px;text-align:center;" />
              </div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Пароль</div>
              <div class="navigation_right">
                <input align="right" type="text" id="passCh"  name="passCh" style="width:300px;text-align:center;" />
              </div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Пере адресація</div>
              <div class="navigation_right">
                <input align="right" type="text" id="pathCh" maxlength="250" name="pathCh" style="width:250px;text-align:center;" />
              </div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Тип</div>
              <div class="navigation_right">
                <select id='typeCh' onchange="" style="text-align:center; width:250px;"></select>
              </div>
            </p>
            <div class="clr"></div>
            <div>
              <p align="center">
                <input type="button" value="Скасувати" class="button" onclick="showHide('userChange');" />
                <input type="button" value="Зберегти" id="btContactCh" class="button" onclick="changeUser();" />
              </p>
            </div>
          </div>
        </div>




        <div id="userAdd" class="parent_popup" >
          <div id="popup" class="popup" style="width:400px;left:40%;">
            <div id='errorMesAdd' style='display="none";'></div>

            <h2>Додати користувача</h2>
            <div class="clr"></div>
            <div id="typeC"> </div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Логін</div>
              <div class="navigation_right">
                <input align="right" type="text" id="loginAdd" maxlength="250" style="width:300px;text-align:center;" />
              </div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Пароль</div>
              <div class="navigation_right">
                <input align="right" type="text" id="passAdd" style="width:300px;text-align:center;" />
              </div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Пере адресація</div>
              <div class="navigation_right">
                <input align="right" type="text" id="pathAdd" maxlength="250" name="pathCh" style="width:250px;text-align:center;" />
              </div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Тип</div>
              <div class="navigation_right">
                <select id='typeAdd' onchange="" style="text-align:center; width:250px;"></select>
              </div>
            </p>
            <div class="clr"></div>
            <div>
              <p align="center">
                <input type="button" value="Скасувати" class="button" onclick="showHide('userAdd');" />
                <input type="button" value="Зберегти" id="btContactCh" class="button" onclick="addUser();" />
              </p>
            </div>
          </div>
        </div>


        <form name="adminForm" action="index.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <h2>Перелік користувачів системи</h2>
          <div class="item_blue" style="float:right;margin-right:35%; width:320px;">
            <h2>Пошук користувачів</h2>
            <p align="center">
              <p>
                 <div class="navigation_left">Пошук по логіну:</div>
                 <div class="navigation_right"><input type="text" id="loginS" name="loginS" value="<?php echo $filtr_login; ?>" style="width:185px" /></div>
              </p>
               <div class="clr"></div>
              <p>
                 <div class="navigation_left">Пошук по ролі:</div>
                 <div class="navigation_right"><select id="typeS" name="typeS" style="width:200px;"><?php echo $list_role_kategory; ?></select></div>
              </p>
            </p>
              <div class="clr"></div>
            <p align="center">
              <input type="button" value="Пошук" class="button" onclick="searchUser()" />
              <input type="button" value="Додати" class="button" onclick="openFormAdd();" />
              <input type="button" id="delButton" disabled value="Видатили" class="button" onclick="delUser()" />
            </p>
          </div>

          <div class="clr"></div>
          <div id="lo"></div>

          <? if(isset($lists)){ ?>
            <div  id="tableDiv" align="center">
              <table>
                <tr>
                  <th>&nbsp;</th>
                  <th>id</th>
                  <th>Логін</th>
                  <th>Пароль(MD5)</th>
                  <th>Шлях</th>
                  <th>Тип</th>
                  <th>Назва типу</th>
                  <th>&nbsp;</th>
                </tr>
              <? foreach ($lists as $key => $value) {
                # code...
                  echo "<tr>";
                  echo "<td> <input type=\"checkbox\" name=\"sections[]\" value=".$value["id"]." onchange=\"buttonDisplay()\" /></td>";
                  echo "<td>".$value["id"]."</td>";
                  echo "<td>".$value["login"]."</td>";
                  echo "<td>".$value["pass"]."</td>";
                  echo "<td>".$value["locathion"]."</td>";
                  echo "<td>".$value["type"]."</td>";
                  echo "<td>".$value["typeNu"]."</td>";
                  echo "<td><input type=\"button\" value=\"\" class=\"btn_edit\"  onclick=\"editUser('".$value['id']."');\"/></td>";
                  echo"</tr>";
                }
             ?>
            </table>
          </div>
        <?  } ?>
          </form>
      </div>
	  </div><!-- .content -->
  </div><!-- .wrapper -->

<div class="footer">
	 <?php  require_once('footer.php'); ?>
</div>

<!--  <H2>Зарегестрировался Урааа </H2>
  <?
  //  echo $_SESSION['name'];
  ?>
  !-->
</body>
</html>
