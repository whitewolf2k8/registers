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
<script src="../../../js/script_select_org_by_user_list.js"></script>
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
        <h2>Експорт підприємств по списку</h2>
        <div id='errorMes' style='display="none"'>
      		    <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
      	</div>
        <form name="adminForm" id="adminForm" action="picks_organizations.php" method="post" enctype="multipart/form-data">
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
            <h5 class="spoiler-title">Перлік полів для перегляду/експорту </h5>
            <div class="spoiler-body">
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_1" name="fildList[]" value="kd" <? echo (in_array('kd',$arrfild))?"checked":""; ?> >&nbsp;<font>kd</font> - ідентифікаційний код субєкту
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_2" name="fildList[]" value="kdmo" <? echo (in_array('kdmo',$arrfild))?"checked":""; ?> >&nbsp; <font>kdmo</font> - ідентифікаційний код місцевої одиниці
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_3" name="fildList[]" value="nu" <? echo (in_array('nu',$arrfild))?"checked":""; ?> >&nbsp; <font>nu</font> - найменування субєкту
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_4" name="fildList[]" value="pk" <? echo (in_array('pk',$arrfild))?"checked":""; ?> >&nbsp; <font>pk</font>- прізвище керівника
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_5" name="fildList[]" value="kdg" <? echo (in_array('kdg',$arrfild))?"checked":""; ?> >&nbsp;<font>kdg</font>- код головного підприємства
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_6" name="fildList[]" value="te" <? echo (in_array('te',$arrfild))?"checked":""; ?> >&nbsp;<font>te</font>- код території за КОАТУУ
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_7" name="fildList[]" value="tea" <? echo (in_array('tea',$arrfild))?"checked":""; ?>  >&nbsp; <font>tea</font> - адміністративно територіальна належність
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_8" name="fildList[]" value="ad" <? echo (in_array('ad',$arrfild))?"checked":""; ?>  >&nbsp;<font>ad</font> - адреса
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_9" name="fildList[]" value="pi" <? echo (in_array('pi',$arrfild))?"checked":""; ?> >&nbsp;<font>pi</font> - поштовий індекс
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_10" name="fildList[]" value="pf" <? echo (in_array('pf',$arrfild))?"checked":""; ?> >&nbsp;<font>pf</font>- код організаційно-правової форми
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_11" name="fildList[]" value="pf_nu" <? echo (in_array('pf_nu',$arrfild))?"checked":""; ?> >&nbsp;<font>pf_nu</font>- назва коду організаційно-правової форми
                  </label>
                  &nbsp;
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_12" name="fildList[]" value="gu" <? echo (in_array('gu',$arrfild))?"checked":""; ?>  >&nbsp;<font>gu</font> - код органу управління
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_13" name="fildList[]" value="uo" <? echo (in_array('uo',$arrfild))?"checked":""; ?>  >&nbsp;<font>uo</font> - ознака особи
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_14" name="fildList[]" value="dl" <? echo (in_array('dl',$arrfild))?"checked":""; ?>  >&nbsp;<font>dl</font>- дата ліквідації
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_15" name="fildList[]" value="kise" <? echo (in_array('kise',$arrfild))?"checked":""; ?>  >&nbsp; <font>kise</font>- інституційний сектор економіки
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_16" name="fildList[]" value="iz" <? echo (in_array('iz',$arrfild))?"checked":""; ?>  >&nbsp;<font>iz</font>- ознакая наявності іноземного засновника
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_17" name="fildList[]" value="e1_10" <? echo (in_array('e1_10',$arrfild))?"checked":""; ?>  >&nbsp;<font>e1_10</font>- код виду діяльності 1 (КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_18" name="fildList[]" value="ne1_10" <? echo (in_array('ne1_10',$arrfild))?"checked":""; ?>>&nbsp;<font>ne1_10</font> - назва виду діяльності 1 (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_19" name="fildList[]" value="e2_10" <? echo (in_array('e2_10',$arrfild))?"checked":""; ?> >&nbsp; <font>e2_10</font>- код виду діяльності 2 (КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_20" name="fildList[]" value="ne2_10" <? echo (in_array('ne2_10',$arrfild))?"checked":""; ?>>&nbsp;<font>ne2_10</font> - назва виду діяльності 2 (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_21" name="fildList[]" value="e3_10" <? echo (in_array('e3_10',$arrfild))?"checked":""; ?> >&nbsp; <font>e3_10</font> - код виду діяльності 3 (КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_22" name="fildList[]" value="ne3_10" <? echo (in_array('ne3_10',$arrfild))?"checked":""; ?>>&nbsp; <font>ne3_10</font> - назва виду діяльності 3 (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_23" name="fildList[]" value="e4_10" <? echo (in_array('e4_10',$arrfild))?"checked":""; ?> >&nbsp; <font>e4_10</font> - код виду діяльності 4 (КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_24"  name="fildList[]" value="ne4_10" <? echo (in_array('ne4_10',$arrfild))?"checked":""; ?>>&nbsp;<font>ne4_10</font> - назва виду діяльності 4 (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_25" name="fildList[]" value="e5_10" <? echo (in_array('e5_10',$arrfild))?"checked":""; ?> >&nbsp;<font>e5_10</font> - код виду діяльності 5 (КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_26" name="fildList[]" value="ne5_10" <? echo (in_array('ne5_10',$arrfild))?"checked":""; ?>>&nbsp; <font>ne5_10</font> - назва виду діяльності 5 (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_27" name="fildList[]" value="e6_10" <? echo (in_array('e6_10',$arrfild))?"checked":""; ?> >&nbsp;<font>e6_10</font>- код виду діяльності 6 (КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_28" name="fildList[]" value="ne6_10" <? echo (in_array('ne6_10',$arrfild))?"checked":""; ?> >&nbsp;<font>ne6_10</font> - назва виду діяльності 6 (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_29" name="fildList[]" value="vdf10" <? echo (in_array('vdf10',$arrfild))?"checked":""; ?>>&nbsp;<font>vdf10</font> - код факт. в.д.(КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_30" name="fildList[]" value="n_vdf10"<? echo (in_array('n_vdf10',$arrfild))?"checked":""; ?>>&nbsp; <font>n_vdf10</font> - назва фак. в.д. (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_31" name="fildList[]" value="rn" <? echo (in_array('rn',$arrfild))?"checked":""; ?> >&nbsp;<font>rn</font> - номер останньої реєстраційної дії
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_32" name="fildList[]" value="dr" <? echo (in_array('dr',$arrfild))?"checked":""; ?> >&nbsp;<font>dr</font> - дата реєстраційних дій
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_33" name="fildList[]" value="dz" <? echo (in_array('dz',$arrfild))?"checked":""; ?> >&nbsp;<font>dz</font> - дата внес. змін до ЄДРПОУ
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_34" name="fildList[]" value="pr" <? echo (in_array('pr',$arrfild))?"checked":""; ?> >&nbsp;<font>pr</font> - Тип (1-ввід, 2-кор., 9-АБК, 8- вибуло в іншу обл.)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_35" name="fildList[]" value="phone" <? echo (in_array('phone',$arrfild))?"checked":""; ?> >&nbsp;<font>phone</font> - контактні телефони
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_36" name="fildList[]" value="phacs" <? echo (in_array('phacs',$arrfild))?"checked":""; ?> >&nbsp;<font>phacs</font> - факс
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_37" name="fildList[]" value="mail" <? echo (in_array('mail',$arrfild))?"checked":""; ?> >&nbsp;<font>mail</font> - електроні адреси
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_38" name="fildList[]" value="sof" <? echo (in_array('sof',$arrfild))?"checked":""; ?> >&nbsp;<font>sof</font> - СКОФ
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_39" name="fildList[]" value="sof_nu" <? echo (in_array('sof_nu',$arrfild))?"checked":""; ?> >&nbsp;<font>sof_nu</font> - Назва коду СКОФ
                  </label>
                </span>
              </p>
              <p align="center">
                <input type="button" value="Обрати всі" class="button" onclick="checkAllFild();" />
                <input type="button" value="Зняти всі" class="button" onclick="unCheckAllFild();" />
              </p>
            </div>

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
