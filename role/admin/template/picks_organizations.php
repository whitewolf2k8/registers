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

<script src="../../../js/jquery-1.7.2.js"></script>
<script src="../../../js/scripts.js"></script>
<script src="../../../js/script_picks_organizations.js"></script>
<script src="../../../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  function submitForm(mode) {
    correct = true;
    form = document.forms['adminForm'];
    document.getElementById("kveds").value=getKveds();
    document.getElementById("kises").value=getKises();
    if (correct) {
      document.getElementById('lo').innerHTML='<div id="preloader"></div>';
      form.mode.value = mode;
      var x = document.getElementsByName("limitstart");
        x[0].value=0;
      form.submit();
    }
  }

  function openUrl(url, post)
   {
       if ( post ) {
           var form = $('<form/>', {
               action: url,
               method: 'POST',
               target: '_blank',
               style: {
                  display: 'none'
               }
           });
           for(var key in post) {
               form.append($('<input/>',{
                   type: 'hidden',
                   name: key,
                   value: post[key]
               }));
           }
           form.appendTo(document.body); // Необходимо для некоторых браузеров
           form.submit();

       } else {
           window.open( url, '_blank' );
       }
  }



  $(document).ready(function() {
    setDataPoclerFild("dateActS");
    setDataPoclerFild('dateActE');
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
        <div id='errorMes' style='display="none"'>
      		    <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
      	</div>

        <h2>Перегляд вибірки підприємств по параметрам  </h2>
        <form name="adminForm" action="picks_organizations.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />
          <input type="hidden" id ="kveds" name="kveds" <? echo "value='".$filtr_Kveds."'"; ?> />
          <input type="hidden" id ="kises" name="kises" <? echo "value='".$filtr_Kises."'"; ?> />
          <input type="hidden" id ="controlArr" name="controlArr" <? echo "value='".$filtr_Kises."'"; ?> />


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
                <select id='obl_select_1' name="obl_select_1" onchange="updateLists('1');" style="text-align:center; width:150px;"><? echo $select_obl; ?></select>
              </span>
              <span>Район/Місто
                <select id='ray_select_1' name='ray_select_1' onchange="generateTeLists('1');" <? echo (($select_ray["anabled"]==0)?"disabled":""); ?> style="width:150px;text-align:center;">
                  <? echo $select_ray["data"]; ?>
                </select>
              </span>
              <span>Територія
                <select id='ter_select_1' name="ter_select_1" <? echo (($select_ter["anabled"]==0)?"disabled":""); ?> style="width:150px;text-align:center;">
                  <? echo $select_ter["data"]; ?>
                </select>
              </span>
            </p>

            <div class="clr"></div>
            <h2 style="text-align:center;" >Коду території фактичному </h2>
            <div class="clr"></div>
            <p>
              <span> Область
                <select id='obl_select_2' name="obl_select_2" onchange="updateLists('2');" style="text-align:center; width:150px;"><? echo $select_obl; ?></select>
              </span>
              <span>Район/Місто
                <select id='ray_select_2' name='ray_select_2' onchange="generateTeLists('2');" <? echo (($select_ray["anabled"]==0)?"disabled":""); ?> style="width:150px;text-align:center;">
                  <? echo $select_ray["data"]; ?>
                </select>
              </span>
              <span>Територія
                <select id='ter_select_2' name="ter_select_2" <? echo (($select_ter["anabled"]==0)?"disabled":""); ?> style="width:150px;text-align:center;">
                  <? echo $select_ter["data"]; ?>
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
                  <input type="checkbox" id="check_3" name="flag_group[]" value="3" onchange='showActElement();' <? if($filtr_flag!=''){ echo  (in_array('3',$filtr_flag))?"checked":"";} ?> > Актів
                </label>
                &nbsp;
                <label>
                  <input type="checkbox" id="check_4" name="flag_group[]" value="4"<? if($filtr_flag!=''){ echo  (in_array('4',$filtr_flag))?"checked":"";} ?> > ознаки вибуття в інший регіон
                </label>
              </span>
            </p>

            <p class="act_add" id='act_block' <? if($filtr_flag!=''){echo (!in_array('3',$filtr_flag))?"hidden":"";}else{ echo "hidden"; } ?> >
              <span>
                Типу(ам) актів
                <? echo $html_type; ?>
                <input type="button" value="" name="add_type" class="btn_add"  onclick="addTypeSelect();"/> </span>
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
                <? echo $html_contol; ?>
              </span>
            </p>

            <div class="clr"></div>
            <p class="act_add">
               <span>Даті первинної реєстрації в межах :
                  з <input type="text" id='dateReS' name='dateReS'  value="<? echo $filtr_dateActS; ?>">
                  по <input type="text" id='dateReE' name='dateReE'  value="<? echo $filtr_dateActE; ?>">
               </span>
            </p>
            <div class="clr"></div>
            <p class="act_add">
               <span> даті ліквідації підприємства в межах:
                  з <input type="text" id='dateDelS' name='dateDelS'  value="<? echo $filtr_dateDelS; ?>">
                  по <input type="text" id='dateDelE' name='dateDelE'  value="<? echo $filtr_dateDelE; ?>">
               </span>
            </p>
            <div class="clr"></div>
            <h5 class="spoiler-title">Перлік полів для перегляду/експорту </h5>
            <div class="spoiler-body">
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_1" name="filds[]" value="kd" <? echo (in_array('kd',$arrfild))?"checked":""; ?> >&nbsp;<font>kd</font> - ідентифікаційний код субєкту
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_2" name="filds[]" value="kdmo" <? echo (in_array('kdmo',$arrfild))?"checked":""; ?> >&nbsp; <font>kdmo</font> - ідентифікаційний код місцевої одиниці
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_3" name="filds[]" value="nu" <? echo (in_array('nu',$arrfild))?"checked":""; ?> >&nbsp; <font>nu</font> - найменування субєкту
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_4" name="filds[]" value="pk" <? echo (in_array('pk',$arrfild))?"checked":""; ?> >&nbsp; <font>pk</font>- прізвище керівника
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_5" name="filds[]" value="kdg" <? echo (in_array('kdg',$arrfild))?"checked":""; ?> >&nbsp;<font>kdg</font>- код головного підприємства
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_6" name="filds[]" value="te" <? echo (in_array('te',$arrfild))?"checked":""; ?> >&nbsp;<font>te</font>- код території за КОАТУУ
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_7" name="filds[]" value="tea" <? echo (in_array('tea',$arrfild))?"checked":""; ?>  >&nbsp; <font>tea</font> - адміністративно територіальна належність
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_8" name="filds[]" value="ad" <? echo (in_array('ad',$arrfild))?"checked":""; ?>  >&nbsp;<font>ad</font> - адреса
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_9" name="filds[]" value="pi" <? echo (in_array('pi',$arrfild))?"checked":""; ?> >&nbsp;<font>pi</font> - поштовий індекс
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_10" name="filds[]" value="pf" <? echo (in_array('pf',$arrfild))?"checked":""; ?> >&nbsp;<font>pf</font>- код організаційно-правової форми
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_11" name="filds[]" value="gu" <? echo (in_array('gu',$arrfild))?"checked":""; ?>  >&nbsp;<font>gu</font> - код органу управління
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_12" name="filds[]" value="uo" <? echo (in_array('uo',$arrfild))?"checked":""; ?>  >&nbsp;<font>uo</font> - ознака особи
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_13" name="filds[]" value="dl" <? echo (in_array('dl',$arrfild))?"checked":""; ?>  >&nbsp;<font>dl</font>- дата ліквідації
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_14" name="filds[]" value="kise" <? echo (in_array('kise',$arrfild))?"checked":""; ?>  >&nbsp; <font>kise</font>- інституційний сектор економіки
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_15" name="filds[]" value="iz" <? echo (in_array('iz',$arrfild))?"checked":""; ?>  >&nbsp;<font>iz</font>- ознакая наявності іноземного засновника
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_16" name="filds[]" value="e1_10" <? echo (in_array('e1_10',$arrfild))?"checked":""; ?>  >&nbsp;<font>e1_10</font>- код виду діяльності 1 (КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_17" name="filds[]" value="ne1_10" <? echo (in_array('ne1_10',$arrfild))?"checked":""; ?>>&nbsp;<font>ne1_10</font> - назва виду діяльності 1 (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_18" name="filds[]" value="e2_10" <? echo (in_array('e2_10',$arrfild))?"checked":""; ?> >&nbsp; <font>e2_10</font>- код виду діяльності 2 (КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_19" name="filds[]" value="ne2_10" <? echo (in_array('ne2_10',$arrfild))?"checked":""; ?>>&nbsp;<font>ne2_10</font> - назва виду діяльності 2 (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_20" name="filds[]" value="e3_10" <? echo (in_array('e3_10',$arrfild))?"checked":""; ?> >&nbsp; <font>e3_10</font> - код виду діяльності 3 (КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_21" name="filds[]" value="ne3_10" <? echo (in_array('ne3_10',$arrfild))?"checked":""; ?>>&nbsp; <font>ne3_10</font> - назва виду діяльності 3 (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_22" name="filds[]" value="e4_10" <? echo (in_array('e4_10',$arrfild))?"checked":""; ?> >&nbsp; <font>e4_10</font> - код виду діяльності 4 (КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_23"  name="filds[]" value="ne4_10" <? echo (in_array('ne4_10',$arrfild))?"checked":""; ?>>&nbsp;<font>ne4_10</font> - назва виду діяльності 4 (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_24" name="filds[]" value="e5_10" <? echo (in_array('e5_10',$arrfild))?"checked":""; ?> >&nbsp;<font>e5_10</font> - код виду діяльності 5 (КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_25" name="filds[]" value="ne5_10" <? echo (in_array('ne5_10',$arrfild))?"checked":""; ?>>&nbsp; <font>ne5_10</font> - назва виду діяльності 5 (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_26" name="filds[]" value="e6_10" <? echo (in_array('e6_10',$arrfild))?"checked":""; ?> >&nbsp;<font>e6_10</font>- код виду діяльності 6 (КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_27" name="filds[]" value="ne6_10" <? echo (in_array('ne6_10',$arrfild))?"checked":""; ?> >&nbsp;<font>ne6_10</font> - назва виду діяльності 6 (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_28" name="filds[]" value="vdf10" <? echo (in_array('vdf10',$arrfild))?"checked":""; ?>>&nbsp;<font>vdf10</font> - код факт. в.д.(КВЕД 10)
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_29" name="filds[]" value="n_vdf10"<? echo (in_array('n_vdf10',$arrfild))?"checked":""; ?>>&nbsp; <font>n_vdf10</font> - назва фак. в.д. (КВЕД 10)
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_30" name="filds[]" value="rn" <? echo (in_array('rn',$arrfild))?"checked":""; ?> >&nbsp;<font>rn</font> - номер останньої реєстраційної дії
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_31" name="filds[]" value="dr" <? echo (in_array('dr',$arrfild))?"checked":""; ?> >&nbsp;<font>dr</font> - дата реєстраційних дій
                  </label>
                </span>
              </p>
              <p>
                <span>
                  <label>
                    <input type="checkbox" id="f_32" name="filds[]" value="dz" <? echo (in_array('dz',$arrfild))?"checked":""; ?> >&nbsp;<font>dz</font> - дата внес. змін до ЄДРПОУ
                  </label>
                  &nbsp;
                  <label>
                    <input type="checkbox" id="f_33" name="filds[]" value="pr" <? echo (in_array('pr',$arrfild))?"checked":""; ?> >&nbsp;<font>pr</font> - Тип (1-ввід, 2-кор., 9-АБК, 8- вибуло в іншу обл.)
                  </label>
                </span>
              </p>
              <p align="center">
                <input type="button" value="Обрати всі" class="button" onclick="checkAllFild();" />
                <input type="button" value="Зняти всі" class="button" onclick="delAllcheckFild();" />
              </p>
            </div>

            <div class="clr"></div>
            <p align="center">
              <input type="button" value="Пошук" class="button" onclick="submitForm('find_department');" />
            </p>

          </div>
          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){ ?>
          <div id="table_id" align="center">
            <table id="table_id" >
              <tr>
              <!--  <th rowspan="2">&nbsp;</th>-->
                <th rowspan="2">ЄДРПОУ</th>
                <th rowspan="2">КДМО</th>
                <th colspan="2">Дата </th>
                <th rowspan="2">Номер рішення</th>
                <th rowspan="2">Тип акту</th>
                <th rowspan="2">Галузевий відділ</th>
                <th rowspan="2">Адреса складання</th>
              </tr>
              <tr class="second_level">
                <th> складання акту</th>
                <th>ліквідації по рішенню суду</th>
              </tr>
              <? foreach ($ListResult as $key => $value) {
                echo "<tr id=\"".$value['id']."\">";
                echo "<td style =\" overflow:hidden;\" ><a OnClick=\"openUrl('index.php',{filtr_edrpou:'".$value["kd"]."', filtr_kdmo:'".$value["kdmo"]."'});\">".$value["kd"]."</a></td>";
                echo "<td style =\" overflow:hidden;\" ><a OnClick=\"openUrl('index.php',{filtr_edrpou:'".$value["kd"]."', filtr_kdmo:'".$value["kdmo"]."'});\">".$value["kdmo"]."</a></td>";
                echo "<td style =\" overflow:hidden;\" >".$value["da"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["dl"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["rnl"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["types"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["dep"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["ad"]."</td>";
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
