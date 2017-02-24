<?
  require_once('../../lib/start.php');

  $filtr_kd=isset($_POST['kd']) ? stripslashes($_POST['kd']) : '';
  $filtr_kdmo=isset($_POST['kdmo']) ? stripslashes($_POST['kdmo']) : '';

  $filtr_dis=isset($_POST['kodDis']) ? stripslashes($_POST['kodDis']) : '';

  $filtr_dep_nom=isset($_POST['kodDepNom']) ? stripslashes($_POST['kodDepNom']) : '';
  $filtr_dep_id=isset($_POST['kodDepList']) ? stripslashes($_POST['kodDepList']) : '';

  $filtr_arr_typse_act=isset($_POST['types']) ? $_POST['types'] : array(0,0);

    // $filtr_dateTest=isset($_POST['textTest']) ? stripslashes($_POST['textTest']) : '';
    // $filtr_dateTest1=isset($_POST['textTest1']) ? stripslashes($_POST['textTest1']) : '';

  $filtr_dateDelS=isset($_POST['dateDelS']) ? stripslashes($_POST['dateDelS']) : '';
  $filtr_dateDelE=isset($_POST['dateDelE']) ? stripslashes($_POST['dateDelE']) : '';

  $filtr_Kveds=isset($_POST['kveds']) ? $_POST['kveds'] : '';
  $filtr_Kises=isset($_POST['kises']) ? $_POST['kises'] : '';

  $filtr_Obl=isset($_POST['obl_select']) ? $_POST['obl_select'] : '';
  $filtr_Ray=isset($_POST['ray_select']) ? $_POST['ray_select'] : '';
  $filtr_Ter=isset($_POST['ter_select']) ? $_POST['ter_select'] : '';

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";

  if ($action=='edit') {
    $checkElement = $_POST["checkList"];
    $arrAd = $_POST["textAd"];
    $arrRnl = $_POST["textRnl"];
    $arrDepartment=$_POST["depSelect"];
    $arrType = $_POST["typeSelect"];
    $arrChange=$_POST["checkDead"];
    $textTest = $_POST["textTest"];
    $textTest1 = $_POST["textTest1"];
    foreach ($checkElement as $key => $value) {
      $query_str = "UPDATE `acts` SET"
        ." `ad`='".$arrAd[$value]."', `rnl`='".$arrRnl[$value]."',"
        ."`department`=".$arrDepartment[$value]." WHERE id =".$value;
      $queryStr="UPDATE `acts` SET `da`='".$textTest[$value]."',`dl`='".$textTest1[$value]."' WHERE id=".$value;
      mysqli_query($link,$queryStr);
      mysqli_query($link,$query_str);
      //  print_r($queryStr);
      $countUpd++;

  }
  $ERROR_MSG .= "<br />Оновлено: $countUpd запис(ів).";
}else if ($action=="del"){
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
    $where[]=" organ.kd = '".$filtr_kd."'";
  }
  if($filtr_kdmo!=""){
    $where[]=" organ.kdmo = '".$filtr_kdmo."'";
  }

  if($filtr_dis!=""){
    $where[]=" ac.rnl like ( '%".$filtr_dis."%')";
  }

  // if( $filtr_dateTest!="" && $filtr_dateTest1!=""){
  //   $where[]=" ac.da between (".dateToSqlFormat($filtr_dateTest)." and ".dateToSqlFormat($filtr_dateTest1)." )";
  // }else{
  //   if($filtr_dateTest!=""){
  //     $where[]=" ac.da >= '".dateToSqlFormat($filtr_dateTest)."'";
  //   }
  //   if($filtr_dateTest1!=""){
  //     $where[]=" ac.da <= '".dateToSqlFormat($filtr_dateTest1)."'";
  //   }
  // }

  $arrTypes=array();
  foreach ($filtr_arr_typse_act as $key => $value) {
    if($value!=0) $arrTypes[]= " (ac.act like ('%".$value."%'))";
  }
  $str=implode(' OR ', $arrTypes);
  if($str!=""){
    $where[]="(".$str.")";
  }


  if($filtr_dep_id!=0){
    $where[]=" ac.department = '".$filtr_dep_id."'";
  }
  $str ="";
  if($filtr_Kveds!=''){
    $kvedArr= getKveds($link, $filtr_Kveds);
    $kvedWhere=array();
    foreach ($kvedArr as $key => $value) {
      $kvedWhere[]=" organ.vdf10 like ('".$value."')";
    }
    $str=implode(' OR ', $kvedWhere);
    if($str!=""){
      $where[]=" (".$str.") ";
    }
  }

  if($filtr_Kises!=''){
    $kiseWhere=array();
    $fields = explode(",", $filtr_Kises);
    foreach ($fields as $key => $value) {
      $kvedWhere[]=" organ.kice like ('".substr($value,5)."')";
    }
    if($str=implode('OR', $kiseWhere)!=""){
      $where[]=" (".$str.") ";
    }
  }

  if($filtr_Obl!="" && $filtr_Ray!="" && $filtr_Ter!=""){
    $where[]="organ.te like ('".$filtr_Ter."')";
  }else{
    if($filtr_Ter=="" && $filtr_Ray!=""){
      $where[]="organ.te like ('".$filtr_Obl.$filtr_Ray."%')";
    }
    if($filtr_Obl!="" && $filtr_Ray==""){
      $where[]="organ.te like ('".$filtr_Obl."%')";;
    }
  }



  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

  $qeruStrPaginathion="SELECT COUNT(ac.id) as resC FROM `acts`  as ac "
    ." left join  organizations as organ on organ.id=ac.org".$whereStrPa;


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

  $qeruStr="SELECT organ.kd, organ.kdmo, ac.* FROM `acts`  as ac "
    ." left join  organizations as organ on organ.id=ac.org".$whereStr;

  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $row["da"]=dateToDatapiclerFormat($row["da"]);
      $row["dl"]=dateToDatapiclerFormat($row["dl"]);
     $ListResult[]=$row+array('types'=>getTypeAct($typeAct,$row['act']),'dep'=>getListDepatment($link,$row['department']) );
    }
    mysqli_free_result($result);
  }

  function getTyps($arrType, $arrInput)
  {
      $result="";
      $count=count($arrInput);
          $result.="<select name=\"types\" style=\"width:150px;\">".getListTypeAct($arrType,$value)."</select>";
      return $result;
  }

  // $filtr_arr_typse_act

  $html_type=getTyps($typeAct,$filtr_arr_typse_act);

  $list_department=getListDepatment($link,$filtr_d);
  $list_department=getListDepatment($link,$filtr_dep_id);

  $html_kved=getKvedHtml($link,$filtr_Kveds);
  $html_kises=getKisedHtml($link,$filtr_Kises);

  $select_obl=getListObl($link, $filtr_Obl);
  $select_ray=getListRay($link, $filtr_Obl,$filtr_Ray);
  $select_ter=getListTeritorys($link, $filtr_Obl,$filtr_Ray,$filtr_Ter);

  require_once('template/act_change.php');
?>
