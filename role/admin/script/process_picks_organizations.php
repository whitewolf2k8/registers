<? header('Content-type: text/html; charset=windows-1251');
  include_once('../../../lib/start.php');
  include_once('../../../lib/function.php');

  $action=$_POST['mode'];

  if($action=="getOrg"){

    $kd=iconv("utf-8","windows-1251",$_POST['kd']);
    $kdmo=iconv("utf-8","windows-1251",$_POST['kdmo']);

    $where = array();
    if($kd!=""){
      $kd=ltrim($kd,'0');
      $where[]=' `kd` = '.$kd;

    }

    if($kdmo!=""){
      $kdmo=ltrim($kdmo,'0');
      $where[]=' `kdmo` = '.$kdmo;
    }

    $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
    $qeruStr="SELECT id , nu , kd, kdmo FROM `organizations` ".$whereStr;
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=$row;
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }
  if($action=="getList")
  {
    $kod=iconv("utf-8","windows-1251",$_POST['kod']);
    $options= array();

    $qeruStr="SELECT * FROM `depatment` WHERE nom='".$kod."' AND dead = 0";
    $result = mysqli_query($link,$qeruStr);
    if($result){
      if(mysqli_num_rows($result)>0){
        while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $options[]=array('list' => getListDepatmentByKod($link,$kod),'exists'=> 1);
        }
      }else{
        $options[]=array('list' => getListDepatmentByKod($link,$kod),'exists'=> 0);
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }


  if($action=="kodDepList")
  {
    $id=iconv("utf-8","windows-1251",$_POST['id']);
    $options= array();
    $qeruStr="SELECT * FROM `depatment` WHERE id='".$id."'";
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=$row["nom"];
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }

  if($action=="getListType")
  {
    $options= array(getListTypeAct($typeAct,0));
    echo php2js($options);
  }

  if($action=="addRow")
  {
    if (!isset ($_SESSION))
    {
      session_start();
    }
    $idUser=$_SESSION['id'];
    $dataTime= date("m.d.y/H:i:s");
    $inputArr=$_POST["inData"];
    $type= $inputArr[6];
    $type_str="";
    if($type!=""){
      foreach ($type as $key => $value) {
        $type_str.=$value.";";
      }
    }
    $options= array();
    $qeruStr="INSERT INTO `acts_temp`(`org`, `da`, `dl`, `rnl`,`act`,`department`, `ad`, `dr`, `user`) VALUES"
      ." (".$inputArr[0].",'".dateToSqlFormat($inputArr[1])."','".dateToSqlFormat($inputArr[2])."','".$inputArr[3]."','".$type_str."',"
      .(($inputArr[4]!="")?$inputArr[4]:0).",'".iconv("utf-8","windows-1251",$inputArr[5])."','".$dataTime."',".$idUser.")";
    mysqli_query($link,$qeruStr);
    $qeruStr="SELECT act.*,Org.kd,Org.kdmo,Org.nu FROM `acts_temp` as act LEFT JOIN `organizations` as Org on Org.id = act.org   WHERE act.`user`='".$idUser."'";
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $row["da"]=dateToDatapiclerFormat($row["da"]);
        $row["dl"]=dateToDatapiclerFormat($row["dl"]);
        $options[]=$row+array('types' =>getTypeAct($typeAct,$row['act']),'dep'=>getDepartmentNu($link,$row['department']) );
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }

  if ($action=="checkKved") {
    $filtr_kved_kod=$_POST["info"];
    $ERROR_MSG ="";
    $options= array();
    $filtr_kved_kod1=formatKodKved10($filtr_kved_kod);
    if(iconv_strlen($filtr_kved_kod1, "Windows-1251")==5){
      $where[]=' (`kod` LIKE "'.$filtr_kved_kod1.'" ) ';
      $filtr_kved_kod=str_replace(" ","",$filtr_kved_kod1);
    }else{
      $ERROR_MSG.= "<br>".$filtr_kved_kod1;
    }
    if($ERROR_MSG==""){
      $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
      $qeruStr="SELECT * FROM `kved10` ".$whereStr;
      $result = mysqli_query($link,$qeruStr);
      if($result){
        $ListResult=array();

        while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $row["kod"]=str_replace(" ","",$row["kod"]);
          $ListResult[]=$row;
        }
        if(mysqli_num_rows($result)==0){
          $ERROR_MSG="Такого коду Квед 2010 не знайдено. Перевірте ще раз..";
        }
        mysqli_free_result($result);
      }
    }
    $options['kved_kod']=((isset($ListResult))?$ListResult:"");
    $options['erroMes']=$ERROR_MSG;
    echo php2js($options);
  }

  if ($action=="checkKise") {
    $filtr_kise_kd=isset($_POST["info"]) ? stripslashes($_POST["info"]) : '';
    $ERROR_MSG ="";
    $options= array();
    $where=array();

    $filtr_kise_kd1=formatKdKise14($filtr_kise_kd);
    if(iconv_strlen($filtr_kise_kd1, "Windows-1251")==1||iconv_strlen($filtr_kise_kd1, "Windows-1251")==4){
      $where[]=' (`kd` = '.$filtr_kise_kd1.' ) ';
    }else{
      $ERROR_MSG.= "<br>".$filtr_kise_kd1;
    }

    if($ERROR_MSG==""){
      $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
      $qeruStr="SELECT * FROM `kise14` ".$whereStr;
      $result = mysqli_query($link,$qeruStr);
      if($result){
        $ListResult=array();
        while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $ListResult[]=$row;
        }
        if(mysqli_num_rows($result)==0){
          $ERROR_MSG="Такого коду Kise не знайдено. Перевірте ще раз..";
        }
        mysqli_free_result($result);
      }
    }
    $options['kise_kod']=((isset($ListResult))?$ListResult:"");
    $options['erroMes']=$ERROR_MSG;
    echo php2js($options);
  }

  if($action=="getRay"){
    $kodObl=$_POST['obl'];
    $options=array();
    $qeruStr="SELECT * FROM `region` WHERE reg=".$kodObl." AND kod NOT IN (0,100,200)";
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=array("kod" =>$row['kod'],"nu" =>$row['nu']);
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }

  if ($action=="checkControls") {
    $filtr_controls_kod=$_POST["info"];
    $ERROR_MSG ="";
    $options= array();
    $filtr_controls_kod=delSpace($filtr_controls_kod);
    if($filtr_controls_kod!=""){
      $qeruStr="SELECT kd,nu FROM `managment_department` WHERE kd like ('".$filtr_controls_kod."')";
      $result = mysqli_query($link,$qeruStr);
      if($result){
        $ListResult=array();
        while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $row["kd"]=str_replace(" ","",$row["kd"]);
          $ListResult[]=$row;
        }
        if(mysqli_num_rows($result)==0){
          $ERROR_MSG="Органу управління з таким кодом не знайдено <br>";
        }
        mysqli_free_result($result);
      }
    }else{
      $ERROR_MSG+="Пошук здіснити неможливо, не заповнено поле.";
    }
    $options['controls_kod']=((isset($ListResult))?$ListResult:"");
    $options['erroMes']=$ERROR_MSG;
    echo php2js($options);
  }


  if($action=="getOpf"){
    echo php2js(getOpfHtml($link,array()));
  }


  closeConnect($link);
?>
