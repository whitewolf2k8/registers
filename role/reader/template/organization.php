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
            </p>
            <div class="clr"></div>
            <div id ="ur_adres">
              <? if(isset($addres)){
                foreach ($addres as $key => $value) { ?>
                  <p>
                    <text > - <? echo "Код території(повний/короткий):".$value["tea"]."/"
                      .$value["te"].", адреса : ".$value["pi"].",".$value['ad'];?>
                    </text>

                  </p>
              <? }
              } ?>
            </div>
            <div class="clr"></div>
            <p>
              <text> <b> Контактні дані: </b></text>
            </p>
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
<div id="toTop" > ^ Наверх </div>
</body>
</html>
