<?  include_once('../../../lib/start.php');
include_once('../../../lib/function.php');
  $action=$_POST["action"];

  $ERROR_MSG="";
  $INFO_MSG="";

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  if($action=="load"){
    set_time_limit(90000);
    $paginathionLimitStart=0;

    $periodIns=$_POST['filtr_period_insert'];
    $yearIns=$_POST['filtr_year_insert'];

    if (!file_exists($tmpFile=$_FILES['fileImp']['tmp_name'])) {
      $ERROR_MSG .= 'Помилка завантаження файлу! <br/>';
      setMaxSession("");
    }else {
      $db = dbase_open($tmpFile, 0);
      if ($db) {
        $countUpdate=0;
        $countInsert=0;
        $rowCount=dbase_numrecords ($db);
        setMaxSession($rowCount);
        for($i=1;$i<=$rowCount;$i++){
          $row= dbase_get_record_with_names ( $db , $i);
          $strSelectOrg="SELECT `id` FROM `organizations` WHERE `kd` like('".$row['KD']
            ."') and `kdmo` like ('".$row['KD']."%') ";
          $resOrg=mysqli_query($link,$strSelectOrg);
          if(mysqli_error($link)!=""){
            $ERROR_MSG .="При виконані запиту виникла помилка:". mysqli_error($link)."<br>";
          }else {
            if(mysqli_num_rows($resOrg)>0){
              $rowOrg=mysqli_fetch_array($resOrg, MYSQLI_ASSOC);
              $strSelectExists="SELECT id FROM `activity_tax` WHERE `id_org`='".$rowOrg['id']."'"
                ." and `id_period`= ".$periodIns." and `id_year` = ".$yearIns;
              $resFin=mysqli_query($link,$strSelectExists);
              if(mysqli_error($link)!=""){
                $ERROR_MSG .="При виконані запиту виникла помилка: ". mysqli_error($link)."<br>";
              }else{
                if(mysqli_num_rows($resFin)!=0){
                  $rowAct=mysqli_fetch_array($resFin, MYSQLI_ASSOC);
                  $strUpdate="UPDATE `activity_tax` SET `sign`=".(($row['POD1']==0)?"1":"2")." WHERE `id`=".$rowAct['id'];
                  mysqli_query($link,$strUpdate);
                  $countUpdate++;
                }else{
                  $strInsert="INSERT INTO `activity_tax`(`id_org`, `id_period`, `id_year`, `sign`)"
                    ."VALUES (".$rowOrg['id'].",".$periodIns.",".$yearIns.",".(($row['POD1']==0)?"1":"2").")";
                  mysqli_query($link,$strInsert);
                  $countInsert++;
                }
                mysqli_free_result($resFin);
              }
              mysqli_free_result($resOrg);
            }else{
              $ERROR_MSG .="У базі не знайдено підприємство з кодом ЄДРПОУ: ".$row['KD'].". <br>";
            }
          }
          session_start();
          $_SESSION['ls_sleep_test'] = $i;
          session_write_close();
        }
        $INFO_MSG.=" Записів оновлено ".$countUpdate." . ";
        $INFO_MSG.= " Додано записів ".$countInsert." . ";
        $INFO_MSG.= " З файлу зчитано  ".$rowCount." записів. <br>";
        dbase_close($db);
      }else{
        $ERROR_MSG .="Не вдалося підєднатися до бази данних. ";
      }
    }
  }




  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';

  $periodSelect=isset($_POST['filtr_period_select'])?$_POST['filtr_period_select']:0;
  $yearSelect=isset($_POST['filtr_year_select'])?$_POST['filtr_year_select']:0;


  $where= array();
  if(delSpace($filtr_kd)!=''){
    $where[]=" t2.kd like('".delSpace($filtr_kd)."') ";
  }

  if(delSpace($filtr_kdmo)!=''){
    $where[]=" t2.kdmo like('".delSpace($filtr_kdmo)."') ";
  }

  if($periodSelect!=0){
    $where[]=" t1.id_period = ".$periodSelect;
  }

  if($yearSelect!=0){
    $where[]=" t1.id_year = ".$yearSelect;
  }



  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(t1.id) as resC  FROM `activity_tax` as t1"
    ." left join organizations as t2 on t2.id=t1.id_org ".$whereStrPa;

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

   $qeruStr="SELECT t2.kd,t2.kdmo,t2.nu,t3.short_nu,t4.nu as Nuperiod,t1.sign FROM "
    ." `activity_tax` as t1 "
    ." left join organizations as t2 on t2.id=t1.id_org"
    ." left join `year` as t3 on t3.id=t1.id_year "
    ." left join `period` as t4 on t4.id=t1.id_period ".$whereStr;


  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  $resultArr=array();

  $resultArr['table']=$ListResult;
  $resultArr['paginator']=$pagination;
  $resultArr['ERROR_MSG']=$ERROR_MSG;
  $resultArr['INFO_MSG']=$INFO_MSG;

  echo php2js($resultArr);
?>
