<? header('Content-type: text/html; charset=windows-1251');
  require_once('../../../lib/start.php');

  $kodObl=$_POST['ob'];
  $kodRay=$_POST['ra'];

  $options=array();
  $qeruStr="SELECT te, nu FROM `koatuu` WHERE  te like  ('".$kodObl.$kodRay."%')  and te not like  ('%000') ";


  $result = mysqli_query($link,$qeruStr);
  if($result){
    
    if(mysqli_num_rows($result)>0){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=array("te" =>$row['te'],"nu" =>$row['nu']);
      }
      mysqli_free_result($result);
    }else{
      mysqli_free_result($result);
      $qeruStr="SELECT te, nu FROM `koatuu` WHERE  te like  ('".$kodObl.$kodRay."%')";

      $result = mysqli_query($link,$qeruStr);
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=array("te" =>$row['te'],"nu" =>$row['nu']);
      }
      mysqli_free_result($result);
    }

  }
  echo php2js($options);
  closeConnect($link);
?>
