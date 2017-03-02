<?
    require_once('../../lib/start.php');

    $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
    $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';
    $filtr_manager_deal=isset($_POST['filtr_manager_deal']) ? stripslashes($_POST['filtr_manager_deal']) : '';
    $filtr_deal_number=isset($_POST['filtr_deal_number']) ? stripslashes($_POST['filtr_deal_number']) : '';
    $filtr_date_deal=isset($_POST['filtr_date_deal']) ? stripslashes($_POST['filtr_date_deal']) : '';
    $filtr_type_deal=isset($_POST['filtr_type_deal']) ? stripslashes($_POST['filtr_type_deal']) : '0';

    $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
    $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

    $ERROR_MSG="";

    $where = array();

    $filtr_kd = str_replace(" ","",$filtr_kd);

    if($filtr_kd!=""){
      $where[]="t2.kd =".$filtr_kd;
    }

    if($filtr_kdmo!=""){
      $where[]=" t2.kdmo = '".$filtr_kdmo."'";
    }
    if($filtr_deal_number!=""){
      $where[]=" t1.deal_number LIKE('".$filtr_deal_number."')";
    }
    if($filtr_date_deal!=""){
      $where[]=" t1.date_deal = '".dateToSqlFormat($filtr_date_deal)."'";
    }
    if($filtr_type_deal!="0"){
      $where[]=" t1.type_deal LIKE ('".$filtr_type_deal."')";
    }

    $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

    $qeruStrPaginathion="SELECT COUNT(t1.id) as resC  FROM bankrupts as t1"
      ." left join organizations as t2 on t2.id=t1.id_org" .$whereStrPa;

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

     $qeruStr="SELECT t2.kd,t2.kdmo, t1.* FROM "
      ." bankrupts as t1 "
      ." left join organizations as t2 on t2.id=t1.id_org".$whereStr;

    $result = mysqli_query($link,$qeruStr);
    if($result){
      $ListResult=array();
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $row["date_deal"]= dateToDatapiclerFormat($row["date_deal"]);
        $ListResult[]=$row;
      }
      mysqli_free_result($result);
    }

    $list_bankrupts=getListBankruts($link,$filtr_type_deal);

    require_once('template/load_bankrut.php');
?>
