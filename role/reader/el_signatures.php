<?
  require_once('../../lib/start.php');

  $filtr_year_insert=isset($_POST['filtr_year_insert']) ? stripslashes($_POST['filtr_year_insert']) : 0;
  $filtr_year_select=isset($_POST['filtry_year_select']) ? stripslashes($_POST['filtry_year_select']) : 0;

  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;


  $ERROR_MSG="";

  $where = array();
   $where[]=' t1.id_org != 0';
  if($filtr_kd!=""){
    $where[]=" t2.kd = '".$filtr_kd."'";
  }
  if($filtr_kdmo!=""){
    $where[]=" t2.kdmo = '".$filtr_kdmo."'";
  }
  if($filtr_year_select!=""){
    $where[]=" t1.id_year = ".$filtr_year_select;
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(t1.id) as resC   FROM  el_signatures as t1"
  ." left join organizations as t2 on t2.id=t1.id_org"
  ." left join year as t3 on t3.id=t1.id_year".$whereStrPa;
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

  $qeruStr="SELECT t3.nu, t2.kd,t2.kdmo,t1.* FROM "
      ." el_signatures as t1 "
      ." left join organizations as t2 on t2.id=t1.id_org"
      ." left join year as t3 on t3.id=t1.id_year".$whereStr;

  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      //$row['year']=getYear($link,$row['year']);
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  $insert_year= getListYear($link,0,0);
  $insert_period= getListPeriod($link,0);

  $select_year= getListYear($link,$filtr_year_select,1);
  $select_period= getListPeriod($link,$filtr_period_select);

  require_once('template/el_signatures.php');


?>
