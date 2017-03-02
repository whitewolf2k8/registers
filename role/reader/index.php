<?
  require_once('../../lib/start.php');
  $filtr_edrpou=isset($_POST['filtr_edrpou']) ? stripslashes($_POST['filtr_edrpou']) : '';
  $filtr_kdmo=isset($_POST['filtr_kdmo']) ? stripslashes($_POST['filtr_kdmo']) : '';

  $where = array();
  if($filtr_edrpou!=""){

    $where[]=' `kd` = '.$filtr_edrpou;
    $filtr_edrpou=ltrim($filtr_edrpou,'0');
  }

  if($filtr_kdmo!=""){
    $filtr_kdmo=ltrim($filtr_kdmo,'0');
    $where[]=' `kdmo` = '.$filtr_kdmo;
  }

  $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  if($whereStr!=''){
    $qeruStr="SELECT id FROM `organizations` ".$whereStr;
    $result = mysqli_query($link,$qeruStr);
    if($result){

      if(mysqli_num_rows($result)!=0){
        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        if (!isset ($_SESSION))

        {
          session_start();
        }
       $_SESSION['orgId']=$row['id'];
       closeConnect($link);
       header('Location: organization.php');
     }else{
       $ERROR_MSG.="<br> Підприємствo з таким кодом не знайдено";
     }
   }

  }
  require_once('template/index.php');
?>
