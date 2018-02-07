<? header('Content-type: text/html; charset=windows-1251');
  include_once('../../../lib/start.php');
  include_once('../../../lib/function.php');
  include_once ('../../../Classes/PHPExcel.php');
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

    $typeExport=$_POST['typeF'];

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
        $where[]="t1.te like ('".$filtr_OblU."%')";
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

    $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' )." ORDER BY t1.kd, t1.kdmo";

    $qeruStr="SELECT t1.kd, t1.kdmo,t1.nu, t2.ad, t2.pi,t2.te,t2.tea  FROM  `actual_address`  as t2 "
      ." left join `organizations` as t1  on t2.id_org=t1.id".$whereStr;

    $result = mysqli_query($link,$qeruStr);
    if($result){
      if(mysqli_num_rows($result)>0){
        $ListResult=array();
        while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $ListResult[]=$row;
        }
      }
      mysqli_free_result($result);
    }
    $file_name=generateFileName();
    if($typeExport=="dbf"){
      $def=array();
      $def[]= array('KD','N',8,0);
      $def[]= array('KDMO','N',12,0);
      $def[]= array('NU','C',250);
      $def[]= array('TE','N',10,0);
      $def[]= array('TEA','N',5,0);
      $def[]= array('PI','N',6,0);
      $def[]= array('AD','C',150);


      $db=dbase_create('../../../files/unload/'.$file_name.'.dbf', $def);
      if (!$db) {
        $ERROR_MSG.="Не можливо створити базу даних <br>";
        setMaxSession("");
      }else{
        setMaxSession(count($ListResult));
            $count=0;
            foreach ($ListResult as $key => $value) {
              $row_arr=array();
              $row_arr[]=$value["kd"];
              $row_arr[]=$value["kdmo"];
              $row_arr[]=mb_convert_encoding($value["nu"], "cp866", "windows-1251");
              $row_arr[]=$value["tea"];
              $row_arr[]=$value["te"];
              $row_arr[]=$value["pi"];
              $row_arr[]=mb_convert_encoding($value["ad"], "cp866", "windows-1251");

              dbase_add_record($db,$row_arr);
              $count+=1;
              session_start();
              $_SESSION['ls_sleep_test'] =$count;
              session_write_close();
            }
            dbase_close($db);
          }
        $res=array();
        $res["er"]=iconv("windows-1251","utf-8",$ERROR_MSG);
        $res["file"]=((isset($file_name))?$file_name.".dbf":"");
        header_remove('Set-Cookie');
        echo php2js($res);
    }else{
      $count=0;
      setMaxSession(count($ListResult));
      $objPHPExcel = new PHPExcel;
      $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
      $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
      $objSheet = $objPHPExcel->getActiveSheet();

      $cnt_row=1;
      $cnt_cell=0;
      $arrHead = array("kd","kdmo","nu","te","tea","pi","ad");
      foreach ($arrHead as $key => $value) {
        $objSheet->getCellByColumnAndRow($cnt_cell,$cnt_row)->setValue($value);
        $objSheet->getCellByColumnAndRow($cnt_cell,$cnt_row)->getStyle()->getFont()->setBold(true)->setSize(12);
        $cnt_cell+=1;
      }
      $cnt_row+=1;

      foreach ($ListResult as $key => $value) {
        $objSheet->getCellByColumnAndRow(0,$cnt_row)->setValue($value["kd"]);
        $objSheet->getCellByColumnAndRow(1,$cnt_row)->setValue($value["kdmo"]);
        $objSheet->getCellByColumnAndRow(2,$cnt_row)->setValue(mb_convert_encoding($value["nu"], 'utf-8', 'cp-1251'));
        $objSheet->getCellByColumnAndRow(3,$cnt_row)->setValue($value["tea"]);
        $objSheet->getCellByColumnAndRow(4,$cnt_row)->setValue($value["te"]);
        $objSheet->getCellByColumnAndRow(5,$cnt_row)->setValue($value["pi"]);
        $objSheet->getCellByColumnAndRow(6,$cnt_row)->setValue(mb_convert_encoding($value["ad"], 'utf-8', 'cp-1251'));
        $cnt_row+=1;
        session_start();
        $_SESSION['ls_sleep_test'] =$count;
        session_write_close();
      }
      $objWriter->save('../../../files/unload/'.$file_name.'.xls');
      header_remove('Set-Cookie');

      $res=array();
      $res["er"]=iconv("windows-1251","utf-8",$ERROR_MSG);
      $res["file"]=((isset($file_name))?$file_name.".xls":"");
      echo php2js($res);
    }
  }

  closeConnect($link);
?>
