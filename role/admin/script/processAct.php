<? header('Content-type: text/html; charset=windows-1251');
  require_once('../../../lib/start.php');

  $action=$_POST['mode'];

  if($action=="getOrg"){

    $kd=iconv("utf-8","windows-1251",$_POST['kd']);
    $kdmo=iconv("utf-8","windows-1251",$_POST['kdmo']);

    $where = array();
    if($kd!=""){
      $kd=ltrim($kd,'0');
      $where[]=' `kd` = '.$kd;

    }

    if($kdmo!=""){
      $kdmo=ltrim($kdmo,'0');
      $where[]=' `kdmo` = '.$kdmo;
    }

    $whereStr = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
    $qeruStr="SELECT id , nu , kd, kdmo FROM `organizations` ".$whereStr;
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=$row;
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }
  if($action=="getList")
  {
    $kod=iconv("utf-8","windows-1251",$_POST['kod']);
    $options= array();

    $qeruStr="SELECT * FROM `depatment` WHERE nom='".$kod."' AND dead = 0";
    $result = mysqli_query($link,$qeruStr);
    if($result){
      if(mysqli_num_rows($result)>0){
        while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $options[]=array('list' => getListDepatmentByKod($link,$kod),'exists'=> 1);
        }
      }else{
        $options[]=array('list' => getListDepatmentByKod($link,$kod),'exists'=> 0);
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }


  if($action=="kodDepList")
  {
    $id=iconv("utf-8","windows-1251",$_POST['id']);
    $options= array();
    $qeruStr="SELECT * FROM `depatment` WHERE id='".$id."'";
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $options[]=$row["nom"];
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }

  if($action=="getListType")
  {
    $options= array(getListTypeAct($typeAct,0));
    echo php2js($options);
  }

  if($action=="addRow")
  {
    if (!isset ($_SESSION))
    {
      session_start();
    }
    $idUser=$_SESSION['id'];
    $dataTime= date("m.d.y/H:i:s");
    $inputArr=$_POST["inData"];
    $type= $inputArr[6];
    $type_str="";
    if($type!=""){
      foreach ($type as $key => $value) {
        $type_str.=$value.";";
      }
    }
    $options= array();
    $qeruStr="INSERT INTO `acts_temp`(`org`, `da`, `dl`, `rnl`,`act`,`department`, `ad`, `dr`, `user`) VALUES"
      ." (".$inputArr[0].",'".dateToSqlFormat($inputArr[1])."','".dateToSqlFormat($inputArr[2])."','".$inputArr[3]."','".$type_str."',"
      .(($inputArr[4]!="")?$inputArr[4]:0).",'".iconv("utf-8","windows-1251",$inputArr[5])."','".$dataTime."',".$idUser.")";
    mysqli_query($link,$qeruStr);
    $qeruStr="SELECT act.*,Org.kd,Org.kdmo,Org.nu FROM `acts_temp` as act LEFT JOIN `organizations` as Org on Org.id = act.org   WHERE act.`user`='".$idUser."'";
    $result = mysqli_query($link,$qeruStr);
    if($result){
      while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $row["da"]=dateToDatapiclerFormat($row["da"]);
        $row["dl"]=dateToDatapiclerFormat($row["dl"]);
        $options[]=$row+array('types' =>getTypeAct($typeAct,$row['act']),'dep'=>getDepartmentNu($link,$row['department']) );
      }
      mysqli_free_result($result);
    }
    echo php2js($options);
  }

  closeConnect($link);
?>
