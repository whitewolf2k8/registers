<? header('Content-type: text/html; charset=windows-1251');
  require_once('../../../lib/start.php');
//$type тип возращаемого (область/район) 0/1
  function getTer($type,$id){
    $len=iconv_strlen($id);
    if($len==4){
      if($type==0){
        return  substr($id,0,1);
      }else{
        return  substr($id,1,3);
      }
    }else{
      if($type==0){
        return  substr($id,0,2);
      }else{
        return  substr($id,2,3);
      }
    }
  }

  $action=$_POST['mode'];


  if($action=="add"){
    $kodObl=$_POST['ob'];
    $kodRay=$_POST['ra'];
    $kodTe=$_POST['te'];
    $kodPi=$_POST['pi'];
    $ad=iconv("utf-8","windows-1251",$_POST['ad']);
    $org=$_POST['org'];
    $options=array();
    $qeruStr="INSERT INTO `actual_address`(`id_org`, `pi`, `ad`, `te`, `tea`)"
    ." VALUES ($org,$kodPi,'".$ad."',".$kodObl.$kodRay.".$kodRay,$kodTe)";
    mysqli_query($link,$qeruStr);
    $options=array();
    $qeruStr="SELECT * FROM `actual_address` WHERE  id_org=".$org;
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=$row+array("obl" =>getTer(0,$row['te']),"ray" =>getTer(1,$row['te']));
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }else if($action=="get"){
    $id_row=$_POST['id'];
    $options=array();
    $qeruStr="SELECT * FROM `actual_address` WHERE  id=".$id_row;
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=$row+array("obl" =>getTer(0,$row['te']),"ray" =>getTer(1,$row['te']));
      }
      mysqli_free_result($result);
      echo php2js($options);
    }
  }else  if($action=="del"){
    $id_row=$_POST['id'];
    $qeruStr="SELECT id_org FROM `actual_address` WHERE  id=".$id_row;
    $result = mysqli_query($link,$qeruStr);
    if($result){
      $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
      $id_org=$row["id_org"];
      mysqli_free_result($result);
    }
    $qeruStr="DELETE FROM `actual_address` WHERE id=".$id_row;
    mysqli_query($link,$qeruStr);
    $options=array();
    $qeruStr="SELECT * FROM `actual_address` WHERE  id_org=".$id_org;
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=$row+array("obl" =>getTer(0,$row['te']),"ray" =>getTer(1,$row['te']));
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }else if($action=="change"){
    $kodObl=$_POST['ob'];
    $kodRay=$_POST['ra'];
    $kodTe=$_POST['te'];
    $kodPi=$_POST['pi'];
    $ad=iconv("utf-8","windows-1251",$_POST['ad']);
    $id_row=$_POST['id'];
    $qeruStr="SELECT id_org FROM `actual_address` WHERE  id=".$id_row;
    $result = mysqli_query($link,$qeruStr);
    if($result){
      $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
      $id_org=$row["id_org"];
      mysqli_free_result($result);
    }
    $qeruStr="UPDATE `actual_address` SET `pi`=$kodPi,`ad`= '$ad',`te`=".$kodObl.$kodRay.",`tea`=$kodTe WHERE id=$id_row";
    mysqli_query($link,$qeruStr);
    $options=array();
    $qeruStr="SELECT * FROM `actual_address` WHERE  id_org=".$id_org;
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=$row+array("obl" =>getTer(0,$row['te']),"ray" =>getTer(1,$row['te']));
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }
  if($action=="getList"){
    $option = array();
    $option["insert_year"]=getListYear($link,0,0);
    $option["insert_period"]= getListPeriod($link,"");
    echo php2js($option);
  }


  closeConnect($link);
?>
