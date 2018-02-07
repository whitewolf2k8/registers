<?
  require_once('../../lib/start.php');

  $filtr_kd=isset($_POST['kd']) ? stripslashes($_POST['kd']) : '';
  $filtr_kdmo=isset($_POST['kdmo']) ? stripslashes($_POST['kdmo']) : '';

  $filtr_dateReS=isset($_POST['dateReS']) ? stripslashes($_POST['dateReS']) : '';
  $filtr_dateReE=isset($_POST['dateReS']) ? stripslashes($_POST['dateReE']) : '';

  $filtr_dateDelS=isset($_POST['dateDelS']) ? stripslashes($_POST['dateDelS']) : '';
  $filtr_dateDelE=isset($_POST['dateDelE']) ? stripslashes($_POST['dateDelE']) : '';

  $filtr_Kveds=isset($_POST['kveds']) ? $_POST['kveds'] : '';
  $filtr_Kises=isset($_POST['kises']) ? $_POST['kises'] : '';
  $filtr_Contols=isset($_POST['controlArr']) ? $_POST['controlArr'] : '';

  $filtr_OblF=isset($_POST['obl_select_2']) ? $_POST['obl_select_2'] : '';
  $filtr_RayF=isset($_POST['ray_select_2']) ? $_POST['ray_select_2'] : '';
  $filtr_TerF=isset($_POST['ter_select_2']) ? $_POST['ter_select_2'] : '';

  $filtr_OblU=isset($_POST['obl_select_1']) ? $_POST['obl_select_1'] : '';
  $filtr_RayU=isset($_POST['ray_select_1']) ? $_POST['ray_select_1'] : '';
  $filtr_TerU=isset($_POST['ter_select_1']) ? $_POST['ter_select_1'] : '';

  $filtr_flag=isset($_POST['flag_group']) ? $_POST['flag_group'] : '';
  $filtr_opf=isset($_POST['opf_S']) ? $_POST['opf_S'] : array();


  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";

  $headTable = array();
  $filds = array("0"=>array(),"1"=>array());


