<?
  require_once('../../lib/start.php');

  print_r($_POST);


  $filtr_kd=isset($_POST['kd']) ? stripslashes($_POST['kd']) : '';
  $filtr_kdmo=isset($_POST['kdmo']) ? stripslashes($_POST['kdmo']) : '';

  $filtr_dateReS=isset($_POST['dateReS']) ? stripslashes($_POST['dateReS']) : '';
  $filtr_dateReE=isset($_POST['dateReS']) ? stripslashes($_POST['dateReS']) : '';

  $filtr_dateDelS=isset($_POST['dateDelS']) ? stripslashes($_POST['dateDelS']) : '';
  $filtr_dateDelE=isset($_POST['dateDelE']) ? stripslashes($_POST['dateDelE']) : '';

  $filtr_Kveds=isset($_POST['kveds']) ? $_POST['kveds'] : '';
  $filtr_Kises=isset($_POST['kises']) ? $_POST['kises'] : '';
  $filtr_Contols=isset($_POST['controlArr']) ? $_POST['controlArr'] : '';

  $filtr_OblF=isset($_POST['obl_select']) ? $_POST['obl_select'] : '';
  $filtr_RayF=isset($_POST['ray_select']) ? $_POST['ray_select'] : '';
  $filtr_TerF=isset($_POST['ter_select']) ? $_POST['ter_select'] : '';

  $filtr_OblU=isset($_POST['obl_select']) ? $_POST['obl_select'] : '';
  $filtr_RayU=isset($_POST['ray_select']) ? $_POST['ray_select'] : '';
  $filtr_TerU=isset($_POST['ter_select']) ? $_POST['ter_select'] : '';

  $filtr_flag=isset($_POST['flag_group']) ? $_POST['flag_group'] : '';
  $filtr_opf=isset($_POST['opf_S']) ? $_POST['opf_S'] : '';
  if($filtr_flag!="" && in_array("3",$filtr_flag))
  {
    $filtr_arr_typse_act=isset($_POST['types']) ? $_POST['types'] : array(0);
  }

  $arrfild= isset($_POST['filds'])? $_POST['filds'] :  array('kd','kdmo','nu','pk','kdg','te','tea','ad','pi');

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";

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

  if( $filtr_dateActS!="" && $filtr_dateActE!=""){
    $where[]=" ac.da between (".dateToSqlFormat($filtr_dateActS)." and ".dateToSqlFormat($filtr_dateActE)." )";
  }else{
    if($filtr_dateActS!=""){
      $where[]=" ac.da >= '".dateToSqlFormat($filtr_dateActS)."'";
    }
    if($filtr_dateActE!=""){
      $where[]=" ac.da <= '".dateToSqlFormat($filtr_dateActE)."'";
    }
  }



  if( $filtr_dateDelS!="" && $filtr_dateDelE!=""){
    $where[]=" ac.dl between (".dateToSqlFormat($filtr_dateDelS)." and ".dateToSqlFormat($filtr_dateDelE)." )";
  }else{
    if($filtr_dateDelS!=""){
      $where[]=" ac.dl >= '".dateToSqlFormat($filtr_dateDelS)."'";
    }
    if($filtr_dateDelE!=""){
      $where[]=" ac.dl <= '".dateToSqlFormat($filtr_dateDelE)."'";
    }
  }

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


  $qeruStr="SELECT".$fild."";  

  $qeruStr="SELECT organ.kd, organ.kdmo, ac.* FROM `acts`  as ac "
    ." left join  organizations as organ on organ.id=ac.org".$whereStr;

  //echo $qeruStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $row["da"]=dateToDatapiclerFormat($row["da"]);
      $row["dl"]=dateToDatapiclerFormat($row["dl"]);
      $ListResult[]=$row+array('types' =>getTypeAct($typeAct,$row['act']),'dep'=>getDepartmentNu($link,$row['department']) );
    }
    mysqli_free_result($result);
  }


  $list_department=getListDepatment($link,$filtr_dep_id);
  $html_type=getTypsHtml($typeAct,(isset($filtr_arr_typse_act))?$filtr_arr_typse_act:array(0));
  $html_kved=getKvedHtml($link,$filtr_Kveds);
  $html_kises=getKisedHtml($link,$filtr_Kises);
  $html_opf=getOpfHtml($link,$filtr_opf);
  $html_control=getControlsHtml($link,$filtr_Contols);

  $select_obl=getListObl($link, $filtr_Obl);
  $select_ray=getListRay($link, $filtr_Obl,$filtr_Ray);
  $select_ter=getListTeritorys($link, $filtr_Obl,$filtr_Ray,$filtr_Ter);

  require_once('template/picks_organizations.php');
?>
