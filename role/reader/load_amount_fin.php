<?
  require_once('../../lib/start.php');

  $filtr_year_select=isset($_POST['filtry_year_select']) ? stripslashes($_POST['filtry_year_select']) : 0;
  $filtr_period_select=isset($_POST['filtr_period_select']) ? stripslashes($_POST['filtr_period_select']) : 0;

  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $filtr_type_table=isset($_POST['typeShow'])?$_POST['typeShow']:0;

  $ERROR_MSG="";

  $table=(($filtr_type_table==0)?"`amount_workers`":"profit_fin");

  $where = array();
  if($filtr_type_table!=1){
    $where[]=' t1.type = 1';
  }

  if($filtr_kd!=""){
    $where[]=" t2.kd = '".$filtr_kd."'";
  }
  if($filtr_kdmo!=""){
    $where[]=" t2.kdmo = '".$filtr_kdmo."'";
  }
  if($filtr_year_select!=""){
    $where[]=" t1.id_year = ".$filtr_year_select;
  }
  if($filtr_period_select!=""){
    $where[]=" t1.id_period = ".$filtr_period_select;
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(t1.id) as resC FROM ".$table."  as t1 "
    ." left join  organizations as t2 on t2.id=t1.id_org"
    ." left join year as t3 on t3.id=t1.id_year "
    ." left join period as t4 on t4.id=t1.id_period ".$whereStrPa;

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


  $qeruStr="SELECT t2.nu as nu_org , t3.short_nu as nu_year, t4.nu as nu_period"
    . " , t1.".(($filtr_type_table==0)?"amount":"profit")." as res  FROM ".$table." as t1 "
    ." left join  organizations as t2 on t2.id=t1.id_org"
    ." left join year as t3 on t3.id=t1.id_year "
    ." left join period as t4 on t4.id=t1.id_period ".$whereStr;

//  echo $qeruStr;

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

  require_once('template/load_amount_fin.php');
?>
