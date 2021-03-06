<? header('Content-type: text/html; charset=windows-1251');
  include_once('../../../lib/start.php');
  include_once('../../../lib/function.php');
  include_once('../../../lib/setting.php');
  include_once ('../../../Classes/PHPExcel.php');
  $action=$_POST['mode'];

    if($action=="getOrgs"){
      $kdNu=trim(iconv("utf-8","windows-1251",$_POST['pkNu']));
      $arrfild= (isset($_POST['fildList']) &&  $_POST['fildList']!='')?(explode ( ',', $_POST['fildList'])) :  array('kd','kdmo','nu','pk','kdg','te','tea','ad','pi');
      $resProcessFild=getFildArray($arrfild);
      $headTable=$resProcessFild['headTable'];
      $filds=$resProcessFild['filds'];
      $filds[0][]="t1.id";

      $where = array();
      $where[]="t1.`pk` like ('%".$kdNu."%')";
      $fildStr = ( count( $filds[0] ) ?implode( ' , ',   $filds[0] ) : '' );
      $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' )." GROUP BY t1.id";
      $qeruStr="SELECT ".$fildStr." FROM `organizations` as t1"
        ." left join  `actual_address`  as t2 on t2.id_org=t1.id"
        ." left join  `acts` as t3 on t1.id=t3.org "
        ." left join  `opf` as t4 on t1.pf=t4.kd "
        ." left join  `skof` as t5 on t1.sof=t5.kod ".$whereStr;

      $result = mysqli_query($link,$qeruStr);
      if($result){
        $row_arr=array();
        if(mysqli_num_rows($result)>0){

          $row_arr=array();
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
            $row+=getContactsdata($link,$headTable ,$row['id']);
            $row_arr[]=$row;
           }

            mysqli_free_result($result);
          }
        }else {
          setMaxSession("");
          $ERROR_MSG.="�� ������� ���������� �� �������� �� ������ ���������� <br>";
        }
        // �������� ������ �������� �������, ��� �������������� ����������. � ������� ���������
        $arrHed=array();
        foreach ($headTable as $key => $value) {
          $arrHed[]=array('kod'=>$key,'nu'=>$value['hNu']);
        }

      echo php2js( array('res' => $row_arr, 'hed' => $arrHed));
    }


  if($action=="generationFile"){
    set_time_limit(90000);

    $arrOrgId=(isset($_POST['orgs']) &&  $_POST['orgs']!='')?(explode ( ',', $_POST['orgs'])):array();
    
    $typeFile=$_POST['typeF'];
    $ERROR_MSG="";
    $cnt_exp=0;

    $arrfild= (isset($_POST['fildList']) &&  $_POST['fildList']!='')?(explode ( ',', $_POST['fildList'])) :  array('kd','kdmo','nu','pk','kdg','te','tea','ad','pi');
    $action = isset($_POST['mode']) ? $_POST['mode'] : '';

    $resProcessFild=getFildArray($arrfild);

    $headTable=$resProcessFild['headTable'];
    $filds=$resProcessFild['filds'];

    $filds[0][]="t1.id";
    $listItems=array();
        setMaxSession((count($arrOrgId))*2);
        foreach ($arrOrgId as $key => $value) {
              $where=array();
              $where[]=" t1.id =".$value;


            $fildStr = ( count( $filds[0] ) ?implode( ' , ',   $filds[0] ) : '' );
            $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' )." GROUP BY t1.id";

            $qeruStr="SELECT ".$fildStr." FROM `organizations` as t1"
              ." left join  `actual_address`  as t2 on t2.id_org=t1.id"
              ." left join  `acts` as t3 on t1.id=t3.org "
              ." left join  `opf` as t4 on t1.pf=t4.kd "
              ." left join  `skof` as t5 on t1.sof=t5.kod ".$whereStr;

            $result=mysqli_query($link,$qeruStr);
            if($result){
              while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $row+=getContactsdata($link,$headTable ,$row['id']);
                $listItems[]=$row;
              }
            }

            mysqli_free_result($result);
          $cnt_exp+=1;
          session_start();
          $_SESSION['ls_sleep_test'] =$cnt_exp;
          session_write_close();
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
          $ERROR_MSG.="�� ������� �������� ���� ����� <br>";
      }else{
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

  function getContactsdata($link, $headTable,$idOrg)
  {
      $type=array();
      $resultData=array();

      if(array_key_exists('phone', $headTable)){ $type[]=0;}
      if(array_key_exists('phacs', $headTable)){ $type[]=1; }
      if(array_key_exists('mail', $headTable)){ $type[]=2; }

      if(count($type)>0){
        $strType=(count( $type )) ? ' type in ( ' . implode( ', ', $type ).' )' : '' ;
        $queryS="SELECT data, type FROM `contact` WHERE id_org = ".$idOrg.(($strType!='')?" AND ".$strType:"");
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

          if(in_array(0, $type)){
            $resultData+=array('phone' => ((count( $listContact['phone'] )) ? implode( ';', $listContact['phone'] ): '')) ;
          }
          if(in_array(1, $type)){
            $resultData+=array('phacs' => ((count( $listContact['phacs'] )) ? implode( ';', $listContact['phacs'] ): '')) ;
          }
          if(in_array(2, $type)){
            $resultData+=array('mail' => ((count( $listContact['mail'] )) ? implode( ';', $listContact['mail'] ): '')) ;
          }
      }
      return $resultData;
  }

function getFildArray($arrfild)
{
  $headTable = array();
  $filds = array("0"=>array(),"1"=>array());
  if(count($arrfild)>0){
    foreach ($arrfild as $key => $value) {
      switch (mb_strtolower($value)) {
        case 'kd':
          $headTable["kd"]['type']="N";
          $headTable["kd"]['len']=8;
          $headTable["kd"]['hNu']="������";
          $filds[0][]="t1.kd";
        break;
        case 'kdmo':
          $headTable["kdmo"]['type']="N";
          $headTable["kdmo"]['len']=12;
          $headTable["kdmo"]['hNu']="����";
          $filds[0][]="t1.kdmo";
        break;
        case 'nu':
          $headTable["nu"]['type']="C";
          $headTable["nu"]['len']=250;
          $headTable["nu"]['hNu']="�����";
          $filds[0][]="t1.nu";
        break;
        case 'pk':
          $headTable["pk"]['type']="C";
          $headTable["pk"]['len']=45;
          $headTable["pk"]['hNu']="�������";
          $filds[0][]="t1.pk";
        break;
        case 'kdg':
          $headTable["kdg"]['type']="N";
          $headTable["kdg"]['len']=8;
          $headTable["kdg"]['hNu']="��������<br>����������";
          $filds[0][]="t1.kdg";
        break;
        case 'te':
          $headTable["te"]['type']="N";
          $headTable["te"]['len']=10;
          $headTable["te"]['hNu']="��� �������";
          $filds[0][]="t1.te";
        break;
        case 'tea':
          $headTable["tea"]["type"]="N";
          $headTable["tea"]["len"]=5;
          $headTable["tea"]['hNu']="��������������<br>����������";
          $filds[0][]="t1.tea";
        break;
        case 'ad':
          $headTable["ad"]["type"]="C";
          $headTable["ad"]["len"]=150;
          $headTable["ad"]['hNu']="������";
          $filds[0][]="t1.ad";
        break;
        case 'pi':
          $headTable["pi"]["type"]="N";
          $headTable["pi"]["len"]=6;
          $headTable["pi"]['hNu']="��������<br>������";
          $filds[0][]="t1.pi";
        break;
        case 'pf':
          $headTable["pf"]['type']="N";
          $headTable["pf"]['len']=3;
          $headTable["pf"]['hNu']="��� �������������<br>�����";
          $filds[0][]="t1.pf";
        break;
        case 'pf_nu':
          $headTable["pf_nu"]['type']="C";
          $headTable["pf_nu"]['len']=100;
          $headTable["pf_nu"]['hNu']="����� �������������<br>�����";
          $filds[0][]="t4.nu as pf_nu";
        break;
        case 'gu':
          $headTable["gu"]['type']="N";
          $headTable["gu"]['len']=5;
          $headTable["gu"]['hNu']="����� <br> ���������";
          $filds[0][]="t1.gu";
        break;
        case 'uo':
          $headTable["uo"]['type']="N";
          $headTable["uo"]['len']=1;
          $headTable["uo"]['hNu']="������ <br> ����� ";
          $filds[0][]="t1.uo";
        break;
        case 'dl':
          $headTable["dl"]['type']="N";
          $headTable["dl"]['len']=8;
          $headTable["dl"]['hNu']="����<br>��������";
          $filds[0][]="t1.dl";
        break;
        case 'kise':
          $headTable["kice"]['type']="N";
          $headTable["kice"]['len']=4;
          $headTable["kice"]['hNu']="������ <br> ��������";
          $filds[0][]="t1.kice";
        break;
        case 'iz':
          $headTable["iz"]['type']="N";
          $headTable["iz"]['len']=1;
          $headTable["iz"]['hNu']="��������� <br> ���������";
          $filds[0][]="t1.iz";
        break;
        case 'e1_10':
          $headTable["e1_10"]["type"]="C";
          $headTable["e1_10"]['len']=5;
          $headTable["e1_10"]['hNu']="��� �.�.1<br>KVED10";
          $filds[0][]="t1.e1_10";
        break;
        case 'ne1_10':
          $headTable["ne1_10"]["type"]="C";
          $headTable["ne1_10"]['len']=250;
          $headTable["ne1_10"]['hNu']="����� �.�.1";
          $filds['1'][]="ne1_10";
          if(!array_key_exists('e1_10', $headTable)){
            $filds[0][]="t1.e1_10";
          }
        break;
        case 'e2_10':
          $headTable["e2_10"]["type"]="C";
          $headTable["e2_10"]["len"]=5;
          $headTable["e2_10"]['hNu']="��� �.�. 2<br>KVED10";
          $filds[0][]="t1.e2_10";
        break;
        case 'ne2_10':
          $headTable["ne2_10"]["type"]="C";
          $headTable["ne2_10"]["len"]=250;
          $headTable["ne2_10"]['hNu']="����� �.�. 2";
          $filds[1][]="ne2_10";
          if(!array_key_exists('e2_10', $headTable)){
            $filds[0][]="t1.e2_10";
          }
        break;
        case 'e3_10':
          $headTable["e3_10"]["type"]="C";
          $headTable["e3_10"]["len"]=5;
          $headTable["e3_10"]['hNu']="��� �.�. 3 <br>KVED10";
          $filds[0][]="t1.e3_10";
        break;
        case 'ne3_10':
          $headTable["ne3_10"]["type"]="C";
          $headTable["ne3_10"]["len"]=250;
          $headTable["ne3_10"]['hNu']="����� �.�. 3";
          $filds[1][]="ne3_10";
          if(!array_key_exists('e3_10', $headTable)){
            $filds[0][]="t1.e3_10";
          }
        break;
        case 'e4_10':
          $headTable["e4_10"]["type"]="C";
          $headTable["e4_10"]["len"]=5;
          $headTable["e4_10"]['hNu']="��� �.�. 4 <br>KVED10";
          $filds[0][]="t1.e4_10";
        break;
        case 'ne4_10':
          $headTable["ne4_10"]["type"]="C";
          $headTable["ne4_10"]["len"]=250;
          $headTable["ne4_10"]['hNu']="����� �.�. 4 ";
          $filds[1][]="ne4_10";
          if(!array_key_exists('e4_10', $headTable)){
            $filds[0][]="t1.e4_10";
          }
        break;
        case 'e5_10':
          $headTable["e5_10"]["type"]="C";
          $headTable["e5_10"]["len"]=5;
          $headTable["e5_10"]['hNu']="��� �.�. 5 <br>KVED10";
          $filds[0][]="t1.e5_10";
        break;
        case 'ne5_10':
          $headTable["ne5_10"]["type"]="C";
          $headTable["ne5_10"]["len"]=250;
          $headTable["ne5_10"]['hNu']="����� �.�. 5";
          $filds[1][]="ne5_10";
          if(!array_key_exists('e5_10', $headTable)){
            $filds[0][]="t1.e5_10";
          }
        break;
        case 'e6_10':
          $headTable["e6_10"]["type"]="C";
          $headTable["e6_10"]["len"]=5;
          $headTable["e6_10"]['hNu']="��� �.�. 6 <br>KVED10";
          $filds[0][]="t1.e6_10";
        break;
        case 'ne6_10':
          $headTable["ne6_10"]["type"]="C";
          $headTable["ne6_10"]["len"]=250;
          $headTable["ne6_10"]['hNu']="����� �.� 6 ";
          $filds[1][]="ne6_10";
          if(!array_key_exists('e6_10', $headTable)){
            $filds[0][]="t1.e6_10";
          }
        break;
        case 'vdf10':
          $headTable["vdf10"]["type"]="C";
          $headTable["vdf10"]["len"]=5;
          $headTable["vdf10"]['hNu']="��� ����. �.�. <br>KVED10";
          $filds[0][]="t1.vdf10";
        break;
        case 'n_vdf10':
          $headTable["n_vdf10"]["type"]="C";
          $headTable["n_vdf10"]["len"]=250;
          $headTable["n_vdf10"]['hNu']="����� ����. �.�.";
          $filds[1][]="n_vdf10";
          if(!array_key_exists('vdf10', $headTable)){
            $filds[0][]="t1.vdf10";
          }
        break;
        case 'rn':
          $headTable["rn"]["type"]="C";
          $headTable["rn"]["len"]=17;
          $headTable["rn"]['hNu']="���. �����������  <br> ��";
          $filds[0][]="t1.rn";
        break;
        case 'dr':
          $headTable["dr"]['type']="N";
          $headTable["dr"]['len']=8;
          $headTable["dr"]['hNu']="����  ������������ <br> ��";
          $filds[0][]="t1.dr";
        break;
        case 'dz':
          $headTable["dz"]['type']="N";
          $headTable["dz"]['len']=8;
          $headTable["dz"]['hNu']="���� ����. ��� <br> �� ������ ";
          $filds[0][]="t1.dz";
        break;
        case 'pr':
          $headTable["pr"]['type']="N";
          $headTable["pr"]['len']=1;
          $headTable["pr"]['hNu']="��� ���";
          $filds[0][]="t1.pr";
        break;
        case 'phone':
          $headTable["phone"]["type"]="C";
          $headTable["phone"]['len']=200;
          $headTable["phone"]['hNu']="��������";
        break;
        case 'phacs':
          $headTable["phacs"]["type"]="C";
          $headTable["phacs"]['len']=200;
          $headTable["phacs"]['hNu']="����";
        break;
        case 'mail':
          $headTable["mail"]["type"]="C";
          $headTable["mail"]['len']=200;
          $headTable["mail"]['hNu']="���������� ������";
        break;
        case 'sof':
          $headTable["sof"]["type"]="N";
          $headTable["sof"]['len']=3;
          $headTable["sof"]['hNu']="��� ����";
          $filds[0][]="t1.sof";
        break;
        case 'sof_nu':
          $headTable["sof_nu"]["type"]="C";
          $headTable["sof_nu"]['len']=200;
          $headTable["sof_nu"]['hNu']="����� ���� <br> ����";
          $filds[0][]="t5.nu as sof_nu";
        break;
      }
    }
  }
  return array('headTable' => $headTable ,'filds' => $filds);
}

  closeConnect($link);
?>
