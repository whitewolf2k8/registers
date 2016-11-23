<?
  require_once('../../lib/start.php');

  $filtr_year_insert=isset($_POST['filtr_year_insert']) ? stripslashes($_POST['filtr_year_insert']) : 0;
  $filtr_period_insert=isset($_POST['filtr_period_insert']) ? stripslashes($_POST['filtr_period_insert']) : 0;

  $filtr_year_select=isset($_POST['filtry_year_select']) ? stripslashes($_POST['filtry_year_select']) : 0;
  $filtr_period_select=isset($_POST['filtr_period_select']) ? stripslashes($_POST['filtr_period_select']) : 0;

  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $filtr_type_table=isset($_POST['typeShow'])?$_POST['typeShow']:0;

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";


  if($action=="import") {
  	$countIns = 0;
  	$countUpd = 0;
    $countKdmoNull = 0;
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
        $querySelectAmount = "SELECT t1.id FROM `amount_workers` as t1 "
          ." left join  `organizations` as t2  on t1.id_org=t2.id ";
        $querySelectProfit = "SELECT t1.id FROM `profit_fin` as t1 "
          ." left join  `organizations` as t2  on t1.id_org=t2.id ";

        $queryUpdateAmount = "UPDATE `amount_workers` SET `type`=%d,`id_org`=%d,`id_year`=%d,`id_period`=%d,`amount`=%d WHERE `type`=%d AND `id_org`=%d AND `id_year`=%d AND `id_period`=%d";
        $queryUpdateProfit = "UPDATE `profit_fin` SET `id_org`=%d,`id_year`=%d,`id_period`=%d,`profit`=%F WHERE `id_org`=%d AND `id_year`=%d AND `id_period`=%d";

        $queryInsertAmount = "INSERT INTO `amount_workers`(`type`, `id_org`, `id_year`, `id_period`, `amount`)"
          ." VALUES (%d,%d,%d,%d,%d)";
        $queryInsertProfit = "INSERT INTO `profit_fin`(`id_org`, `id_year`, `id_period`, `profit`)"
          ." VALUES (%d,%d,%d,%F)";

        $rowCount=dbase_numrecords ($db);
        for($i=1;$i<=$rowCount;$i++){
          $row= dbase_get_record_with_names ( $db , $i);
          $queryOrg="SELECT id FROM `organizations` WHERE `kd`=".$row["OKPO"]." AND `kdmo`=".$row["OKPO"]."0001";

          $orgResult=mysqli_query($link, $queryOrg);
          if($orgResult){
            if (mysqli_num_rows($orgResult) == 1) {
              $res=mysqli_fetch_assoc($orgResult);
              $whereAmount=array();
              $whereProfit=array();

              $whereAmount[]="t1.type=1";
              $whereAmount[]="t2.kd =".$row["OKPO"];
              $whereAmount[]="t2.kdmo =".$row["OKPO"]."0001";
              $whereAmount[]="t1.id_year =".$filtr_year_insert;
              $whereAmount[]="t1.id_period =".$filtr_period_insert;

              $whereProfit[]="t2.kd =".$row["OKPO"];
              $whereProfit[]="t2.kdmo =".$row["OKPO"]."0001";
              $whereProfit[]="t1.id_year =".$filtr_year_insert;
              $whereProfit[]="t1.id_period =".$filtr_period_insert;

              $whereAmountStr = ( count( $whereAmount ) ? ' WHERE ' . implode( ' AND ', $whereAmount ) : '' );
              $whereProfitStr = ( count( $whereProfit ) ? ' WHERE ' . implode( ' AND ', $whereProfit ) : '' );

              $resultAmount=mysqli_query($link, $querySelectAmount.$whereAmountStr);
              $resultProfit=mysqli_query($link, $querySelectProfit.$whereProfitStr);

              if(mysqli_num_rows($resultAmount) == 1){
                mysqli_query($link,sprintf($queryUpdateAmount,1,$res["id"],$filtr_year_insert,$filtr_period_insert,$row["CHIS_FIN15"],1,$res["id"],$filtr_year_insert,$filtr_period_insert));
                $countUpd++;
              }else{
                mysqli_query($link,sprintf($queryInsertAmount,1,$res["id"],$filtr_year_insert,$filtr_period_insert,$row["CHIS_FIN15"]));
                $countIns++;
              }

              if(mysqli_num_rows($resultProfit) == 1){
                mysqli_query($link,sprintf($queryUpdateProfit,$res["id"],$filtr_year_insert,$filtr_period_insert,$row["DOXID_15"],$res["id"],$filtr_year_insert,$filtr_period_insert));
              }else{
                mysqli_query($link,sprintf($queryInsertProfit,$res["id"],$filtr_year_insert,$filtr_period_insert,$row["DOXID_15"]));

              }
              mysqli_free_result($resultAmount);
              mysqli_free_result($resultProfit);
              mysqli_free_result($orgResult);
            }else{
              $ERROR_MSG .= 'Не знайдено підприємства з  kd '.$row["OKPO"]."<br>";
            }
          }
        }
        $ERROR_MSG .= "До бази данних було внесено ".$countIns.", та оновлено ".$countUpd." записів.<br>";
      }else{
        $ERROR_MSG .= "Не можливо відкрити файл з базою данних  <br>";
      }
      dbase_close($db);
    }
  }

  $table=(($filtr_type_table==0)?"`amount_workers`":"profit_fin");


  $where = array();
  if($filtr_type_table!=1){
    $where[]=' t1.type = 1';
  }

  if($filtr_kd!=""){
    $where[]=" t2.kd = '".$filtr_kd."'";
  }
  if($filtr_kdmo!=""){
    $where[]=" t2.kdmo = '".$filtr_kdmo."'";
  }
  if($filtr_year_select!=""){
    $where[]=" t1.id_year = ".$filtr_year_select;
  }
  if($filtr_period_select!=""){
    $where[]=" t1.id_period = ".$filtr_period_select;
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(t1.id) as resC FROM ".$table."  as t1 "
    ." left join  organizations as t2 on t2.id=t1.id_org"
    ." left join year as t3 on t3.id=t1.id_year "
    ." left join period as t4 on t4.id=t1.id_period ".$whereStrPa;

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


  $qeruStr="SELECT t2.nu as nu_org , t3.short_nu as nu_year, t4.nu as nu_period"
    . " , t1.".(($filtr_type_table==0)?"amount":"profit")." as res  FROM ".$table." as t1 "
    ." left join  organizations as t2 on t2.id=t1.id_org"
    ." left join year as t3 on t3.id=t1.id_year "
    ." left join period as t4 on t4.id=t1.id_period ".$whereStr;

//  echo $qeruStr;

  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }


  $insert_year= getListYear($link,0,0);
  $insert_period= getListPeriod($link,0);

  $select_year= getListYear($link,$filtr_year_select,1);
  $select_period= getListPeriod($link,$filtr_period_select);

  require_once('template/load_amount_fin.php');
?>