$where = array();

  if($filtr_kd!=""){
    $where[]=" t1.kd = '".$filtr_kd."'";
  }
  if($filtr_kdmo!=""){
    $where[]=" t1.kdmo = '".$filtr_kdmo."'";
  }

  if($filtr_dateReS!=""){
    $where[]=" t1.rik >= ".dateToStrFormat($filtr_dateReS)." ";
  }
  if($filtr_dateReE!=""){
    $where[]=" t1.rik <= ".dateToStrFormat($filtr_dateReE)." ";
  }

  if($filtr_dateDelS!=""){
    $where[]=" t1.dl >= ".dateToStrFormat($filtr_dateDelS)."  ";
  }
  if($filtr_dateDelE!=""){
    $where[]=" t1.dl <= ".dateToStrFormat($filtr_dateDelE)." ";
  }

  if($filtr_dateDelS!="" || $filtr_dateDelE!="" ){
    $where[]=" t1.dl > 0 ";
  }

  if($filtr_Contols!=""){
    $resArr=explode(",",$filtr_Contols);
    foreach ($resArr as $key => $value) {
      $resArr[$key]=substr($value,8);
    }
    $str=( count( $resArr ) ? implode( ' , ',$resArr ) : '' );
    $where[]=" t1.gu in (".$str.")";
  }

  if($filtr_Kises!=""){
    $resArr=explode(",",$filtr_Kises);
    foreach ($resArr as $key => $value) {
      $resArr[$key]=substr($value,5);
    }
    $str=( count( $resArr ) ? implode( ' , ',$resArr ) : '' );
    $where[]=" t1.kice in (".$str.")";
  }

  if($filtr_Kveds!=""){
    $resArr=getKveds($link,$filtr_Kveds);
    $str="";
    if(count($resArr)>1){
      for ($i=0; $i <count($resArr)  ; $i++) {
        if($i==count($resArr)-1){
          $str.="'".$resArr[$i]."'";
          continue;
        }
        $str.="'".$resArr[$i]."',";
      }
    }else{
      $str="'".$resArr[0]."'";
    }
    $where[]="(t1.e1_10 in (".$str.") or t1.e2_10 in (".$str.") or "
      ." t1.e3_10 in (".$str.") or t1.e4_10 in (".$str.") or"
      ." t1.e5_10 in (".$str.") or t1.e6_10 in (".$str.")) " ;
  }

  if($filtr_flag!="" && in_array("1",$filtr_flag))
  {
    $where[]= " t1.countChild>0";
  }

  if($filtr_flag!="" && in_array("2",$filtr_flag))
  {
    $where[]= "t1.iz='1'";
  }

  if($filtr_flag!="" && in_array("4",$filtr_flag))
  {
    $where[]= "t1.pr='8'";
  }

  if($filtr_OblU!="" && $filtr_RayU!="" && $filtr_TerU!=""){
    $where[]="t1.te like ('".$filtr_TerU."')";
  }else{
    if($filtr_TerU=="" && $filtr_RayU!=""){
      $where[]="t1.te like ('".$filtr_OblU.$filtr_RayU."%')";
    }
    if($filtr_OblU!="" && $filtr_RayU==""){
      $where[]="t1.te like ('".$filtr_OblU."%')";;
    }
  }

  if($filtr_OblF!="" && $filtr_RayF!="" && $filtr_TerF!=""){
    $where[]="t2.tea like ('".$filtr_TerF."')";
  }else{
    if($filtr_TerF=="" && $filtr_RayF!=""){
      $where[]="t2.tea like ('".$filtr_OblF.$filtr_RayF."%')";
    }
    if($filtr_OblF!="" && $filtr_RayF==""){
      $where[]="t2.tea like ('".$filtr_OblF."%')";;
    }
  }

  if(count($filtr_opf)>0){
    $str_opf=array();
    foreach ($filtr_opf as $key => $value) {
      if($value!=0){
        $str_opf[]=$value;
      }
    }
    $str = (count($str_opf) ? implode( ' , ', $str_opf ) : '' );
    if($str!=""){
      $where[]=" t1.pf in (".$str.")";
    }
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

  $qeruStrPaginathion="SELECT COUNT(t2.id) as resC FROM `actual_address`  as t2  "
    ." left join   `organizations` as t1  on t1.id=t2.id_org".$whereStrPa;


  $resultPa = mysqli_query($link,$qeruStrPaginathion);
  if($resultPa){
    $r=mysqli_fetch_array($resultPa, MYSQLI_ASSOC);
    $rowCount=$r['resC'];
    mysqli_free_result($resultPa);
  }

  if($rowCount>0){
      $pagination.=getPaginator($rowCount,$paginathionLimit,$paginathionLimitStart);
  }

  $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' )." ORDER BY t1.kd, t1.kdmo";
  if($paginathionLimit!=0 ){
    $whereStr.=' LIMIT '.$paginathionLimitStart.','.$paginathionLimit;
  }

  $qeruStr="SELECT t1.id, t1.kd, t1.kdmo,t1.nu, t2.ad, t2.pi,t2.te,t2.tea  FROM  `actual_address`  as t2 "
    ." left join `organizations` as t1  on t2.id_org=t1.id".$whereStr;

  $result = mysqli_query($link,$qeruStr);
  if($result){
    if(mysqli_num_rows($result)>0){
      $ListResult=array();
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $row["kdg"]=(($row["kdg"]>0)?$row["kdg"]:"- - - - -");
        $ListResult[]=$row;
      }
    }
    mysqli_free_result($result);
  }





  $list_department=getListDepatment($link,$filtr_dep_id);
  $html_type=getTypsHtml($typeAct,(isset($filtr_arr_typse_act))?$filtr_arr_typse_act:array(0));
  $html_kved=getKvedHtml($link,$filtr_Kveds);
  $html_kises=getKisedHtml($link,$filtr_Kises);
  $html_opf=getOpfHtml($link,$filtr_opf);
  $html_control=getControlsHtml($link,$filtr_Contols);

  $select_obl_f=getListObl($link, $filtr_OblF);
  $select_ray_f=getListRay($link, $filtr_OblF,$filtr_RayF);
  $select_ter_f=getListTeritorys($link, $filtr_OblF,$filtr_RayF,$filtr_TerF);

  $select_obl_u=getListObl($link, $filtr_OblU);
  $select_ray_u=getListRay($link, $filtr_OblU,$filtr_RayU);
  $select_ter_u=getListTeritorys($link, $filtr_OblU,$filtr_RayU,$filtr_TerU);

  require_once('template/export_organizations_adress.php');
?>
