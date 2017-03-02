<?
  session_start();
  $max = isset($_SESSION['max']) ? $_SESSION['max'] : '';
  $now = isset($_SESSION['ls_sleep_test']) ? $_SESSION['ls_sleep_test'] : '';
//  echo $max."  -- ";
//  echo $now." == ";
  if($max=="" || $now==""){
    echo 0 ;
  }else{
    echo sprintf("%.2f", (($now/$max)*100));
  }

?>
