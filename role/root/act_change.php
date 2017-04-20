<?
  require_once('../../lib/start.php');

  $filtr_kd=isset($_POST['kd']) ? stripslashes($_POST['kd']) : '';
  $filtr_kdmo=isset($_POST['kdmo']) ? stripslashes($_POST['kdmo']) : '';

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";

  if ($action=="edit") {
    $countUpd = 0;
    $checkElement = $_POST["checkList"];
    $arrAd = $_POST["textAd"];
    $arrRnl = $_POST["textRnl"];
    $arrDepartment=$_POST["depSelect"];
    $arrChange=$_POST["checkDead"];
    $textTest = $_POST["Ddata"];
    $textTest1 = $_POST["Ldata"];
    foreach ($checkElement as $key => $value){
    $arrType = $_POST["typeSelect_".$value];
      $query_str = "UPDATE `acts` SET"
        ." `ad`='".$arrAd[$value]."', `rnl`='".$arrRnl[$value]."',"
        ." `department`=".$arrDepartment[$value].",`da`='".$textTest[$value]."',"
        ." `da`='".dateToSqlFormat($textTest[$value])."',`dl`='".dateToSqlFormat($textTest1[$value])."', "
        ." `act`='".delTypeNullActs($arrType)."' WHERE id =".$value;
      mysqli_query($link,$query_str);
      $countUpd++;
  }
  $ERROR_MSG .= "<br />Оновлено: $countUpd запис(ів).";
}else if ($action=="del"){
  $countUpd = 0;
  $checkElement = $_POST["checkList"];
  foreach ($checkElement as $key => $value) {
    $query_str = "DELETE FROM `acts` WHERE `id` = ".$value;
    mysqli_query($link,$query_str);
    $countUpd++;
  }
  $ERROR_MSG .= "<br />Видалено: $countUpd запис(ів).";
}

  $where = array();
  if($filtr_kd!=""){
    $where[]=" t2.kd = '".$filtr_kd."'";
  }
  if($filtr_kdmo!=""){
    $where[]=" t2.kdmo = '".$filtr_kdmo."'";
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

  $qeruStrPaginathion="SELECT COUNT(t1.id) as resC FROM `acts`  as t1 "
    ." left join  organizations as t2 on t2.id=t1.org".$whereStrPa;


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

  $qeruStr="SELECT t2.kd, t2.kdmo, t1.* FROM `acts`  as t1 "
    ." left join  organizations as t2 on t2.id=t1.org".$whereStr;

  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $row["da"]=dateToDatapiclerFormat($row["da"]);
      $row["dl"]=dateToDatapiclerFormat($row["dl"]);
     $ListResult[]=$row+array('types'=>getTypeActMod($typeAct,$row['act'],$row['id']),'dep'=>getListDepatment($link,$row['department']) );
    }
    mysqli_free_result($result);
  }

  function delTypeNullActs($arr)
  {
    $str = array();
    foreach ($arr as $key => $value) {
      if($value != 0)
      {
        $str[]=$value;
      }
    }
    return implode(';',$str);
  }

  function getTypeActMod($arrType,$inputTypes,$idRow)
  {
    $str="";
    $res=explode(";",$inputTypes);
    if(count($res)!=0){
      foreach ($res as $key => $value) {
        if($value!=""){
          $str.= "<select class=\"amo\" name=\"typeSelect_".$idRow."[]\" style=width:180px;\" onchange=\"changeAmountAction('".$idRow."')\">".getListTypeAct($arrType,$value)."</select><br>";
        }
      }
    }else{
       $str.= "<select class=\"amo\" name=\"typeSelect_".$idRow."[]\" style=width:180px;\" onchange=\"changeAmountAction('".$idRow."')\">".getListTypeAct($arrType,0)."</select><br>";
    }
    return $str;
  }

  require_once('template/act_change.php');
?>
