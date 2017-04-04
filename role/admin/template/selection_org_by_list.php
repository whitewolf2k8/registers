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
<script src="../../../js/scripts.js"></script>
<script src="../../../js/script_select_org_by_list.js"></script>
<script type="text/javascript">
function submitForm(mode) {
  correct = true;
  form = document.forms['adminForm'];
  if(mode=='import'){
    if (form.fileImp.value=="") {
      correct = false;
      text='';
      text+=' - введіть ваш логін; <br>'
      document.getElementById('fileImp').className="error" ;
      document.getElementById('errorMes').innerHTML="<p>Форма була не повністю заповнена будь ласка :</p>"+text;
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
        <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
        <h2>Вибірка підприємств по файлу</h2>

        <form id="adminForm" name="adminForm" action="selection_org_by_list.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />

          <div id="centered" hidden>
            <input class="knob"   readonly  data-width="150" data-displayPrevious=true data-fgColor="#0d932e" data-skin="tron" data-thickness=".2" value="0">
          </div>

          <div id='errorM' style='display="none";margin-left:15%;'>	</div>
    			<div class="item_blue" style="float:left;margin-left:40%; width:320px;">
            <h2>Вибір файлу з підприємствами</h2>
            <p>Оберіть файл з розширення dbf</p>
            <p><input type="file" id="fileImp"  accept=".dbf" name="fileImp" style="width:256px" /></p>
            <p align="center">
              <input type="button" id="btnLoad" value="Зчитати файл" class="button" onclick="checkFile();" />
              <input type="button" id="btnCleanForm" value="Очистити форму" class="button" disabled="disabled"  onclick="cleanForm();" />
            </p>
        	</div>

          <div class="item_blue" id="fildsDiv" style="float:left;margin-left:33%; width:520px;visibility: hidden;" >
            <h2 style="text-align:center; cursor: pointer"  onclick="visibleFild();">Перелік полів для вивантаження. </h2>
            <h2 style="text-align:center;" id="counts" ></h2>
            <div id="unvis">
              <div id="fild_d">
              </div>
    	        <div class="clr"></div>
              <p align="center">
    	          <input type="button" value="Обрати всі " class="button" onclick="checkAllFild()" />
                <input type="button" value="Зняти всі" class="button" onclick="unCheckAllFild()" />
    	        </p>
            </div>
            <h2 style="text-align:center;" id="ErrrFild" ></h2>
            <div id="fild_er"></div>
            <h2 style="text-align:center;" id="NotFindFild" ></h2>
            <div id="fild_not_f" ></div>
            <p align="center">
              <input name="typeF" type="radio" value="dbf" checked > .dbf
              <input name="typeF" type="radio" value="exel"> .xls
              <input type="button" value="Експорт" class="button" onclick="exportTable();" />
            </p>
  	    	</div>
          <div id="lo"></div>
          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){ ?>
          <div align="center">
            <table id="tableOutput">


          </table>
        <? } ?>
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
