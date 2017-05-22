<?
  require_once('../../lib/start.php');

  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';

  $periodSelect=isset($_POST['filtr_period_select'])?$_POST['filtr_period_select']:0;
  $yearSelect=isset($_POST['filtr_year_select'])?$_POST['filtr_year_select']:0;


  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";

  $where= array();
  if(delSpace($filtr_kd)!=''){
    $where[]=" t2.kd like('".delSpace($filtr_kd)."') ";
  }

  if(delSpace($filtr_kdmo)!=''){
    $where[]=" t2.kdmo like('".delSpace($filtr_kdmo)."') ";
  }

  if($periodSelect!=0){
    $where[]=" t1.id_period = ".$periodSelect;
  }

  if($yearSelect!=0){
    $where[]=" t1.id_year = ".$yearSelect;
  }


  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(t1.id) as resC  FROM `activity_tax` as t1 "
    ." left join organizations as t2 on t2.id=t1.id_org"
    ." left join `year` as t3 on t3.id=t1.id_year "
    ." left join `period` as t4 on t4.id=t1.id_period ".$whereStrPa;

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

   $qeruStr="SELECT t2.kd,t2.kdmo,t2.nu,t3.short_nu,t4.nu as Nuperiod,t1.sign FROM "
    ." `activity_tax` as t1 "
    ." left join organizations as t2 on t2.id=t1.id_org"
    ." left join `year` as t3 on t3.id=t1.id_year "
    ." left join `period` as t4 on t4.id=t1.id_period ".$whereStr;


  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }


  $insert_year= getListYear($link,0,1," - не обрано - ");
  $insert_period= getListPeriod($link,0," - не обрано - ");


  $select_year= getListYear($link,$yearSelect,1," - не обрано - ");
  $select_period= getListPeriod($link,$periodSelect," - не обрано - ");

  require_once('template/load_activity.php');
?>
