<?
  require_once('../../lib/start.php');

  function getTea($str){
    $str=str_replace(" ","",$str);
    if(strlen($str)==10){
      return substr($str, 0, 5);
    }else{
      return substr($str, 0, 4);
    }
  }

  function getTypeCon($i)
  {
    if($i<2){
      $type=0;
    }else if($i==2){
      $type=1;
    }else {
      $type=2;
    }
    return $type;
  }



  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";

  if($action=="import")
  {
    $start = microtime(true);
    set_time_limit(90000);
    if (!file_exists($tmpFile=$_FILES["fileImp"]['tmp_name'])) {
      $ERROR_MSG .= '������� ������������ �����! <br/>';
    }else {
      $db = dbase_open($tmpFile, 0);
      if ($db) {
          $countUpdate=0;
          $countInsert=0;
          // ������ �������� ������
          $querySelect = "SELECT id FROM `organizations` WHERE `kd`=? and `kdmo`=?";
          $queryUpdate = "UPDATE `organizations` SET `kd`=?,`kdmo`=?,`kdg`=?,`nu`=?,"
            ."`pk`=?,`ad`=?,`pi`=?,`te`=?,`tea`=?,`e1_10`=?,`e2_10`=?,`e3_10`=?,"
            ."`e4_10`=?,`e5_10`=?,`e6_10`=?,`uo`=?,`vdf10`=?,"
            ."`iz`=?,`pf`=?,`kice`=?,`gu`=?,`os`=?,`rik`=?,`sn`=?,`rn`=?,`dr`=?,"
            ."`pr`=?, `dz`=?, `dl`=?, `sof`=? WHERE `kd`=? and `kdmo`=?";
          $queryInsert = "INSERT INTO `organizations`(`kd`, `kdmo`, `kdg`, `nu`,"
            ." `pk`, `ad`, `pi`, `te`, `tea`, `e1_10`, `e2_10`, `e3_10`, `e4_10`,"
            ."`e5_10`, `e6_10`, `uo`, `vdf10`, `iz`, `pf`, `kice`, `gu`,"
            ." `os`, `rik`, `sn`, `rn`, `dr`, `pr`, `dz`, `dl`,`sof`) VALUES (?,?,?,?,?,?,?,?,?,"
            ."?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
          $stmtSelect = mysqli_stmt_init($link);
          $stmtUpdate = mysqli_stmt_init($link);
          $stmtInsert = mysqli_stmt_init($link);

          $rowCount=dbase_numrecords ($db);
          if((!mysqli_stmt_prepare($stmtSelect, $querySelect))||(!mysqli_stmt_prepare($stmtInsert, $queryInsert))||(!mysqli_stmt_prepare($stmtUpdate, $queryUpdate)))
          {
            echo " ??????? ?????????? ?????? \n <br>";
          } else{
            mysqli_stmt_bind_param($stmtInsert, "iissssssssssssssssssssssssssss",$kd,$kdmo,$kdg,$nu,$pk,$ad,$pi,$te,$tea,$e1_10,$e2_10,$e3_10,$e4_10,$e5_10,$e6_10,$uo,$vdf10,$iz,$pf,$kice,$gu,$os,$rik,$sn,$rn,$dr,$pr,$dz,$sof,$dl);
            mysqli_stmt_bind_param($stmtSelect, "ii", $kdS, $kdmoS);
            mysqli_stmt_bind_param($stmtUpdate, "iissssssssssssssssssssssssssssii",$kdU,$kdmoU,$kdgU,$nuU,$pkU,$adU,$piU,$teU,$teaU,$e1_10U,$e2_10U,$e3_10U,$e4_10U,$e5_10U,$e6_10U,$uoU,$vdf10U,$izU,$pfU,$kiceU,$guU,$osU,$rikU,$snU,$rnU,$drU,$prU,$dzU,$dlU,$sofU,$kdUS,$kdmoUS );
            for($i=1;$i<=$rowCount;$i++){
              $row= dbase_get_record_with_names ( $db , $i);

              $kdS=$row["KD"];
              $kdmoS=$row["KDMO"];
              mysqli_stmt_execute($stmtSelect);
              $result = mysqli_stmt_get_result($stmtSelect);
              if(mysqli_num_rows($result)>0)
              {
                $kdU = $row["KD"];
                $kdmoU = $row["KDMO"];
                $kdgU = $row["KDG"];
                $nuU = changeCodingPage($row['NU']);
                $pkU = changeCodingPage($row['PK']);
                $adU = changeCodingPage($row['AD']);
                $piU = $row['PI'];
                $teU = $row['TE'];
                $teaU = $row['TEA'];
                $e1_10U = changeCodingPageShort($row['E1_10']);
                $e2_10U = changeCodingPageShort($row['E2_10']);
                $e3_10U = changeCodingPageShort($row['E3_10']);
                $e4_10U = changeCodingPageShort($row['E4_10']);
                $e6_10U = changeCodingPageShort($row['E6_10']);
                $e5_10U = changeCodingPageShort($row['E5_10']);
                $uoU = $row['UO'];
                $vdf10U = changeCodingPageShort($row['VDF10']);
                $izU = $row['IZ'];
                $pfU = $row['PF'];
                $kiceU = $row['KICE14'];
                $guU = $row['GU'];
                $osU = $row['OS'];
                $rikU = $row['RIK'];
                $snU = changeCodingPageShort($row['SN']);
                $rnU = changeCodingPageShort($row['RN']);
                $drU = $row['DR'];
                $prU = $row['PR'];
                $dzU = $row['DZ'];
                $dlU = $row['DL'];
                $sofU = $row['SOF'];
                $kdUS = $row["KD"];
                $kdmoUS = $row["KDMO"];
                mysqli_stmt_execute($stmtUpdate);
                $countUpdate+=1;
              } else {
                $kd = $row["KD"];
                $kdmo = $row["KDMO"];
                $kdg = $row["KDG"];
                $nu = changeCodingPage($row['NU']);
                $pk = changeCodingPage($row['PK']);
                $ad = changeCodingPage($row['AD']);
                $pi = $row['PI'];
                $te = $row['TE'];
                $tea = $row['TEA'];
                $e1_10 = changeCodingPageShort($row['E1_10']);
                $e2_10 = changeCodingPageShort($row['E2_10']);
                $e3_10 = changeCodingPageShort($row['E3_10']);
                $e4_10 = changeCodingPageShort($row['E4_10']);
                $e6_10 = changeCodingPageShort($row['E6_10']);
                $e5_10 = changeCodingPageShort($row['E5_10']);
                $uo = $row['UO'];
                $vdf10 = changeCodingPageShort($row['VDF10']);
                $iz = $row['IZ'];
                $pf = $row['PF'];
                $kice = $row['KICE14'];
                $gu = $row['GU'];
                $os = $row['OS'];
                $rik = $row['RIK'];
                $sn = changeCodingPageShort($row['SN']);
                $rn = changeCodingPageShort($row['RN']);
                $dr = $row['DR'];
                $pr = $row['PR'];
                $dz = $row['DZ'];
                $dl = $row['DL'];
                $sof = $row['SOF'];
                mysqli_stmt_execute($stmtInsert);
                $countInsert+=1;
              }
              mysqli_free_result($result);
            }
          mysqli_stmt_close($stmtSelect);
          mysqli_stmt_close($stmtInsert);
          mysqli_stmt_close($stmtUpdate);
          countChild($link);
          $ERROR_MSG.=" ������ �������� ".$countUpdate." . <br>";
          $ERROR_MSG.= " ������ ������ ".$countInsert." . <br>";
          $ERROR_MSG.= " � ����� ������  ".$rowCount." ������. <br>";
          $ERROR_MSG.= "������ ����������� �������� ".calcTimeRun($start,microtime(true))."<br>";
          dbase_close($db);

        }
      }
    }
  }
  if($action=="importKd"){
    $start = microtime(true);
    set_time_limit(90000);
    if (!file_exists($tmpFile=$_FILES["fileImpKd"]['tmp_name'])) {
      $ERROR_MSG .= '������� ������������ �����! <br/>';
    }else {
      $db = dbase_open($tmpFile, 0);
      if ($db) {
          $countUpdate=0;
          $countInsert=0;
          // ������ �������� ������
          $querySelect = "SELECT id FROM `organizations` WHERE `kd`=? and `kdmo`=?";
          $queryUpdate = "UPDATE `organizations` SET `kd`=?,`kdmo`=?,`kdg`=?,`nu`=?,"
            ."`ad`=?,`pi`=?,`te`=?,`tea`=?,`vdf10`=?,`pr`=?, `dz`=?  WHERE `kd`=? and `kdmo`=?";
          $queryInsert = "INSERT INTO `organizations`(`kd`,`kdmo`,`kdg`,`nu`,"
            ."`ad`,`pi`,`te`,`tea`,`vdf10`,`pr`,`dz`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
          $stmtSelect = mysqli_stmt_init($link);
          $stmtUpdate = mysqli_stmt_init($link);
          $stmtInsert = mysqli_stmt_init($link);

          $rowCount=dbase_numrecords ($db);
          if((!mysqli_stmt_prepare($stmtSelect, $querySelect))||(!mysqli_stmt_prepare($stmtInsert, $queryInsert))||(!mysqli_stmt_prepare($stmtUpdate, $queryUpdate)))
          {
            echo " ������� ϳ�������� ������ \n <br>";
          } else {
            mysqli_stmt_bind_param($stmtInsert, "iisssssssss",$kd,$kdmo,$kdg,$nu,
              $ad,$pi,$te,$tea,$vdf10,$pr,$dz);
            mysqli_stmt_bind_param($stmtSelect, "ii", $kdS, $kdmoS);
            mysqli_stmt_bind_param($stmtUpdate, "iisssssssssii",$kdU,$kdmoU,$kdgU,
              $nuU,$adU,$piU,$teU,$teaU,$vdf10U,$prU,$dzU,$kdUS,$kdmoUS);
            for($i=1;$i<=$rowCount;$i++){
              $row= dbase_get_record_with_names ( $db , $i);
              if($row["KO"]==48){
                if($row["KDMO_ST"]!=0){
                  if($row["KDMO_NEW"]==0){
                    $kdmoGet=$row["KDMO_ZAM"];
                  }else{
                    $kdmoGet=$row["KDMO_NEW"];
                  }
                  $kdmo_old=$row["KDMO_ST"];
                }else{
                  $kdmoGet=$row["KDMO"];
                }
                //print_r($row);
                $kdS=$row["KD"];
                $kdmoS=((isset($kdmo_old))?($kdmo_old):($kdmoGet));
                mysqli_stmt_execute($stmtSelect);
                $result = mysqli_stmt_get_result($stmtSelect);
                if(mysqli_num_rows($result)>0)
                {
                  $kdU = $row["KD"];
                  $kdmoU = $kdmoGet;
                  $kdgU = $row["KDG"];
                  $nuU = changeCodingPage($row['NU']);
                  $adU = changeCodingPage($row['ADF']);
                  $piU = $row['PIF'];
                  $teU = $row['TEF'];
                  $teaU = getTea($row['TEF']);
                  $vdf10U = changeCodingPageShort($row['VDF10']);
                  $pr = $row['PR'];
                  $drU = $row['DR'];
                  $dzU = $row['DZ'];
                  $kdUS = $row["KD"];
                  $kdmoUS = ((isset($kdmo_old))?($kdmo_old):($kdmoGet));
                  mysqli_stmt_execute($stmtUpdate);
                  $countUpdate+=1;
                } else {
                  $kd = $row["KD"];
                  $kdmo = $row["KDMO"];
                  $kdg = $row["KDG"];
                  $nu = changeCodingPage($row['NU']);
                  $ad = changeCodingPage($row['ADF']);
                  $pi = $row['PIF'];
                  $te = $row['TEF'];
                  $tea = getTea($row['TEF']);
                  $vdf10 = changeCodingPageShort($row['VDF10']);
                  $pr = $row['PR'];
                  $dz = $row['DZ'];
                  mysqli_stmt_execute($stmtInsert);
                  $countInsert+=1;
                }
                mysqli_free_result($result);
                if(isset($kdmo_old))unset($kdmo_old);
              }
            }
          mysqli_stmt_close($stmtSelect);
          mysqli_stmt_close($stmtInsert);
          mysqli_stmt_close($stmtUpdate);
          countChild($link);
          $ERROR_MSG.=" ������ �������� ".$countUpdate." . <br>";
          $ERROR_MSG.= " ������ ������ ".$countInsert." . <br>";
          $ERROR_MSG.= " � ����� ������  ".$rowCount." ������. <br>";
          $ERROR_MSG.= "������ ����������� �������� ".calcTimeRun($start,microtime(true))."<br>";
          dbase_close($db);
        }
      }
    }
  }

  if($action=="importKdFin"){
    $start = microtime(true);
    set_time_limit(90000);
    if (!file_exists($tmpFile=$_FILES["fileImpKdFin"]['tmp_name'])) {
      $ERROR_MSG .= '������� ������������ �����! <br/>';
    }else {
      $db = dbase_open($tmpFile, 0);
      if ($db) {
          $countUpdate=0;
          $countInsert=0;
          // ������ �������� ������
          $querySelect = "SELECT id FROM `organizations` WHERE `kd`=? and `kdmo`=?";
          $queryUpdate = "UPDATE `organizations` SET `kd`=?,`kdmo`=?,`kdg`=?,`nu`=?,"
            ."`ad`=?,`pi`=?,`te`=?,`tea`=? WHERE `kd`=? and `kdmo`=?";
          $queryInsert = "INSERT INTO `organizations`(`kd`,`kdmo`,`kdg`,`nu`,"
            ."`ad`,`pi`,`te`,`tea`) VALUES (?,?,?,?,?,?,?,?)";
          $stmtSelect = mysqli_stmt_init($link);
          $stmtUpdate = mysqli_stmt_init($link);
          $stmtInsert = mysqli_stmt_init($link);

          $rowCount=dbase_numrecords ($db);
          if((!mysqli_stmt_prepare($stmtSelect, $querySelect))||(!mysqli_stmt_prepare($stmtInsert, $queryInsert))||(!mysqli_stmt_prepare($stmtUpdate, $queryUpdate)))
          {
            echo " ??????? ?????????? ?????? \n <br>";
          } else {
            mysqli_stmt_bind_param($stmtInsert, "iissssss",$kd,$kdmo,$kdg,$nu,
              $ad,$pi,$te,$tea);
            mysqli_stmt_bind_param($stmtSelect, "ii", $kdS, $kdmoS);
            mysqli_stmt_bind_param($stmtUpdate, "iissssssii",$kdU,$kdmoU,$kdgU,
              $nuU,$adU,$piU,$teU,$teaU,$kdUS,$kdmoUS);
            for($i=1;$i<=$rowCount;$i++){
              $row= dbase_get_record_with_names ( $db , $i);

                $kdS=$row["EDRPO"];
                $kdmoS=$row["KMIS_OD"];
                mysqli_stmt_execute($stmtSelect);
                $result = mysqli_stmt_get_result($stmtSelect);
                if(mysqli_num_rows($result)>0)
                {
                  $kdU = $row["EDRPO"];
                  $kdmoU = $row["KMIS_OD"];
                  $kdgU = $row["KOD_GL"];
                  $nuU = changeCodingPage($row['NAME_U']);
                  $adU = changeCodingPage($row['NAM_VUL'].",".$row['NOM_B']);
                  $piU = $row['P_IND'];
                  $teU = $row['TEF'];
                  $teaU = getTea($row['TEF']);
                  $kdUS = $row["EDRPO"];
                  $kdmoUS = $row["KMIS_OD"];

                  mysqli_stmt_execute($stmtUpdate);
                  $countUpdate+=1;
                } else {
                  $kd = $row["EDRPO"];
                  $kdmo = $row["KMIS_OD"];
                  $kdg = $row["KOD_GL"];
                  $nu = changeCodingPage($row['NAME_U']);
                  $ad = changeCodingPage($row['NAME_VUL'].",".$row['NOM_B']);
                  $pi = $row['P_IND'];
                  $te = $row['TEF'];
                  $tea = getTea($row['TEF']);
                  mysqli_stmt_execute($stmtInsert);
                  $countInsert+=1;
                }
                mysqli_free_result($result);

            }
          }
          mysqli_stmt_close($stmtSelect);
          mysqli_stmt_close($stmtInsert);
          mysqli_stmt_close($stmtUpdate);
          countChild($link);
          $ERROR_MSG.=" ������ �������� ".$countUpdate." . <br>";
          $ERROR_MSG.= " ������ ������ ".$countInsert." . <br>";
          $ERROR_MSG.= " � ����� ������  ".$rowCount." ������. <br>";
               $ERROR_MSG.= "������ ����������� �������� ".calcTimeRun($start,microtime(true))."<br>";
          dbase_close($db);
        }
      }
  }
  if($action=="importContact"){
    $start = microtime(true);
    set_time_limit(90000);
    if (!file_exists($tmpFile=$_FILES["fileImpContact"]['tmp_name'])) {
      $ERROR_MSG .= '������� ������������ �����! <br/>';
    }else {
      $db = dbase_open($tmpFile, 0);
      if ($db) {
          $countInsrt=0;
          $countUpdate=0;
          $nameRow=array(0=>"OT",1=>"DT",2=>"OF",3=>"EMAIL" );
          $rowCount=dbase_numrecords ($db);
          for($i=1;$i<=$rowCount;$i++){
            $row= dbase_get_record_with_names ( $db , $i);
            $strSelectOrg="SELECT id FROM `organizations` WHERE `kd`=".$row['KD']."  and `kdmo`=".$row['KDMO'];
            $result=mysqli_query($link,$strSelectOrg);

            if(mysqli_error($link)==''){
              if(mysqli_num_rows($result)>0){
                $rowOrg= mysqli_fetch_assoc($result);
                for ($j=0; $j <4; $j++) {
                  if(str_replace(' ','',$row[$nameRow[$j]])!=""&&str_replace(' ','',$row[$nameRow[$j]])!="0"){
                    $queryGetFild="SELECT id FROM `contact` WHERE `id_org`=".$rowOrg["id"]." AND `data` like('".$row[$nameRow[$j]]."') AND `type`=".getTypeCon($j);
                    $resultCont=mysqli_query($link,$queryGetFild);
                    if(mysqli_num_rows($resultCont)==0){
                      $queryUpdate="INSERT INTO `contact`(`id_org`, `data`, `type`)"
                        ."VALUES (".$rowOrg["id"].",'".$row[$nameRow[$j]]."',".getTypeCon($j).")";
                      mysqli_query($link,$queryUpdate);
                      $countInsrt+=1;
                    }else {
                      $countUpdate+=1;
                    }
                    mysqli_free_result($resultCont);
                  }
                }
                mysqli_free_result($result);
              }else{
                $ERROR_MSG.="ϳ��������� � ����� ������ -".$row['KD']."  �� ���� - ".$row['KDMO']." �� ��������. <br>";
              }
            }else{
              $ERROR_MSG.="��� ��������� ������ ������� ������� ".mysqli_error($link)."<br>";
            }
          }
          $ERROR_MSG.="ϳ� ��� ������� �������� ���� ������ ".$countInsrt." �� �������� ".$countUpdate." �������� (�� ��������, ��� ������ ���������� ���� ���� ������ ��������) <br>";
          dbase_close($db);
      }
    }
  }

  closeConnect($link);
  require_once('template/load_arm.php');
?>
