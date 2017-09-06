<?
  require_once('../../lib/start.php');

  $filtr_year_insert=isset($_POST['filtr_year_insert']) ? stripslashes($_POST['filtr_year_insert']) : 0;
  $filtr_year_select=isset($_POST['filtry_year_select']) ? stripslashes($_POST['filtry_year_select']) : 0;

  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";

  if($action=="import") {
    $start = microtime(true);
    set_time_limit(90000);
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
  				if (mysqli_num_rows($resultOrg) != 0) {
  					$row = mysqli_fetch_assoc($resultOrg);
  					$res = mysqli_query($link,'SELECT id FROM el_signatures WHERE id_org="'.$row['id'].'" AND'
              .'`id_year` = '.$filtr_year_insert.'  LIMIT 1');
  					if (mysqli_num_rows($res) == 0)
  					{
  						$query_str = 'INSERT  INTO `el_signatures`(`id_org`,`el_info`,`id_year`)'
                 .' VALUES ('.$row['id'].',"+",'.$filtr_year_insert.')';
  						mysqli_query($link,$query_str);
  						$countIns++;
  					}
  					else
  					{
              $r = mysqli_fetch_assoc($res);
                $query_str = 'UPDATE `el_signatures` SET `id_org`=?,`id_year`=? WHERE `id_org`='.$row['id'].' AND `id_year`=?';
                mysqli_query($link,$query_str);
  						 $countUpd++;
             }
  					@mysql_free_result($res);
  				}else{
              $ERROR_MSG .= 'Не знайдено підприємства з  kd '.$fields[0]."<br>";
          }
  				@mysql_free_result($resultOrg);
  			} else {
  				$ERROR_MSG .= 'Помилка виконання запиту для підприємства  '.$fields[0];
  				continue;
  			}
  		}
  		fclose($d);
  		$ERROR_MSG .= "<br />Імпорт завершено. Оновлених: $countUpd. Додано: $countIns. Всього: ".($countIns+$countUpd);
  	} else
  		$ERROR_MSG .= "<br />Неможливо відкрити файл імпорта";
}
  $where = array();
   $where[]=' t1.id_org != 0';
  if($filtr_kd!=""){
    $where[]=" t2.kd = '".$filtr_kd."'";
  }
  if($filtr_kdmo!=""){
    $where[]=" t2.kdmo = '".$filtr_kdmo."'";
  }
  if($filtr_year_select!=""){
    $where[]=" t1.id_year = ".$filtr_year_select;
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(t1.id) as resC   FROM  el_signatures as t1"
  ." left join organizations as t2 on t2.id=t1.id_org"
  ." left join year as t3 on t3.id=t1.id_year".$whereStrPa;
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

  $qeruStr="SELECT t3.nu, t2.kd,t2.kdmo,t1.* FROM "
      ." el_signatures as t1 "
      ." left join organizations as t2 on t2.id=t1.id_org"
      ." left join year as t3 on t3.id=t1.id_year".$whereStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  $insert_year= getListYear($link,0,0);
  $select_year= getListYear($link,$filtr_year_select,1);

  require_once('template/load_el_signatures.php');


?>
