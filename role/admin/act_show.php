<?
  require_once('../../lib/start.php');

  print_r($_POST);

  $filtr_kd=isset($_POST['kd']) ? stripslashes($_POST['kd']) : '';
  $filtr_kdmo=isset($_POST['kdmo']) ? stripslashes($_POST['kdmo']) : '';

  $filtr_dis=isset($_POST['kodDis']) ? stripslashes($_POST['kodDis']) : '';

  $filtr_dep_nom=isset($_POST['kodDepNom']) ? stripslashes($_POST['kodDepNom']) : '';
  $filtr_dep_id=isset($_POST['kodDepList']) ? stripslashes($_POST['kodDepList']) : '';

  $filtr_arr_typse_act=isset($_POST['types']) ? $_POST['types'] : array(0,0);

  $filtr_dateActS=isset($_POST['dateActS']) ? stripslashes($_POST['dateActS']) : '';
  $filtr_dateActE=isset($_POST['dateActE']) ? stripslashes($_POST['dateActE']) : '';

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


  if($filtr_dep_id!=""){
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
      $kvedWhere[]=" organ.kice like ('".substr($value,5)."')";# code...
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

  echo $qeruStrPaginathion;

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
    ." left join  organizations as org on org.id=cn.org"
    ." left join year as y on y.id=cn.id_year "
    ." left join period as p on p.id=cn.id_period ".$whereStr;

  //echo $qeruStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }



  $list_department=getListDepatment($link,$filtr_dep_id);
  $html_type=getTypsHtml($typeAct,$filtr_arr_typse_act);
  $html_kved=getKvedHtml($link,$filtr_Kveds);
  $html_kises=getKisedHtml($link,$filtr_Kises);

  $select_obl=getListObl($link, $filtr_Obl);
  $select_ray=getListRay($link, $filtr_Obl,$filtr_Ray);
  $select_ter=getListTeritorys($link, $filtr_Obl,$filtr_Ray,$filtr_Ter);

  require_once('template/act_show.php');
?>
