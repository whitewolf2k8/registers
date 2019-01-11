<? header('Content-type: text/html; charset=windows-1251');
  include_once('../../../lib/start.php');
  include_once('../../../lib/function.php');
  include_once('../../../lib/setting.php');
  include_once ('../../../Classes/PHPExcel.php');
  $action=$_POST['mode'];

  if($action=="getFileInformathion"){

    $ERROR_MSG="";
    if (!file_exists($tmpFile=$_FILES["fileImp"]['tmp_name'])) {
      $ERROR_MSG .= 'Помилка завантаження файлу! <br/>';
    }else {
      $db = dbase_open($tmpFile, 0);
      if ($db) {
        $filds_d=dbase_get_header_info($db);
        $problemFild=array("notF"=>array(),"errorF"=>array());
        $found_list=array();
        $keyFildExist=0;
        foreach ($filds_d as $key => $value) {
          if(($value['name']=="KD" && $value['type']=="number"&& $value['length']==8)||($value['name']=="KDMO" && $value['type']=="number"&& $value['length']==12) ){
            $keyFildExist=1;
          }
          $res = checkExistFild($fildListDb,$value);
          if($res>=0){
            $found_list[]=$res;
          }else{
            if($res==-1){
              $problemFild['notF'][]=$value;
            }else{
              $problemFild['errorF'][]=$value;
            }
          }
        }
        dbase_close($db);
      }else{
        $ERROR_MSG .= 'При відкритті вказаного файлу сталася помилка! <br/>';
      }
    }
    $resultArray=array();
    $resultArray['er']=$ERROR_MSG;
    $resultArray['fildList']=$fildListDb;
    $resultArray['problem']=$keyFildExist;
    $resultArray['exist']=(isset($found_list))?$found_list:array();
    $resultArray['promF']=(isset($problemFild))?$problemFild:array();

    echo php2js($resultArray);
  }

  if($action=="generationFile"){
    set_time_limit(90000);
    $typeFile=$_POST['typeF'];
    $ERROR_MSG="";
    $cnt_exp=0;

      $arrfild= isset($_POST['fildList'])? $_POST['fildList'] :  array('kd','kdmo','nu','pk','kdg','te','tea','ad','pi');

      $action = isset($_POST['mode']) ? $_POST['mode'] : '';

      $headTable = array();
      $filds = array("0"=>array(),"1"=>array());

      if(count($arrfild)>0){
        foreach ($arrfild as $key => $value) {
          switch (mb_strtolower($value)) {
            case 'kd':
              $headTable["kd"]['type']="N";
              $headTable["kd"]['len']=8;
              $filds[0][]="t1.kd";
            break;
            case 'kdmo':
              $headTable["kdmo"]['type']="N";
              $headTable["kdmo"]['len']=12;
              $filds[0][]="t1.kdmo";
            break;
            case 'nu':
              $headTable["nu"]['type']="C";
              $headTable["nu"]["len"]=250;
              $filds[0][]="t1.nu";
            break;
            case 'pk':
              $headTable["pk"]['type']="C";
              $headTable["pk"]['len']=45;
              $filds[0][]="t1.pk";
            break;
            case 'kdg':
              $headTable["kdg"]['type']="N";
              $headTable["kdg"]['len']=8;
              $filds[0][]="t1.kdg";
            break;
            case 'te':
              $headTable["te"]['type']="N";
              $headTable["te"]['len']=10;
              $filds[0][]="t1.te";
            break;
            case 'tea':
              $headTable["tea"]["type"]="N";
              $headTable["tea"]["len"]=5;
              $filds[0][]="t1.tea";
            break;
            case 'ad':
              $headTable["ad"]["type"]="C";
              $headTable["ad"]["len"]=150;
              $filds[0][]="t1.ad";
            break;
            case 'pi':
              $headTable["pi"]["type"]="N";
              $headTable["pi"]["len"]=6;
              $filds[0][]="t1.pi";
            break;
            case 'pf':
              $headTable["pf"]['type']="N";
              $headTable["pf"]['len']=3;
              $filds[0][]="t1.pf";
            break;
            case 'gu':
              $headTable["gu"]['type']="N";
              $headTable["gu"]['len']=5;
              $filds[0][]="t1.gu";
            break;
            case 'uo':
              $headTable["uo"]['type']="N";
              $headTable["uo"]['len']=1;
              $filds[0][]="t1.uo";
            break;
            case 'dl':
              $headTable["dl"]['type']="N";
              $headTable["dl"]['len']=8;
              $filds[0][]="t1.dl";
            break;
            case 'kise':
              $headTable["kice"]['type']="N";
              $headTable["kice"]['len']=4;
              $filds[0][]="t1.kice";
            break;
            case 'iz':
              $headTable["iz"]['type']="N";
              $headTable["iz"]['len']=1;
              $filds[0][]="t1.iz";
            break;
            case 'e1_10':
              $headTable["e1_10"]["type"]="C";
              $headTable["e1_10"]['len']=5;
              $filds[0][]="t1.e1_10";
            break;
            case 'ne1_10':
              $headTable["ne1_10"]["type"]="C";
              $headTable["ne1_10"]['len']=250;
              $filds['1'][]="ne1_10";
              if(!array_key_exists('e1_10', $headTable)){
                $filds[0][]="t1.e1_10";
              }
            break;
            case 'e2_10':
              $headTable["e2_10"]["type"]="C";
              $headTable["e2_10"]["len"]=5;
              $filds[0][]="t1.e2_10";
            break;
            case 'ne2_10':
              $headTable["ne2_10"]["type"]="C";
              $headTable["ne2_10"]["len"]=250;
              $filds[1][]="ne2_10";
              if(!array_key_exists('e2_10', $headTable)){
                $filds[0][]="t1.e2_10";
              }
            break;
            case 'e3_10':
              $headTable["e3_10"]["type"]="C";
              $headTable["e3_10"]["len"]=5;
              $filds[0][]="t1.e3_10";
            break;
            case 'ne3_10':
              $headTable["ne3_10"]["type"]="C";
              $headTable["ne3_10"]["len"]=250;
              $filds[1][]="ne3_10";
              if(!array_key_exists('e3_10', $headTable)){
                $filds[0][]="t1.e3_10";
              }
            break;
            case 'e4_10':
              $headTable["e4_10"]["type"]="C";
              $headTable["e4_10"]["len"]=5;
              $filds[0][]="t1.e4_10";
            break;
            case 'ne4_10':
              $headTable["ne4_10"]["type"]="C";
              $headTable["ne4_10"]["len"]=250;
              $filds[1][]="ne4_10";
              if(!array_key_exists('e4_10', $headTable)){
                $filds[0][]="t1.e4_10";
              }
            break;
            case 'e5_10':
              $headTable["e5_10"]["type"]="C";
              $headTable["e5_10"]["len"]=5;
              $filds[0][]="t1.e5_10";
            break;
            case 'ne5_10':
              $headTable["ne5_10"]["type"]="C";
              $headTable["ne5_10"]["len"]=250;
              $filds[1][]="ne5_10";
              if(!array_key_exists('e5_10', $headTable)){
                $filds[0][]="t1.e5_10";
              }
            break;
            case 'e6_10':
              $headTable["e6_10"]["type"]="C";
              $headTable["e6_10"]["len"]=5;
              $filds[0][]="t1.e6_10";
            break;
            case 'ne6_10':
              $headTable["ne6_10"]["type"]="C";
              $headTable["ne6_10"]["len"]=250;
              $filds[1][]="ne6_10";
              if(!array_key_exists('e6_10', $headTable)){
                $filds[0][]="t1.e6_10";
              }
            break;
            case 'vdf10':
              $headTable["vdf10"]["type"]="C";
              $headTable["vdf10"]["len"]=5;
              $filds[0][]="t1.vdf10";
            break;
            case 'n_vdf10':
              $headTable["n_vdf10"]["type"]="C";
              $headTable["n_vdf10"]["len"]=250;
              $filds[1][]="n_vdf10";
              if(!array_key_exists('vdf10', $headTable)){
                $filds[0][]="t1.vdf10";
              }
            break;
            case 'rn':
              $headTable["rn"]["type"]="C";
              $headTable["rn"]["len"]=17;
              $filds[0][]="t1.rn";
            break;
            case 'dr':
              $headTable["dr"]['type']="N";
              $headTable["dr"]['len']=8;
              $filds[0][]="t1.dr";
            break;
            case 'dz':
              $headTable["dz"]['type']="N";
              $headTable["dz"]['len']=8;
              $filds[0][]="t1.dz";
            break;
            case 'pr':
              $headTable["pr"]['type']="N";
              $headTable["pr"]['len']=1;
              $filds[0][]="t1.pr";
            break;
          }
        }
      }

    $filds[0][]="t1.id";


    $listItems=array();
    if (!file_exists($tmpFile=$_FILES["fileImp"]['tmp_name'])) {
      $ERROR_MSG .= 'Помилка завантаження файлу! <br/>';
    }else {
      $db = dbase_open($tmpFile, 0);
      if ($db) {
        $filds_d=dbase_get_header_info($db);
        $keyFildExist=array("0"=>0,"1"=>0);
        foreach ($filds_d as $key => $value) {
          if(($value['name']=="KD" && $value['type']=="number"&& $value['length']==8)){
              $keyFildExist[0]=1;
          }elseif (($value['name']=="KDMO" && $value['type']=="number"&& $value['length']==12) ) {
            $keyFildExist[1]=1;
          }
        }

        $rowCount=dbase_numrecords ($db);
        setMaxSession($rowCount*2);
        for ($i=1; $i < $rowCount; $i++) {
          $rowTable=dbase_get_record_with_names($db ,$i);

          if($rowTable){
            $where=array();

            if($keyFildExist[0]==1){
              $where[]=" t1.kd =".$rowTable["KD"];
            }

            if($keyFildExist[1]==1 && $rowTable["KDMO"] != 0){
              $where[]=" t1.kdmo =".$rowTable["KDMO"];
            }
            $fildStr = ( count( $filds[0] ) ?implode( ' , ',   $filds[0] ) : '' );
            $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' )." GROUP BY t1.id";

            $qeruStr="SELECT ".$fildStr." FROM `organizations` as t1"
              ." left join  `actual_address`  as t2 on t2.id_org=t1.id"
              ." left join  `acts` as t3 on t1.id=t3.org ".$whereStr;

            $result=mysqli_query($link,$qeruStr);
            if($result){
              while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $listItems[]=$row;
              }
            }
            mysqli_free_result($result);
          }

          $cnt_exp+=1;
          session_start();
          $_SESSION['ls_sleep_test'] =$cnt_exp;
          session_write_close();
        }
        dbase_close($db);
      }else{
        $ERROR_MSG .= 'При відкритті вказаного файлу сталася помилка! <br/>';
      }
    }

    $file_name=generateFileName();
    if($typeFile=="dbf"){
      $def = array();
      foreach ($headTable as $key => $value) {
        if($value['type']=="N"){
          $def[]= array($key,$value['type'],$value["len"],0);
        }else{
          $def[]= array($key,$value['type'],$value["len"]);
        }
      }
      $db=dbase_create('../../../files/unload/'.$file_name.'.dbf', $def);
      if (!$db) {
          $ERROR_MSG.="Не можливо створити базу даних <br>";
      }else{
        //setMaxSession(mysqli_num_rows($result));
        $count=0;
        foreach ($listItems as $key => $value) {
          if(count($filds[1])>0){
            foreach ($filds[1] as $k => $v) {
              if($v=="n_vdf10"){
                $value[$v]=getKvedName($link,$value[substr($v, 2)]);
              }else{
                $value[$v]=getKvedName($link,$value[substr($v, 1)]);
              }
            }
          }
          $row_arr=array();
          foreach ($headTable as $k => $v) {
            if($v['type']=="C"){
              $row_arr[]=mb_convert_encoding($value[$k], "cp866", "windows-1251");
            }else{
              $row_arr[]=$value[$k];
            }
          }
          $cnt_exp+=1;
          session_start();
          $_SESSION['ls_sleep_test'] =$cnt_exp;
          session_write_close();
          dbase_add_record($db,$row_arr);
        }
        dbase_close($db);
      }
      $res=array();
      $res["er"]=$ERROR_MSG;
      $res["file"]=((isset($file_name))?$file_name.".dbf":"");
      header_remove('Set-Cookie');
      echo php2js($res);
    }else{
      $objPHPExcel = new PHPExcel;
      // set default font
      $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
      // set default font size
      $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
      // create the writer
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
      // writer already created the first sheet for us, let's get it
      $objSheet = $objPHPExcel->getActiveSheet();
      // let's bold and size the header font and write the header
      // as you can see, we can specify a range of cells, like here:
      // write header
      $cnt_row=1;
      $cnt_cell=0;
      foreach ($headTable as $key => $value) {

        $objSheet->getCellByColumnAndRow($cnt_cell,$cnt_row)->setValue($key);
        $objSheet->getCellByColumnAndRow($cnt_cell,$cnt_row)->getStyle()->getFont()->setBold(true)->setSize(12);
        $cnt_cell+=1;
      }

      $fild_count=$cnt_cell-1;
      $cnt_cell=0;
      $cnt_row+=1;

      foreach ($listItems as $key => $value) {

        if(count($filds[1])>0){
          foreach ($filds[1] as $k => $v) {
            if($v=="n_vdf10"){
              $value[$v]=getKvedName($link,$value[substr($v, 2)]);
            }else{
              $value[$v]=getKvedName($link,$value[substr($v, 1)]);
            }
          }
        }
        foreach ($headTable as $k => $v) {
          if($v["type"]=="C"){
            $objSheet->getCellByColumnAndRow($cnt_cell,$cnt_row)->setValue(mb_convert_encoding($value[$k], 'utf-8', 'cp-1251'));
          }else{
            $objSheet->getCellByColumnAndRow($cnt_cell,$cnt_row)->setValue($value[$k]);
          }
          if($cnt_cell<$fild_count){
            $cnt_cell+=1;
          }else{
            $cnt_cell=0;
            $cnt_row+=1;
          }
        }
        $cnt_exp+=1;
        session_start();
        $_SESSION['ls_sleep_test'] =$cnt_exp;
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

  function checkExistFild($arrFild,$fildInp)
  {
    $flag=-1;
    foreach ($arrFild as $key => $value) {
      if($value['nu']==$fildInp['name']){
        if(($value["typeL"]==$fildInp['type'])&&($value["len"]==$fildInp['length']) ){
          $flag=$key;
          break;
        }else{
          $flag=-2;
           break;
        }
      }
    }
    return $flag;
  }

  closeConnect($link);
?>
