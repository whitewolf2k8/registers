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
        <object data=<? echo "\"".$path."\""; ?> type="application/pdf"  style=" margin-left: 10%; margin-right: 10%;width: 80%; height: 80vh; ">
        </object>
      </div>
	  </div><!-- .content -->
  </div><!-- .wrapper -->

<div class="footer">
	 <?php  require_once('footer.php'); ?>
</div>


</body>
</html>
