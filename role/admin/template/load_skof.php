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


  $(document).ready(function() {
    $("#filtr_kd_opf").ForceNumericOnly();
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
        <div id='errorMes' style='display="none"'  <? if($ERROR_MSG!=""){echo "class='error'";}?> >
      		    <?php if ($ERROR_MSG != '') echo '<p >'.$ERROR_MSG.'</p>';?>
      	</div>

        <h2>Довідник OПФ </h2>

        <form name="adminForm" action="load_skof.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />
    			<div class="item_blue" style="float:left;margin-left:15%; width:300px;">
            <h2>Іморт файлу</h2>
            <p>Оберіть файл з розширення dbf</p>
            <p><input type="file" id="fileImp"  accept=".dbf" name="fileImp" style="width:256px" /></p>
            <p align="center">
              <input type="button" value="Імпортувати" class="button" onclick="submitForm('import')" />
            </p>
        	</div>

          <div class="item_blue" style="float:right;margin-right:15%; width:320px;">
  	        <h2>Пошук по довіднику СКОФ</h2>
            <p align="center">
              <p>
            	   <div class="navigation_left">Пошук по "Kd"</div>
                 <div class="navigation_right"><input align="right" type="text" id="filtr_kd_opf" maxlength="3" name="filtr_kd_opf" value="<?php echo $filtr_kd; ?>" style="width:130px;text-align:center;" /></div>
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
                <th>Код</th>
                <th>Назва</th>
              </tr>

            <? foreach ($ListResult as $key => $value) {
              # code...
                echo "<tr>";
                echo "<td>".$value["kod"]."</td>";
                echo "<td>".$value["nu"]."</td>";
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
