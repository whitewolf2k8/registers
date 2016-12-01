<?
    require_once('../../lib/start.php');

    $filtr_kd=isset($_POST['filtr_kd']) ? stripslashes($_POST['filtr_kd']) : '';
    $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';
    $filtr_manager_deal=isset($_POST['filtr_manager_deal']) ? stripslashes($_POST['filtr_manager_deal']) : '';
    $filtr_deal_number=isset($_POST['filtr_deal_number']) ? stripslashes($_POST['filtr_deal_number']) : '';
    $filtr_date_deal=isset($_POST['filtr_date_deal']) ? stripslashes($_POST['filtr_date_deal']) : '';
    $filtr_type_deal=isset($_POST['filtr_type_deal']) ? stripslashes($_POST['filtr_type_deal']) : '0';

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

  			  $str_query = 'SELECT id FROM organizations'
  					.' WHERE kd='.$fields[0].' and kdmo ='.$fields[0].'0001'
  					.' LIMIT 1';
  			  $resultOrg = mysqli_query($link,$str_query);
  			  if ($resultOrg){
  				  if (mysqli_num_rows($resultOrg) == 1){
  					  $row = mysqli_fetch_assoc($resultOrg);
  					  $res = mysqli_query($link,'SELECT id FROM bankrupts WHERE id_org="'.$row['id'].'" AND'
              ." deal_number like ('".$fields[2]."')");

  				    if (mysqli_num_rows($res) == 0)
    					{
                $query_str = 'INSERT INTO `bankrupts`(`id_org`, `maneger_deal`, `deal_number`, `date_deal`, `type_deal`)'
                  .' VALUES ('.$row['id'].",'".$fields[1]."','".$fields[2]."','".dateToSqlFormat($fields[3])."','".$fields[4]."')";
                mysqli_query($link,$query_str);
                $countIns++;
    					}else{
                $query_str ="UPDATE `bankrupts` SET `maneger_deal`='".$fields[1]."'"
                  ." ,`date_deal`='".dateToSqlFormat($fields[3])."',`type_deal`='".$fields[4]."'"
                  ." WHERE `id_org`=".$row['id']." AND "." deal_number like ('".$fields[2]."')";
                mysqli_query($link,$query_str);
  						  $countUpd++;
  					  }
  					 mysqli_free_result($res);
    				}else{
              $ERROR_MSG .= 'Не знайдено підприємства з  kd '.$fields[0]."<br>";
            }
  				  mysqli_free_result($resultOrg);
  			  } else {
  				  $ERROR_MSG .= 'Помилка виконання запиту для підприємства kd '.$fields[0]."<br>";
  				  continue;
  			  }
  		  }
  		  fclose($d);
  		  $ERROR_MSG .= "<br />Імпорт завершено. Оновлених: $countUpd. Додано: $countIns. Всього: ".($countIns+$countUpd);
  	  } else {
        $ERROR_MSG .= "<br />Неможливо відкрити файл імпорта";
      }
    }

    $where = array();

    $filtr_kd = str_replace(" ","",$filtr_kd);

    if($filtr_kd!=""){
      $where[]="t2.kd =".$filtr_kd;
    }

    if($filtr_kdmo!=""){
      $where[]=" t2.kdmo = '".$filtr_kdmo."'";
    }
    if($filtr_deal_number!=""){
      $where[]=" t1.deal_number LIKE('".$filtr_deal_number."')";
    }
    if($filtr_date_deal!=""){
      $where[]=" t1.date_deal = '".dateToSqlFormat($filtr_date_deal)."'";
    }
    if($filtr_type_deal!="0"){
      $where[]=" t1.type_deal LIKE ('".$filtr_type_deal."')";
    }

    $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

    $qeruStrPaginathion="SELECT COUNT(t1.id) as resC  FROM bankrupts as t1"
      ." left join organizations as t2 on t2.id=t1.id_org" .$whereStrPa;

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

     $qeruStr="SELECT t2.kd,t2.kdmo, t1.* FROM "
      ." bankrupts as t1 "
      ." left join organizations as t2 on t2.id=t1.id_org".$whereStr;

    $result = mysqli_query($link,$qeruStr);
    if($result){
      $ListResult=array();
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $row["date_deal"]= dateToDatapiclerFormat($row["date_deal"]);
        $ListResult[]=$row;
      }
      mysqli_free_result($result);
    }

    $list_bankrupts=getListBankruts($link,$filtr_type_deal);

    require_once('template/load_bankrut.php');
?>
