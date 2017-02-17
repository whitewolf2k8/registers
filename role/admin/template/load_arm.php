  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<title>Головна</title>
<link rel="shortcut icon" href="/images/favicon.png" type="image/png">

<script src="../../../js/jquery-1.7.2.js"></script>
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
    form.submit();
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
        <div id='errorMes' style='display="none"'>
              <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
        </div>

        <h2>Імпорт довідників організацій</h2>

        <form name="adminForm" action="load_arm.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <div class="item_blue" style="float:left;margin-left:5%;width:256px;">
            <h2>Іморт файлу АРМ</h2>
            <p>Оберіть файл з розширення dbf</p>
            <p><input type="file" id="fileImp"  accept="db" name="fileImp" style="width:256px" /></p>
            <p align="center">
              <input type="button" value="Імпортувати" class="button" onclick="submitForm('import')" />
              <input type="button" value="Експорт" class="button" onclick="submitForm('export')" />
            </p>
        	</div>

          <div class="item_blue" style="float:left;margin-left:5%;width:265px;">
            <h2>Іморт файлу з форми Фінансова звітність</h2>
            <p>Оберіть файл з розширення dbf</p>
            <p><input type="file" id="fileImpKdFin"  accept="db" name="fileImpKdFin" style="width:256px" /></p>
            <p align="center">
              <input type="button" value="Імпортувати" class="button" onclick="submitForm('importKdFin')" />
              <input type="button" value="Експорт" class="button" onclick="submitForm('export')" />
            </p>
          </div>

          <div class="item_blue" style="float:left;margin-left:5%; width:265px;">
  	        <h2>Іморт файлу MONOKD</h2>
  	        <p>Оберіть файл з розширення dbf</p>
  	        <p><input type="file" id="fileImpKd"  accept="db" name="fileImpKd" style="width:256px" /></p>
  	        <p align="center">
  	          <input type="button" value="Імпортувати" class="button" onclick="submitForm('importKd')" />
  	          <input type="button" value="Експорт" class="button" onclick="submitForm('export')" />
  	        </p>
  	    	</div>

          <div class="item_blue" style="float:left;margin-left:5%; width:265px;">
            <h2>Іморт файлу Контактів підприємства</h2>
            <p>Оберіть файл з розширення dbf</p>
            <p><input type="file" id="fileImpContact"  accept="db" name="fileImpContact" style="width:256px" /></p>
            <p align="center">
              <input type="button" value="Імпортувати" class="button" onclick="submitForm('importContact')" />
              <input type="button" value="Експорт" class="button" onclick="submitForm('export')" />
            </p>
          </div>

        <div class="clr"></div>
				<div id="lo"></div>
        </form>
      </div>
	  </div><!-- .content -->

  </div><!-- .wrapper -->

<div class="footer">
	 <?php  require_once('footer.php'); ?>
</div>
<div id="toTop" > ^ Наверх </div>
</body>
</html>
