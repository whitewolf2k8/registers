<?
  require_once('../../lib/start.php');

  $paginathionLimitStart=isset($_POST['limitstart']) ? stripslashes($_POST['limitstart']) : 0;
  $paginathionLimit=isset($_POST['limit']) ? stripslashes($_POST['limit']) : 50;
  $filtr_nu= isset($_POST['filtr_nu']) ? stripslashes(trim($_POST['filtr_nu'])) :"";


  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $ERROR_MSG="";

  if($action=="edit"){
    $arrCheck=$_POST["checkList"];
    $arrChange=$_POST["checkDead"];
    foreach ($arrCheck as $key => $value) {
      if(isset($arrChange[$value])){
        $qeruStr="UPDATE `depatment` SET `dead`= 1 WHERE id=".$value;
      }else{
        $qeruStr="UPDATE `depatment` SET `dead`= 0 WHERE id=".$value;
      }
      mysqli_query($link,$qeruStr);
    }
  }

  $where = array();

  if($filtr_nu!=""){
    $where[]=" nu  Like ('%".$filtr_nu."%')";
  }

  $whereStrPa = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  $qeruStrPaginathion="SELECT COUNT(id) as resC FROM `depatment`  ".$whereStrPa;
  $resultPa = mysqli_query($link,$qeruStrPaginathion);
  if($resultPa){
    $r=mysqli_fetch_array($resultPa, MYSQLI_ASSOC);
    $rowCount=$r['resC'];
    mysqli_free_result($resultPa);
  }

  if($rowCount>0){
      $pagination.=getPaginator($rowCount,$paginathionLimit,$paginathionLimitStart);
  }
  $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
  if($paginathionLimit!=0 ){

    $whereStr.=' LIMIT '.$paginathionLimitStart.','.$paginathionLimit;
  }

  $qeruStr="SELECT * FROM `depatment` ".$whereStr;
  $result = mysqli_query($link,$qeruStr);
  if($result){
    $ListResult=array();
    while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $ListResult[]=$row;
    }
    mysqli_free_result($result);
  }

  require_once('template/department.php');
?>
