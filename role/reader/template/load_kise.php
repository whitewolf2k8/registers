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
<script type="text/javascript">
function submitForm(mode) {
  correct = true;
  form = document.forms['adminForm'];
  if(mode=='import'){
    if (form.fileImp.value=="") {
      correct = false;
      text='';
      text+=' - ������ ��� ����; <br>'
      document.getElementById('fileImp').className="error";
      document.getElementById('errorMes').innerHTML="<p>���� ����� ������ ���� :</p>"+text;
    }
  }
  if (correct) {
    document.getElementById('lo').innerHTML='<div id="preloader"></div>';
    form.mode.value = mode;
    form.submit();
  }
}
</script>
<script src="../../../js/scripts.js"></script>
</head>

<body>

  <div class="wrapper">

	  <div class="header">
         <?php  require_once('header.php'); ?>
	  </div>

	  <div class="content">
      <div class="mainConteiner">
        <?php if ($ERROR_MSG != '') echo '<p class="error">'.$ERROR_MSG.'</p>';?>
        <h2>������� ʲ�� - 2014 </h2>

        <form name="adminForm" action="load_kise.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <input type="hidden" name="limitstart" value="0"/>
          <input type="hidden" name="limit" <? echo "value='".$paginathionLimit."'"; ?> />

          <div class="item_blue" style="float:right;margin-right:38%; width:320px;">
  	        <h2>����� �� �������� ʲ�� 2014</h2>
            <p align="center">
              <p>
            	   <div class="navigation_left">����� �� ������ ʲ��:</div>
                 <div class="navigation_right"><input type="text" name="filtr_kise_kd" value="<?php echo $filtr_kise_kd; ?>" style="width:130px" /></div>
              </p>
              <div class="clr"></div>
              <p>
            	   <div class="navigation_left">����� �� ���� ʲ��:</div>
                 <div class="navigation_right"><input  type="text" name="filtr_kise_kod" value="<?php echo $filtr_kise_kod; ?>" style="width:130px" /></div>
              </p>
               <div class="clr"></div>
            </p>
              <div class="clr"></div>
            <p align="center">
  	          <input type="button" value="�����" class="button" onclick="submitForm('')" />
  	        </p>
  	    	</div>
          <div class="clr"></div>
          <div id="lo"></div>

        <? if(isset($ListResult)){ ?>
          <div align="center">
            <table>
              <tr>
                <th>KD</th>
                <th>���</th>
                <th>�����</th>
              </tr>
            <? foreach ($ListResult as $key => $value) {
              # code...
                echo "<tr>";
                echo "<td>".$value["kd"]."</td>";
                echo "<td>".$value["kod"]."</td>";
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
