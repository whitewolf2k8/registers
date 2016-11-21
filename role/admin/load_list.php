<?
  require_once('../../lib/start.php');

  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';

  $ERROR_MSG="";


  if($action=="import") {
  	$countIns = 0;
  	$countUpd = 0;
    $countKdmoNull = 0;

  	if (!file_exists($tmpFile=$_FILES["fileImp"]['tmp_name'])) {
  		$ERROR_MSG .= '<br />Помилка завантаження файлу.';
  	}

    $d = @fopen($tmpFile, "r");
  	if ($d != false) {
  		while (!feof($d)) {
  			$str = chop(fgets($d)); //считываем очередную строку из файла до \n включительно
  			if ($str == '') continue;
  			$fields = explode(",", $str);

  			$str_query = 'SELECT id FROM `organizations` '
  							.' WHERE kd='.$fields[0].' and kdmo ='.$fields[0].'0001 LIMIT 1';

  			$resultOrg = mysqli_query($link,$str_query);
      	if ($resultOrg){
  				if (mysqli_num_rows($resultOrg) == 1) {
  					$row = mysqli_fetch_assoc($resultOrg);
  					$query_str = 'INSERT INTO `latter_base`(`id_org`, `label`, `type`)'
              .' VALUES ('.$row[id].",'".$fields[1]."',0)";
  						mysqli_query($link,$query_str);
  						$countIns++;
  				}else{
            if($fields[1]!=0){
              $ERROR_MSG .= 'Не знайдено підприємства з  kd '.$fields[0]."<br>";
            }
          }
  				@mysql_free_result($resultOrg);
  			} else {
  				$ERROR_MSG .= 'Помилка виконання запиту для підприємства kd '.$fields[0]."<br>";
  				continue;
  			}
  		}
  		fclose($d);
  		$ERROR_MSG .= "<br />Імпорт завершено. Додано: $countIns.";
  	} else{
  		$ERROR_MSG .= "<br />Неможливо відкрити файл імпорта";
    }
  }

  $where = array();
  $where[]=' letter.type = 0';
  if($filtr_kd!=""){
    $where[]=" org.kd = '".$filtr_kd."'";
  }
  if($filtr_kdmo!=""){
    $where[]=" org.kdmo = '".$filtr_kdmo."'";
  }


  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(letter.id) as resC   FROM  letter_base as letter"
  ." left join organizations as org  on org.id=letter.id_org ".$whereStrPa;
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

  $qeruStr="SELECT org.kd,org.kdmo,letter.label FROM  letter_base as letter "
    ." left join organizations as org on org.id=letter.id_org".$whereStr;

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

  require_once('template/load_list.php');
?>
