<?
  require_once('../../lib/start.php');

  $filtr_kved_kod=isset($_POST['filtr_kved_kod']) ? stripslashes($_POST['filtr_kved_kod']) : '';
  $filtr_kved_kategory=isset($_POST['filtr_kved_kategory']) ? stripslashes($_POST['filtr_kved_kategory']) : '';
  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;


  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";
  //print_r($_POST);

  if($action=="import")
  {
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
          $querySelect = "SELECT * FROM `kved10` WHERE (`kod`LIKE ?) and (`sek`LIKE ?)";
          $queryUpdate = "UPDATE `kved10` SET`sek`=?,`kod`=?,`nu`=? WHERE (`kod`LIKE ?) and (`sek`LIKE ?)";
          $queryInsert = "INSERT INTO `kved10`(`sek`, `kod`, `nu`) VALUES (?,?,?)";
          $stmtSelect = mysqli_stmt_init($link);
          $stmtUpdate = mysqli_stmt_init($link);
          $stmtInsert = mysqli_stmt_init($link);

          $rowCount=dbase_numrecords ($db);
          if((!mysqli_stmt_prepare($stmtSelect, $querySelect))||(!mysqli_stmt_prepare($stmtInsert, $queryInsert))||(!mysqli_stmt_prepare($stmtUpdate, $queryUpdate)))
          {
            $ERROR_MSG.="<br> Помилка Підготовки запиту \n <br>";
          } else{
            mysqli_stmt_bind_param($stmtInsert, "sss",$sek,$kod,$nu);
            mysqli_stmt_bind_param($stmtSelect, "ss", $kodS,$sekS);
            mysqli_stmt_bind_param($stmtUpdate, "sssss",$sekU,$kodU,$nuU,$kodUS,$sekUS);
            for($i=1;$i<=$rowCount;$i++){
              $row= dbase_get_record_with_names ( $db , $i);
              $kodS=$row["KOD"];
              $sekS=$row["SEK"];
              mysqli_stmt_execute($stmtSelect);
              $result = mysqli_stmt_get_result($stmtSelect);
              if(mysqli_num_rows($result)>0){
                $sekU = $row["SEK"];
                $kodU = $row["KOD"];

                $nuU = changeCodingPage($row['NU']);
                $kodUS =$row['KOD'];
                $sekUS = $row["SEK"];
                mysqli_stmt_execute($stmtUpdate);
                $countUpdate+=1;
              } else {
                $sek = $row["SEK"];
                $kod = $row["KOD"];
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
  if($filtr_kved_kod!=""){
    $filtr_kved_kod1=formatKodKved10($filtr_kved_kod);
    if(iconv_strlen($filtr_kved_kod1, "Windows-1251")==5){
      $where[]=' (`kod` LIKE "'.$filtr_kved_kod1.'" ) ';
      $filtr_kved_kod=str_replace(" ","",$filtr_kved_kod1);
    }else{
      $ERROR_MSG.= "<br>".$filtr_kved_kod1;
    }

  }
  if($filtr_kved_kategory!=""){
    $where[]='(`sek` LIKE "'.$filtr_kved_kategory.'" ) ';
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(*) as resC FROM `kved10` ".$whereStrPa;
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

//  prin $whereStr;
  $qeruStr="SELECT * FROM `kved10` ".$whereStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }





  $list_kved_kategory=getListKvedSek($link, $filtr_kved_kategory);
  require_once('template/load_kved.php');
?>
