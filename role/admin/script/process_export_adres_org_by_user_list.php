<? header('Content-type: text/html; charset=windows-1251');
  include_once('../../../lib/start.php');
  include_once('../../../lib/function.php');
  include_once('../../../lib/setting.php');
  include_once('../../../Classes/PHPExcel.php');
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


  if($action=="generationFile"){
    set_time_limit(90000);

    $arrOrgId=$_POST['idList'];
    $typeExport=$_POST['typeF'];

    $ERROR_MSG="";
    $cnt_exp=0;

    $ListResult=array();

    foreach ($arrOrgId as $key => $value) {
      $where=array();
      $qeruStr="SELECT t1.kd, t1.kdmo,t1.nu, t2.ad, t2.pi,t2.te,t2.tea  FROM  `actual_address`  as t2 "
        ." left join `organizations` as t1  on t2.id_org=t1.id WHERE t2.id_org = ".$value;

      $result = mysqli_query($link,$qeruStr);
      if($result){
        if(mysqli_num_rows($result)>0){
          while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $ListResult[]=$row;
          }
        }
        mysqli_free_result($result);
      }
    }

    if(count($ListResult)>0){
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
        $res=array();
        $res["er"]=iconv("windows-1251","utf-8",$ERROR_MSG);
        $res["file"]=((isset($file_name))?$file_name.".xls":"");
        header_remove('Set-Cookie');
        echo php2js($res);
      }
    }

  }

  closeConnect($link);
?>
