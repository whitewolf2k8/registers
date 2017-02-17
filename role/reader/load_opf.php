<?
  require_once('../../lib/start.php');

  $filtr_kd=isset($_POST['filtr_kd_opf']) ? stripslashes($_POST['filtr_kd_opf']) : '';
  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $ERROR_MSG="";

  $where = array();
  if($filtr_kd!=""){
    $where[]=' `kd` = '.$filtr_kd;
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(*) as resC FROM `opf` ".$whereStrPa;
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

  $qeruStr="SELECT * FROM `opf` ".$whereStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  require_once('template/load_opf.php');
?>
