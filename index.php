<?php
  require_once('lib/setting.php');
  require_once('lib/function.php');

  $login=isset($_POST['login']) ? stripslashes($_POST['login']) : '';
  $password=isset($_POST['password']) ? stripslashes($_POST['password']) : '';
  session_start();

  if(isset($_SESSION['id']))
  {
    header('Location: role/'.$_SESSION['locathion']);
  }else if($login!=""){
    $link=connectingDb();
    $res=checkUser($link,$login,$password);
    if($res!=false)
    {
    //  session_name("aleks");
      session_start();
      session_unset();
		  $_SESSION['id'] = $res["id"];
			$_SESSION['name'] = $res["login"];
      $_SESSION['type'] = $res["type"];
      $_SESSION['locathion'] = $res["locathion"];

		  header('Location: role/'.$res["locathion"]);
      //  print_r($res);
    }else {
      if(checkExistsLogin($link,$login))
      {
        $errorMes="Ви ввели некоретний пароль";
      }else{
        $errorMes="Пара \"Логін - Пароль\" не існує в системі";
      }
    }
    closeConnect($link);
  }

  require_once('template/index.php');
?>
