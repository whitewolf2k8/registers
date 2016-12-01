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
    if (correct) {
      document.getElementById('lo').innerHTML='<div id="preloader"></div>';
      form.mode.value = mode;
      var x = document.getElementsByName("limitstart");
        x[0].value=0;
      form.submit();
    }
  }

  function cleanFiter() {
    document.getElementById("filtr_deal_number").value="";
    document.getElementById("filtr_kd").value="";
    document.getElementById("filtr_kdmo").value="";
    var lists= document.getElementById("filtr_type_deal");
    lists.selectedIndex=0;
    document.getElementById("filtr_date_deal").value="";
  }

  function cleanFormImport() {
    document.getElementById("fileImp").value="";
  }
  $(document).ready(function() {
    $("#filtr_kd").ForceNumericOnly();
    $("#filtr_kdmo").ForceNumericOnly();
  });
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

        <h2>Дані про перебування юридичної особи в процесі провадження у справі про банкрутство, санації</h2>

        <form name="adminForm" action="load_bankrut.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />

          <div class="item_blue" style="float:left;margin-left:15%; width:300px;">
            <h2>Завантаження файлу</h2>
            <p><input type="file" id="fileImp"  accept=".csv" name="fileImp" style="width:256px" /></p>
            <p style="text-align:center"></p>
            <p>

               <div class="navigation_right">

               </div>
            </p>
            <div class="clr"></div>
            <p>

               <div class="navigation_right">

               </div>
            </p>
            <div class="clr"></div>
            <p align="center">
              <input type="button" value="Очистити" class="button" onclick="cleanFormImport()" />
              <input type="button" value="Завантажити" class="button" onclick="submitForm('import')" />
            </p>
          </div>

          <div class="item_blue" style="float:right;margin-right:15%; width:350px;">
  	        <h2>Пошук</h2>
            <p>
          	   <div class="navigation_left">Пошук по "Kd"</div>
               <div class="navigation_right"><input align="right" type="text" id="filtr_kd"  name="filtr_kd" value="<?php echo $filtr_kd; ?>" style="width:180px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <p>
               <div class="navigation_left">Пошук по "Kdmo"</div>
               <div class="navigation_right"><input align="right" type="text" id="filtr_kdmo" name="filtr_kdmo" value="<?php echo $filtr_kdmo; ?>" style="width:180px;text-align:center;" /></div>
            </p>

            <div class="clr"></div>
            <p>
               <div class="navigation_left">№ справи</div>
               <div class="navigation_right"><input align="right" type="text" id="filtr_deal_number"  name="filtr_deal_number" value="<?php echo $filtr_deal_number; ?>" style="width:180px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <p>
               <div class="navigation_left">Дата порушення</div>
               <div class="navigation_right"><input align="right" type="text" id="filtr_date_deal"  name="filtr_date_deal" value="<?php echo $filtr_date_deal; ?>" style="width:180px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <p>
               <div class="navigation_left">Стадія провадження</div>
               <div class="navigation_right"> <select name="filtr_type_deal"  id="filtr_type_deal" style="width:180px;text-align:center;" ><? echo $list_bankrupts; ?></select></div>
            </p>
            <div class="clr"></div>
            <p align="center">
              <input type="button" value="Пошук" class="button" onclick="submitForm('')" />
              <input type="button" value="Очистити" class="button" onclick="cleanFiter()" />
  	        </p>
  	    	</div>

          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){ ?>
          <div id="table_id" align="center">
            <table>
              <tr>
                <th>ЄДРПО</th>
                <th>КДМО</th>
                <th>Арбітражний керуючий</th>
                <th>№ справи</th>
                <th>Дата порушення</th>
                <th>Стадія провадження</th>
              </tr>
            <? foreach ($ListResult as $key => $value) {
                echo "<tr>";
                echo "<td style =\" overflow:hidden;\" >".$value["kd"]."</td>";
                echo "<td style =\" overflow:hidden;white-space:nowrap;\" >".$value["kdmo"]." ".$value[""]."</td>";
                echo "<td style =\" overflow:hidden;white-space:nowrap;\" >".$value["maneger_deal"]." ".$value[""]."</td>";
                echo "<td style =\" overflow:hidden;white-space:nowrap;\" >".$value["deal_number"]." ".$value[""]."</td>";
                echo "<td style =\" overflow:hidden;white-space:nowrap;\" >".$value["date_deal"]." ".$value[""]."</td>";
                echo "<td style =\" overflow:hidden;white-space:nowrap;\" >".$value["type_deal"]." ".$value[""]."</td>";
                echo"</tr>";
              } ?>
              </table>
            </div>
        <? } ?>

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
