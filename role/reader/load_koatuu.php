<?
  require_once('../../lib/start.php');

  $filtr_kodu=isset($_POST['filtr_kodu']) ? stripslashes($_POST['filtr_kodu']) : '';
  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;
  $filtr_obl_s=isset($_POST['filtr_obl']) ? stripslashes($_POST['filtr_obl']) : '';
  $filtr_region_s=isset($_POST['filtr_region']) ? stripslashes($_POST['filtr_region']) : '';

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";

  if($action=="import"){
    $start = microtime(true);
    set_time_limit(90000);
    if (!file_exists($tmpFile=$_FILES["fileImp"]['tmp_name'])) {
      $ERROR_MSG .= 'Помилка завантаження файлу! <br/>';
    }else {
      //echo _detectFileEncoding($tmpFile);
      $db = dbase_open($tmpFile, 0);
      if ($db) {
          $countUpdate=0;
          $countInsert=0;
          // чтение некотрых данных
          $querySelect = "SELECT * FROM `koatuu` WHERE `te`= ?";
          $queryUpdate = "UPDATE `koatuu` SET `te`=?,`te1`=?,`np`=?,`nr`=?,"
            ."`nu`=?,`kdn`=?,`dz`=?,`pr`=? WHERE `te`= ?";
          $queryInsert = "INSERT INTO `koatuu`(`te`, `te1`, `np`, `nr`, `nu`, `kdn`, `dz`, `pr`)"
            ." VALUES (?,?,?,?,?,?,?,?)";
          $stmtSelect = mysqli_stmt_init($link);
          $stmtUpdate = mysqli_stmt_init($link);
          $stmtInsert = mysqli_stmt_init($link);

          $rowCount=dbase_numrecords ($db);
          if((!mysqli_stmt_prepare($stmtSelect, $querySelect))||(!mysqli_stmt_prepare($stmtInsert, $queryInsert))||(!mysqli_stmt_prepare($stmtUpdate, $queryUpdate)))
          {
            $ERROR_MSG.="<br> Помилка Підготовки запиту \n <br>";
          } else{
            mysqli_stmt_bind_param($stmtInsert, "ssssssss",$te,$te1,$np,$nr,$nu,$kdn,$dz,$pr);
            mysqli_stmt_bind_param($stmtSelect, "s", $teS);
            for($i=1;$i<=$rowCount;$i++){
              mysqli_stmt_bind_param($stmtUpdate, "sssssssss",$teU,$te1U,$npU,$nrU,$nuU,$kdnU,$dzU,$prU,$teUS);
              $row= dbase_get_record_with_names ( $db , $i);
              $teS=$row["TE"];
              mysqli_stmt_execute($stmtSelect);
              $result = mysqli_stmt_get_result($stmtSelect);
              if(mysqli_num_rows($result)>0){
                $teU=$row["TE"];
                $te1U=$row["TE1"];
                $npU=changeCodingPage($row['NP']);
                $nrU=changeCodingPage($row['NR']);
                $nuU=changeCodingPage($row['NU']);
                $kdnU=$row['KDN'];
                $dzU=$row['DZ'];
                $prU=$row['PR'];
                $teUS=$row["TE"];
                mysqli_stmt_execute($stmtUpdate);
                $countUpdate+=1;
              } else {
                $te=$row["TE"];
                $te1=$row["TE1"];
                $np=changeCodingPage($row['NP']);
                $nr=changeCodingPage($row['NR']);
                $nu=changeCodingPage($row['NU']);
                $kdn=$row['KDN'];
                $dz=$row['DZ'];
                $pr=$row['PR'];

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

  $where = array();
  if($filtr_obl_s!=""){
    $where[]="te like  ('".$filtr_obl_s.$filtr_region_s."%') ";
  }
  if($filtr_kodu!=""){
    $where[]="te like  ('".$filtr_kodu."') ";
  }


  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(*) as resC FROM `koatuu` ".$whereStrPa;
  $resultPa = mysqli_query($link,$qeruStrPaginathion);
  if($resultPa){
    $r=mysqli_fetch_array($resultPa, MYSQLI_ASSOC);
    $rowCount=$r['resC'];
  }
  mysqli_free_result($resultPa);
  if($rowCount>0){
      $pagination.=getPaginator($rowCount,$paginathionLimit,$paginathionLimitStart);
  }
  $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  if($paginathionLimit!=0 ){

    $whereStr.=' LIMIT '.$paginathionLimitStart.','.$paginathionLimit;
  }


  $qeruStr="SELECT * FROM `koatuu` ".$whereStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  $filtr_obl=getListObl($link, $filtr_obl_s);
  $filtr_region=getListTeR($link,$filtr_obl_s, $filtr_region_s);
  closeConnect($link);
  require_once('template/load_koatuu.php');
?>
