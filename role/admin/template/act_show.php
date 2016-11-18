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
<script src="../../../js/act_show.js"></script>
<script src="../../../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
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

    if(mode=='edit'){
      correct= confirm("Ви впевнені в змінах ??");
      if(correct){
        var arrCheck=document.getElementsByName("checkList[]");
        for(var i=0;i<arrCheck.length;i++){
          arrCheck[i].disabled=false;
        }
      }
    }
    if(mode=='del'){
      correct= confirm("Ви що хочете видалити відмічені записи??");
    }

    document.getElementById("kveds").value=getKveds();
    document.getElementById("kises").value=getKises();
    if (correct) {
    //  document.getElementById('lo').innerHTML='<div id="preloader"></div>';
      form.mode.value = mode;
      var x = document.getElementsByName("limitstart");
        x[0].value=0;
      form.submit();
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

        <h2>Перегляд внесених актів</h2>
        <form name="adminForm" action="act_show.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />
          <input type="hidden" id ="kveds" name="kveds" <? echo "value='".$filtr_Kveds."'"; ?> />
          <input type="hidden" id ="kises" name="kises" <? echo "value='".$filtr_Kises."'"; ?> />
          <div class="item_blue" style="position: relative; width: 770px; left: 50%; margin-left: -335px;">
            <div id='errorM' style='display="none";margin-left:15%;'>	</div>
            <h2 style="text-align:center;" >Пошук актів по параметрам</h2>
            <p class="act_add">
              <span>Коду ЄДРПОУ <input type="text" maxlength="8" placeholder="ЄДРПОУ" id="kd" name="kd" onchange="searhOrg();" style="width:90px;" value="<? echo $filtr_kd; ?>" /> </span>
              <span>Коду КДМО <input type="text" placeholder="КДМО" maxlength="12" id="kdmo" name="kdmo" onchange="searhOrg();" style="width:125px;" value="<? echo $filtr_kdmo; ?>" />
              <input type="button" value="" class="btn_del"  onclick="cleanOrg();"/>
              Номеру рішення суду <input type="text"  id="kodDis" name="kodDis" style="width:110px;"  value="<? echo $filtr_dis; ?>"></span>
            </p>
            <p class="act_add">
              <span>Коду галузевого відділу
                <input type="text"  id="kodDepNom" name="kodDepNom" maxlength="4"  style="width:50px;" onchange="chandeDep();" value="<? echo $filtr_dep_nom; ?>" />
                <select id="kodDepList" name="kodDepList" style="width:222px; text-align:center;" onchange="chengeIdListDep();"><? echo $list_department; ?></select>
              </span>
            </p>
            <div class="clr"></div>
            <p class="act_add">
              <span>
                Типу(ам) актів
                <? echo $html_type; ?>
                <input type="button" value="" name="add_type" class="btn_add"  onclick="addTypeSelect();"/> </span>
              </span>
            </p>
            <div class="clr"></div>
            <p class="act_add">
               <span>Період складання акту:
                  З <input type="text" id='dateActS' name='dateActS'  value="<? echo $filtr_dateActS; ?>">
                  по <input type="text" id='dateActE' name='dateActE'  value="<? echo $filtr_dateActE; ?>">
               </span>
            </p>
            <div class="clr"></div>
            <p class="act_add">
               <span>Період ліквідації по рішенню суду:
                  З <input type="text" id='dateDelS' name='dateDelS'  value="<? echo $filtr_dateDelS; ?>">
                  по <input type="text" id='dateDelE' name='dateDelE'  value="<? echo $filtr_dateDelE; ?>">
               </span>
            </p>
            <div class="clr"></div>

            <h5 class="spoiler-title">Додадкові умови відбору</h5>
            <div class="spoiler-body">
              <p>
                <span id="kved"> Квед(и)
                  <input type="text" id="text_kved" style="width:130px" />
                  <input type="button" value="" name="add_kved" id="add_kved" class="btn_add"  onclick="checkInputDataKved();"/>
                  <? echo $html_kved; ?>
                </span>
              </p>
              <p>
                <span id="kise"> Код(и) Кise
                  <input type="text" id="text_kise" style="width:105px" />
                  <input type="button" value="" name="add_kise" id="add_kise" class="btn_add"  onclick="checkInputDataKise();"/>
                  <? echo $html_kises; ?>
                </span>
              </p>
              <p>
                <span> Область
                  <select id='obl_select' name="obl_select" onchange="updateLists();" style="text-align:center; width:170px;"><? echo $select_obl; ?></select>
                </span>
                <span>Район
                  <select id='ray_select' name='ray_select' onchange="generateTeLists();" <? echo (($select_ray["anabled"]==0)?"disabled":""); ?> style="width:170px;text-align:center;">
                    <? echo $select_ray["data"]; ?>
                  </select>
                </span>
                <span> Місто/Село
                  <select id='ter_select' name="ter_select" <? echo (($select_ter["anabled"]==0)?"disabled":""); ?> style="width:170px;text-align:center;">
                    <? echo $select_ter["data"]; ?>
                  </select>
                </span>
              </p>
            </div>
            <div class="clr"></div>
            <p align="center">
              <input type="button" value="Скасувати" class="button" onclick="cleanFormImport()" />
              <input type="button" value="Імпортувати" class="button" onclick="submitForm('search')" />
            </p>
          </div>
          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){ ?>
          <div id="table_id" align="center">
            <table>
              <tr>
                <th>&nbsp;</th>
                <th>Підприємство</th>
                <th>Період</th>
                <th>Чисельність</th>
              </tr>
            <? foreach ($ListResult as $key => $value) {
                echo "<tr>";
            //    echo "<td style =\" overflow:visible\" > <input type=\"checkbox\"  value=\"".$value["id"]."\" onchange=\"chacheCheck()\" /></td>";
                echo "<td style =\" overflow:hidden;\" >".$value["nu_org"]."</td>";
                echo "<td style =\" overflow:hidden;white-space:nowrap;\" >".$value["nu_period"]." ".$value["nu_year"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value['amount']."</td>";
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
