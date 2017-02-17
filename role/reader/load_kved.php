<?
  require_once('../../lib/start.php');

  $filtr_kved_kod=isset($_POST['filtr_kved_kod']) ? stripslashes($_POST['filtr_kved_kod']) : '';
  $filtr_kved_kategory=isset($_POST['filtr_kved_kategory']) ? stripslashes($_POST['filtr_kved_kategory']) : '';
  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $ERROR_MSG="";

  $where = array();
  if($filtr_kved_kod!=""){
    $filtr_kved_kod1=formatKodKved10($filtr_kved_kod);
    if(iconv_strlen($filtr_kved_kod1, "Windows-1251")==5){
      $where[]=' (`kod` LIKE "'.$filtr_kved_kod1.'" ) ';
      $filtr_kved_kod=str_replace(" ","",$filtr_kved_kod1);
    }else{
      $ERROR_MSG.= "<br>".$filtr_kved_kod1;
    }
  }
  if($filtr_kved_kategory!=""){
    $where[]='(`sek` LIKE "'.$filtr_kved_kategory.'" ) ';
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(*) as resC FROM `kved10` ".$whereStrPa;
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
  $qeruStr="SELECT * FROM `kved10` ".$whereStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  $list_kved_kategory=getListKvedSek($link, $filtr_kved_kategory);
  require_once('template/load_kved.php');
?>
