<?
  require_once('../../lib/start.php');

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;
  $filtr_pib= isset($_POST['filtr_pib']) ? stripslashes(trim($_POST['filtr_pib'])) :"";
  $filtr_d=isset($_POST['filtr_dep'])?$_POST['filtr_dep']:0;

  $ERROR_MSG="";

  $where = array();
  if($filtr_pib!=""){
    $where[]=" managers.nu  Like ('%".$filtr_pib."%')";
  }

  if($filtr_d!=0){
    $where[]=" `depatment`=".$filtr_d;
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(id) as resC FROM `managers` ".$whereStrPa;
  $resultPa = mysqli_query($link,$qeruStrPaginathion);
  if($resultPa){
    $r=mysqli_fetch_array($resultPa, MYSQLI_ASSOC);
    $rowCount=$r['resC'];
    mysqli_free_result($resultPa);
  }

  if($rowCount>0){
      $pagination.=getPaginator($rowCount,$paginathionLimit,$paginathionLimitStart);
  }
  $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  if($paginathionLimit!=0 ){
    $whereStr.=' LIMIT '.$paginathionLimitStart.','.$paginathionLimit;
  }

  $qeruStr="SELECT dep.nu as depnu,managers.* FROM `managers`left join depatment as dep on dep.id=managers.depatment ".$whereStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  $list_department=getListDepatment($link,$filtr_d);
  require_once('template/manegers.php');
?>
