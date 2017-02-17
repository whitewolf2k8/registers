<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/pag.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/modal-contact-form.css"  type="text/css" />
<title>Головна</title>
<link rel="shortcut icon" href="../../../images/favicon.png" type="image/png">

<script src="../../../js/jquery-1.7.2.js"></script>
<script src="../../../js/scripts.js"></script>
<script src="../../../js/script_fact_adress.js"></script>
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
        <div id='errorMes' style='display="none"'>
      		    <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
      	</div>

        <h2>Довідник відділів</h2>

        <form name="adminForm" action="department.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />

          <div class="item_blue" style="float:left;margin-left:39%; width:320px;">
  	        <p>
          	   <div class="navigation_left">Пошук по назві</div>
               <div class="navigation_right"><input align="right" type="text" id="filtr_nu"  name="filtr_nu" value="<?php echo $filtr_nu; ?>" style="width:160px;text-align:center;" /></div>
            </p>
            <div class="clr"></div>
            <div class="clr"></div>
            <p align="center">
  	          <input type="button" value="Пошук" class="button" onclick="submitForm('')" />

  	        </p>
  	    	</div>

          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){ ?>
          <div align="center">
            <table id="table_id">
              <tr>
                <th>Назва</th>
                <th>Номер</th>
                <th>Не активний</th>
              </tr>
            <? foreach ($ListResult as $key => $value) {
                echo "<tr id=\"".$value['id']."\"  ".(($value['dead']==1)?"class=\"notactive\"":"").">";
                echo "<td style =\" overflow:hidden;\" >".$value["nu"]."</td>";
                echo "<td style =\" overflow:hidden;\" >".$value["nom"]."</td>";
                echo "<td style =\" overflow:visible\" > <input type=\"checkbox\"  name=\"checkList[]\" value=\"".$value["id"]."\" onclick=\"return false\" /></td>";
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
