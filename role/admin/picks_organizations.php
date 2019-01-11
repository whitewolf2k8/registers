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

  if($filtr_flag!="" && in_array("3",$filtr_flag))
  {
    $filtr_arr_typse_act=isset($_POST['types']) ? $_POST['types'] : array(0);
  }

  $arrfild= isset($_POST['fildList'])? $_POST['fildList'] :  array('kd','kdmo','nu','pk','kdg','te','tea','ad','pi');

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";

  $headTable = array();
  $filds = array("0"=>array(),"1"=>array());

  if(count($arrfild)>0){
    foreach ($arrfild as $key => $value) {
      switch ($value) {
        case 'kd':
          $headTable["kd"]="ЄДРПОУ";
          $filds[0][]="t1.kd";
        break;
        case 'kdmo':
          $headTable["kdmo"]="КДМО";
          $filds[0][]="t1.kdmo";
        break;
        case 'nu':
          $headTable["nu"]="Назва";
          $filds[0][]="t1.nu";
        break;
        case 'pk':
          $headTable["pk"]="Керівник";
          $filds[0][]="t1.pk";
        break;
        case 'kdg':
          $headTable["kdg"]="Голловне<br>підприємство";
          $filds[0][]="t1.kdg";
        break;
        case 'te':
          $headTable["te"]="Код території";
          $filds[0][]="t1.te";
        break;
        case 'tea':
          $headTable["tea"]="Адмінмістративна<br>належність";
          $filds[0][]="t1.tea";
        break;
        case 'ad':
          $headTable["ad"]="Адреса";
          $filds[0][]="t1.ad";
        break;
        case 'pi':
          $headTable["pi"]="Поштовий<br>індекс";
          $filds[0][]="t1.pi";
        break;
        case 'pf':
          $headTable["pf"]="Код організаційної<br>форми";
          $filds[0][]="t1.pf";
        break;
        case 'pf_nu':
          $headTable["pf_nu"]="Назва організаційної<br>форми";
          $filds[0][]="t4.nu as pf_nu";
        break;
        case 'gu':
          $headTable["gu"]="Орган <br> управління";
          $filds[0][]="t1.gu";
        break;
        case 'uo':
          $headTable["uo"]="Ознака <br> особи ";
          $filds[0][]="t1.uo";
        break;
        case 'dl':
          $headTable["dl"]="Дата<br>ліквідації";
          $filds[0][]="t1.dl";
        break;
        case 'kise':
          $headTable["kice"]="Сектор <br> економіки";
          $filds[0][]="t1.kice";
        break;
        case 'iz':
          $headTable["iz"]="Іноземний <br> засновник";
          $filds[0][]="t1.iz";
        break;
        case 'e1_10':
          $headTable["e1_10"]="Код в.д.1<br>KVED10";
          $filds[0][]="t1.e1_10";
        break;
        case 'ne1_10':
          $headTable["ne1_10"]="Назва в.д.1";
          $filds['1'][]="ne1_10";
          if(!array_key_exists('e1_10', $headTable)){
            $filds[0][]="t1.e1_10";
          }
        break;
        case 'e2_10':
          $headTable["e2_10"]="Код в.д. 2<br>KVED10";
          $filds[0][]="t1.e2_10";
        break;
        case 'ne2_10':
          $headTable["ne2_10"]="Назва в.д. 2";
          $filds[1][]="ne2_10";
          if(!array_key_exists('e2_10', $headTable)){
            $filds[0][]="t1.e2_10";
          }
        break;
        case 'e3_10':
          $headTable["e3_10"]="Код в.д. 3 <br>KVED10";
          $filds[0][]="t1.e3_10";
        break;
        case 'ne3_10':
          $headTable["ne3_10"]="Назва в.д. 3";
          $filds[1][]="ne3_10";
          if(!array_key_exists('e3_10', $headTable)){
            $filds[0][]="t1.e3_10";
          }
        break;
        case 'e4_10':
          $headTable["e4_10"]="Код в.д. 4 <br>KVED10";
          $filds[0][]="t1.e4_10";
        break;
        case 'ne4_10':
          $headTable["ne4_10"]="Назва в.д. 4 ";
          $filds[1][]="ne4_10";
          if(!array_key_exists('e4_10', $headTable)){
            $filds[0][]="t1.e4_10";
          }
        break;
        case 'e5_10':
          $headTable["e5_10"]="Код в.д. 5 <br>KVED10";
          $filds[0][]="t1.e5_10";
        break;
        case 'ne5_10':
          $headTable["ne5_10"]="Назва в.д. 5";
          $filds[1][]="ne5_10";
          if(!array_key_exists('e5_10', $headTable)){
            $filds[0][]="t1.e5_10";
          }
        break;
        case 'e6_10':
          $headTable["e6_10"]="Код в.д. 6 <br>KVED10";
          $filds[0][]="t1.e6_10";
        break;
        case 'ne6_10':
          $headTable["ne6_10"]="Назва в.д 6 ";
          $filds[1][]="ne6_10";
          if(!array_key_exists('e6_10', $headTable)){
            $filds[0][]="t1.e6_10";
          }
        break;
        case 'vdf10':
          $headTable["vdf10"]="Код факт. в.д. <br>KVED10";
          $filds[0][]="t1.vdf10";
        break;
        case 'n_vdf10':
          $headTable["n_vdf10"]="Назва факт. в.д.";
          $filds[1][]="n_vdf10";
          if(!array_key_exists('vdf10', $headTable)){
            $filds[0][]="t1.vdf10";
          }
        break;
        case 'rn':
          $headTable["rn"]="Ост. реєстраційна  <br> дія";
          $filds[0][]="t1.rn";
        break;
        case 'dr':
          $headTable["dr"]="Дата  реєстраційних <br> дій";
          $filds[0][]="t1.dr";
        break;
        case 'dz':
          $headTable["dz"]="Дата внес. змін <br> до ЄДРПОУ ";
          $filds[0][]="t1.dz";
        break;
        case 'pr':
          $headTable["pr"]="Тип змін";
          $filds[0][]="t1.pr";
        break;
        case 'phone':
          $headTable["phone"]="Телефони";
        break;
        case 'phacs':
          $headTable["phacs"]="Факс";
        break;
        case 'mail':
          $headTable["mail"]="Електронні адреси";
        break;
        case 'sof':
          $headTable["sof"]="Код СКОФ";
          $filds[0][]="t1.sof";
        break;
        case 'sof_nu':
          $headTable["sof_nu"]="Назва коду <br> СКОФ";
          $filds[0][]="t5.nu as sof_nu";
        break;
      }
    }
  }
  $filds[0][]="t1.id";
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

  if($filtr_flag!="" && in_array("3",$filtr_flag))
  {
    $arrTypes=array();
    foreach ($filtr_arr_typse_act as $key => $value) {
      if($value!=0) $arrTypes[]= " (t3.act like ('%".$value."%'))";
    }
    $str=implode(' OR ', $arrTypes);
    if($str!=""){
      $where[]="(".$str.")";
    }
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

  $qeruStrPaginathion="SELECT COUNT(DISTINCT t1.id) as resC FROM `organizations` as t1  "
    ." left join  `actual_address`  as t2 on t2.id_org=t1.id"
    ." left join  `acts` as t3 on t1.id=t3.org "
    ." left join  `opf` as t4 on t1.pf=t4.kd "
    ." left join  `skof` as t5 on t1.sof=t5.kod ".$whereStrPa;

  $resultPa = mysqli_query($link,$qeruStrPaginathion);
  if($resultPa){
    $r=mysqli_fetch_array($resultPa, MYSQLI_ASSOC);
    $rowCount=$r['resC'];
    mysqli_free_result($resultPa);
  }

  if($rowCount>0){
      $pagination.=getPaginator($rowCount,$paginathionLimit,$paginathionLimitStart);
  }

  $fildStr = ( count( $filds[0] ) ?implode( ' , ',   $filds[0] ) : '' );
  $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' )." GROUP BY t1.id";
  if($paginathionLimit!=0 ){

    $whereStr.=' LIMIT '.$paginathionLimitStart.','.$paginathionLimit;
  }

  $qeruStr="SELECT ".$fildStr." FROM `organizations` as t1"
    ." left join  `actual_address`  as t2 on t2.id_org=t1.id"
    ." left join  `acts` as t3 on t1.id=t3.org "
    ." left join  `opf` as t4 on t1.pf=t4.kd "
    ." left join  `skof` as t5 on t1.sof=t5.kod ".$whereStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      if(count($filds[1])>0){
        foreach ($filds[1] as $key => $value) {
          if($value=="n_vdf10"){
            $row[$value]=getKvedName($link,$row[substr($value, 2)]);
          }else{
            $row[$value]=getKvedName($link,$row[substr($value, 1)]);
          }
        }
      }

      $row["kdg"]=(($row["kdg"]>0)?$row["kdg"]:"- - - - -");
      $row["pf_nu"]=(($row["pf_nu"]!='')?$row["pf_nu"]:"- - - - -");
      $row["sof_nu"]=(($row["sof_nu"]!='')?$row["sof_nu"]:"- - - - -");
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  if(array_key_exists('phone', $headTable)||array_key_exists('phacs', $headTable)||array_key_exists('mail', $headTable)){
    $type=array();

    if(array_key_exists('phone', $headTable)){ $type[]=0;}
    if(array_key_exists('phacs', $headTable)){ $type[]=1; }
    if(array_key_exists('mail', $headTable)){ $type[]=2; }

    $strType=(count( $type )) ? ' type in ( ' . implode( ', ', $type ).' )' : '' ;
    foreach ($ListResult as $key => $value) {
      $queryS="SELECT data, type FROM `contact` WHERE id_org = ".$value['id'].(($strType!='')?" AND ".$strType:"");

      $result = mysqli_query($link,$queryS);
      if($result){
        $listContact=array('phone'=>array(),'phacs'=>array(),'mail'=>array());
        while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {

          if ($row['type']==0) {$listContact['phone'][]=$row['data']; }
          else if($row['type']==1){ $listContact['phacs'][]=$row['data']; }
          else if($row['type']==2){ $listContact['mail'][]=$row['data']; }
        }
        mysqli_free_result($result);
      }

      if(array_key_exists('phone', $headTable)){
        $ListResult[$key]=$ListResult[$key]+array('phone' => ((count( $listContact['phone'] )) ? implode( ';', $listContact['phone'] ): '')) ;
      }
      if(array_key_exists('phacs', $headTable)){
        $ListResult[$key]=$ListResult[$key]+array('phacs' => ((count( $listContact['phacs'] )) ? implode( ';', $listContact['phacs'] ): '')) ;
      }
      if(array_key_exists('mail', $headTable)){
        $ListResult[$key]=$ListResult[$key]+array('mail' => ((count( $listContact['mail'] )) ? implode( ';', $listContact['mail'] ): '')) ;
      }

    }

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

  require_once('template/picks_organizations.php');
?>
