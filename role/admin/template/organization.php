<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/modal-contact-form.css"  type="text/css" />

<title>Головна</title>
<link rel="shortcut icon" href="/images/favicon.png" type="image/png">

<script src="../../../js/jquery-1.7.2.js"></script>
<script src="../../../js/scripts.js"></script>
<script src="../../../js/script_fact_adress.js"></script>
<script type="text/javascript">
  function submitForm(mode) {
    correct = true;
    form = document.forms['adminForm'];

    if (form.filtr_edrpou.value==""&&form.filtr_kdmo.value=="") {
      correct = false;
      text='';
      text+=' Введіть код ЄДРПОУ або КДМО. <br>'
      document.getElementById('errorMes').className="error";
      document.getElementById('errorMes').innerHTML=text;
    }

    if (correct) {
    //  document.getElementById('lo').innerHTML='<div id="preloader"></div>';
      form.submit();
    }
  }

  $(document).ready(function() {
    $("#postCode").ForceNumericOnly();
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
      		    <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
      	</div>

        <div id="add_adress" class="parent_popup" >
          <div id="popup" class="popup" style="width:400px;left:40%;">
            <div id='errorMesAdd' style='display="none";'>
            </div>
            <h2>Внесення фактичної адреси</h2>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Область</div>
              <div class="navigation_right">
                <select id='obl_add' onchange="updateLists(this.options[this.selectedIndex].value,'','ray_add')" style="text-align:center; width:250px;"></select>
              </div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Район</div>
              <div class="navigation_right"><select id='ray_add' onchange="generateTeLists('1',getIndexObl('obl_add'),getIndexObl('ray_add'),'ter_add')" style="width:250px;text-align:center;"></select></div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Місто/Село</div>
              <div class="navigation_right"><select id='ter_add' style="width:250px;text-align:center;"></select></div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Поштовий індекс</div>
              <div class="navigation_right"><input align="right" type="text" id="postCode" maxlength="5" name="postCode" style="width:250px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Адреса</div>
              <div class="navigation_right"><input align="right" type="text" id="adressAdd" maxlength="150" name="adressAdd" style="width:250px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>

            <div>
              <p align="center">
    	          <input type="button" value="Скасувати" class="button" onclick="showHide('add_adress');" />
                <input type="button" value="Зберегти" class="button" onclick="addAdres('add','<? echo $org['id'];?>')" />
    	        </p>
            </div>
          </div>
        </div>

        <div id="change_adress" class="parent_popup" >
          <div id="popup" class="popup" style="width:400px;left:40%;">
            <div id='errorMesAdd' style='display="none";'>
            </div>
            <h2>Редагування фактичної адреси</h2>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Область</div>
              <div class="navigation_right">
                <select id='obl_ch' onchange="updateLists(this.options[this.selectedIndex].value,'','ray_ch')" style="text-align:center; width:250px;"></select>
              </div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Район</div>
              <div class="navigation_right"><select id='ray_ch' onchange="generateTeLists('1',getIndexObl('obl_ch'),getIndexObl('ray_ch'),'ter_ch')" style="width:250px;text-align:center;"></select></div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Місто/Село</div>
              <div class="navigation_right"><select id='ter_ch' style="width:250px;text-align:center;"></select></div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Поштовий індекс</div>
              <div class="navigation_right"><input align="right" type="text" id="postCodeCh" maxlength="5" name="postCodeCh" style="width:250px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Адреса</div>
              <div class="navigation_right"><input align="right" type="text" id="adressAddCh" maxlength="150" name="adressAdd" style="width:250px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <div>
              <p align="center">
    	          <input type="button" value="Скасувати" class="button" onclick="showHide('change_adress');" />
                <input type="button" value="Видалити" id="btDel" class="button"  />
                <input type="button" value="Зберегти" class="button" id="btChange" />
    	        </p>
            </div>
          </div>
        </div>

        <div id="contactAdd" class="parent_popup" >
          <div id="popup" class="popup" style="width:400px;left:40%;">
            <div id='errorMesCon' style='display="none";'></div>
            <h2>Додати контактні дані</h2>
            <div class="clr"></div>
            <p>
              <div class="navigation_left"  style="margin-left:10px;">Тип даних</div>
              <div class="navigation_right">
                <select id='type_contact' onchange="" style="text-align:center; width:250px;">
                  <option value="0" selected>Телефон</option>
                  <option value="1">Факс</option>
                  <option value="2">Email</option>
                </select>
              </div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_right"><input align="right" type="text" id="contactData" maxlength="250" name="contactData" style="width:400px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <div>
              <p align="center">
                <input type="button" value="Скасувати" class="button" onclick="showHide('contactAdd');" />
                <input type="button" value="Зберегти" class="button" onclick="addContact(<? echo $org['id']; ?>)" />
              </p>
            </div>
          </div>
        </div>

        <div id="contactChange" class="parent_popup" >
          <div id="popup" class="popup" style="width:400px;left:40%;">
            <div id='errorMesCon' style='display="none";'></div>
            <h2>Редагувати контактні дані</h2>
            <div class="clr"></div>
            <div id="typeC"> </div>
            <p>
              <div class="navigation_right"><input align="right" type="text" id="contactDataCh" maxlength="250" name="contactData" style="width:400px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <div>
              <p align="center">
                <input type="button" value="Скасувати" class="button" onclick="showHide('contactChange');" />
                <input type="button" value="Видалити" id="btContactDel" class="button" />
                <input type="button" value="Зберегти" id="btContactCh" class="button"/>
              </p>
            </div>
          </div>
        </div>


        <form name="adminForm" action="index.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <h2>Облікова картка підприємства</h2>
          <div class="item_main"  style="margin-top:1%;">
            <p>
              <text> <b> Код ЄДРПОУ:</b> <? echo (($org['kd']!="")?$org['kd']:'-------------------'); ?></text>&nbsp;&nbsp;
              <text> <b>  Код КДМО: </b> <? echo (($org['kdmo']!="")?$org['kdmo']:'-------------------'); ?> </text>
              <? if($org['dl']!=0) echo "<text style=\"color:red;\" > <b>  Дата ліквідації:</b>".$org['dl']."</text>"; ?>
            </p>
            <p>
              <text> <b><? echo (($org['nu']!="")?$org['nu']:'-------------------'); ?></b></text>
            </p>
            <div class="clr"></div>
            <p>
              <text> <b> Керівник:</b> <? echo (($org['pk']!="")?$org['pk']:'-------------------'); ?></text>&nbsp;&nbsp;
            </p>
            <div class="clr"></div>
            <p>
              <text> <b> Юридична адреса:</b> <? echo (($org['pi']!="")?($org['pi'].', '):'').(($org['ad']!="")?$org['ad']:'-------------------'); ?></text>&nbsp;&nbsp;
            </p>
            <div class="clr"></div>
            <p>
              <text> <b> Код території(повний/короткий): </b>
                <? echo ($org['te'].' / '.$org['tea']); ?></text>&nbsp;&nbsp;
              <text> <b> Ознака юридичної особи:</b> <? echo (($org['uo']!="1")?('-'):'+'); ?></text>
            </p>
            <div class="clr"></div>
            <p>
              <text > <b> Фактична адреса: </b></text>
              <input type="button" value="" class="btn_add"  onclick="callAddWindow('add');"/>
            </p>
            <div class="clr"></div>
            <div id ="ur_adres">
              <? if(isset($addres)){
                foreach ($addres as $key => $value) { ?>
                  <p>
                    <text > - <? echo "Код території(повний/короткий):".$value["tea"]."/"
                      .$value["te"].", адреса : ".$value["pi"].",".$value['ad'];?>
                    </text>
                    <input type="button" class="btn_edit" onclick="callAddWindow('change','<? echo $value["id"]; ?>');" />
                  </p>
              <? }
              } ?>
            </div>
            <div class="clr"></div>

            <p>
              <text> <b> Контактні дані: </b></text>
              <input type="button" value="" class="btn_add"  onclick="showHide('contactAdd');"/>
            </p>

            <div class="clr"></div>
            <div id ="contact">
              <? if(isset($contact)){
                  $count=0;
                  foreach ($contact as $key => $value) {
                    if($count==0){
                      echo "<p>";
                      $count+=1;
                    }
                    switch ($value["type"]) {
                      case "0":
                        echo "<text>Телефон: ".$value["data"].";</text>"
                          ."<input type=\"button\" class=\"btn_edit\" onclick=\"contactChange(".$value['id'].",".$value['id_org'].",'".$value['data']."',".$value['type'].");\" />";
                        break;
                      case "1":
                        $text="<text>Факс: ".$value["data"].";</text>"
                          ."<input type=\"button\" class=\"btn_edit\" onclick=\"contactChange(".$value['id'].",".$value['id_org'].",'".$value['data']."',".$value['type'].");\" />";
                        break;
                      case "2":
                        $text="<text>Email: ".$value["data"].";</text>"
                          ."<input type=\"button\" class=\"btn_edit\" onclick=\"contactChange(".$value['id'].",".$value['id_org'].",'".$value['data']."',".$value['type'].");\" />";
                        break;
                    }
                    if ($count==3){
                      echo "</p>";
                      $count=0;
                    }else{
                      $count+=1;
                    }
                  }
                  if($count!=0){echo "</p>";}
                }?>
            </div>

          <p>
            <text> <b>Основний вид економічної діяльності:</b></text>
            <text id="vdf10"><? echo $org["vdf10"]."(".$org['vdf10N'].")";?></<text>
          </p>

          <p>
            <text> <b>Додадкові види економічної діяльності:</b></text>
          </p>
          <div id="kved">
            <? $c=0;
              for($i=1;$i<=6;$i++){
                if($c== 0){
                    echo "<p>";
                }
                echo "<text>".((str_replace(" ","",$org["e".$i."_10"])=="")?("-------- (------------------------------)"):($org["e".$i."_10"]." (".$org["e_".$i."N"].")"))."</text>";
                if($c==1){
                    echo "</p>";
                    $c=0;
                }else{
                  $c++;
                }
              } ?>
          </div>
          <p>
            <text> <b>KICE 2014:</b></text>
            <text ><?  echo (($org["kice"]!="")?($org["kisKod"]."  (".$org['kisNu'].");"):'-------------------');?></<text>
            <text> <b>Наявність іноземного засновника: <?  echo (($org["iz"]!=0)?("+"):"&ndash;");?></b></<text>
          </p>
          <p>
            <text> <b>Організаційна форма суб&#039;єкта:</b></text>
            <text><?  echo (($org["pf"]!="")?($org["pf"]."  (".$org['opfNu'].");"):'-------------------');?></<text>
          </p>
          <p>
            <text> <b>Орган управління:</b></text>
            <text><?  echo (($org["gu"]!=0)?($org["gu"]."  (".$org['depNu'].");"):'-------------------');?></<text>
          </p>
          <p>
            <text> <b>Головне підприємство :</b></text>
            <text><?  echo (($org["kdg"]!=0)?($org["kdg"]."  (".((isset($org['kdgNu']))?($org['kdgNu']):"Дані про підприєство відсутні в довіднику").");"):'-------------------');?></<text>
          </p>
          <p>
            <text>
              <b>Дата первинної реєстрації :</b> <? echo $org["rik"].";";?>
              <b>Номер реєстрації: №</b><? echo $org["sn"].";";?>
              <b>Орган реєстрації: </b><? echo $org["os"].";";?>
            </text>
          </p>
          <p>
            <text>
              <b>Дата реєстрації В ЄДР :</b> <? echo (($org["dz"]!=0)?($org["dz"]):"-------------------").";";?>
              <b>Інформація про вибуття в інший регіон :</b> <? echo $org["pr"].";";?>
            </text>
          </p>
          <p>
            <text>
              <b>Остання реєстраційна дія (код) :</b> <? echo ((str_replace(" ","",$org["rn"])!='')?($org["rn"]):"-------------------").";";?>
              <b>Дата здійснення дії :</b>  <? echo (($org["dr"]!=0)?($org["dr"]):"-------------------").";";?>
            </text>
          </p>
          <? if(isset($child)){ ?>
            <p>
              <text>
                <b>Відокремлені підрозділи :</b>
              </text>
            </p>
            <? foreach ($child as $key => $value) {
              echo "<p> <text> ";
              echo "ЄДРПОУ: ".(($value['kd']!=0)?$value['kd']:"--------------")." ; ";
              echo "КДМО: ".(($value['kdmo']!=0)?$value['kdmo']:"--------------")." ; ";
              echo "Назва : ".((str_replace(" ","",$value['nu'])!="")?$value['nu']:"--------------")." ; "."</p></text>";
            } ?>
          <? } ?>

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

</body>
</html>
