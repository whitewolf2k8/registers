<? header('Content-type: text/html; charset=windows-1251');
  include_once('../../../lib/start.php');
  include_once('../../../lib/function.php');

  $action=$_POST['mode'];

  if($action=="getOrg"){

    $kd=iconv("utf-8","windows-1251",$_POST['kd']);
    $kdmo=iconv("utf-8","windows-1251",$_POST['kdmo']);

    $where = array();
    if($kd!=""){
      $kd=ltrim($kd,'0');
      $where[]=' `kd` = '.$kd;

    }

    if($kdmo!=""){
      $kdmo=ltrim($kdmo,'0');
      $where[]=' `kdmo` = '.$kdmo;
    }

    $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
    $qeruStr="SELECT id , nu , kd, kdmo FROM `organizations` ".$whereStr;
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=$row;
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }
  if($action=="getList")
  {
    $kod=iconv("utf-8","windows-1251",$_POST['kod']);
    $options= array();

    $qeruStr="SELECT * FROM `depatment` WHERE nom='".$kod."' AND dead = 0";
    $result = mysqli_query($link,$qeruStr);
    if($result){
      if(mysqli_num_rows($result)>0){
        while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $options[]=array('list' => getListDepatmentByKod($link,$kod),'exists'=> 1);
        }
      }else{
        $options[]=array('list' => getListDepatmentByKod($link,$kod),'exists'=> 0);
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }




  if($action=="getListType")
  {
    $options= array(getListTypeAct($typeAct,0));
    echo php2js($options);
  }


  if ($action=="checkKved") {
    $filtr_kved_kod=$_POST["info"];
    $ERROR_MSG ="";
    $options= array();
    $filtr_kved_kod1=formatKodKved10($filtr_kved_kod);
    if(iconv_strlen($filtr_kved_kod1, "Windows-1251")==5){
      $where[]=' (`kod` LIKE "'.$filtr_kved_kod1.'" ) ';
      $filtr_kved_kod=str_replace(" ","",$filtr_kved_kod1);
    }else{
      $ERROR_MSG.= "<br>".$filtr_kved_kod1;
    }
    if($ERROR_MSG==""){
      $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
      $qeruStr="SELECT * FROM `kved10` ".$whereStr;
      $result = mysqli_query($link,$qeruStr);
      if($result){
        $ListResult=array();

        while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $row["kod"]=str_replace(" ","",$row["kod"]);
          $ListResult[]=$row;
        }
        if(mysqli_num_rows($result)==0){
          $ERROR_MSG="Такого коду Квед 2010 не знайдено. Перевірте ще раз..";
        }
        mysqli_free_result($result);
      }
    }
    $options['kved_kod']=((isset($ListResult))?$ListResult:"");
    $options['erroMes']=$ERROR_MSG;
    echo php2js($options);
  }

  if ($action=="checkKise") {
    $filtr_kise_kd=isset($_POST["info"]) ? stripslashes($_POST["info"]) : '';
    $ERROR_MSG ="";
    $options= array();
    $where=array();

    $filtr_kise_kd1=formatKdKise14($filtr_kise_kd);
    if(iconv_strlen($filtr_kise_kd1, "Windows-1251")==1||iconv_strlen($filtr_kise_kd1, "Windows-1251")==4){
      $where[]=' (`kd` = '.$filtr_kise_kd1.' ) ';
    }else{
      $ERROR_MSG.= "<br>".$filtr_kise_kd1;
    }

    if($ERROR_MSG==""){
      $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
      $qeruStr="SELECT * FROM `kise14` ".$whereStr;
      $result = mysqli_query($link,$qeruStr);
      if($result){
        $ListResult=array();
        while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $ListResult[]=$row;
        }
        if(mysqli_num_rows($result)==0){
          $ERROR_MSG="Такого коду Kise не знайдено. Перевірте ще раз..";
        }
        mysqli_free_result($result);
      }
    }
    $options['kise_kod']=((isset($ListResult))?$ListResult:"");
    $options['erroMes']=$ERROR_MSG;
    echo php2js($options);
  }

  if($action=="getRay"){
    $kodObl=$_POST['obl'];
    $options=array();
    $qeruStr="SELECT * FROM `region` WHERE reg=".$kodObl." AND kod NOT IN (0,100,200)";
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=array("kod" =>$row['kod'],"nu" =>$row['nu']);
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }

  if ($action=="checkControls") {
    $filtr_controls_kod=$_POST["info"];
    $ERROR_MSG ="";
    $options= array();
    $filtr_controls_kod=delSpace($filtr_controls_kod);
    if($filtr_controls_kod!=""){
      $qeruStr="SELECT kd,nu FROM `managment_department` WHERE kd like ('".$filtr_controls_kod."')";
      $result = mysqli_query($link,$qeruStr);
      if($result){
        $ListResult=array();
        while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $row["kd"]=str_replace(" ","",$row["kd"]);
          $ListResult[]=$row;
        }
        if(mysqli_num_rows($result)==0){
          $ERROR_MSG="Органу управління з таким кодом не знайдено <br>";
        }
        mysqli_free_result($result);
      }
    }else{
      $ERROR_MSG+="Пошук здіснити неможливо, не заповнено поле.";
    }
    $options['controls_kod']=((isset($ListResult))?$ListResult:"");
    $options['erroMes']=$ERROR_MSG;
    echo php2js($options);
  }


  if($action=="getOpf"){
    echo php2js(getOpfHtml($link,array()));
  }


  if($action=="export"){

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

    $arrfild= isset($_POST['filds'])? $_POST['filds'] :  array('kd','kdmo','nu','pk','kdg','te','tea','ad','pi');

    $action = isset($_POST['mode']) ? $_POST['mode'] : '';
    $ERROR_MSG="";

    $headTable = array();
    $filds = array("0"=>array(),"1"=>array());

    if(count($arrfild)>0){
      foreach ($arrfild as $key => $value) {
        switch ($value) {
          case 'kd':
            $headTable["kd"]['type']="NUMERIC";
            $headTable["kd"]['len']=8;
            $filds[0][]="t1.kd";
          break;
          case 'kdmo':
            $headTable["kdmo"]['type']="NUMERIC";
            $headTable["kdmo"]['len']=12;
            $filds[0][]="t1.kdmo";
          break;
          case 'nu':
            $headTable["nu"]['type']="CHAR";
            $headTable["nu"]["len"]=250;
            $filds[0][]="t1.nu";
          break;
          case 'pk':
            $headTable["pk"]['type']="CHAR";
            $headTable["pk"]['len']=45;
            $filds[0][]="t1.pk";
          break;
          case 'kdg':
            $headTable["kdg"]['type']="NUMERIC";
            $headTable["kdg"]['len']=8;
            $filds[0][]="t1.kdg";
          break;
          case 'te':
            $headTable["te"]['type']="NUMERIC";
            $headTable["te"]['len']=10;
            $filds[0][]="t1.te";
          break;
          case 'tea':
            $headTable["tea"]["type"]="NUMERIC";
            $headTable["tea"]["len"]=5;
            $filds[0][]="t1.tea";
          break;
          case 'ad':
            $headTable["ad"]["type"]="CHAR";
            $headTable["ad"]["len"]=150;
            $filds[0][]="t1.ad";
          break;
          case 'pi':
            $headTable["pi"]["type"]="NUMERIC";
            $headTable["pi"]["len"]=6;
            $filds[0][]="t1.pi";
          break;
          case 'pf':
            $headTable["pf"]['type']="NUMERIC";
            $headTable["pf"]['len']=3;
            $filds[0][]="t1.pf";
          break;
          case 'gu':
            $headTable["gu"]['type']="NUMERIC";
            $headTable["gu"]['len']=5;
            $filds[0][]="t1.gu";
          break;
          case 'uo':
            $headTable["uo"]['type']="NUMERIC";
            $headTable["uo"]['len']=1;
            $filds[0][]="t1.uo";
          break;
          case 'dl':
            $headTable["dl"]['type']="NUMERIC";
            $headTable["dl"]['len']=8;
            $filds[0][]="t1.dl";
          break;
          case 'kise':
            $headTable["kice"]['type']="NUMERIC";
            $headTable["kice"]['len']=4;
            $filds[0][]="t1.kice";
          break;
          case 'iz':
            $headTable["kice"]['type']="NUMERIC";
            $headTable["kice"]['len']=4;
            $filds[0][]="t1.iz";
          break;
          case 'e1_10':
            $headTable["e1_10"]["type"]="CHAR";
            $headTable["e1_10"]['len']=5;
            $filds[0][]="t1.e1_10";
          break;
          case 'ne1_10':
            $headTable["ne1_10"]["type"]="CHAR";
            $headTable["ne1_10"]['len']=250;
            $filds['1'][]="ne1_10";
            if(!array_key_exists('e1_10', $headTable)){
              $filds[0][]="t1.e1_10";
            }
          break;
          case 'e2_10':
            $headTable["e2_10"]["type"]="CHAR";
            $headTable["e2_10"]["len"]=5;
            $filds[0][]="t1.e2_10";
          break;
          case 'ne2_10':
            $headTable["ne2_10"]["type"]="CHAR";
            $headTable["ne2_10"]["len"]=250;
            $filds[1][]="ne2_10";
            if(!array_key_exists('e2_10', $headTable)){
              $filds[0][]="t1.e2_10";
            }
          break;
          case 'e3_10':
            $headTable["e3_10"]["type"]="CHAR";
            $headTable["e3_10"]["len"]=5;
            $filds[0][]="t1.e3_10";
          break;
          case 'ne3_10':
            $headTable["ne3_10"]["type"]="CHAR";
            $headTable["ne3_10"]["len"]=250;
            $filds[1][]="ne3_10";
            if(!array_key_exists('e3_10', $headTable)){
              $filds[0][]="t1.e3_10";
            }
          break;
          case 'e4_10':
            $headTable["e4_10"]["type"]="CHAR";
            $headTable["e4_10"]["len"]=5;
            $filds[0][]="t1.e4_10";
          break;
          case 'ne4_10':
            $headTable["ne4_10"]["type"]="CHAR";
            $headTable["ne4_10"]["len"]=250;
            $filds[1][]="ne4_10";
            if(!array_key_exists('e4_10', $headTable)){
              $filds[0][]="t1.e4_10";
            }
          break;
          case 'e5_10':
            $headTable["e5_10"]["type"]="CHAR";
            $headTable["e5_10"]["len"]=5;
            $filds[0][]="t1.e5_10";
          break;
          case 'ne5_10':
            $headTable["ne5_10"]["type"]="CHAR";
            $headTable["ne5_10"]["len"]=250;
            $filds[1][]="ne5_10";
            if(!array_key_exists('e5_10', $headTable)){
              $filds[0][]="t1.e5_10";
            }
          break;
          case 'e6_10':
            $headTable["e6_10"]["type"]="CHAR";
            $headTable["e6_10"]["len"]=5;
            $filds[0][]="t1.e6_10";
          break;
          case 'ne6_10':
            $headTable["ne6_10"]["type"]="CHAR";
            $headTable["ne6_10"]["len"]=250;
            $filds[1][]="ne6_10";
            if(!array_key_exists('e6_10', $headTable)){
              $filds[0][]="t1.e6_10";
            }
          break;
          case 'vdf10':
            $headTable["vdf10"]["type"]="CHAR";
            $headTable["vdf10"]["len"]=5;
            $filds[0][]="t1.vdf10";
          break;
          case 'n_vdf10':
            $headTable["n_vdf10"]["type"]="CHAR";
            $headTable["n_vdf10"]["len"]=250;
            $filds[1][]="n_vdf10";
            if(!array_key_exists('vdf10', $headTable)){
              $filds[0][]="t1.vdf10";
            }
          break;
          case 'rn':
            $headTable["rn"]["type"]="CHAR";
            $headTable["rn"]["len"]=17;
            $filds[0][]="t1.rn";
          break;
          case 'dr':
            $headTable["dr"]['type']="NUMERIC";
            $headTable["dr"]['len']=8;
            $filds[0][]="t1.dr";
          break;
          case 'dz':
            $headTable["dz"]['type']="NUMERIC";
            $headTable["dz"]['len']=8;
            $filds[0][]="t1.dz";
          break;
          case 'pr':
            $headTable["pr"]['type']="NUMERIC";
            $headTable["pr"]['len']=1;
            $filds[0][]="t1.pr";
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
      ." left join  `acts` as t3 on t1.id=t3.org ".$whereStrPa;

    $resultPa = mysqli_query($link,$qeruStrPaginathion);
    if($resultPa){
      $r=mysqli_fetch_array($resultPa, MYSQLI_ASSOC);
      $rowCount=$r['resC'];
      mysqli_free_result($resultPa);
    }
    $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' )." GROUP BY t1.id";
    $qeruStr="SELECT ".$fildStr." FROM `organizations` as t1"
      ." left join  `actual_address`  as t2 on t2.id_org=t1.id"
      ." left join  `acts` as t3 on t1.id=t3.org ".$whereStr;

    $fildStr = ( count( $filds[0] ) ?implode( ' , ',   $filds[0] ) : '' );
    $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' )." GROUP BY t1.id";

    $qeruStr="SELECT ".$fildStr." FROM `organizations` as t1"
      ." left join  `actual_address`  as t2 on t2.id_org=t1.id"
      ." left join  `acts` as t3 on t1.id=t3.org ".$whereStr;

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
        $ListResult[]=$row;
      }
      mysqli_free_result($result);
    }
    print_r($ListResult);
  }
  closeConnect($link);
?>
