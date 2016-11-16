<?
  require_once('../../lib/start.php');

  print_r($_POST);

  $filtr_year_insert=isset($_POST['filtr_year_insert']) ? stripslashes($_POST['filtr_year_insert']) : 0;
  $filtr_period_insert=isset($_POST['filtr_period_insert']) ? stripslashes($_POST['filtr_period_insert']) : 0;

  $filtr_year_select=isset($_POST['filtry_year_select']) ? stripslashes($_POST['filtry_year_select']) : 0;
  $filtr_period_select=isset($_POST['filtr_period_select']) ? stripslashes($_POST['filtr_period_select']) : 0;

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
  			$str_query = 'SELECT id'.' FROM organizations'
  							.' WHERE kd="'.$fields[0].'" and kdmo ="'.$fields[1].'"'
  							.' LIMIT 1';
  			$resultOrg = mysqli_query($link,$str_query);
  			if ($resultOrg){
  				if (mysqli_num_rows($resultOrg) == 1) {
  					$row = mysqli_fetch_assoc($resultOrg);
  					$res = mysqli_query($link,'SELECT id FROM amount_workers WHERE id_org="'.$row['id'].'" AND'
              .' type = 0 AND id_year = '.$filtr_year_insert
              .' AND id_period = '.$filtr_period_insert .'   LIMIT 1');
  					if (mysqli_num_rows($res) == 0)
  					{
  						$query_str = 'INSERT INTO `amount_workers`(`type`, `id_org`, `id_year`, `id_period`, `amount`)'
                .' VALUES (0,'.$row[id].','.$filtr_year_insert.','.$filtr_period_insert.','.($fields[2]+$fields[3]+$fields[4]).')';
  						mysqli_query($link,$query_str);
  						$countIns++;
  					}
  					else
  					{
              $r = mysqli_fetch_assoc($res);
              $query_str = "UPDATE `amount_workers` SET"
                ." `amount`=".($fields[2]+$fields[3]+$fields[4])." WHERE id =".$r['id'];
              mysqli_query($link,$query_str);
  						 $countUpd++;
  					}
  					@mysql_free_result($res);
  				}else{
            if($fields[1]!=0){
              $ERROR_MSG .= 'Не знайдено підприємства з  kd '.$fields[0].' kdmo '.$fields[1]."<br>";
            }else{
              $countKdmoNull++;
            }
          }
  				@mysql_free_result($resultOrg);
  			} else {
  				$ERROR_MSG .= 'Помилка виконання запиту для підприємства kd '.$fields[0].' kdmo '.$fields[1];
  				continue;
  			}
  		}
  		fclose($d);
  		$ERROR_MSG .= "<br />Імпорт завершено. Оновлених: $countUpd. Додано: $countIns. Де KDMO рівне 0: $countKdmoNull .  Всього: ".($countIns+$countUpd);
  	} else
  		$ERROR_MSG .= "<br />Неможливо відкрити файл імпорта";
} else if ($action=="edit"){
  $checkElement = $_POST["checkList"];
  $arrAmont = $_POST["textAmount"];
  foreach ($checkElement as $key => $value) {
    $query_str = "UPDATE `amount_workers` SET"
      ." `amount`=".$arrAmont[$value]." WHERE id =".$value;
    mysqli_query($link,$query_str);
    $countUpd++;
  }
  $ERROR_MSG .= "<br />Оновлено: $countUpd запис(ів).";
}else if ($action=="del"){
  $checkElement = $_POST["checkList"];
  foreach ($checkElement as $key => $value) {
    $query_str = "DELETE FROM `amount_workers` WHERE `id` = ".$value;
    mysqli_query($link,$query_str);
    $countUpd++;
  }
  $ERROR_MSG .= "<br />Видалено: $countUpd запис(ів).";
}

  $where = array();
  $where[]=' cn.type = 0';
  if($filtr_kd!=""){
    $where[]=" org.kd = '".$filtr_kd."'";
  }
  if($filtr_kdmo!=""){
    $where[]=" org.kdmo = '".$filtr_kdmo."'";
  }
  if($filtr_year_select!=""){
    $where[]=" cn.id_year = ".$filtr_year_select;
  }
  if($filtr_period_select!=""){
    $where[]=" cn.id_period = ".$filtr_period_select;
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(cn.id) as resC FROM `amount_workers`  as cn "
    ." left join  organizations as org on org.id=cn.id_org"
    ." left join year as y on y.id=cn.id_year "
    ." left join period as p on p.id=cn.id_period ".$whereStrPa;
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


  $qeruStr="SELECT cn.id, org.nu as nu_org ,cn.amount, y.short_nu as nu_year, p.nu as nu_period FROM `amount_workers`  as cn "
    ." left join  organizations as org on org.id=cn.id_org"
    ." left join year as y on y.id=cn.id_year "
    ." left join period as p on p.id=cn.id_period ".$whereStr;

  //echo $qeruStr;
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

  $list_department=getListDepatment($link,0);
  $list_type_act=getListTypeAct($typeAct,0);

  require_once('template/act_show.php');
?>
