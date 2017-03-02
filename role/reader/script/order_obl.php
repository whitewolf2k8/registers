<? header('Content-type: text/html; charset=windows-1251');
  require_once('../../../lib/start.php');

  $kodObl=$_POST['id'];

  $options=array();
  $qeruStr="SELECT * FROM `region` WHERE `kod`=0";

  $result = mysqli_query($link,$qeruStr);
  if($result){
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $options[]=array("reg" =>$row['reg'],"nu" =>$row['nu']);
    }
    mysqli_free_result($result);
  }

  echo php2js($options);
  closeConnect($link);
?>
