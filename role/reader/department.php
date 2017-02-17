<?
  require_once('../../lib/start.php');

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;
  $filtr_nu= isset($_POST['filtr_nu']) ? stripslashes(trim($_POST['filtr_nu'])) :"";

  $ERROR_MSG="";

  $where = array();

  if($filtr_nu!=""){
    $where[]=" nu  Like ('%".$filtr_nu."%')";
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(id) as resC FROM `depatment`  ".$whereStrPa;
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

  $qeruStr="SELECT * FROM `depatment` ".$whereStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  require_once('template/department.php');
?>
