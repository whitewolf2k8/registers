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
<script src="../../../js/script_export_organizations_adress.js"></script>
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

  $(document).ready(function() {
    setDataPoclerFild("dateReS");
    setDataPoclerFild('dateReE');
    setDataPoclerFild("dateDelS");
    setDataPoclerFild('dateDelE');
    $('.spoiler-body').hide();
    $('.spoiler-title').click(function(){
      $(this).next().slideToggle();
    });
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
        <h2>Перегляд вибірки підприємств по параметрам  </h2>
        <div id='errorMes' style='display="none"'>
      		    <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
      	</div>


        <form name="adminForm" id="adminForm" action="export_organizations_adress.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />
          <input type="hidden" id ="kveds" name="kveds" <? echo "value='".$filtr_Kveds."'"; ?> />
          <input type="hidden" id ="kises" name="kises" <? echo "value='".$filtr_Kises."'"; ?> />
          <input type="hidden" id ="controlArr" name="controlArr" <? echo "value='".$filtr_Contols."'"; ?> />

          <div id="centered" hidden>
            <input class="knob"   readonly  data-width="150" data-displayPrevious=true data-fgColor="#0d932e" data-skin="tron" data-thickness=".2" value="0">
          </div>

          <div class="item_blue" style="position: relative; width: 770px; left: 50%; margin-left: -335px;">
            <div id='errorM' style='display="none";margin-left:15%;'>	</div>
            <h2 style="text-align:center;" >Вибірка підприємств по :</h2>
            <p class="act_add">
              <span>Коду ЄДРПОУ <input type="text" maxlength="8" placeholder="ЄДРПОУ" id="kd" name="kd" onchange="searhOrg();" style="width:90px;" value="<? echo $filtr_kd; ?>" /> </span>
              <span>Коду КДМО <input type="text" placeholder="КДМО" maxlength="12" id="kdmo" name="kdmo" onchange="searhOrg();" style="width:125px;" value="<? echo $filtr_kdmo; ?>" />
                <input type="button" value="" class="btn_del"  onclick="cleanOrg();"/>
              </span>
            </p>


            <div class="clr"></div>
            <h2 style="text-align:center;" >Коду території юридичному </h2>
            <div class="clr"></div>
            <p>
              <span> Область
                <select id='obl_select_1' name="obl_select_1" onchange="updateLists('1');" style="text-align:center; width:150px;"><? echo $select_obl_u; ?></select>
              </span>
              <span>Район/Місто
                <select id='ray_select_1' name='ray_select_1' onchange="generateTeLists('1');" <? echo (($select_ray_u["anabled"]==0)?"disabled":""); ?> style="width:150px;text-align:center;">
                  <? echo $select_ray_u["data"]; ?>
                </select>
              </span>
              <span>Територія
                <select id='ter_select_1' name="ter_select_1" <? echo (($select_ter_u["anabled"]==0)?"disabled":""); ?> style="width:150px;text-align:center;">
                  <? echo $select_ter_u["data"]; ?>
                </select>
              </span>
            </p>

            <div class="clr"></div>
            <h2 style="text-align:center;" >Коду території фактичному </h2>
            <div class="clr"></div>
            <p>
              <span> Область
                <select id='obl_select_2' name="obl_select_2" onchange="updateLists('2');" style="text-align:center; width:150px;"><? echo $select_obl_f; ?></select>
              </span>
              <span>Район/Місто
                <select id='ray_select_2' name='ray_select_2' onchange="generateTeLists('2');" <? echo (($select_ray_f["anabled"]==0)?"disabled":""); ?> style="width:150px;text-align:center;">
                  <? echo $select_ray_f["data"]; ?>
                </select>
              </span>
              <span>Територія
                <select id='ter_select_2' name="ter_select_2" <? echo (($select_ter_f["anabled"]==0)?"disabled":""); ?> style="width:150px;text-align:center;">
                  <? echo $select_ter_f["data"]; ?>
                </select>
              </span>
            </p>
            <h2 style="text-align:center;" >Наявності :</h2>

            <p class="act_add">
              <span>
                <label>
                  <input type="checkbox" id="check_1" name="flag_group[]"  value="1" <? if($filtr_flag!=''){ echo (in_array('1',$filtr_flag))?"checked":"";} ?> > відокремлених підрозділів
                </label>
                &nbsp;
                <label>
                  <input type="checkbox" id="check_2" name="flag_group[]" value="2" <? if($filtr_flag!=''){echo (in_array('2',$filtr_flag))?"checked":"";} ?> > іноземного засновника
                </label>
                &nbsp;
                <label>
                  <input type="checkbox" id="check_4" name="flag_group[]" value="4"<? if($filtr_flag!=''){ echo  (in_array('4',$filtr_flag))?"checked":"";} ?> > ознаки вибуття в інший регіон
                </label>
              </span>
            </p>



            <p class="act_add">
              <span id="kved"> Квед(и)
                <input type="text" id="text_kved" style="width:130px" />
                <input type="button" value="" name="add_kved" id="add_kved" class="btn_add"  onclick="checkInputDataKved();"/>
                <? echo $html_kved; ?>
              </span>
            </p>

            <p class="act_add">
              <span id="kise"> Код(и) Кise
                <input type="text" id="text_kise" style="width:105px" />
                <input type="button" value="" name="add_kise" id="add_kise" class="btn_add"  onclick="checkInputDataKise();"/>
                <? echo $html_kises; ?>
              </span>
            </p>

            <p class="act_add">
              <span id="opf">Організаційно правова форма
                <? echo $html_opf; ?>
                <input type="button" value="" name="add_opf" id="add_opf" class="btn_add"  onclick="addOpfSelect();"/>
              </span>
            </p>

            <p class="act_add">
              <span id="controls">Орган управління
                <input type="text" id="text_controls" style="width:130px" />
                <input type="button" value="" name="add_controls" id="add_controls" class="btn_add"  onclick="checkInputDataControls();"/>
                <? echo $html_control; ?>
              </span>
            </p>

            <div class="clr"></div>
            <p class="act_add">
               <span>Даті первинної реєстрації в межах :
                  з <input type="text" id='dateReS' name='dateReS'  value="<? echo $filtr_dateReS; ?>">
                  по <input type="text" id='dateReE' name='dateReE'  value="<? echo $filtr_dateReE; ?>">
               </span>
            </p>
            <div class="clr"></div>
            <p class="act_add">
               <span> Даті ліквідації підприємства в межах:
                  з <input type="text" id='dateDelS' name='dateDelS'  value="<? echo $filtr_dateDelS; ?>">
                  по <input type="text" id='dateDelE' name='dateDelE'  value="<? echo $filtr_dateDelE; ?>">
               </span>
            </p>
              <div class="clr"></div>
            <p align="center">
              <input type="button" value="Пошук" class="button" onclick="submitForm('find_department');" />
              &nbsp;
              <span>
                <input name="typeF" type="radio" value="dbf" checked <? echo ((!isset($ListResult))?"disabled":""); ?> > .dbf
                <input name="typeF" type="radio" value="exel" <? echo ((!isset($ListResult))?"disabled":""); ?>> .xls
                <input type="button" value="Експорт" class="button" <? echo ((!isset($ListResult))?"disabled":""); ?> onclick="exportElementd();" />
              </span>
            </p>

          </div>
          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){
            if(count($ListResult)>0){?>
              <div id="table_block" class="prokrutka"  align="center">
                <table id="table_id" >
                  <tr>
                    <th>ЄДРПОУ</th>
                    <th>КДМО</th>
                    <th>Назва</th>
                    <th>Код території за КОАТУУ</th>
                    <th>Адміністративно-територіальна<br> приналежність</th>
                    <th>Поштовий індекс</th>
                    <th>Адреса</th>
                  </tr>

                <? foreach ($ListResult as $key => $value) {
                    echo "<tr id=\"".$value['id']."\">";
                    echo "<td style =\" overflow:hidden;\" >".$value['kd']."</td>";
                    echo "<td style =\" overflow:hidden;\" >".$value['kdmo']."</td>";
                    echo "<td style =\" overflow:hidden;\" >".$value['nu']."</td>";
                    echo "<td style =\" overflow:hidden;\" >".$value['tea']."</td>";
                    echo "<td style =\" overflow:hidden;\" >".$value['te']."</td>";
                    echo "<td style =\" overflow:hidden;\" >".$value['pi']."</td>";
                    echo "<td style =\" overflow:hidden;\" >".$value['ad']."</td>";
                    echo"</tr>";
                  } ?>
                </table>
              </div>
        <? }else{
              echo "<div id='errorMes'>"
                ."<p class=\"error\">По заданим умовам не знайдено ні одного запису! </p>
                .</div>";
            }
          } ?>
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
