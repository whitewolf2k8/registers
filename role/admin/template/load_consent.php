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
<script src="../../../js/knob.js"></script>
<script src="../../../js/script_consent_process.js"></script>
<script type="text/javascript">
function submitForm(mode) {
  correct = true;
  form = document.forms['adminForm'];
  if (correct) {
    var x = document.getElementsByName("limitstart");
      x[0].value=0;
    form.submit();
  }
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
        <h2>Ознака активності за даними ДФС</h2>
        <div id='errorMes' style='display="none"'  <? if($ERROR_MSG!=""){echo "class='error'";}?> >
      		    <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
      	</div>
        <form name="adminForm" id="adminForm" action="load_consent.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" id="limitstart" name="limitstart" value="0"/>
          <input type="hidden" id="limit" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />

          <div class="item_blue" style="float:left;margin-left:15%; width:300px;">
            <h2>Іморт файлу</h2>
            <p><input type="file" id="fileImp"  accept=".csv" name="fileImp" style="width:256px" /></p>
            <p style="text-align:center">Період за який  імпортується</p>
            <p>
               <div class="navigation_left">рік</div>
               <div class="navigation_right">
                  <select id="filtr_year_insert" name="filtr_year_insert" style="width:200px;text-align:center;"><? echo $insert_year; ?></select>
               </div>
            </p>
            <div class="clr"></div>
            <p align="center">
              <input type="button" value="Імпортувати" class="button" onclick="inmportInformathion()" />
              <input type="button" value="Очистити" class="button" onclick="cleanImport();" />
            </p>
        	</div>

          <div class="item_blue" style="float:right;margin-right:15%; width:280px;">
  	        <h2>Пошук по </h2>
            <p align="center">
            	   <div class="navigation_left">Коду ЄДРПОУ</div>
                 <div class="navigation_right"><input align="right" type="text" id="filtr_kd"  name="filtr_kd" value="<?php echo $filtr_kd; ?>" style="width:150px;text-align:center;" /></div>
              <div class="clr"></div>
            </p>
            <p align="center">
            	   <div class="navigation_left">Коду КДМО</div>
                 <div class="navigation_right"><input align="right" type="text" id="filtr_kdmo" name="filtr_kdmo" value="<?php echo $filtr_kdmo; ?>" style="width:150px;text-align:center;" /></div>
              <div class="clr"></div>
            </p>
            <p style="text-align:center">Періоду за який  імпортувалося</p>
            <p>
               <div class="navigation_left">рік</div>
               <div class="navigation_right">
                  <select id="filtr_year_select" name="filtr_year_select" style="width:200px;text-align:center;"><? echo $select_year; ?></select>
               </div>
            </p>
            <div class="clr"></div>

            <p align="center">
    	        <input type="button" value="Пошук" class="button" onclick="submitForm('')"/>
    	      </p>
          </div>
          <div class="clr"></div>
          <div id="lo"></div>
          <div id="centered" hidden>
            <input class="knob"   readonly  data-width="150" data-displayPrevious=true data-fgColor="#0d932e" data-skin="tron" data-thickness=".2" value="0">
          </div>
        <? if(isset($ListResult)){ ?>
          <div align="center">
            <table id='table_id' >
              <tr>
                <th>ЄДРПОУ</th>
                <th>КДМО</th>
                <th>Назва</th>
                <th>Рік імпорту</th>
                <th>Ознака активності</th>
              </tr>

            <? foreach ($ListResult as $key => $value) {
                echo "<tr>";
                echo "<td>".$value["kd"]."</td>";
                echo "<td>".$value["kdmo"]."</td>";
                echo "<td>".$value["nu"]."</td>";
                echo "<td>".$value["Nuperiod"]."</td>";
                echo "<td>".$value["type"]."</td>";
                echo"</tr>";
              }
        } ?>
          </table>
        </div>
      </form>
     </div>
	  </div>
</div>
  <div id="paginatorT">

      <? if(isset($pagination)) echo $pagination; ?>

  </div>
<div class="footer">
	 <?php  require_once('footer.php'); ?>
</div>
  <div id="toTop" > ^ Наверх </div>
</body>
</html>
