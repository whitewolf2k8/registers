<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/pag.css" media="screen" type="text/css" />
<title>Головна</title>
<link rel="shortcut icon" href="../../../images/favicon.png" type="image/png">


<script src="../../../js/jquery-1.7.2.js"></script>
<script src="../../../js/scripts.js"></script>
<script type="text/javascript">

$(document).ready(function() {
  $("#filtr_kodu").ForceNumericOnly();
});

function submitForm(mode) {
  correct = true;
  form = document.forms['adminForm'];
  if(mode=='import'){
    if (form.fileImp.value=="") {
      correct = false;
      text='';
      text+=' - введіть ваш логін; <br>'
      document.getElementById('fileImp').className="error";
      document.getElementById('errorMes').innerHTML="<p>Будь ласка оберіть файл :</p>"+text;
    }
  }
  if (correct) {
    form.mode.value = mode;
    var x = document.getElementsByName("limitstart");
      x[0].value=0;
    form.submit();
  }
}

function formList(arr) {
  var arrSize=count(arr);
  if(arrSize!=0) {
    var x = document.getElementsByName("filtr_region");
      if(x[0].getAttribute("disabled")){
        x[0].removeAttribute("disabled");
      }
      x[0].setAttribute("disabled","disabled");
      x[0].innerHTML = "";
      var opt = document.createElement('option');
      opt.value = "";
      opt.innerHTML = "- Всі -";
      x[0].appendChild(opt);
    for(var i = 0; i < arrSize; i++)
    {
      var opt = document.createElement('option');
      opt.value = arr[i].kod;
      opt.innerHTML = arr[i].nu;
      x[0].appendChild(opt);
    }
    if(x[0].getAttribute("disabled")){
      x[0].removeAttribute("disabled");
    }
  }
}


function updateLists(mode) {
  if(mode!="")
  {
    $.ajax({
     type: "POST",
     url: "order.php",
     data: {id:mode},
     scriptCharset: "CP1251",
     success: function(data){
         var res = JSON.parse(data);
         formList(res); // распарсим JSON
      }
   });
  }else{
    var x = document.getElementsByName("filtr_region");
    x[0].innerHTML = "";
    var opt = document.createElement('option');
    opt.value = "";
    opt.innerHTML = "- Всі -";
    x[0].appendChild(opt);
    x[0].setAttribute("disabled","disabled");
  }
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
        <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
        <h2>Довідник територій України</h2>

        <form name="adminForm" action="load_koatuu.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden"  name="limitstart" <? echo "value='".(($paginathionLimitStart==0)?"0":$paginathionLimitStart)."'"; ?>/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />
    			<div class="item_blue" style="float:left;margin-left:15%; width:300px;">
            <h2>Іморт файлу АРМ</h2>
            <p>Оберіть файл з розширення dbf</p>
            <p><input type="file" id="fileImp"  accept=".dbf" name="fileImp" style="width:256px" /></p>
            <p align="center">
              <input type="button" value="Імпортувати" class="button" onclick="submitForm('import')" />
            </p>
        	</div>

          <div class="item_blue" style="float:right;margin-right:15%; width:320px;">
  	        <h2>Пошук по довіднику територій</h2>
            <p align="center">
              <p>
            	   <div class="navigation_left">KODU</div>
                 <div class="navigation_right"><input type="text" maxlength="10" id="filtr_kodu" name="filtr_kodu" value="<?php echo $filtr_kodu; ?>" style="width:130px" /></div>
              </p>
              <div class="clr"></div>
              <p>
          	   <div class="navigation_left">Область</div>
                 <div class="navigation_right"><select name="filtr_obl" onchange="updateLists(this.options[this.selectedIndex].value)" style="width:130px" ><?php echo $filtr_obl; ?></select></div>
              </p>
               <div class="clr"></div>
               <p>
           	   <div class="navigation_left">Район</div>
                  <div class="navigation_right"><select name="filtr_region" <? echo (($filtr_obl_s!="")?'':'disabled="disabled";');?> style="width:130px" ><?php echo $filtr_region; ?></select></div>
               </p>
                <div class="clr"></div>
            </p>
              <div class="clr"></div>
            <p align="center">
  	          <input type="button" value="Пошук" class="button" onclick="submitForm('')" />
  	        </p>
  	    	</div>
          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){ ?>
          <div align="center">
            <table>
              <tr>
                <th rowspan="2">Код (te)</th>
                <th rowspan="2">Тип</th>
                <th colspan="2">Найменування</th>
              </tr>
              <tr>
                <th>Українмькою</th>
                <th>Російською</th>
              </tr>
            <? foreach ($ListResult as $key => $value) {
                echo "<tr>";
                echo "<td>".$value["te"]."</td>";
                echo "<td>".$value["np"]."</td>";
                echo "<td>".$value["nu"]."</td>";
                echo "<td>".$value["nr"]."</td>";
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
