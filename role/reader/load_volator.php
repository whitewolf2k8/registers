<?
  require_once('../../lib/start.php');

  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';
  $filtr_volator=isset($_POST['filtr_volator']) ? stripslashes($_POST['filtr_volator']) : '';

  $filtr_maneger = isset($_POST['filtr_maneger_select']) ? stripslashes($_POST['filtr_maneger_select']) : '';

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $ERROR_MSG="";

  $where = array();
  if($filtr_kd!=""){
    $where[]=" t2.kd = '".$filtr_kd."'";
  }

  if($filtr_kdmo!=""){
    $where[]=" t2.kdmo = '".$filtr_kdmo."'";
  }

  if($filtr_maneger!=""){
    $where[]=" t1.id_maneger = ".$filtr_maneger;
  }

  if($filtr_volator!=""){
    $where[]=" t1.volator like ('".$filtr_volator."')";
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );


  $qeruStrPaginathion="SELECT COUNT(t1.id) as resC FROM `violation_base`  as t1 "
    ." left join  organizations as t2 on t2.id=t1.id_org"
    ." left join managers as t3 on t3.id=t1.id_maneger ".$whereStrPa;
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

  $qeruStr="SELECT t2.kd, t2.kdmo, t1.decree, t1.volator, t3.nu FROM `violation_base`  as t1 "
    ." left join  organizations as t2 on t2.id=t1.id_org"
    ." left join managers as t3 on t3.id=t1.id_maneger ".$whereStr;



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
  $selected_menager= getListMeneger($link,$filtr_maneger);
  require_once('template/load_volator.php');
?>
