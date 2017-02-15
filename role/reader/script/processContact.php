<? header('Content-type: text/html; charset=windows-1251');
  require_once('../../../lib/start.php');

  $action=$_POST["action"];
  $org=$_POST['org'];

  if($action=="add"){
    $type=$_POST['t'];
    $data=iconv("utf-8","windows-1251",$_POST['d']);
    $qeruStr="INSERT INTO `contact`(`id_org`, `data`, `type`) VALUES ($org,'$data',$type)";
    mysqli_query($link,$qeruStr);
  }else if($action=="edit"){
    $idRow=$_POST['idR'];
    $type=$_POST['t'];
    $data=iconv("utf-8","windows-1251",$_POST['d']);
    $qeruStr="UPDATE `contact` SET `data`='".$data."' WHERE id=$idRow";
    mysqli_query($link,$qeruStr);
  }else{
    $idRow=$_POST['idR'];
    $qeruStr="DELETE FROM `contact` WHERE id=$idRow";
    //echo $qeruStr;
    mysqli_query($link,$qeruStr);
  }


  $options=array();
  $qeruStr="SELECT * FROM `contact` WHERE id_org=$org  ORDER BY type";

  $result = mysqli_query($link,$qeruStr);
  if($result){
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $options[]=$row;
    }
    mysqli_free_result($result);
  }
  echo php2js($options);
  closeConnect($link);
?>
