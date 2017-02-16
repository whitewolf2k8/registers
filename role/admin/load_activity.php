<?
  require_once('../../lib/start.php');

  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';

  $periodSelect=isset($_POST['filtr_period_select'])?$_POST['filtr_period_select']:0;
  $yearSelect=isset($_POST['filtr_year_select'])?$_POST['filtr_year_select']:0;


  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";

  if($action=="import"){
    $start = microtime(true);
    set_time_limit(90000);
    if (!file_exists($tmpFile=$_FILES["fileImp"]['tmp_name'])) {
      $ERROR_MSG .= 'Помилка завантаження файлу! <br/>';
    }else {
      $db = dbase_open($tmpFile, 0);
      if ($db) {
          $countUpdate=0;
          $countInsert=0;
          // чтение некотрых данных
          $querySelect = "SELECT * FROM `opf` WHERE `kd`= ?";
          $queryUpdate = "UPDATE `opf` SET `kd`=?,`nu`=? WHERE `kd`=?";
          $queryInsert = "INSERT INTO `opf`(`kd`, `nu`) VALUES (?,?)";
          $stmtSelect = mysqli_stmt_init($link);
          $stmtUpdate = mysqli_stmt_init($link);
          $stmtInsert = mysqli_stmt_init($link);

          $rowCount=dbase_numrecords ($db);
          if((!mysqli_stmt_prepare($stmtSelect, $querySelect))||(!mysqli_stmt_prepare($stmtInsert, $queryInsert))||(!mysqli_stmt_prepare($stmtUpdate, $queryUpdate)))
          {
            $ERROR_MSG.="<br> Помилка Підготовки запиту \n <br>";
          } else{
            mysqli_stmt_bind_param($stmtInsert, "ss",$kd,$nu);
            mysqli_stmt_bind_param($stmtSelect, "s", $kdS);
            mysqli_stmt_bind_param($stmtUpdate, "sss",$kdU,$nuU,$kdUs);
            for($i=1;$i<=$rowCount;$i++){
              $row= dbase_get_record_with_names ( $db , $i);
              $kdS=$row["KD"];

              mysqli_stmt_execute($stmtSelect);
              $result = mysqli_stmt_get_result($stmtSelect);
              if(mysqli_num_rows($result)>0){
                $kdU = $row["KD"];
                $nuU = changeCodingPage($row['NU']);
                $kdUS = $row["KD"];
                mysqli_stmt_execute($stmtUpdate);
                $countUpdate+=1;
              } else {
                $kd = $row["KD"];
                $nu = changeCodingPage($row['NU']);
                mysqli_stmt_execute($stmtInsert);
                $countInsert+=1;
              }
              mysqli_free_result($result);
            }
          mysqli_stmt_close($stmtSelect);
          mysqli_stmt_close($stmtInsert);
          mysqli_stmt_close($stmtUpdate);
          $ERROR_MSG.=" Записів оновлено ".$countUpdate." . <br>";
          $ERROR_MSG.= " Додано записів ".$countInsert." . <br>";
          $ERROR_MSG.= " З файлу запитано  ".$rowCount." записів. <br>";
          $ERROR_MSG.= "Скрипт виконувався протягом ".calcTimeRun($start,microtime(true))."<br>";
          dbase_close($db);
        }
      }
    }
  }

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
  $qeruStrPaginathion="SELECT COUNT(t1.id) as resC  FROM `activity_tax` as t1 "
    ." left join organizations as t2 on t2.id=t1.id_org"
    ." left join `year` as t3 on t3.id=t1.id_year "
    ." left join `period` as t4 on t4.id=t1.id_period ".$whereStrPa;

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


  $insert_year= getListYear($link,0,1," - не обрано - ");
  $insert_period= getListPeriod($link,0," - не обрано - ");


  $select_year= getListYear($link,$yearSelect,1," - не обрано - ");
  $select_period= getListPeriod($link,$periodSelect," - не обрано - ");

  require_once('template/load_activity.php');
?>
