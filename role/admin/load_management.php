<?
  require_once('../../lib/start.php');

  $filtr_kd=isset($_POST['filtr_kd_m']) ? stripslashes($_POST['filtr_kd_m']) : '';
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
          $querySelect = "SELECT * FROM `managment_department` WHERE `kd`= ?";
          $queryUpdate = "UPDATE `managment_department` SET `kd`=?,`nu`=? WHERE `kd`=?";
          $queryInsert = "INSERT INTO `managment_department`(`kd`, `nu`) VALUES (?,?)";
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

  $where = array();
  if($filtr_kd!=""){
    $where[]=' `kd` = '.$filtr_kd;
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(*) as resC FROM `managment_department` ".$whereStrPa;
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


  $qeruStr="SELECT * FROM `managment_department` ".$whereStr;
  //echo $qeruStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  closeConnect($link);
  require_once('template/load_management.php');
?>
