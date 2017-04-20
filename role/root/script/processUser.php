<? header('Content-type: text/html; charset=windows-1251');
  require_once('../../../lib/start.php');

  $action=$_POST["mode"];
  $idRow=$_POST['idRow'];
  $selectOptin=$_POST['arrS'];

  

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


  if($action=="add"){
    $login=iconv("utf-8","windows-1251",$_POST['name']);
    $pass=iconv("utf-8","windows-1251",$_POST['pass']);
    $path=iconv("utf-8","windows-1251",$_POST['path']);
    $type=$_POST['type'];
    $pass=md5($pass);

    $qeruStr="INSERT INTO `users`(`login`, `pass`, `locathion`, `type`)"
      ." VALUES ('".$login."','".$pass."','".$path."',$type)";
    mysqli_query($link,$qeruStr);

  }else if($action=="del"){
    $idArrDel=$_POST['arr'];
    foreach ($idArrDel as $key => $value) {
      $qeruStr="DELETE FROM `users` WHERE `id`= $value";
      mysqli_query($link,$qeruStr);
    }
  }else if($action=="update"){
    $login=iconv("utf-8","windows-1251",$_POST['name']);
    $pass=iconv("utf-8","windows-1251",$_POST['pass']);
    $path=iconv("utf-8","windows-1251",$_POST['path']);
    $type=$_POST['type'];

    $qeruStr="SELECT pass FROM `users` WHERE id=$idRow";
    $result = mysqli_query($link,$qeruStr);
    if($result){
      $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
      $now_pass=$row["pass"];
      mysqli_free_result($result);
    }
    if($now_pass!=$pass){
      $pass=md5($pass);
    }
    $qeruStr="UPDATE `users` SET `login`='".$login."',`pass`='".$pass."',`locathion`='".$path."',`type`=".$type." WHERE id=$idRow";
    mysqli_query($link,$qeruStr);
  }else if($action=="get"){
    $options=array();
    $qeruStr="SELECT * FROM `users` WHERE id=$idRow";
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=$row;
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
    closeConnect($link);
    exit;
  }





  $where=array();
  if($selectOptin[0]!=''){
    $where[]=" login = '".$selectOptin[0]."'";
  }

  if($selectOptin[1]!=''){
    $where[]=" type = ".$selectOptin[1];
  }

  $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );


  $options=array();
  $qeruStr="SELECT * FROM `users`".$whereStr;
  $result = mysqli_query($link,$qeruStr);


  //echo $qeruStr;
  if($result){
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $options[]=$row+array("typeNu"=>$typeUsers[$row['type']]);;
    }
    mysqli_free_result($result);
  }
  echo php2js($options);

  closeConnect($link);

?>
