<?
  require_once('../../lib/start.php');

  $filtr_edrpou=isset($_POST['filtr_edrpou']) ? stripslashes($_POST['filtr_edrpou']) : '';
  $filtr_role=isset($_POST['filtr_role_kategory']) ? stripslashes($_POST['filtr_role_kategory']) : '';

    $qeruStr="SELECT * FROM `users` ".$whereStr;
    $result = mysqli_query($link,$qeruStr);
    if($result){
      $lists=array();
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $lists[]=$row+array("typeNu"=>$typeUsers[$row['type']]);
      }
      mysqli_free_result($result);
     }

  $list_role_kategory=getListRoleUser($filtr_role,$typeUsers);
  require_once('template/index.php');
?>
