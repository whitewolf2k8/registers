<?
  require_once('../../lib/start.php');

  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';
  $filtr_volator=isset($_POST['filtr_volator']) ? stripslashes($_POST['filtr_volator']) : '';

  $filtr_maneger = isset($_POST['filtr_maneger_select']) ? stripslashes($_POST['filtr_maneger_select']) : '';


  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";
  if($action=="import") {
  	$countIns = 0;
  	$countUpd = 0;
    $countAll = 0;
  	if (!file_exists($tmpFile=$_FILES["fileImp"]['tmp_name'])) {
  		$ERROR_MSG .= '<br />Помилка завантаження файлу.';
  	}
  	$d = @fopen($tmpFile, "r");
  	if ($d != false) {
      $strInsert ="INSERT INTO `violation_base`(`id_org`, `decree`, `volator`, `id_maneger`) VALUES (%d,'%s','%s',%d)";
      $strUpdate ="UPDATE `violation_base` SET `id_org`=%d,`decree`='%s',`volator`='%s',`id_maneger`=%d WHERE `id`=%d";
      $strSelectManeger ="SELECT id FROM `managers` WHERE  nu LIKE ('%s')";
  		while (!feof($d)) {
  			$str = chop(fgets($d)); //считываем очередную строку из файла до \n включительно
  			if ($str == '') continue;
  			$fields = explode(",", $str);
  			$str_query = 'SELECT id  FROM organizations'
  							.' WHERE kd="'.$fields[0].'" and kdmo ="'.(($fields[1]=="")?($fields[0]."0001"):$fields[1]).'"'
  							.' LIMIT 1';
        $resultOrg = mysqli_query($link,$str_query);
  			if ($resultOrg){
  				if (mysqli_num_rows($resultOrg) == 1) {
  					$row = mysqli_fetch_assoc($resultOrg);
            $res = mysqli_query($link,"SELECT * FROM `violation_base` WHERE id_org = ".$row['id']);
            $resManeger = mysqli_query($link,"SELECT id FROM `managers` WHERE  nu LIKE ('%".$fields[4]."%')");
            if(mysqli_num_rows($resManeger) != 0){
              if (mysqli_num_rows($res) == 0)
              {
                $rowManeger = mysqli_fetch_assoc($resManeger);
                $query_str = sprintf($strInsert,$row["id"],$fields[2],delApostrophe($fields[3]),$rowManeger["id"]);
                mysqli_query($link,$query_str);
                  echo $query_str."<br>";
                $countIns++;
              }else{
                $rowManeger = mysqli_fetch_assoc($resManeger);
                $flag=false;
                while($r = mysqli_fetch_array($res, MYSQLI_ASSOC)){
                  if(strnatcasecmp($r["decree"],$fields[2])==0){
                    $flag=true;
                    $query_str =sprintf($strUpdate,$row["id"],$fields[2],delApostrophe($fields[3]),$rowManeger["id"],$r["id"]);
                    mysqli_query($link,$query_str);
                      echo $query_str."<br>";
                    $countUpd++;
                  }
                }
                if($flag==false){
                  $query_str = sprintf($strInsert,$row["id"],$fields[2],delApostrophe($fields[3]),$rowManeger["id"]);
                  mysqli_query($link,$query_str);
                    echo $query_str."<br>";
                  $countIns++;
                }
                mysqli_free_result($resManeger);
                mysqli_free_result($res);
              }
            }else{
              $ERROR_MSG .= 'Не знайдено керівника внісшого адмін справу для підприємства  з  kd '.$fields[0].' kdmo '.$fields[1]." датою/номером постанови ".$fields[2]."<br>";
            }
  					@mysql_free_result($res);
  				}else{
              $ERROR_MSG .= 'Не знайдено підприємства з  kd '.$fields[0]."<br>";
          }
  				@mysql_free_result($resultOrg);
  			} else {
  				$ERROR_MSG .= 'Помилка виконання запиту для підприємства kd '.$fields[0].' kdmo '.$fields[1];
  				continue;
  			}
  		}
  		fclose($d);
  		$ERROR_MSG .= "<br />Імпорт завершено. Оновлених: $countUpd. Додано: $countIns. Всього: ".($countIns+$countUpd)."  --".$countAll;
  	} else
  		$ERROR_MSG .= "<br />Неможливо відкрити файл імпорта";
}

  $where = array();

  if($filtr_kd!=""){
    $where[]=" t2.kd = '".$filtr_kd."'";
  }

  if($filtr_kdmo!=""){
    $where[]=" t2.kdmo = '".$filtr_kdmo."'";
  }

  if($filtr_maneger!=""){
    $where[]=" t1.id_maneger = ".$filtr_maneger;
  }

  if($filtr_volator!=""){
    $where[]=" t1.volator like ('".$filtr_volator."')";
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );


  $qeruStrPaginathion="SELECT COUNT(t1.id) as resC FROM `violation_base`  as t1 "
    ." left join  organizations as t2 on t2.id=t1.id_org"
    ." left join managers as t3 on t3.id=t1.id_maneger ".$whereStrPa;
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

  $qeruStr="SELECT t2.kd, t2.kdmo, t1.decree, t1.volator, t3.nu FROM `violation_base`  as t1 "
    ." left join  organizations as t2 on t2.id=t1.id_org"
    ." left join managers as t3 on t3.id=t1.id_maneger ".$whereStr;



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
  $selected_menager= getListMeneger($link,$filtr_maneger);
  require_once('template/load_volator.php');
?>
