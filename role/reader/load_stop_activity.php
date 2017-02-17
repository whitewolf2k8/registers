<?
  require_once('../../lib/start.php');


  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';
  $filtr_data_type=isset($_POST['filtr_data_type']) ? stripslashes($_POST['filtr_data_type']) : '';


  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $ERROR_MSG="";

  $where = array();
  $where[]=' t1.type = 1';
  if($filtr_kd!=""){
    $where[]=" t2.kd = '".$filtr_kd."'";
  }
  if($filtr_kdmo!=""){
    $where[]=" t2.kdmo = '".$filtr_kdmo."'";
  }
  if($filtr_data_type!=""){
    $where[]=" t1.label LIKE('%".$filtr_data_type."%')";
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(t1.id) as resC FROM `letter_base`  as t1 "
    ." left join  organizations as t2 on t2.id=t1.id_org".$whereStrPa;
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


  $qeruStr="SELECT t2.kd , t2.kdmo, t1.label FROM `letter_base`  as t1 "
    ." left join  organizations as t2 on t2.id=t1.id_org".$whereStr;

  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  $insert_year= getListYear($link,0,0);
  $insert_period= getListPeriod($link,0);

  $select_year= getListYear($link,$filtr_year_select,1);
  $select_period= getListPeriod($link,$filtr_period_select);

  require_once('template/load_stop_activity.php');
?>
