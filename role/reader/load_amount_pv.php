<?
  require_once('../../lib/start.php');

  $filtr_year_select=isset($_POST['filtry_year_select']) ? stripslashes($_POST['filtry_year_select']) : 0;
  $filtr_period_select=isset($_POST['filtr_period_select']) ? stripslashes($_POST['filtr_period_select']) : 0;

  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $ERROR_MSG="";

  $where = array();
  $where[]=' cn.type = 0';
  if($filtr_kd!=""){
    $where[]=" org.kd = '".$filtr_kd."'";
  }
  if($filtr_kdmo!=""){
    $where[]=" org.kdmo = '".$filtr_kdmo."'";
  }
  if($filtr_year_select!=""){
    $where[]=" cn.id_year = ".$filtr_year_select;
  }
  if($filtr_period_select!=""){
    $where[]=" cn.id_period = ".$filtr_period_select;
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(cn.id) as resC FROM `amount_workers`  as cn "
    ." left join  organizations as org on org.id=cn.id_org"
    ." left join year as y on y.id=cn.id_year "
    ." left join period as p on p.id=cn.id_period ".$whereStrPa;
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


  $qeruStr="SELECT cn.id, org.nu as nu_org ,cn.amount, y.short_nu as nu_year, p.nu as nu_period FROM `amount_workers`  as cn "
    ." left join  organizations as org on org.id=cn.id_org"
    ." left join year as y on y.id=cn.id_year "
    ." left join period as p on p.id=cn.id_period ".$whereStr;

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

  require_once('template/load_amount_pv.php');
?>
