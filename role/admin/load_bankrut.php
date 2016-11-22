<?
  require_once('../../lib/start.php');

  $filtr_year_insert=isset($_POST['filtr_year_insert']) ? stripslashes($_POST['filtr_year_insert']) : 0;
  $filtr_period_insert=isset($_POST['filtr_period_insert']) ? stripslashes($_POST['filtr_period_insert']) : 0;

  $filtr_type_deal_select=isset($_POST['filtr_type_deal_select']) ? stripslashes($_POST['filtr_type_deal_select']) : 0;
  $filtr_maneger_deal_select=isset($_POST['filtr_maneger_deal_select']) ? stripslashes($_POST['filtr_maneger_deal_select']) : 0;

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
  							.' WHERE kd="'.$fields[0].' and kdmo ='.$fields[0].''
  							.' LIMIT 1';

  			$resultOrg = mysqli_query($link,$str_query);
  			if ($resultOrg){
  				if (mysqli_num_rows($resultOrg) == 1)
          {
  					$row = mysqli_fetch_assoc($resultOrg);
  					$res = mysqli_query($link,'SELECT id FROM bankrupts WHERE org="'.$row['id'].'" AND'
            ." bankrupts like ('".$fields[1]."')");

          //  echo 'SELECT id FROM bankrupts WHERE id_org="'.$row['id'].'" AND'
          //  ." bankrupts like ('".$fields[0]."')"."<br>";

  				 if (mysqli_num_rows($res) == 0)
  					{
            $query_str = 'INSERT INTO `bankrupts`(`id_org`, `maneger_deal`, `deal_number`, `date_deal`, `type_deal`)'
              .' VALUES ('.$row[id].",'".$fields[1]."')";
               mysqli_query($link,$query_str);
              $countIns++;
  					}
  					else
  					{
  						 $countUpd++;
  					}
  					@mysql_free_result($res);
  				}
          else{
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
  //$where[]=' cn.type = 0';
  if($filtr_kd!=""){
    $where[]=" org.kd = '".$filtr_kd."'";
  }
  if($filtr_kdmo!=""){
    $where[]=" org.kdmo = '".$filtr_kdmo."'";
  }
  if($filtr_type_deal_select!=""){
    $where[]=" ba.type_deal = ".$filtr_type_deal_select;
  }
  if($filtr_maneger_deal_select!=""){
    $where[]=" ba.maneger_deal = ".$filtr_maneger_deal_select;
  }


  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(ba.id)  FROM
    . bankrupts as ba
    . left join organizations as org on org.id=ba.id_org
    WHERE
    . kd,kdmo,id_org,maneger_deal,deal_number,data_deal,type_deal"
    .$whereStrPa;
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


   $qeruStr="SELECT org.kd,org.kdmo, ba.* FROM "
   ." bankrupts as ba "
   ." left join organizations as org on org.id=ba.id_org".$whereStr;
    //." left join year as y on y.id=cn.id_year "
    //." left join period as p on p.id=cn.id_period ".$whereStr;

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

  require_once('template/load_bankrut.php');
?>
