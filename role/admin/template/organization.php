<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/modal-contact-form.css"  type="text/css" />
<link rel="stylesheet" href="../../../css/block.css"  type="text/css" />

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
                    if($value["type"]==0) {
                        echo "<text>Телефон: ".$value["data"].";</text>"
                          ."<input type=\"button\" class=\"btn_edit\" onclick=\"contactChange(".$value['id'].",".$value['id_org'].",'".$value['data']."',".$value['type'].");\" />";
                    } else if($value["type"]==1) {

                        echo"<text>Факс: ".$value["data"].";</text>"
                          ."<input type=\"button\" class=\"btn_edit\" onclick=\"contactChange(".$value['id'].",".$value['id_org'].",'".$value['data']."',".$value['type'].");\" />";
                    } else {
                        echo"<text>Email: ".$value["data"].";</text>"
                          ."<input type=\"button\" class=\"btn_edit\" onclick=\"contactChange(".$value['id'].",".$value['id_org'].",'".$value['data']."',".$value['type'].");\" />";
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
          <p>
            <text>
              <b> СКОФ :</b> <? echo (($org["sof"]!=0)?($org["sof_text"]):"-------------------").";";?>
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

          <? if(isset($bankrut_info)){ ?>
            <p>
              <text>
                <b>Дані про перебування особи в процесі провадження у справі про банруцтво, санації :</b>
              </text>
            </p>
            <? foreach ($bankrut_info as $key => $value) {
              echo "<p> <text> ";
              echo "Номер справи: ".(str_replace(" ","",$value['deal_number']!="")?str_replace(" ","",$value['deal_number']):"--------------")." ; ";
              echo "Дата: ".(str_replace(" ","",$value['date_deal']!="")?str_replace(" ","",$value['date_deal']):"--------------")." ; ";
              echo "ПІБ ліквідатора: ".(str_replace(" ","",$value['maneger_deal']!="")?str_replace(" ","",$value['maneger_deal']):"--------------")." ; ";
              echo "Тип : ".((str_replace(" ","",$value['type_deal'])!="")?$value['type_deal']:"--------------")." ; "."</p></text>";
            } ?>
          <? } ?>

          <? if(isset($act_info)){ ?>
            <p>
              <text>
                <b>Дані про наявність акту(-ів):</b>
              </text>
            </p>
            <? foreach ($act_info as $key => $value) {
              echo "<p style='text-align:left;'> <text> ";
              echo "Дата складання: ".(str_replace(" ","",$value['da']!="")?str_replace(" ","",$value['da']):"--------------")." ; ";
              echo "Дата ліквідації по рішенню суду: ".(str_replace(" ","",$value['dl']!="")?str_replace(" ","",$value['dl']):"--------------")." ; ";
              echo "Тип атку: ( ".(str_replace(" ","",$value['types']!="")?$value['types']:"--------------")." ) ; ";
              echo "Відділ що склав : ".((str_replace(" ","",$value['dep'])!="")?$value['dep']:"--------------")." ; ";
              echo "Адреса складання : ".((str_replace(" ","",$value['ad'])!="")?$value['ad']:"--------------").";  "."</p></text>";
            } ?>
          <? } ?>

          <? if(isset($cause_info)){ ?>
            <p>
              <text>
                <b>Дані про порушення адмінсправ(и):</b>
              </text>
            </p>
            <? foreach ($cause_info as $key => $value) {
              echo "<p style='text-align:left;'> <text> ";
              echo "Номер/Дата адмінсправи: ".(str_replace(" ","",$value['decree']!="")?str_replace(" ","",$value['decree']):"--------------")." ; ";
              echo " Відповідальна особа: ".(str_replace(" ","",$value['volator']!="")?str_replace(" ","",$value['volator']):"--------------")." ; ";
              echo " Керівник відділу ініціатора : ".((str_replace(" ","",$value['nu'])!="")?$value['nu']:"--------------").";  "."</p></text>";
            } ?>
          <? } ?>

          <? if(isset($violation_info)){ ?>
            <p>
              <text>
                <b>Дані про порушення законодвства:</b>
              </text>
            </p>
            <? foreach ($violation_info as $key => $value) {
              echo "<p style='text-align:left;'> <text> ";
              echo "Вихідний № листа: ".(str_replace(" ","",$value['label']!="")?str_replace(" ","",$value['label']):"--------------")." ; "."</p></text>";
            } ?>
          <? } ?>

          <? if(isset($activity_info)){ ?>
            <p>
              <text>
                <b>Дані про призупинення діяльності:</b>
              </text>
            </p>
            <? foreach ($activity_info as $key => $value) {
              echo "<p style='text-align:left;'> <text> ";
              echo "Номер/дата листа: ".(str_replace(" ","",$value['label']!="")?str_replace(" ","",$value['label']):"--------------")." ; "."</p></text>";
            } ?>
          <? } ?>
          <br>
        <p>
          <text>
            <b>Чистий дохід від реалізації продукції (товарів, робіт, послуг) :</b>
          </text>
          <? if(isset($profit_info[0])){ ?>
            <p style='text-align:center;'>
              <text>
                <? echo " - дохід за ".$profit_info[0]['nuPeriod']." ".$profit_info[0]['yearShot']." становив ".$profit_info[0]['profit']." тис.грн ;" ?>
              <text>
            </p>
          <? } ?>
          <? if(isset($profit_info[1])){ ?>
            <p style='text-align:center;'>
              <text>
                <? echo " - дохід за ".$profit_info[1]['nuPeriod']." ".$profit_info[1]['yearShot']." становив ".$profit_info[1]['profit']." тис.грн ;" ?>
              <text>
            </p>
          <? } ?>
          <div class="demo">
            <input class="hide" id="hd-1" type="checkbox">
            <label for="hd-1">Чистий дохід від реалізації продукції (товарів, робіт, послуг) за <font style="color:red;"> інші періоди</font> </label>
            <div>
              <? for ($i=2; $i < count($profit_info) ; $i++) { ?>
                <p>
                  <? echo " - дохід за ".$profit_info[$i]['nuPeriod']." ".$profit_info[$i]['yearShot']." становив ".$profit_info[$i]['profit']." тис.грн ;" ?>
                </p>
              <? }  ?>
            </div>
          </div>
        </p>


        <p>
          <text>
            <b>Середня кількість працівник (за формами фінансової звітності та формою 1-ПВ) :</b>
          </text>
          <? if(isset($amount_res[0])){ ?>
            <p style='text-align:center;'>
              <text>
                <? echo " - кількість працівник за ".$amount_res[0]['nuPeriod']." ".$amount_res[0]['yearShot']." становив:  у фін.звіті ".$amount_res[0]['amountF']."осіб, у 1-ПВ ".$profit_info[0]['amountP']."осіб ; " ?>
              <text>
            </p>
          <? } ?>
          <? if(isset($amount_res[1])){ ?>
            <p style='text-align:center;'>
              <text>
                <? echo " - кількість працівник за ".$amount_res[1]['nuPeriod']." ".$amount_res[1]['yearShot']." становив:  у фін.звіті ".$amount_res[1]['amountF']."осіб, у 1-ПВ ".$profit_info[1]['amountP']."осіб ; " ?>
              <text>
            </p>
          <? } ?>
          <div class="demo">
            <input class="hide" id="hd-2" type="checkbox">
            <label for="hd-2">Середня кількість працівник (за формами фінансової звітності та формою 1-ПВ) за <font style="color:red;"> інші періоди</font> </label>
            <div>
              <? for ($i=2; $i < count($amount_res) ; $i++) { ?>
                <p>
                  <? echo " - кількість працівник за ".$amount_res[$i]['nuPeriod']." ".$amount_res[$i]['yearShot']." становив:  у фін.звіті ".$amount_res[$i]['amountF']."осіб, у 1-ПВ ".$profit_info[$i]['amountP']."осіб ; " ?>
                </p>
              <? }  ?>
            </div>
          </div>
        </p>



        <p>
          <text>
            <b>Ознака активності за даними ДФС :</b>
          </text>
          <? if(isset($activity_tax_info[0])){ ?>
            <p style='text-align:center;'>
              <text>
                <? echo " - ознака за ".$activity_tax_info[0]['nuPeriod']." ".$activity_tax_info[0]['yearShot']." :  ".$activity_tax_info[0]['sign']." ;" ?>
              <text>
            </p>
          <? } ?>
          <? if(isset($activity_tax_info[1])){ ?>
            <p style='text-align:center;'>
              <text>
                <? echo " - ознака за ".$activity_tax_info[1]['nuPeriod']." ".$activity_tax_info[1]['yearShot']." :  ".$activity_tax_info[1]['sign']." ;" ?>
              <text>
            </p>
          <? } ?>
          <div class="demo">
            <input class="hide" id="hd-3" type="checkbox">
            <label for="hd-3">Ознака активності за даними ДФС за <font style="color:red;"> інші періоди</font>: </label>
            <div>
              <? for ($i=2; $i < count($activity_tax_info) ; $i++) { ?>
                <p>
                  <? echo " - ознака за ".$activity_tax_info[$i]['nuPeriod']." ".$activity_tax_info[$i]['yearShot']." :  ".$activity_tax_info[$i]['sign']." ;" ?>
                </p>
              <? }  ?>
            </div>
          </div>
        </p>

        <p>
          <text>
            <b>Ознака наявності електронно цифрового підпису :</b>
          </text>
          <? if(isset($info_ecp[0])){ ?>
            <p style='text-align:center;'>
              <text>
                <? echo " - ознака наявності ЕЦП за ".$info_ecp[0]['nuYear']." рік :  ".$info_ecp[0]['el_info']." ;" ?>
              <text>
            </p>
          <? } ?>
          <div class="demo">
            <input class="hide" id="hd-4" type="checkbox">
            <label for="hd-4">Ознака наявності електронно цифрового підпису за <font style="color:red;"> інші періоди</font>: </label>
            <div>
              <? for ($i=1; $i < count($info_ecp) ; $i++) { ?>
                <p>
                  <? echo " - ознака наявності ЕЦП за ".$info_ecp[$i]['nuYear']." рік :  ".$info_ecp[$i]['el_info']." ;" ?>
                </p>
              <? }  ?>
            </div>
          </div>
        </p>

        <p>
          <text>
            <b> Відомості про згоду на використання інформації, отриманої за результатами ДСС в публікаціях :</b>
          </text>
          <? if(isset($info_consents[0])){ ?>
            <p style='text-align:center;'>
              <text>
                <? echo " - відомость про згоду на використання інформації,  в публікаціях за ".$info_consents[0]['nuYear']." рік :  ".$info_consents[0]['type']." ;" ?>
              <text>
            </p>
          <? } ?>
          <div class="demo">
            <input class="hide" id="hd-5" type="checkbox">
            <label for="hd-5">Відомості про згоду на використання інформації, отриманої за результатами ДСС в публікаціях за <font style="color:red;"> інші періоди</font>: </label>
            <div>
              <? for ($i=1; $i < count($info_consents) ; $i++) { ?>
                <p>
                  <? echo " - відомость про згоду на використання інформації,  в публікаціях за ".$info_consents[$i]['nuYear']." рік :  ".$info_consents[$i]['type']." ;" ?>
                </p>
              <? }  ?>
            </div>
          </div>
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
