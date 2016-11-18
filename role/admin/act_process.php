<?
  require_once('../../lib/start.php');

  $action = isset($_POST['mode']) ? $_POST['mode'] : '';
  $arrList = $_POST['checkList'];

  $ERROR_MSG="";

if ($action=="add"){
  $countUpd=0;
  foreach ($arrList as $key => $value) {
    $query_str = "INSERT INTO `acts` (`org`, `da`, `dl`, `rnl`, `act`, `department`, `ad`, `dr`, `user`) SELECT `org`, `da`, `dl`, `rnl`, `act`, `department`, `ad`, `dr`, `user` FROM `acts_temp` WHERE `id` = ".$value;
    echo $query_str;
    mysqli_query($link,$query_str);
    $query_str = "DELETE FROM `acts_temp` WHERE `id` = ".$value;
    mysqli_query($link,$query_str);
    $countUpd++;
  }
  $ERROR_MSG .= "<br />Перенесено з тимчасової до робочої бази: $countUpd запис(ів).";
}


if ($action=="del"){
  $countUpd=0;
  foreach ($arrList as $key => $value) {
    $query_str = "DELETE FROM `acts_temp` WHERE `id` = ".$value;
    mysqli_query($link,$query_str);
    $countUpd++;
  }
  $ERROR_MSG .= "<br />Видалено з тимчасової бази: $countUpd запис(ів).";
}

if (!isset ($_SESSION))
{
  session_start();
}

$idUser=$_SESSION['id'];

$qeruStr="SELECT act.*,Org.kd,Org.kdmo,Org.nu FROM `acts_temp` as act LEFT JOIN `organizations` as Org on Org.id = act.org   WHERE act.`user`='".$idUser."'";
$result = mysqli_query($link,$qeruStr);
if($result){
  $ListResult=array();
  while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $row["da"]=dateToDatapiclerFormat($row["da"]);
    $row["dl"]=dateToDatapiclerFormat($row["dl"]);
    $ListResult[]=$row+array('types' =>getTypeAct($typeAct,$row['act']),'dep'=>getDepartmentNu($link,$row['department']) );
  }
  mysqli_free_result($result);
}

  $list_department=getListDepatment($link,0);
  $list_type_act=getListTypeAct($typeAct,0);
  require_once('template/act_process.php');
?>
