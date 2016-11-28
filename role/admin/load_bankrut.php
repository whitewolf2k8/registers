<?
  require_once('../../lib/start.php');

  $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';
  $filtr_manager_deal=isset($_POST['filtr_manager_deal']) ? stripslashes($_POST['filtr_manager_deal']) : '';
  $filtr_deal_number=isset($_POST['filtr_deal_number']) ? stripslashes($_POST['filtr_deal_number']) : '';
  $filtr_date_deal=isset($_POST['filtr_date_deal']) ? stripslashes($_POST['filtr_date_deal']) : '';
  $filtr_type_deal=isset($_POST['filtr_type_deal']) ? stripslashes($_POST['filtr_type_deal']) : '';

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
  							.' WHERE kd='.$fields[0].' and kdmo ='.$fields[0].'0001'
  							.' LIMIT 1';
  			$resultOrg = mysqli_query($link,$str_query);
  			if ($resultOrg){
  				if (mysqli_num_rows($resultOrg) == 1)
          {
  					$row = mysqli_fetch_assoc($resultOrg);
  					$res = mysqli_query($link,'SELECT id FROM bankrupts WHERE id_org="'.$row['id'].'" AND'
              ." type_deal like ('".$fields[1]."')");

  				 if (mysqli_num_rows($res) == 0)
  					{
            $query_str = 'INSERT INTO `bankrupts`(`id_org`, `maneger_deal`, `deal_number`, `date_deal`, `type_deal`)'
              .' VALUES ('.$row['id'].",'".$fields[1]."','".$fields[2]."','".$fields[3]."','".$fields[4]."')";
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
  str_replace(" ","",$filtr_kd);

  $where = array();
  if($filtr_kd!=""){
    $where[]="kd LIKE ('%".$filtr_kd."%')";
  }
  /*if($filtr_kd!="")
  {
    $where[]=" org.kd = '".$filtr_kd."'";
  }*/
  if($filtr_kdmo!=""){
    $where[]=" org.kdmo = '".$filtr_kdmo."'";
  }
  if($filtr_deal_number!=""){
    $where[]=" ba.deal_number = '".$filtr_deal_number."'";
  }
  if($filtr_date_deal!=""){
    $where[]=" ba.date_deal = '".$filtr_date_deal."'";
  }
    if($filtr_type_deal!=""){
    $where[]=" ba.type_deal = '".$filtr_type_deal."'";
  }


  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(ba.id)  FROM bankrupts as ba"
    ." left join organizations as org on org.id=ba.id_org" .$whereStrPa;


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

  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
       $ListResult[]=$row+array("Id"=>getListBankruts($link,$row["bankrupts"],1));
       //$ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  $list_bankrupts=getListBankruts($link,$filtr_t);

  require_once('template/load_bankrut.php');
?>
