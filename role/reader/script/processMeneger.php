<? header('Content-type: text/html; charset=windows-1251');
  require_once('../../../lib/start.php');

  $action=$_POST['mode'];

  if($action=="add"){

    $pib=iconv("utf-8","windows-1251",$_POST['pib']);
    $pib=delApostrophe($pib);
    $dep=$_POST['dep'];

    $qeruStr="INSERT INTO `managers`(`nu`, `dead`, `depatment`) VALUES ('".$pib."',0,".$dep.")";
    mysqli_query($link,$qeruStr);
    $options=array();
    $qeruStr="SELECT * FROM `managers` ";
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        $options[]=$row+array("ld"=>getListDepatment($link,$row["depatment"],1));
      }
      mysqli_free_result($result);
    }

    echo php2js($options);
  }
  if($action=="getList"){
    $qeruStr="SELECT * FROM `depatment` WHERE dead = 0 ";
    $result = mysqli_query($link,$qeruStr);
    $options=array();
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        $options[]=$row;
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }
  closeConnect($link);
?>
