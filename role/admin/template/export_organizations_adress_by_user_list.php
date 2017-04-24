<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/pag.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../jquery-ui-1.12.1.custom/jquery-ui.css" media="screen" type="text/css" />
<title>Головна</title>
<link rel="shortcut icon" href="../../../images/favicon.png" type="image/png">

<style>
  .spoiler-body span {
    padding-left:30px;
    padding-right:30px;
  }

</style>
<script src="../../../js/jquery-1.7.2.js"></script>
<script src="../../../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src="../../../js/knob.js"></script>
<script src="../../../js/scripts.js"></script>
<script src="../../../js/script_export_adres_org_by_user_list.js"></script>
<script type="text/javascript">
  function submitForm(mode) {
    correct = true;
    form = document.forms['adminForm'];
    document.getElementById("kveds").value=getKveds();
    document.getElementById("kises").value=getKises();
    document.getElementById("controlArr").value=getControls();
    if (correct) {
      document.getElementById('lo').innerHTML='<div id="preloader"></div>';
      form.mode.value = mode;
      var x = document.getElementsByName("limitstart");
        x[0].value=0;
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
        <h2>Вибірка фактичних адрес підприємств по обраним респонентам </h2>
        <div id='errorMes' style='display="none"'>
      		    <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
      	</div>
        <form name="adminForm" id="adminForm" action="export_organizations_adress_by_user_list.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />

          <input type="hidden" id ="controlArr" name="controlArr" <? echo "value='".$filtr_Contols."'"; ?> />

          <div id="centered" hidden>
            <input class="knob"   readonly  data-width="150" data-displayPrevious=true data-fgColor="#0d932e" data-skin="tron" data-thickness=".2" value="0">
          </div>

          <div class="item_blue" style="position: relative; width: 880px; left: 50%; margin-left: -440px;">
            <div id='errorM' style='display="none"; argin-left:15%;'>	</div>
            <h2 style="text-align:center;" >Вибірка по  підприємствам :</h2>
            <p class="act_add">
              <input type="hidden" id="orgid"/>
              <span>ЄДРПОУ<input type="text"  maxlength="8" placeholder="ЄДРПОУ" id="kd" style="width:80px;" /></span>
              <span>КДМО<input type="text" placeholder="КДМО" maxlength="12" id="kdmo" style="width:110px;"/> </span>
              <span>Назва <input type="text" id="nuOrg"  placeholder="Назва підприємства" readonly  style=" width:350px;" /> </span>
              <span><input type="button"  class="button" value="Пошук" onclick="searhOrg()"/></span>
              <span><input type="button" id="btnAddOrg" name="add_type" class="btn_add" disabled  onclick="addToListOrg();"/> </span>
            </p>
            <p align="center">
              <div  id='orgList' style="text-align:center;"></div>
            </p>
            <div class="clr"></div>
            <p align="center">
              <input name="typeF" id="Ch1" type="radio" value="dbf"  disabled checked > .dbf
              <input name="typeF" id="Ch2" type="radio" value="exel" disabled > .xls
              <input type="button" id="btEx" value="Експорт" class="button" disabled onclick="exportTable();" />
              <input type="button" value="Очистити" class="button" onclick="cleanForm();" />
            </p>

          </div>
          <div class="clr"></div>
          <div id="lo"></div>

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
