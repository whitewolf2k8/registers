<?
  require_once('../../lib/start.php');

  $filtr_kodu=isset($_POST['filtr_kodu']) ? stripslashes($_POST['filtr_kodu']) : '';
  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;
  $filtr_obl_s=isset($_POST['filtr_obl']) ? stripslashes($_POST['filtr_obl']) : '';
  $filtr_region_s=isset($_POST['filtr_region']) ? stripslashes($_POST['filtr_region']) : '';

  $ERROR_MSG="";

  $where = array();
  if($filtr_obl_s!=""){
    $where[]="te like  ('".$filtr_obl_s.$filtr_region_s."%') ";
  }
  if($filtr_kodu!=""){
    $where[]="te like  ('".$filtr_kodu."') ";
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(*) as resC FROM `koatuu` ".$whereStrPa;
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

  $qeruStr="SELECT * FROM `koatuu` ".$whereStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  $filtr_obl=getListObl($link, $filtr_obl_s);
  $filtr_region=getListTeR($link,$filtr_obl_s, $filtr_region_s);
  closeConnect($link);
  require_once('template/load_koatuu.php');
?>
