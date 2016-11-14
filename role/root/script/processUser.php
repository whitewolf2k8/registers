<? header('Content-type: text/html; charset=windows-1251');
  require_once('../../../lib/start.php');

  $action=$_POST["mode"];
  $idRow=$_POST['idRow'];
  $selectOptin=$_POST['arrS'];


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
