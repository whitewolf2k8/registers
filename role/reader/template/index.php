<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="../../../css/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../../../css/style_menu.css" media="screen" type="text/css" />
<title>Головна</title>
<link rel="shortcut icon" href="/images/favicon.png" type="image/png">

<script src="../../../js/jquery-1.7.2.js"></script>
<script src="../../../js/scripts.js"></script>
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

  $(document).ready(function(){
	     	 $("#my_name").keypress(function(e){
	     	   if(e.keyCode==13){
	     	   //нажата клавиша enter - здесь ваш код
	     	   }
	     	 });

	     });

  jQuery.fn.ForceEnter =function(){
     $(this).keyup(function(event){
       if(event.keyCode == 13){
         submitForm('');

       }
     });
  }
  $(document).ready(function() {
    $("#filtr_edrpou").ForceNumericOnly();
    $("#filtr_kdmo").ForceNumericOnly();
    $("#filtr_edrpou").ForceEnter();
    $("#filtr_kdmo").ForceEnter();
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
        <form name="adminForm" action="index.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" />
          <div class="item_blue" style="margin-left:40%;margin-top:10%; width:320px;">
            <h2 style="text-align:center;">Пошук підприємства по</h2>
            <p align="center">
              <p>
            	   <div class="navigation_left" style="margin-left:10px;">ЄДРПОУ</div>
                 <div class="navigation_right"><input align="right" type="text" id="filtr_edrpou" maxlength="8" name="filtr_edrpou" style="width:200px;text-align:center;" /></div>
              </p>
              <div class="clr"></div>
              <p>
            	   <div class="navigation_left"  style="margin-left:10px;">КДМО</div>
                 <div class="navigation_right"><input align="right" type="text" id="filtr_kdmo" maxlength="12" name="filtr_kdmo" style="width:200px;text-align:center;" /></div>
              </p>
              <div class="clr"></div>
            </p>
            <div class="clr"></div>
            <p align="center">
  	          <input type="button" value="Розпочати пошук" class="button" onclick="submitForm('')" />
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

<!--  <H2>Зарегестрировался Урааа </H2>
  <?
  //  echo $_SESSION['name'];
  ?>
  !-->
</body>
</html>
