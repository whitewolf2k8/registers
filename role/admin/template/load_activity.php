<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/pag.css" media="screen" type="text/css" />
<title>�������</title>
<link rel="shortcut icon" href="../../../images/favicon.png" type="image/png">

<script src="../../../js/jquery-1.7.2.js"></script>
<script src="../../../js/scripts.js"></script>
<script src="../../../js/knob.js"></script>
<script src="../../../js/script_activity_process.js"></script>
<script type="text/javascript">
function submitForm(mode) {
  correct = true;
  form = document.forms['adminForm'];
  if(mode=='import'){
    if (form.fileImp.value=="") {
      correct = false;
      document.getElementById('fileImp').className="error";
      document.getElementById('errorMes').className="error";
      document.getElementById('errorMes').innerHTML="<p>���� ����� ������ ���� ��� �������.</p>";
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
function tryRadius() {
  var x=  document.getElementById("cerc");
  var autoVal = 0;
  timer = setInterval(function() {
  $(".knob").val(autoVal);
  $(".knob").trigger('change');
    autoVal+=0.1;
    if(autoVal==101){
      clearInterval(timer);
    }
  }, 100);
}

function clicks() {
  document.getElementById('lo').innerHTML='<div id="preloader"></div>';
  document.getElementById('centered').removeAttribute("hidden");
  tryRadius();
}

  $(document).ready(function() {
    $("#filtr_kd_opf").ForceNumericOnly();
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

        <h2>������ ��������� �� ������ ���</h2>

        <form name="adminForm" action="load_activity.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />

          <div class="item_blue" style="float:left;margin-left:15%; width:300px;">
            <h2>����� �����</h2>
            <p><input type="file" id="fileImp"  accept=".dbf" name="fileImp" style="width:256px" /></p>
            <p style="text-align:center">����� �� ����  �����������</p>
            <p>
               <div class="navigation_left">��</div>
               <div class="navigation_right">
                  <select id="filtr_year_insert" name="filtr_year_insert" style="width:200px;text-align:center;"><? echo $insert_year; ?></select>
               </div>
            </p>
            <div class="clr"></div>
            <p>
               <div class="navigation_left">�����</div>
               <div class="navigation_right">
                  <select id="filtr_period_insert" name="filtr_period_insert" style="width:200px;text-align:center;"><? echo $insert_period; ?></select>
               </div>
            </p>
            <div class="clr"></div>
            <p align="center">
              <input type="button" value="�����������" class="button" onclick="submitForm('import')" />
              <input type="button" value="��������" class="button" onclick="cleanImport();" />
            </p>
        	</div>

          <div class="item_blue" style="float:right;margin-right:15%; width:320px;">
  	        <h2>����� �� </h2>
            <p align="center">
            	   <div class="navigation_left">���� ������</div>
                 <div class="navigation_right"><input align="right" type="text" id="filtr_kd_opf" maxlength="3" name="filtr_kd_opf" value="<?php echo $filtr_kd; ?>" style="width:130px;text-align:center;" /></div>
              <div class="clr"></div>
            </p>
            <p align="center">
            	   <div class="navigation_left">���� ����</div>
                 <div class="navigation_right"><input align="right" type="text" id="filtr_kd_opf" maxlength="3" name="filtr_kd_opf" value="<?php echo $filtr_kd; ?>" style="width:130px;text-align:center;" /></div>
              <div class="clr"></div>
            </p>
            <p style="text-align:center">������ �� ����  �������������</p>
            <p>
               <div class="navigation_left">��</div>
               <div class="navigation_right">
                  <select id="filtr_year_select" name="filtr_year_select" style="width:200px;text-align:center;"><? echo $insert_year; ?></select>
               </div>
            </p>
            <div class="clr"></div>
            <p>
              <div class="navigation_left">�����</div>
              <div class="navigation_right">
                <select id="filtr_period_select" name="filtr_period_select" style="width:200px;text-align:center;"><? echo $insert_period; ?></select>
              </div>
            </p>
            <div class="clr"></div>
            <p align="center">
    	        <input type="button" value="�����" class="button" onclick="submitForm('')"/>
    	      </p>
          </div>
          <div class="clr"></div>
          <div id="lo"></div>
          <div id="centered" hidden>
            <input class="knob"   readonly  data-width="150" data-displayPrevious=true data-fgColor="#0d932e" data-skin="tron" data-thickness=".2" value="75">
          </div>
        <? if(isset($ListResult)){ ?>
          <div align="center">
            <table>
              <tr>
                <th>&nbsp;</th>
                <th>������</th>
                <th>����</th>
                <th>�����</th>
                <th>�����</th>
                <th>������ ���������</th>
              </tr>

            <? foreach ($ListResult as $key => $value) {
              # code...
                echo "<tr>";
                echo "<td>".$value["kd"]."</td>";
                echo "<td>".$value["nu"]."</td>";
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
  <div id="toTop" > ^ ������ </div>
</body>
</html>
