<? header('Content-type: text/html; charset=windows-1251');
  require_once('../../../lib/start.php');

  $action=$_POST['mode'];

  if($action=="add"){

    $nu=iconv("utf-8","windows-1251",$_POST['nu']);
    $nom=iconv("utf-8","windows-1251",$_POST['nom']);

    $qeruStr="INSERT INTO `depatment`(`nu`, `nom`, `dead`) VALUES ('".$nu."',$nom,0)";

    mysqli_query($link,$qeruStr);
    $options=array();
    $qeruStr="SELECT * FROM `depatment` ";
    $result = mysqli_query($link,$qeruStr);
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
