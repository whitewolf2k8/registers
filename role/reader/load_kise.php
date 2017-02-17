<?
  require_once('../../lib/start.php');

  $filtr_kise_kd=isset($_POST['filtr_kise_kd']) ? stripslashes($_POST['filtr_kise_kd']) : '';
  $filtr_kise_kod=isset($_POST['filtr_kise_kod']) ? ((stripslashes($_POST['filtr_kise_kod'])=="") ? 'S.':stripslashes($_POST['filtr_kise_kod'])) : 'S.';
  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $ERROR_MSG="";

  $where = array();
  if($filtr_kise_kd!=""){
    $filtr_kise_kd1=formatKdKise14($filtr_kise_kd);
    if(iconv_strlen($filtr_kise_kd1, "Windows-1251")==1||iconv_strlen($filtr_kise_kd1, "Windows-1251")==4){

      $where[]=' (`kd` = '.$filtr_kise_kd1.' ) ';
    }else{
      $ERROR_MSG.= "<br>".$filtr_kise_kd1;
    }
  }
  if(str_replace(" ","",$filtr_kise_kod)!="S."){
    $filtr_kise_kod1=formatKodKise14($filtr_kise_kod);
    if(iconv_strlen($filtr_kise_kod1, "Windows-1251")<=8){
      $where[]=" (`kod` = '".$filtr_kise_kod1."' ) ";
      $filtr_kise_kod=$filtr_kise_kod1;
    }else{
      $ERROR_MSG.= "<br>".$filtr_kise_kod1;
    }
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(*) as resC FROM `kise14` ".$whereStrPa;
  $resultPa = mysqli_query($link,$qeruStrPaginathion);
  if($resultPa){
    $r=mysqli_fetch_array($resultPa, MYSQLI_ASSOC);
    $rowCount=$r['resC'];
  }
  mysqli_free_result($resultPa);
  if($rowCount>0){
      $pagination.=getPaginator($rowCount,$paginathionLimit,$paginathionLimitStart);
  }
  $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  if($paginathionLimit!=0 ){

    $whereStr.=' LIMIT '.$paginathionLimitStart.','.$paginathionLimit;
  }


  $qeruStr="SELECT * FROM `kise14` ".$whereStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  require_once('template/load_kise.php');
?>
