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
    if (correct) {
      document.getElementById('lo').innerHTML='<div id="preloader"></div>';
      form.mode.value = mode;
      var x = document.getElementsByName("limitstart");
        x[0].value=0;
      form.submit();
    }
  }
  function formCleanList(arr) {
    document.getElementById("filtr_year_insert").innerHTML=arr.insert_year;
    document.getElementById("filtr_period_insert").innerHTML=arr.insert_period;
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

        <h2>Середня кількість працівників із форми 1-ПВ по періодах</h2>

        <form name="adminForm" action="load_amount_pv.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />

          <div class="item_blue" style="float:right;margin-right:39%; width:320px;">
  	        <h2>Пошук</h2>
            <p>
          	   <div class="navigation_left">Пошук по ЄДРПОУ</div>
               <div class="navigation_right"><input align="right" type="text" id="filtr_kd"  name="filtr_kd" value="<?php echo $filtr_kd; ?>" style="width:177px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <p>
          	   <div class="navigation_left">Пошук по "Kdmo"</div>
               <div class="navigation_right"><input align="right" type="text" id="filtr_kdmo" name="filtr_kdmo" value="<?php echo $filtr_kdmo; ?>" style="width:180px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <p>
               <div class="navigation_left">рік</div>
               <div class="navigation_right">
                  <select id="filtr_year_select" name="filtry_year_select" style="width:200px;text-align:center;"><? echo $select_year; ?></select>
               </div>
            </p>
            <div class="clr"></div>
            <p>
               <div class="navigation_left">період</div>
               <div class="navigation_right">
                  <select id="filtr_period_select" name="filtr_period_select" style="width:200px;text-align:center;"><? echo $select_period; ?></select>
               </div>
            </p>
            <div class="clr"></div>
            <p align="center">
  	          <input type="button" value="Пошук" class="button" onclick="submitForm('')" />
  	        </p>
  	    	</div>

          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){ ?>
          <div id="table_id" align="center">
            <table>
              <tr>
                <th>Підприємство</th>
                <th>Період</th>
                <th>Чисельність</th>
              </tr>
            <? foreach ($ListResult as $key => $value) {
                echo "<tr>";
                echo "<td style =\" overflow:hidden;\" >".$value["nu_org"]."</td>";
                echo "<td style =\" overflow:hidden;white-space:nowrap;\" >".$value["nu_period"]." ".$value["nu_year"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["amount"]."</td>";
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
